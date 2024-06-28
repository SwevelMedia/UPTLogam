<?php

namespace App\Http\Requests\karyawan;

use App\Models\employee;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryawanRequest extends FormRequest
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
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nik'               => 'nullable',
            'pendidikan'        => 'nullable',
            'tempat_lahir'      => 'nullable',
            'tanggal_lahir'     => 'nullable',
            'gol_darah'         => 'nullable',
            'agama'             => 'nullable',
            'gender'            => 'nullable',
            'tanggal_masuk'     => 'nullable',
            'status_nikah'      => 'nullable',
            'address'           => 'nullable',
            'phone'             => 'nullable',
        ];
    }
}