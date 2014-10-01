<?php namespace Devise\Pages\Providers;

use Config;
use Devise\Pages\Repositories\FieldsRepository;
use Devise\Pages\Repositories\TemplatesRepository;
use Devise\Pages\Repositories\VariablesRepository;
use Devise\Support\Files\FileManager;
use Event;
use Field;
use Illuminate\Support\ServiceProvider;

class CompilerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // only load repositories and register listeners
        // when the compiler engine begins compiling
        Event::listen('compiler.engine.begin', function(){
            $this->loadRepositories();

            Event::listen('pages.field.parsed', function($field){
                if(!isset($field['db-id'])){
                    $this->FieldsRepository->saveNew($field);
                } else if(isset($field['overwrite'])) {
                    $this->FieldsRepository->updateExisting($field['db-id'], $field);
                }
            });

            Event::listen('pages.template.parsed', function($template){
                if(!$template['existing']){
                    $this->TemplatesRepository->saveNew($template['path'], $template['parent']);
                } else if(isset($template['overwrite'])) {
                    $this->TemplatesRepository->updateExisting($template['path'], $template['parent']);
                } else {
                    $skipList = (Config::get('devise::skip.template')) ? Config::get('devise::skip.template') : array();
                    $skipList[] = $template['path'];
                    Config::set('devise::skip.template', $skipList);
                }
            });

            Event::listen('pages.variable.parsed', function($variable){
                if(!$variable['existing'] || isset($variable['overwrite'])){
                    $this->VariablesRepository->save($variable);
                }
            });
        });
    }

    private function loadRepositories()
    {
        $this->TemplatesRepository = new TemplatesRepository(new FileManager);
        $this->VariablesRepository = new VariablesRepository(new FileManager);
        $this->FieldsRepository = new FieldsRepository(new Field);
    }
}