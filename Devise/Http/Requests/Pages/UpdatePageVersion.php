<?php

namespace Devise\Http\Requests\Pages;

use Devise\Http\Requests\ApiRequest;

class UpdatePageVersion extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'start_date'        => 'filled|date|nullable',
      'end_date'          => 'filled|date|nullable',
      'ab_testing_amount' => 'filled|numeric',
    ];
  }
}
