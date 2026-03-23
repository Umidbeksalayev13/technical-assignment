<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'subject' => 'required |max:255',
            'message' => 'required',
            'file' => 'file|mimes:jpeg,png,jpg,pdf,gif,svg|max:2048'
        ];
    }
}
