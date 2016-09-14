<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class CreatePermissionRequest
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission
 */
class CreatePermissionRequest extends Request
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
            //
        ];
    }
}
