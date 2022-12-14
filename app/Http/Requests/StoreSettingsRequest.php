<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vat_value' => 'required|numeric',
            'vat_value_type' => 'nullable|in:percentage,amount',
            'shipping_cost_value' => 'required|numeric',
            'shipping_cost_value_type' => 'nullable|in:percentage,amount',
        ];
    }
}
