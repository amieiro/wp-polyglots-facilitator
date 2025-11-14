<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadAndReplaceTranslation extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'translationType' => 'required',
            'translationFrom' => 'required',
            'originalLanguage' => 'required',
            'destinationLanguage' => 'required',
            'numberOfStrings' => 'required|integer|min:1|max:1000000'
        ];

        if (($this->input('translationType') === 'plugin') || ($this->input('translationType') === 'theme')) {
            $rules['slug'] = 'required';
        }
        return $rules;
    }
}
