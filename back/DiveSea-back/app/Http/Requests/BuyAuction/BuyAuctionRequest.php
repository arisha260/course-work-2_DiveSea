<?php

namespace App\Http\Requests\BuyAuction;

use Illuminate\Foundation\Http\FormRequest;

class BuyAuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nft_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'bid_amount' => 'nullable|numeric|between:0,99999999.99',
        ];
    }
}
