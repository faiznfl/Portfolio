<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string', 'max:120'],
            'sender_email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:200'],
            'message_body' => ['required', 'string', 'min:10', 'max:5000'],
            'website_hp' => ['nullable', 'max:0'], // Honeypot field: must be empty
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sender_name.required' => 'Nama lengkap wajib diisi.',
            'sender_email.required' => 'Alamat email wajib diisi.',
            'sender_email.email' => 'Format alamat email tidak valid.',
            'subject.required' => 'Subjek pesan kerja sama wajib diisi.',
            'message_body.required' => 'Isi pesan penawaran wajib diisi.',
            'message_body.min' => 'Isi pesan minimal 10 karakter.',
            'website_hp.max' => 'Pengiriman terdeteksi sebagai spam.',
        ];
    }
}
