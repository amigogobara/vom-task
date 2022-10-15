<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateCollection extends ResourceCollection
{
    private $resourceClass;

    public function __construct($resource, $resourceClass)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->resourceClass = $resourceClass;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->resourceClass::collection($this->collection),
            'per_page' => (int) $this->resource->perPage(),
            'total' => (int) $this->resource->total(),
            'current_url' => request()->url().'?'
                .http_build_query(request()->all()),
            'last_page'   => $this->resource->lastPage(),
            'current_page' => $this->resource->currentPage(),
        ];
    }
}
