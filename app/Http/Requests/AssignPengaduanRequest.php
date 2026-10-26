<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'kategori_definitif' => ['nullable', 'string', 'max:100'],
            'urgensi_admin' => ['required', 'string', 'in:Normal,Mendesak,Ada risiko keselamatan'],
            'unit_tujuan' => ['required', 'string', 'max:150'],
            'petugas_id' => ['nullable', 'exists:users,id'],
            'nama_petugas' => ['nullable', 'string', 'max:150'],
            'deadline' => ['nullable', 'date'],
            'deadline_hours' => ['nullable', 'integer'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'urgensi_admin.required' => 'Urgensi resmi sekolah wajib ditentukan.',
            'unit_tujuan.required' => 'Unit kerja tujuan wajib dipilih.',
        ];
    }
}
