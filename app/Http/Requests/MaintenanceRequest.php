<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;

class MaintenanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $rules = [
            'hardware' => 'required',
            'total_work' => ['required_if:maintenance_time.*,null|required_with:breakdown'],
            'breakdown.*' => ['required_with:total_work'],
            'maintenance_time.*' => ['required_if:total_work,null'],
        ];

        return $rules;
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'hardware.required' => 'Kolom Hardware harus di isi',
            'total_work.required_with' => 'Kolom Total Waktu Kerja (Tanpa Kerusakan) harus di isi',
            'breakdown.*.required_with' => 'Kolom Waktu Kerusakan harus di isi',
            'total_work.required_if' => 'Kolom Total Waktu Kerja (Tanpa Kerusakan) harus di isi',
            'maintenance_time.*.required_if' => 'Kolom Total Maintenance Harus Di Isi',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            Response::json([
                'status' => 'error',
                'data' => collect($errors)->flatten()->toArray(),
            ], 422)
        );
    }
}