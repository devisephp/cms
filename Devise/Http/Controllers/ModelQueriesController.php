<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\ModelQueries;
use Illuminate\Routing\Controller;

class ModelQueriesController extends Controller
{

    public function index(ApiRequest $request)
    {
        return ModelQueries::all();
    }
}