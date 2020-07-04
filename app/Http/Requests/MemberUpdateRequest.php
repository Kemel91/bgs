<?php

namespace App\Http\Requests;

class MemberUpdateRequest extends MemberRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:members,email,'.$this->route('member'),
            'events' => 'nullable|array',
            'events.*.id' => 'nullable|integer|exists:events,id'
        ];
    }
}
