<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class RestoreUserRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User
 */
class RestoreUserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('restore-users');
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
