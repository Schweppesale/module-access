<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class StoreUserRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\User
 */
class StoreUserRequest extends Request
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
            'name' => 'required|unique:\Schweppesale\Module\Access\Presentation\Entities\User',
            'email' => 'required|email|unique:\Schweppesale\Module\Access\Presentation\Entities\User',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
        ];
    }
}
