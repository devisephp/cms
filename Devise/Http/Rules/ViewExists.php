<?php

namespace Devise\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\View;

class ViewExists implements Rule
{
  /**
   * Determine if the validation rule passes.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @return bool
   */
  public function passes($attribute, $value)
  {
    return View::exists($value);
  }

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return 'The view selected does not exist.';
  }
}