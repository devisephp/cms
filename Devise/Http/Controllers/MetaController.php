<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Meta\SaveMeta;
use Devise\Http\Requests\Meta\DeleteMeta;
use Devise\Http\Resources\Api\MetaResource;
use Devise\Models\DvsPageMeta;

use Illuminate\Routing\Controller;

class MetaController extends Controller
{
    /**
     * @var DvsPageMeta
     */
    private $DvsPageMeta;


    /**
     * MetasController constructor.
     * @param DvsPageMeta $DvsPageMeta
     */
    public function __construct(DvsPageMeta $DvsPageMeta)
    {
        $this->DvsPageMeta = $DvsPageMeta;
    }

    public function all(ApiRequest $request)
    {
        $all = $this->DvsPageMeta
            ->where('page_id', 0)
            ->get();

        return MetaResource::collection($all);
    }

    /**
     * @param SaveMeta $request
     * @return MetaResource
     */
    public function store(SaveMeta $request)
    {
        $new = $this->DvsPageMeta
            ->createFromRequest($request);

        return new MetaResource($new);
    }

    /**
     * @param SaveMeta $request
     * @param $id
     * @return MetaResource
     */
    public function update(SaveMeta $request, $id)
    {
        $slice = $this->DvsPageMeta
            ->where('page_id', 0)
            ->findOrFail($id);

        $slice->updateFromRequest($request);

        return new MetaResource($slice);
    }

    /**
     * @param DeleteMeta $request
     * @param $id
     */
    public function delete(DeleteMeta $request, $id)
    {
        $slice = $this->DvsPageMeta
            ->where('page_id', 0)
            ->findOrFail($id);

        $slice->delete();
    }
}