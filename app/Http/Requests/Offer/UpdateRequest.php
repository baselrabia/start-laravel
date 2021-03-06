<?php

namespace App\Http\Requests\Offer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
    public function rules()
    {
        // dd($this->all());

        // dd($this->offer_id);
        return [
            'name_ar' => 'required|unique:offers,name_ar,' . $this->offer . '|max:255',
            'name_en' => 'required|unique:offers,name_en,' . $this->offer . '|max:255',
            'details_ar' => 'required|min:10',
            'details_en' => 'required|min:10',
            'price' => 'required|max:255|min:1',
            // 'image' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => __('messages.name.required'),
            'name_ar.unique' => __('messages.name.unique'),
            'name_en.required' => __('messages.name.required'),
            'name_en.unique' => __('messages.name.unique'),
            'details_ar.required' => __('messages.details.required'),
            'details_en.required' => __('messages.details.required'),
            'price.required' => __('messages.price.required'),
            // 'image' => __('messages.image.required'),
        ];
    }
}
