

////////////////////////////////////////////////////////////////
// Gulp variables
////////////////////////////////////////////////////////////////
var elixir = require('laravel-elixir');
var phpunit = require('gulp-phpunit');
var rjs = require('gulp-requirejs');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var gulp = require('gulp');
var notify  = require('gulp-notify');
var concat = require('gulp-concat-util');
// var count = require('gulp-count');
var fs = require('fs')


////////////////////////////////////////////////////////////////
// run phpunit as a task
////////////////////////////////////////////////////////////////
gulp.task('phpunit', function()
{
    var options = {debug: false, notify: true, configurationFile: 'phpunit.xml'};
    if (process.env.GULP_PHPUNIT_FILTER) options['filter'] = process.env.GULP_PHPUNIT_FILTER;
    gulp.src('tests/*.php')
        .pipe(phpunit('vendor/bin/phpunit', options))
        .on('error', notify.onError({
            title: "Failed Tests!",
            message: "Error(s) occurred during testing..."
        }));
});


////////////////////////////////////////////////////////////////
// watch phpunit as a task and run phpunit whenever changes to
// files are made within test/ and src/
////////////////////////////////////////////////////////////////
gulp.task('test', function()
{
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], ['phpunit']);
});



////////////////////////////////////////////////////////////////
// watch script files and rebuild automatically
////////////////////////////////////////////////////////////////
gulp.task('default', function()
{
    gulp.watch(['public/js/app/**/*.js'], ['build:js']);
});


////////////////////////////////////////////////////////////////
// Build devise
////////////////////////////////////////////////////////////////
gulp.task('build:js', ['build:js:devise'], function()
{
  gulp.src(['public/js/devise.vendor.js', 'public/js/devise.app.js'])
    .pipe(concat('devise.js'))
    .pipe(gulp.dest('public/js'));

  gulp.src(['public/js/devise.vendor.min.js', 'public/js/devise.app.min.js'])
    .pipe(concat('devise.min.js'))
    .pipe(gulp.dest('public/js'));
});


////////////////////////////////////////////////////////////////
// Build devise vendor files (only run this if you update vendors)
////////////////////////////////////////////////////////////////
gulp.task('build:js:vendor', function()
{
  rjs({
    mainConfigFile : "public/js/config.js",
    baseUrl: "public/js",
    removeCombined: false,
    findNestedDependencies: false,
    wrap: true,
    out: 'devise.vendor.js',
    include: [
        'config',
        'jquery',
        'jquery-ui',
        'jqSerializeObject',
        'jqNestedSortable',
        'datetimepicker',
        'fullCalendar',
        'scrollTo',
        'localScroll',
        'handlebars',
        'vueJs',
    ]
  })
  .pipe(concat.header(fs.readFileSync('public/js/devise.require.js', 'utf8') + '\n'))
  .pipe(gulp.dest('public/js'))
  .pipe(uglify())
  .pipe(rename('devise.vendor.min.js'))
  .pipe(gulp.dest('public/js'));
});


////////////////////////////////////////////////////////////////
// Gulp watch
////////////////////////////////////////////////////////////////
elixir(function(mix) {
    mix.sass(['main.scss'], 'public/css/main.css', 'public/scss');
    mix.sass(['editor-nodes.scss'], 'public/css/editor-nodes.css', 'public/scss');
});


////////////////////////////////////////////////////////////////
// Build devise application files... this is run everytime as
// a dependency when you run build:js
////////////////////////////////////////////////////////////////
gulp.task('build:js:devise', function()
{
  rjs({
    mainConfigFile : "public/js/config.js",
    baseUrl: "public/js",
    removeCombined: false,
    findNestedDependencies: false,
    wrap: true,
    out: 'devise.app.js',
    include: [
        'dvsTemplates',
        'dvsEditor',
        'query',
        'dvsCsrf',
        'dvsSidebarView',
        'dvsBaseView',
        'dvsPositionHelper',
        'dvsSelectSurrogate',
        'dvsLiveUpdater',
        'BindingsFinder',
        'dvsFieldView',
        'dvsCollectionView',
        'dvsModelView',
        'dvsAttributeView',
        'dvsCreatorView',
        'dvsGroupView',
        'dvsBreadCrumbsView',
        'dvsLiveUpdate',
        'AttributeBinding',
        'ClassBinding',
        'StyleBinding',
        'TextBinding'
    ]
  })
  .pipe(concat.footer("\ndevise.require(['jquery'], function($){ devise.$ = $; });"))
  .pipe(gulp.dest('public/js'))
  .pipe(uglify())
  .pipe(rename('devise.app.min.js'))
  .pipe(gulp.dest('public/js'));
});
