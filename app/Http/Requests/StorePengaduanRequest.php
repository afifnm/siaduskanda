<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori' => ['required', 'string', 'max:100'],
            'jenis_pelapor' => ['required', 'string', 'max:50'],
            'nama_pelapor' => ['nullable', 'string', 'max:150'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'is_anonim' => ['nullable', 'boolean'],
            'judul' => ['required', 'string', 'min:5', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'uraian' => ['required', 'string', 'min:10'],
            'urgensi_pelapor' => ['required', 'string', 'in:Normal,Mendesak,Ada risiko keselamatan'],
            'bukti_pelapor_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'bukti_pelapor' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori.required' => 'Kategori pengaduan wajib dipilih.',
            'jenis_pelapor.required' => 'Jenis pelapor wajib dipilih.',
            'judul.required' => 'Judul laporan wajib diisi.',
            'judul.min' => 'Judul laporan minimal berisi 5 karakter.',
            'uraian.required' => 'Uraian pengaduan wajib diisi secara rinci.',
            'uraian.min' => 'Uraian pengaduan minimal berisi 10 karakter.',
            'urgensi_pelapor.required' => 'Tingkat urgensi wajib dipilih.',
            'bukti_pelapor_file.image' => 'File bukti harus berupa gambar.',
            'bukti_pelapor_file.max' => 'Ukuran file foto maksimal 5MB.',
        ];
    }
}
