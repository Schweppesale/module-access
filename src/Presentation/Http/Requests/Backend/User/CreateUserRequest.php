<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class CreateUserRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User
 */
class CreateUserRequest extends Request
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
        ];
    }
}
