<?php

namespace App\Http\Requests\Nft;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255|unique:nfts,title', // Заголовок уникален в таблице nfts
            'description' => 'required|string', // Описание должно быть строкой
            'royalty' => 'required|numeric|between:0,99999999.99', // Royalty только десятичные числа от 0 до 50
//            'put_on_sale' => 'required|boolean', // Продажа должна быть булевым значением
//            'direct_sale' => 'required|boolean', // Прямая продажа должна быть булевым значением
            'currentBid' => 'nullable|numeric|between:0,99999999.99', // Ставка должна быть десятичным числом или null
            'price' => 'nullable|numeric|between:0,99999999.99', // Цена должна быть десятичным числом или null
            'in_stock' => 'required|integer|digits_between:1,6', // В наличии должен быть числом от 001 до 999
            'author_id' => 'required|integer', // Автор пока временно, так как без него у меня не получится получить данные
            'sale_type' => 'required|string|in:put_on_sale,direct_sale', // Тип продажи: аукцион или одной ценой
            'end_time' => 'nullable|date',
        ];
    }
}
