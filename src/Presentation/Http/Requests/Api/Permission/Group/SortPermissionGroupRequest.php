<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class SortGroupRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group
 */
class SortGroupRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('sort-groups');
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
