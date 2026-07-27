<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'score' => 'required|integer|min:0',
        ];
    }
}
