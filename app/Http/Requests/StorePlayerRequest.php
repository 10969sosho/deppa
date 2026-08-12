<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePlayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100|unique:players,nama',
            'usia' => 'required|integer|min:1|max:100',
            'jenjang' => 'required|string|max:50',
            'gender' => 'required|string|max:10',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => trim((string) $this->input('nama')),
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $name = (string) $this->input('nama');

        $validator->after(function (Validator $validator) use ($name): void {
            if ($name !== '' && Player::whereRaw('LOWER(nama) = LOWER(?)', [$name])->exists()) {
                $validator->errors()->add('nama', 'Nama sudah terdaftar. Gunakan nama lain.');
            }
        });
    }
}
