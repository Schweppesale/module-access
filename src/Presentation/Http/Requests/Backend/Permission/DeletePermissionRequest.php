<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\Permission;

use App\Http\Requests\Request;

/**
 * Class DeletePermissionRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\Permission
 */
class DeletePermissionRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('delete-permissions');
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
