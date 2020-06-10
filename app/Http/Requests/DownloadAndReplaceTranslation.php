<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadAndReplaceTranslation extends FormRequest
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
        $rules = [
            'translationType' => 'required',
            'translationFrom' => 'required',
            'originalLanguage' => 'required',
            'destinationLanguage' => 'required',
            'numberOfStrings' => 'required|integer|min:1|max:1000000'
        ];

        if (($this->attributes->get('translationType') === 'plugin') || ($this->attributes->get('translationType') === 'plugin')) {
            $rules['slug'] = 'required';
        }
        return $rules;
    }
}
