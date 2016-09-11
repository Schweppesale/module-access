<?php namespace Step\Access\Presentation\Http\Requests\Backend\Permission;

use App\Http\Requests\Request;

/**
 * Class EditPermissionRequest
 *
 * @package Step\Access\Presentation\Http\Requests\Backend\Permission
 */
class EditPermissionRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-permissions');
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
