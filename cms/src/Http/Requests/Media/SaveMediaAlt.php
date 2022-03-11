<?php

namespace Devise\Http\Requests\Media;

use Devise\Http\Requests\ApiRequest;

class SaveMediaAlt extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'     => 'required',
            'alt_text' => 'required'
        ];
    }
}
