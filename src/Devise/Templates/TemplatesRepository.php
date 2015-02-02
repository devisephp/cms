<?php namespace Devise\Templates;

use Devise\Support\Framework;

/**
 * Class TemplatesRepository is used to retrieve template data
 *
 * @package Devise\Templates
 */
class TemplatesRepository
{
    protected $Framework;

    public function __construct(TemplatesManager $TemplatesManager, Framework $Framework, $File = null)
    {
        $this->TemplatesManager = $TemplatesManager;

        $this->Config = $Framework->Config;
        $this->Input = $Framework->Input;
        $this->View = $Framework->View;
        $this->File = $File ?: \File::getFacadeRoot();
    }

    /**
     * Get template and any related data by using its template path
     * to retrieve its related data from the templates config
     *
     * @param  string $templatePath
     * @return array
     */
    public function getTemplateByPath($templatePath)
    {
        $template = $this->Config->get('devise::templates')[$templatePath];

        $templateSource = $this->getTemplateSourceByPath($templatePath);

        // if extends is empty/not set, retrieve it from blade
        if(empty($template['extends'])) {
            $template['extends'] = $this->getTemplateExtends($templateSource);
        }

        // retrieve and set any vars found in source of config
        $template['vars'] = $this->getVarsFromSource($template, $templateSource);

        // split vars array into vars and newVars keys
        $template = $this->splitVarsAndNewVars($template);

        return $template;
    }

    /**
     * Get an array of all template paths and human names
     *
     * @param integer $perPage
     * @return array
     */
    public function allTemplatesPaginated($perPage = 25)
    {
        $templatesList = $this->registeredTemplatesList();

        $currentPage = $this->Input->get('page', 1) - 1;

        $pagedData = array_slice($templatesList, $currentPage * $perPage, $perPage);

        return \Paginator::make($pagedData, count($templatesList), $perPage);
    }

    /**
     * Get an array of all registered templates as an array of paths
     * and human names; registered means already in templates config
     *
     * @param boolean $showHumanName  False returns just paths array
     * @return array
     */
    public function registeredTemplatesList($showHumanName = true)
    {
        $templatesArr = $this->Config->get('devise::templates');
        $templateKeysArr = array_keys($templatesArr);

        $results = array();
        foreach($templateKeysArr as $template) {
            if($showHumanName) {
                $results[$template] = array_get($templatesArr[$template], 'human_name', $template);
            } else {
                $results[$template] = $template;
            }
        }

        asort($results);
        return $results;
    }


     /**
     * Get list of unregistered templates by finding all app template files
     * which are not stored (do not have path key) in the templates config
     *
     * @return array
     */
    public function unregisteredTemplatesList()
    {
        $templates = array();
        $templateLocations = $this->Config->get('view');
        $regisHumanNames = $this->registeredTemplatesList();

        foreach ($templateLocations['paths'] as $path) {

            if (!$this->File->exists($path)) {
                continue;
            }

            $files = $this->File->allFiles($path);

            foreach ($files as $file) {
                if (substr_count($file->getRelativePathname(), '.blade.php')) {

                    $value = str_replace('/', '.', str_replace('.blade.php', '', $file->getRelativePathname()));
                    $nameArr = explode('.', $value);

                    $templateName = last($nameArr);

                    if (substr($templateName, 0, 1) != '_') {
                        $templates[$value] = isset($regisHumanNames[$value]) ? $regisHumanNames[$value] : $value;
                    }
                }
            }
        }

        asort($templates);
        return array_diff($templates, $regisHumanNames);
    }

    /**
     * Get the extends/layout string from given template path
     *
     * @return array
     */
    protected function getTemplateSourceByPath($templatePath)
    {
        // find the file location, so we can get the file contents
        $fileLocation = $this->View->make($templatePath)->getPath();
        return \File::get($fileLocation);
    }

    /**
     * Get the extends/layout string from given template source/contents
     *
     * @param string $templateSource
     * @return array
     */
    protected function getTemplateExtends($templateSource)
    {
        preg_match('/@extends\(\'(.+)\'\)/', $templateSource, $matches);
        return array_pop($matches);
    }

    /**
     * Regex template source/contents to find all variables. An
     * array of variables to ignore from results is also accepted
     *
     * @param array  $template
     * @param string $templateSource
     * @param string $excludeArr  Strings to be excluded/omitted
     * @return array
     */
    protected function getVarsFromSource($template, $templateSource, $excludeArr = array('$page','$input','$params'))
    {
        // gets all variables in template and assigns them to $templateVars
        preg_match_all('/\$[A-Za-z0-9_]+/', $templateSource, $templateVars);

        $templateVars = array_unique($templateVars[0]);

        $varsArr = array();
        foreach($templateVars as $var) {
            if(!in_array($var, $excludeArr)) {
                $varsArr[str_replace("$","",$var)] = NULL;
            }
        }

        // ensure vars key is defined in templates array
        $template['vars'] = array_get($template, 'vars', array());

        return $template['vars'] + $varsArr;
    }

    private function splitVarsAndNewVars($template)
    {
        foreach($template['vars'] as $varName => $varVal) {
            if(is_null($varVal)) {
                // add varName to newVars array
                $template['newVars'][$varName] = NULL;

                // unset/remove key from template vars array
                unset($template['vars'][$varName]);
            }
        }

        return $template;
    }

}