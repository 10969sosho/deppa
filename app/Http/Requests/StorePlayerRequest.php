<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100',
            'usia' => 'required|integer|min:1|max:100',
            'jenjang' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
        ];
    }
}
