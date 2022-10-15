<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->translation($request, 'name'),
            'description' => $this->translation($request, 'description'),
            'price'       => $this->price,
            'price_has_vat' => $this->price_has_vat ? true : false,
            'price_note' => $this->price_has_vat ? 'Price include VAT' : 'Price not Include VAT',
            'vat_value'  => $this->price_has_vat ? 0 : $this->store->vat_value,
            'vat_value_type' => $this->price_has_vat ? '' : $this->store->vat_value_type,
        ];
    }

    private function translation($request, $attribute)
    {
        if ($request->lang) {
            return $this->getTranslation($attribute, $request->lang);
        }else {
            return $this->getTranslations($attribute);
        }
    }
}
