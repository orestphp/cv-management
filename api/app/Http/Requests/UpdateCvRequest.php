<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCvRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cv.title' => ['string', 'max:255', 'required'],
            'cv.first_name' => ['string', 'max:255', 'nullable'],
            'cv.surname' => ['string', 'max:255', 'nullable'],
            'cv.middle_name' => ['string', 'max:255', 'nullable'],
            'cv.date_of_birth' => ['string', 'max:255', 'nullable'],
            'cv.email' => ['email'],
            'cv.phone' => ['string', 'max:255', 'nullable'],
            'cv.avatar' => ['string', 'max:255', 'nullable'],
            'cv.address' => ['string', 'max:255', 'nullable'],
            'cv.linkedin' => ['string', 'max:255', 'nullable'],
            'cv.skype' => ['string', 'max:255', 'nullable'],
            'cv.website' => ['string', 'max:255', 'nullable'],
            'cv.about_me' => ['string', 'max:512', 'nullable'],
            'cv.technology_experience' => ['string', 'max:512', 'nullable'],
        ];
    }
}
