<?php

namespace Devise\Http\Requests\Pages;

use Devise\Http\Requests\ApiRequest;

class StorePageVersion extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'page_version_id' => 'required|exists:dvs_page_versions,id',
      'name'  => 'required'
    ];
  }
}
