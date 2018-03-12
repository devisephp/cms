<?php

namespace Devise\Http\Requests\Redirects;

use Devise\Http\Requests\ApiRequest;

class ExecuteRedirect extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [];
  }

  /**
   * @param $route
   * @return string
   */
  public function newUrl($route)
  {
    $query = '';
    $allinput = [];
    $urlParts = parse_url($route->to_url);

    if(isset($urlParts['query'])){
      parse_str($urlParts['query'], $allinput);
    }

    $input = $this->all();
    $allinput = array_merge($allinput, $input);

    if($allinput){
      $query = '?' . http_build_query($allinput);
    }

    $parts = explode('?', $route->to_url);

    return $parts[0] . $query;
  }
}
