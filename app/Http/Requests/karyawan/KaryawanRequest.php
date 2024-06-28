<?php

namespace App\Http\Requests\karyawan;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class KaryawanRequest extends FormRequest
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
            'name'              => ['required'],
            'nip'               => ['required'],
            'role'              => ['required'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'          => ['required', 'min:6'],
            'photo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nik'               => 'nullable',
            'pendidikan'        => 'nullable',
            'tempat_lahir'      => 'nullable',
            'tanggal_lahir'     => 'nullable',
            'gol_darah'         => 'nullable',
            'agama'             => 'nullable',
            'gender'            => 'nullable',
            'tanggal_masuk'     => 'required',
            'status_nikah'      => 'nullable',
            'address'           => 'nullable',
            'phone'             => 'nullable',
        ];
    }
}
