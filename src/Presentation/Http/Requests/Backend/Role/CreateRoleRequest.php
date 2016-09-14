<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class CreateRoleRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role
 */
class CreateRoleRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('create-roles');
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
