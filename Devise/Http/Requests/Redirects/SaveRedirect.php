<?php

namespace Devise\Http\Requests\Redirects;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveRedirect extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'from_url' => 'required',
      'to_url' => 'required'
    ];
  }
}
