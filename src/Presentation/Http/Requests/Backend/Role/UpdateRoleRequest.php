<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class UpdateRoleRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role
 */
class UpdateRoleRequest extends Request
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
            'name' => 'required',
        ];
    }
}
