<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atau tambahkan logika otorisasi sesuai kebutuhan
    }

    public function rules()
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ];
    }
}
