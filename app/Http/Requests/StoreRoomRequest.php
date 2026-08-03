<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_ruang' => ['required', 'string', 'max:20', 'unique:rooms,kode_ruang'],
            'nama_ruang' => ['required', 'string', 'max:100'],
            'gedung' => ['required', 'string', 'max:100'],
            'lantai' => ['required', 'integer', 'min:1'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'fasilitas' => ['nullable', 'string'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
        ];
    }
}
