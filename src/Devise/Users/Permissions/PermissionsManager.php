<?php namespace Devise\Users\Permissions;

use Devise\Support\Config\FileManager as ConfigFileManager;
use Devise\Support\Framework;

/**
 * Class PermissionsManager manages updating permissions,
 * removing and additional admin functions
 */
class PermissionsManager
{
    protected $ConfigFileManager;

    /**
     * Validator is used to validate permission rules
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
	public $errors = [];

    /**
     * This is a message that we can store why the
     * validation failed
     *
     * @var string
     */
    public $message;

    /**
     * Construct a new permission manager
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
        'permission_name.required' => 'The permission name is required.',
        'permission_name.alpha' => 'The permission name can only contain alpha characters, and no spaces.',
        'permission_name_edit.required' => 'The permission name is required.',
        'permission_name_edit.alpha' => 'The permission name can only contain alpha characters, and no spaces.',
    );


    /**
     * Create rules for a new permission
     *
     * @return array
     */
    public function createRules()
    {
        return array(
            'permission_name' => 'required|alpha',
        );
    }

    /**
     * Create rules to edit a permission
     *
     * @return array
     */
    public function updateRules()
    {
        return array(
            'permission_name_edit' => 'required|alpha',
        );
    }

    /**
     * Validates and updates a permission with the given input
     *
     * @param  array   $input
     * @return bool | array
     */
    public function storePermission($input)
    {
        $validator = $this->Validator->make($input, $this->createRules(), $this->messages);

        if ($validator->passes()){

            if(isset($input[ $input['permission_name'] ])){
                $this->cleanInput($input[ $input['permission_name'] ]);

                $configContents = $this->ConfigFileManager->getAppOnly('devise.permissions');

                $this->includeRedirect($input, $input[ $input['permission_name'] ]);

                $configContents[ $input['permission_name'] ] = $input[ $input['permission_name'] ];

                return $this->ConfigFileManager->saveToFile($configContents, 'permissions');
            }

            $this->errors[] = 'At least 1 rule must be present to save the condition.';
            return false;
        }

        $this->errors = $validator->errors()->all();
        return false;
    }

	/**
	 * Validates and updates a permission with the given input
     *
	 * @param  string  $condition  Unique key from permissions config
	 * @param  array   $input
	 * @return bool
	 */
	public function updatePermission($input)
	{
        $validator = $this->Validator->make($input, $this->updateRules(), $this->messages);

        if ($validator->passes()){

            if(isset($input[ $input['permission_name_edit'] ])){
                $this->cleanInput($input[ $input['permission_name_edit'] ]);

                $configContents = $this->ConfigFileManager->getAppOnly('devise.permissions');

                if($input['permission_name'] != $input['permission_name_edit']){
                    unset($configContents[ $input['permission_name'] ]);
                }

                $this->includeRedirect($input, $input[ $input['permission_name_edit'] ]);

                $configContents[ $input['permission_name_edit'] ] = $input[ $input['permission_name_edit'] ];

                return $this->ConfigFileManager->saveToFile($configContents, 'permissions');
            }

            $this->errors[] = 'At least 1 rule must be present to save the condition.';
            return false;
        }

        $this->errors = $validator->errors()->all();
        return false;
    }

    /**
     * Destroys a permission by retrieving current config contents and
     * unsetting the key (condition) then saving the updated contents
     *
     * @param  string $condition
     * @return boolean | array
     */
    public function destroyPermission($condition)
    {
        // check if key exists in config, if so unset it
        if($this->Config->has('devise.permissions.' . $condition))
        {
            $configContents = $this->ConfigFileManager->getAppOnly('devise.permissions');
            unset($configContents[$condition]);

            return $this->ConfigFileManager->saveToFile($configContents, 'permissions');
        }

        $this->errors[] = 'Failed to remove permission, path unrecognized.';
        return false;
    }

    /**
     * Recursively walks the data received from the form and cleans all duplicate fields and empty values
     *
     * @param  array   $input
     * @param  array   $permission
     * @return void
     */
    protected function includeRedirect($input, &$permission)
    {
        if(isset($input['redirect']) && $input['redirect'] != ''){
            $permission['redirect'] = $input['redirect'];
            $permission['redirect_type'] = $input['redirect_type'];
            $permission['redirect_message'] = $input['redirect_message'];
        }
    }

    /**
     * Recursively walks the data received from the form and cleans all duplicate fields and empty values
     *
     * @param  array   $input
     * @return void
     */
    protected function cleanInput(&$input)
    {
        foreach ($input as $key => &$value) {
            if(is_array($value)){
                if(array_keys($value) !== range(0, count($value) - 1)){
                    $this->cleanInput($value);
                } else {
                    array_shift($value);
                    foreach ($value as $index => $param) {
                        if($param == '0'){
                            unset($value[$index]);
                        }
                    }
                }
            }
        }
    }

}