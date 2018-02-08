<?php

namespace Devise\Http\Requests\Slices;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveSlice extends ApiRequest
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
      'view' => [
        'filled',
        new ViewExists
      ]
    ];
  }
}
