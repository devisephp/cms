<?php namespace Devise\Templates;

use Devise\Support\Config\FileManager as ConfigFileManager;
use Devise\Support\Framework;

/**
 * Class TemplatesManager manages updating templates,
 * removing and additional admin functions
 */
class TemplatesManager
{
    protected $ConfigFileManager;

    /**
     * Validator is used to validate template rules
     *
     * @var Illuminate\Validation\Factory
     */
    private $Validator;

	/**
     * Errors are kept in an array and can be
     * used later if validation fails and we want to
     * know why
     *
	 * @var array
	 */
	public $errors;

    /**
     * This is a message that we can store why the
     * validation failed
     *
     * @var string
     */
    public $message;

    /**
     * Construct a new template manager
     *
     * @param Validator $Validator
     */
	public function __construct(ConfigFileManager $ConfigFileManager, Framework $Framework)
    {
        $this->ConfigFileManager = $ConfigFileManager;
        $this->Config = $Framework->Config;
        $this->Validator = $Framework->Validator;
    }

    /**
     * Validation messages
     *
     * @return void
     */
    public $messages =  array(
        'file_name.not_in'  => 'File name invalid',
        'file_name.required'  => 'File name required',
        'human_name.required' => 'Human name required',
        'var_name.required' => 'Variable name required',
        'class_path.required' => 'Class path required',
        'method_name.required' => 'Method Name required',
    );

    /**
     * Validation rules for registering a new template
     *
     * @return void
     */
    public function registerRules()
    {
        return array(
            'file_name'  => array('required' ,'not_in:0'),
            'human_name' => array('required')
        );
    }

    /**
     * Validate and store a template entry to templates config
     *
     * @param  array   $input
     * @return bool
     */
    public function storeTemplate($input)
    {
        $validator = $this->Validator->make($input, $this->registerRules(), $this->messages);

        if($validator->passes())
        {
            $configContents = $this->ConfigFileManager->getAppOnly('devise.templates');

            // setup array for config file and sets vars array to
            // blank key/value pair to prep. data for init. edit form
            $configContents[$input['file_name']] = array(
                'human_name' => $input['human_name'],
                'extends' => $input['extends'],
            );

            return $this->ConfigFileManager->saveToFile($configContents, 'templates');
        }

        $this->errors = $validator->errors()->all();
        return false;
    }

	/**
	 * Validates and updates a template with the given input
     *
	 * @param  string  $templatePath  Unique key from templates config
	 * @param  array   $input
	 * @return bool
	 */
	public function updateTemplate($input)
	{
        if($this->validateInputVars($input))
        {
            $configContents = $this->ConfigFileManager->getAppOnly('devise.templates');

            // if newVars exist, validate and add to vars array
            if(isset($input['template']['newVars'])) {
                $this->processAndMergeNewVars($input['template']);
            }

            // overwrite input template vars with processed input vars data
            if(isset($input['template']['vars'])) {
                $input['template']['vars'] = $this->prepVarsAndParams($input['template']['vars']);
            }

            // overwrite template data for submitted template path/key
            $configContents[$input['template_path']] = $input['template'];
            
            return $this->ConfigFileManager->saveToFile($configContents, 'templates');
        }

        return false;
    }

    /**
     * Destroys a template by retrieving current config contents and
     * unsetting the key (templatePath) then saving the updated contents
     *
     * @param  string $templatePath
     * @return boolean
     */
    public function destroyTemplate($templatePath)
    {
        // check if key exists in config, if so unset it
        $configContents = $this->ConfigFileManager->getAppOnly('devise.templates');
        
        if(isset($configContents[$templatePath])){
            unset($configContents[$templatePath]);

            return $this->ConfigFileManager->saveToFile($configContents, 'templates');
        }

        $this->errors = 'Failed to remove template, path unrecognized.';
        return false;
    }

    /**
     * Validation rules for registering a new template
     *
     * @return void
     */
    public function createVarRules()
    {
        return array(
            'var_name'  => array('required'),
            'class_path' => array('required'),
            'method_name' => array('required')
        );
    }

    /**
     * Validate and store a new variable for a given template path
     *
     * @param  string  $templatePath
     * @param  array   $input
     * @return bool
     */
    public function storeNewVariable($templatePath, $input)
    {
        $validator = $this->Validator->make($input, $this->createVarRules(), $this->messages);
        $copyVar = (isset($input['copy_var']) && $input['copy_var'] !== '0') ? $input['copy_var'] : false;
        
        if($copyVar || $validator->passes())
        {
            $configContents = $this->ConfigFileManager->getAppOnly('devise.templates');

            if($copyVar){
                $configContents = $this->copyExistingVariable($configContents, $templatePath, $copyVar);
            } else {
                $configContents = $this->addNewVariable($configContents, $templatePath, $input);
            }

            return $this->ConfigFileManager->saveToFile($configContents, 'templates');
        }

        $this->errors = $validator->errors()->all();
        return false;
    }

