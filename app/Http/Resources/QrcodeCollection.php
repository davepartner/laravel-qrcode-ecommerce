<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;


class QrcodeCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $this
     * @return array
     */
    public function toArray($request)
    {
        return [
            'amount' => $this->amount,
            'company_name' => $this->company_name,
            'product_name' => $this->product_name,
            'link' => [
                'qrcode_link' => route('qrcodes.show', $this->id),
            ]
        ];
     
        
    }
}
