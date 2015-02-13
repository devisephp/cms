<?php namespace Devise\Users\Permissions;

use Devise\Support\Framework;
use Illuminate\Filesystem\Filesystem as File;

/**
 * Class PermissionsRepository is used to retrieve permission data
 *
 * @package Devise\Permissions
 */
class PermissionsRepository
{
    protected $Framework;

    public function __construct(Framework $Framework, $File = null)
    {
        $this->Config = $Framework->Config;
        $this->Input = $Framework->Input;
        $this->View = $Framework->View;
        $this->Paginator = $Framework->Paginator;
    }

    /**
     * Get all permissions from current permissions config
     *
     * @return array
     */
    public function getAllPermissions()
    {
        return $this->Config->get('devise.permissions');
    }

    /**
     * Get permission and any related data by using its permission path
     * to retrieve its related data from the permissions config
     *
     * @param  string $condition
     * @return array
     */
    public function getPermissionByPath($condition)
    {
        $rules = $this->Config->get('devise.permissions.' . $condition);

        if ($rules !== null) {

            reset($rules);
            $firstKey = key($rules);
            if($firstKey == 'and' || $firstKey == 'or'){
                return $rules;
            } else {
                $newRules = array();
                if(isset($rules['redirect'])){
                    $newRules['redirect'] = $rules['redirect'];
                    unset($rules['redirect']);
                }
                if(isset($rules['redirect_type'])){
                    $newRules['redirect_type'] = $rules['redirect_type'];
                    unset($rules['redirect_type']);
                }
                if(isset($rules['redirect_message'])){
                    $newRules['redirect_message'] = $rules['redirect_message'];
                    unset($rules['redirect_message']);
                }

                $newRules['and'] = $rules;
                return $newRules;
            }
        } else {
            throw new \Devise\Support\DeviseException('Unable to load the condition "'. $condition .'".');
        }
    }

    /**
     * Get an array of all permission paths and human names
     *
     * @param integer $perPage
     * @return array
     */
    public function allPermissionsPaginated($perPage = 25)
    {
        $perPage = is_numeric($perPage) ?: 25;

        $perPage = ($perPage < 300) ?: 25;

        $permissions = $this->getAllPermissions();

        $currentPage = $this->Input->get('page', 1) - 1;

        $pagedData = array_slice($permissions, $currentPage * $perPage, $perPage);

        return $this->Paginator->make($pagedData, count($permissions), $perPage);
    }

    /**
     * Uses available rules from Devise\Users\Permissions\RuleManager Class to build options for select
     *
     * @return array
     */
    public function availableRulesList()
    {
        $rules = \RuleManager::getRules();
        $list = array();
        foreach ($rules as $value) {
            $list[ $value ] = $value;
        }
        return $list;
    }

    /**
     * Uses array of rule names to create a map of names to paramter count
     *
     * @return array
     */
    public function getRuleParamMap($rules)
    {
        $map = array();
        foreach ($rules as $value) {
            $map[ $value ] = \RuleManager::getNumberOfRequiredParametersForRule($value);
        }
        return $map;
    }

    /**
     * Get the extends/layout string from given permission path
     *
     * @return array
     */
    protected function getPermissionSourceByPath($condition)
    {
        // find the file location, so we can get the file contents
        $fileLocation = $this->View->make($condition)->getPath();
        return File::get($fileLocation);
    }

}