    /**
     * takes an existing var path and copies it to the template path
     *
     * @param  array  $configContents
     * @param  string   $templatePath
     * @param  array   $input
     * @return array
     */
    private function copyExistingVariable($configContents, $templatePath, $path)
    {
        $parts = explode('.', $path);
        $varName = array_pop($parts);
        array_pop($parts);
        $copyFrom = implode('.', $parts);
        $varSettings = $configContents[ $copyFrom ]['vars'][$varName];

        if(!empty($configContents[$templatePath]['vars'])) {
            $configContents[$templatePath]['vars'][$varName] = $varSettings;
        } else {
            $configContents[$templatePath]['vars'] = array(
                $varName => $varSettings
            );
        }

        return $configContents;
    }

    /**
     * adds a brand new variable to the location specified in the form
     *
     * @param  array  $configContents
     * @param  string   $templatePath
     * @param  array   $input
     * @return array
     */
    private function addNewVariable($configContents, $templatePath, $input)
    {
        $pathAndMethod = $input['class_path'] . '.' . $input['method_name'];

        //  if array vars array is not empty, push into vars array.
        //  If it is empty then set vars array to input data
        if(!empty($configContents[$templatePath]['vars'])) {
            $configContents[$templatePath]['vars'][$input['var_name']] = $pathAndMethod;
        } else {
            $configContents[$templatePath]['vars'] = array(
                $input['var_name'] => $pathAndMethod
            );
        }

        return $configContents;
    }

    /**
     * Constructs formatted vars array ready for saving
     * to the templates config file
     *
     * @param  array  $varInput
     * @return array
     */
    private function prepVarsAndParams($varInput)
    {
        $preppedVarsArr = array();

        foreach ($varInput as $varName => $varData) {
            $varName = $varData['varName'];

            // concatenate path and method name
            $pathWithMethod = $varData['classPath'] . '.' . $varData['methodName'];

            // remove params keys with empty values
            $varData['params'] = $this->removeEmptyParams(array_get($varData, 'params', []));

            array_walk_recursive($varData, 'self::castBooleans');

            if (count($varData['params']) > 0) {

                // Do an array of path => params
                $preppedVarsArr[$varName] = array(
                    $pathWithMethod => $varData['params']
                );

            } else {

                // do a string var name equal to namespaced path/method
                $preppedVarsArr[$varName] = $pathWithMethod;

            }
        }

        return $preppedVarsArr;
    }

    /**
     * Processes input['template'] data and unsets any newVars array
     * elements which have empty string values. After processing
     * newVars data, its merged together with template vars array
     *
     * @param  array &$input
     * @return void
     */
    private function processAndMergeNewVars(&$input)
    {
        foreach($input['newVars'] as $key => $newVar) {
            if($newVar['varName'] == ''
                || $newVar['classPath'] == ''
                || $newVar['methodName'] == '')
            {
                unset($input['newVars'][$key]);
            }
        }

        // merge newVars array into vars array
        if(count($input['newVars'])) {
            $input['vars'] = array_get($input, 'vars', []) + $input['newVars'];
        }

        // remove the newVars key from template
        unset($input['newVars']);
    }

    /**
     * Validate input[template][vars]
     *
     * @param  array  $input
     * @return boolean
     */
    private function validateInputVars($input)
    {
        if(isset($input['template']['vars']))
        {
            foreach($input['template']['vars'] as $var)
            {
                if ($var['varName'] == ''
                    || $var['classPath'] == ''
                    || $var['methodName'] == '')
                {
                    $this->errors = ['Var Name, Class Path and Method Name required'];

                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks for any array keys with empty values
     * and removes/unsets key(s) from array
     *
     * @param  array  $arr
     * @return array
     */
    private function removeEmptyParams($arr)
    {
        foreach($arr as $key => $value) {
            if(empty($value)) {
                unset($arr[$key]);
            }
        }

        return $arr;
    }

    /**
     * Takes care of casting 'true/false' strings
     * to data type boolean
     *
     * @param  array &$varData  Array of params input
     * @return void
     */
    private function castBooleans(&$varData)
    {
        if(strtolower($varData) === 'false') {
            $varData = (bool) 0;
        } else if(strtolower($varData) === 'true') {
            $varData = (bool) 1;
        }
    }
}