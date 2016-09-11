<?php namespace Step\Access\Presentation\Http\Requests\Backend\User;

use App\Http\Requests\Request;

/**
 * Class StoreUserRequest
 *
 * @package Step\Access\Presentation\Http\Requests\Backend\User
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
        return access()->can('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:\Step\Access\Presentation\Entities\User',
            'email' => 'required|email|unique:\Step\Access\Presentation\Entities\User',
            'password' => 'required|alpha_num|min:6|confirmed',
            'password_confirmation' => 'required|alpha_num|min:6',
        ];
    }
}
