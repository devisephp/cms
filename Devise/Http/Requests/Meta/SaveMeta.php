<?php

namespace Devise\Http\Requests\Meta;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveMeta extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'attribute_name' => 'required',
      'attribute_value' => 'required'
    ];
  }
}
