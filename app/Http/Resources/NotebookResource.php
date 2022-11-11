<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotebookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'fio' => $this->fio,
          'company' => $this->company,
          'phone' => $this->phone,
          'email' => $this->email,
          'birthday' => $this->birthday,
          'photo' => $this->photo,
        ];
    }
}
