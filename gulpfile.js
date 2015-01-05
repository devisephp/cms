////////////////////////////////////////////////////////////////
// Gulp variables
////////////////////////////////////////////////////////////////

var phpunit = require('gulp-phpunit');
var rjs = require('gulp-requirejs');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var gulp = require('gulp');
var notify  = require('gulp-notify');
var concat = require('gulp-concat-util');
var fs = require('fs')


////////////////////////////////////////////////////////////////
// run phpunit as a task
////////////////////////////////////////////////////////////////
gulp.task('phpunit', function()
{
    var options = {debug: false, notify: true, configurationFile: 'phpunit.xml'};
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
gulp.task('default', function()
{
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], function()
    {
        gulp.run('phpunit');
    });
});


////////////////////////////////////////////////////////////////
// Build devise
////////////////////////////////////////////////////////////////
gulp.task('build:js', function()
{
  rjs({
    mainConfigFile : "public/js/config.js",
    baseUrl: "public/js",
    removeCombined: false,
    findNestedDependencies: false,
    wrap: true,
    out: 'devise.js',
    include: [
        'config',
        'jquery',
        'jquery-ui',
        'datetimepicker',
        'dvsPublic',
        'fullCalendar'
    ]
  })
  .pipe(concat.header(fs.readFileSync('public/js/devise.require.js', 'utf8') + '\n'))
  .pipe(concat.footer("\ndevise.require(['jquery'], function($){ devise.$ = $; });"))
  .pipe(gulp.dest('public/js'))
  .pipe(uglify())
  .pipe(rename('devise.min.js'))
  .pipe(gulp.dest('public/js'));
});
