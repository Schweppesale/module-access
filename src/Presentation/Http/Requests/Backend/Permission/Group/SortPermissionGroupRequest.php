<?php namespace Step\Access\Presentation\Http\Requests\Backend\Permission\Group;

use App\Http\Requests\Request;

/**
 * Class SortPermissionGroupRequest
 *
 * @package Step\Access\Presentation\Http\Requests\Backend\Permission\Group
 */
class SortPermissionGroupRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('sort-permission-groups');
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
