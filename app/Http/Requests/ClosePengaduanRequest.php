<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClosePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'admin_close_feedback' => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'admin_close_feedback.required' => 'Catatan verifikasi penutupan tiket wajib diisi.',
            'admin_close_feedback.min' => 'Catatan verifikasi penutupan tiket minimal 5 karakter.',
        ];
    }
}
