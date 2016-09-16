<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class PermanentlyDeleteUserRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\User
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
