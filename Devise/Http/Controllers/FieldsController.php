<?php

namespace Devise\Http\Controllers;;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Resources\Api\FieldResource;
use Devise\Models\DvsField;

use Illuminate\Routing\Controller;

class FieldsController extends Controller
{
  /**
   * @var DvsField
   */
  private $DvsField;


  /**
   * FieldsController constructor.
   * @param DvsField $DvsField
   */
  public function __construct(DvsField $DvsField)
  {
    $this->DvsField = $DvsField;
  }

  /**
   * @param ApiRequest $request
   * @param $id
   * @return FieldResource
   */
  public function update(ApiRequest $request, $id)
  {
    $field = $this->DvsField
      ->findOrFail($id);

    $data = $request->all();

    if(count($data))
    {
      $field->json_value = json_encode($data);
    } else {
      $field->json_value = "{}";
    }

    return new FieldResource($field);
  }
}