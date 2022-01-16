<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * Validation rules for transaction request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'walletAddress' => ['required', 'regex:/^0x[a-fA-F0-9]{40}$/'],
            'smartchain'    => ['required', 'in:'.implode(',', array_keys(config('smartchain')))],
            'startblock'    => ['integer', 'between:0,99999999'],
            'endblock'      => ['integer', 'between:0,99999999'],
            'page'          => ['integer', 'min:1'],
        ];
    }
}
