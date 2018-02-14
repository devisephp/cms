<?php

namespace Devise\Http\Requests\Users;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends ApiRequest
{

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $userId = $this->route('user_id');

    return [
      'name'     => 'filled',
      'email'    => [
        'required',
        'email',
        Rule::unique('users')->where(function ($query) use ($userId) {
          return $query->where('id', '!=', $userId);
        })
      ],
      'password' => 'filled|string|min:6|confirmed'
    ];
  }
}
