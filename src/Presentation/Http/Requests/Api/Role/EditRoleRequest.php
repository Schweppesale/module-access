<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class EditRoleRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role
 */
class EditRoleRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-roles');
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
