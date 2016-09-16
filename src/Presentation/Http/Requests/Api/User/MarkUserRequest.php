<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class MarkUserRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\User
 */
class MarkUserRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Get the 'mark' id
        switch ((int)request()->segment(6)) {
            case 0:
                return access()->can('deactivate-users');
                break;

            case 1:
                return access()->can('reactivate-users') || access()->can('unban-users');
                break;

            case 2:
                return access()->can('ban-users');
                break;
        }

        return false;
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