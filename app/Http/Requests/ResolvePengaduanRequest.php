<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResolvePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'catatan_petugas' => ['required', 'string', 'min:5'],
            'suku_cadang' => ['nullable', 'string', 'max:255'],
            'bukti_petugas_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'bukti_petugas' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_petugas.required' => 'Catatan tindakan teknis / solusi wajib diisi.',
            'catatan_petugas.min' => 'Catatan tindakan minimal 5 karakter.',
            'bukti_petugas_file.image' => 'File bukti penanganan harus berupa gambar.',
        ];
    }
}
