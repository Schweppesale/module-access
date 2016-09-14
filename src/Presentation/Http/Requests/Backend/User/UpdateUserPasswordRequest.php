<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class UpdateUserPasswordRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User
 */
class UpdateUserPasswordRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('change-user-password');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6'
        ];
    }
}
