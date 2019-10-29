<?php

namespace Devise\Models;

use Devise\Http\Requests\ApiRequest;

use Devise\MotherShip\ReleasesToMotherShip;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Arr;

class Model extends BaseModel
{
  use ReleasesToMotherShip;

  public function createFromRequest(ApiRequest $request)
  {
    return $this->create($this->getFillableData($request));
  }

  public function createFromArray($input)
  {
    return $this->create($this->getFillableData($input));
  }

  public function updateFromRequest(ApiRequest $request)
  {
    return $this->update($this->getFillableData($request));
  }

  public function updateFromArray($input)
  {
    return $this->update($this->getFillableData($input));
  }

  protected function getFillableData($request)
  {
    if(is_a($request, ApiRequest::class))
    {
      return $request->only($this->fillable);
    }

    return Arr::only($request, $this->fillable);
  }
}