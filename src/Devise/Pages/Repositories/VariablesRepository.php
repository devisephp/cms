<?php namespace Devise\Pages\Repositories;

use Config;
use Devise\Support\Files\FileManager;

class VariablesRepository extends BaseRepository {
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
     * adds a variables to templates in config
     *
     * @param array $variable
     * @return boolean
     */
    public function save($variable)
    {
        if($this->canSave($variable)){
            Config::set(
                'devise::templates.' . $variable['parent'] .'.vars.' . $variable['name'], 
                $this->getValue($variable)
            );
            $this->FileManager->saveConfig('devise::templates');
        }
    }

    private function canSave($variable)
    {
        return (
            isset($variable['class']) && 
            $variable['class'] != '' && 
            isset($variable['function']) && 
            $variable['function'] != ''
        );
    }

    private function getValue($variable)
    {
        $classFunction = $variable['class'] .'.'. $variable['function'];
        if(isset($variable['params']) && $variable['params'] !== ''){
            return array(
                $classFunction => explode(',', $variable['params'])
            );
        } else {
            return $classFunction;
        }
    }
}