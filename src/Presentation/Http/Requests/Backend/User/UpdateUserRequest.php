<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\User;

use App\Http\Requests\Request;

/**
 * Class UpdateUserRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\User
 */
class UpdateUserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
        ];
    }
}
