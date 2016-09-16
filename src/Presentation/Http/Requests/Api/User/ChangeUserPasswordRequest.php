<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class ChangeUserPasswordRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\User
 */
class ChangeUserPasswordRequest extends Request
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
            //
        ];
    }
}
