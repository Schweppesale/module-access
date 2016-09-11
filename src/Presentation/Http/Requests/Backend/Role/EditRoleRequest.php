<?php namespace Step\Access\Presentation\Http\Requests\Backend\Role;

use App\Http\Requests\Request;

/**
 * Class EditRoleRequest
 *
 * @package Step\Access\Presentation\Http\Requests\Backend\Role
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
