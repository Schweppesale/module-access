<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\Token;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class RegisterRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\Auth
 */
class RegisterRequest extends Request
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
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
