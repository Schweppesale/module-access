<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\User;

use App\Http\Requests\Request;

/**
 * Class PermanentlyDeleteUserRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\User
 */
class PermanentlyDeleteUserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('permanently-delete-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
