<?php

namespace Devise\Http\Requests\Languages;

use Devise\Http\Requests\ApiRequest;

class SaveLanguage extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'code'                => 'required|unique:dvs_languages,code',
      'human_name'          => 'required',
      'regional_human_name' => 'filled'
    ];
  }
}
