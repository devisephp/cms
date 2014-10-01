<?php namespace Devise\Data\Security;

use Crypt;
use URL;
use Session;

class FormEncrypt {
    /**
    * string containing the data for encryption
    */
    private static $data = '';
    private static $action = '';
    private static $keyHistory = array();

    /**
     * Called when a form is opened will save the url the form will submit to
     *
     * @param  array  $options
     * @return void
     */
    public static function addOpen($options)
    {
        self::$data = '';
        if(isset($options['route'])){
            if(is_string($options['route'])){
                self::$data .= URL::route($options['route']);
            } else {
                $routeName = $options['route'][0];
                array_shift($options['route']);
                self::$data .= URL::route($routeName, $options['route']);
            }
        } else if(isset($options['action'])){
            if(is_string($options['action'])){
                self::$data .= URL::action($options['action']);
            } else {
                self::$data .= URL::action($options['action'][0], $options['action'][1]);
            }
        } else if(isset($options['url'])) {
            self::$data .= URL::to($options['url']);
        }

        self::$action = self::$data;
    }

    /**
     * Adds to data the information of an input.  if it's secure type the value is also saved
     *
     * @param  array  $options
     * @return void
     */
    public static function addInput($options)
    {
        if($options['type'] != 'submit'){
            self::removeBrackets($options);
            self::adjustTrailingDots($options);
            self::addToData($options);
        } else if(isset($options['options']['name'])) {
            $options['name'] = $options['options']['name'];
            self::removeBrackets($options);
            self::adjustTrailingDots($options);
            self::addToData($options);
        }
    }

    /**
     * encrypts and returns all the data from a form
     *
     * @return string
     */
    public static function getToken()
    {
        //Session::flash(self::$action, Crypt::encrypt(self::$data));
    }

    private static function removeBrackets(&$options)
    {
        $parts = explode('[', $options['name']);
        $name = implode('.', $parts);
        $options['name'] = str_replace(']', '', $name);
    }

    private static function adjustTrailingDots(&$options)
    {
        if(substr($options['name'], -1) == '.'){
            $count = (isset(self::$keyHistory[$options['name']])) ? self::$keyHistory[$options['name']] + 1 : 0;
            self::$keyHistory[$options['name']] = $count;
            $options['name'] .= $count;
        }
    }

    private static function addToData($options)
    {
        if(isset($options['type']) && $options['type'] == 'secure'){
            self::$data .= '||' . $options['name'] . ':' . $options['value'] . ':' . $options['type'];
        } else {
            self::$data .= '||' . $options['name'] . ':' . $options['type'];
        }
    }
}
