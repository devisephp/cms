<?php

namespace Devise\Http\Requests\Templates;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveTemplate extends ApiRequest
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
      'layout' => [
        'filled',
        new ViewExists
      ]
    ];
  }
}
