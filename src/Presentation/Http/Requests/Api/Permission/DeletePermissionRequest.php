<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\Permission;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class DeletePermissionRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\Permission
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
