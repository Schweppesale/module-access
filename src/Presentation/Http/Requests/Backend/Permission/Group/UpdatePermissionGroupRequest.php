<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\Permission\Group;

use App\Http\Requests\Request;

/**
 * Class UpdatePermissionGroupRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\Permission\Group
 */
class UpdatePermissionGroupRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-permission-groups');
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
