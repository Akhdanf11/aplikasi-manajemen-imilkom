<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atau tambahkan logika otorisasi sesuai kebutuhan
    }

    public function rules()
    {
        return [
            'location' => 'required',
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
