<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class ApiResourceCollection extends ResourceCollection
{
     /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $data = (object)array_merge(
            ["status" => 200],
            (array)$response->getData()
        );
        $response->setData($data);
    }
}
