<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\Group;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class CreateGroupRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\Group
 */
class CreateGroupRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
