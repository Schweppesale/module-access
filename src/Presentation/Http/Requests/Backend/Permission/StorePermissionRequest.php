<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\Permission;

use App\Http\Requests\Request;

/**
 * Class StorePermissionRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\Permission
 */
class StorePermissionRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('create-permissions');
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
            'display_name' => 'required',
        ];
    }
}
