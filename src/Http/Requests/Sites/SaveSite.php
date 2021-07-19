<?php

namespace Devise\Http\Requests\Sites;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveSite extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required',
      'domain' => 'required',
      'languages' => 'filled|array'
    ];
  }
}
