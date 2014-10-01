<?php

namespace Devise\Models\Controllers;

use Devise\Models\DeviseStore;
use Illuminate\Routing\Controller;
use Input;
use Redirect;

class DeviseStoreController extends Controller {

    /**
     * The Validator instance
     *
     * @var Validator
     */
    public $validator;

    /**
     * Any validation or error message
     *
     * @var Array
     */
    public $message;

    private $DeviseStore;

    function __construct(DeviseStore $DeviseStore)
    {
        $this->DeviseStore = $DeviseStore;
    }

    public function store()
    {
        $successRedirect = (Input::has('success_redirect')) ? Input::get('success_redirect') : Redirect::back();
        $input = array_except(Input::all(), array('_method', '_token', '_data_token', 'success_redirect'));

        if($saved = $this->DeviseStore->store($input)){
            return $successRedirect;
        } else {
            Redirect::back()->with($this->DeviseStore->errors);
        }
    }

    public function update($id)
    {
        $successRedirect = (Input::has('success_redirect')) ? Input::get('success_redirect') : Redirect::back();
        $input = array_except(Input::all(), array('_method', '_token', '_data_token'));

        if($this->DeviseStore->update($id, $input)){
            return $successRedirect;
        } else {
            Redirect::back()->with($this->DeviseStore->errors);
        }
    }
} 