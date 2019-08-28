<?php

namespace Devise\Http\Requests\Users;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveUser extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'filled',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|confirmed'
    ];
  }
}
