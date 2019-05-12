<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Field extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public $payload = [];

    public function toArray($request)
    {
        //return parent::toArray($request);
        
        
        $this->payload = [
            'id' => $this->id,
            'field1' => $this->field1,
            'field2' => $this->field2,
            'field3' => $this->field3,
            'field4' => $this->field4,
            'roofId'=> $this->roofId
        ];

        $this->payloadcheck('field5');
        $this->payloadcheck('field6');
        $this->payloadcheck('field7');
        $this->payloadcheck('field8');
        $this->payloadcheck('field9');
        $this->payloadcheck('field10');
        $this->payloadcheck('field11');
        $this->payloadcheck('field12');
        $this->payloadcheck('field13');
        $this->payloadcheck('field14');
        $this->payloadcheck('field15');
        $this->payloadcheck('field16');
        $this->payloadcheck('field17');
        $this->payloadcheck('field18');

        return $this->payload;
    }

    public function payloadcheck($value){
        if($this->$value != "" && $this->$value != "0"){
            $this->payload[$value] = $this->$value;
        }
    }
}
