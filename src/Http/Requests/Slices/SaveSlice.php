<?php

namespace Devise\Http\Requests\Slices;

use Devise\Http\Rules\ViewExists;
use Devise\Http\Requests\ApiRequest;

class SaveSlice extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'copy_slice_id' => [
                'required',
                'exists:dvs_slice_instances,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'copy_slice_id.exists' => 'This slice does not exist yet. Please save the page before trying to copy a slice.'
        ];
    }
}
