<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class EditGroupRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group
 */
class EditGroupRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('edit-groups');
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
