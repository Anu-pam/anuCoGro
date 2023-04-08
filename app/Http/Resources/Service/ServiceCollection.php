<?php

namespace App\Http\Resources\Service;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                    'record'=>$this->collection,
                    'meta'=>[
                        "current_page" => $this->currentPage(),
                        "total" =>  $this->total(),
                        "per_page" =>  $this->perPage(),
                        "last_page" =>  $this->lastPage(),
                        "next_page" =>  ($this->currentPage()+1),
                    ]
                ];
    }
}
