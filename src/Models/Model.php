<?php

namespace Devise\Models;

use Devise\Http\Requests\ApiRequest;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
  public function createFromRequest(ApiRequest $request)
  {
    return $this->create($this->getFillableData($request));
  }

  public function updateFromRequest(ApiRequest $request)
  {
    return $this->update($this->getFillableData($request));
  }

  protected function getFillableData(ApiRequest $request)
  {
    $data = [];
    foreach ($this->fillable as $field)
    {
      if ($request->has($field))
      {
        $data[$field] = $request->get($field);
      }
    }

    return $data;
  }
}