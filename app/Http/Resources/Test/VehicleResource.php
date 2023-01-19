<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'vehiculo' => [
                'status' => 'OK',
                'auto' => [
                    'compania' => 'SURA',
                    'marca' => $this->brand->name,
                    'modelo' => $this->model->name,
                    'color' => $this->color->name,

                ]
            ]

        ];
    }
}
