<?php namespace Devise\Models\Queue;

/**
 * Class Store
 * @package Devise\Devise
 */
class DataQueue {
    private $executeList = array();
    public function add($model, $method, $params = array())
    {
        $this->executeList[] = array($model, $method, $params);
    }
    public function process()
    {
        $saved = array();
        foreach ($this->executeList as $executable){
            list($model, $method, $params) = $executable;
            $result = call_user_func_array(array($model, $method), $params);
            if($method == 'associate'){
                var_dump($model);
                var_dump($method);
                var_dump($params);
                $result->save();
            }
            $saved[] = $result;
        }
        return $saved;
    }
}