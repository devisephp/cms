<?php namespace Devise\Pages\Repositories;

use Config;
use Devise\Support\Files\FileManager;
use Illuminate\Support\Facades\File;

class TemplatesRepository extends BaseRepository {
    /**
     * Instance of the FileManager Model
     *
     * @var FileManager
     */
    private $FileManager;


    /**
     * Create a new TemplatesRepository instance.
     *
     * @param  FileManager  $FileManager
     */
    public function __construct(FileManager $FileManager)
    {
        $this->FileManager = $FileManager;
    }

    /**
     * Gets settings for a template
     *
     * @param  string $key
     * @return array
     */
    public function find($key)
    {
        return Config::get('devise::' . $key);
    }

    /**
     * returns a list of all views
     *
     * @return array
     */
    public function lists()
    {
        return Config::get('devise::views');
    }

    /**
     * saves a new template to the templates config
     *
     * @param $path
     * @param $parentPath
     * @internal param array $templates
     * @return boolean
     */
    public function saveNew($path, $parentPath)
    {
        $views = Config::get('devise::views');
        if(!in_array($path, $views)){
            if($path == $parentPath){
                Config::set('devise::templates.' . $path, array('extends'=>false));
            } else {
                Config::set('devise::templates.' . $path, array('extends'=>$parentPath));
            }
            
            $this->FileManager->saveConfig('devise::templates');
            $views[] = $path;
            Config::set('devise::views', $views);
        }
    }

    /**
     * saves a new template to the templates config
     *
     * @param $path
     * @param $parentPath
     * @internal param array $templates
     * @return boolean
     */
    public function updateExisting($path, $parentPath)
    {
        $views = Config::get('devise::views');
        if(!in_array($path, $views)){
            if($path == $parentPath){
                Config::set('devise::templates.' . $path, array('extends'=>false));
            } else {
                Config::set('devise::templates.' . $path, array('extends'=>$parentPath));
            }
            
            $this->FileManager->saveConfig('devise::templates');
            $views[] = $path;
            Config::set('devise::views', $views);
        }
    }

    public function availableViewsList()
    {
        $viewLocations = Config::get('view');
        $views = array();   
        $humanNames = Config::get('view.template_human_names');
        foreach($viewLocations['paths'] as $vl) {
            if (File::exists($vl)) {
                $files = File::allFiles($vl);
                foreach($files as $view) {

                    if (substr_count($view->getRelativePathname(), '.blade.php')) {


                        $value = str_replace('/', '.', str_replace('.blade.php', '', $view->getRelativePathname()));
                        $nameArr = explode('.', $value);
                        $folderName = $nameArr[0];
                        $viewName = $nameArr[1];
                        if(substr($viewName, 0, 1) != '_' && $folderName == 'templates'){
                            if(isset($humanNames[$value])){
                                $views[$value] = $humanNames[$value];
                            } else {
                                $views[$value] = $value;                                
                            }
                        }
                    }
                }
            }

        }
        asort($views);
        return $views;

    }
}