<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
     * Validation rules for wallet request.
     *
     * @return array
     */
    public function rules()
    {
        $validationRules = [
            'walletAddress' => [
                'required',
                'regex:/^0x[a-fA-F0-9]{40}$/'
            ],
            'smartchain'    => [
                'required',
                'in:' . implode(',', array_keys(config('smartchain')))
            ],
        ];

        // Add validation rules for historical balance request
        if ($this->route()->getName() === 'wallet.balance') {
            $validationRules['date'] = [
                'required',
                'date_format:Y-m-d',
                'before:today'
            ];
        }

        return $validationRules;
    }

    /**
     * Setup the validation of route parameters.
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['walletAddress'] = $this->route('walletAddress');

        return $data;
    }
}
