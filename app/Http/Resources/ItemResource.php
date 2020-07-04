<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    // public function attach($resource, Request $request = null)
    // {
    //     $request = $request ?? request();
    //     return tap($resource, function ($resource) use ($request) {
    //         $this->getRequestIncludes($request)->each(function ($include) use ($resource) {
    //             $resource->load($include);
    //         });
    //     });
    // }
    // protected function getRequestIncludes(Request $request)
    // {
    //     return collect(data_get($request->input(), 'category', []));
    // }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
