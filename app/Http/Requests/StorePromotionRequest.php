<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $promotionId = $this->input('promotion_id') ?? null;

        return [
            'discount_code' => 'required|string|min:6|max:10|unique:promotions,discount_code,' . $promotionId,
            'discount' => 'required|numeric|between:0,100',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'promotion_hd' => 'required|string|max:255',
            'promotion_sub_hd' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'discount_code.min' => 'Discount code must be at least 6 characters.',
            'discount_code.max' => 'Discount code can be at most 10 characters.',
        ];
    }
}
