<?php namespace Step\Access\Presentation\Http\Requests\Backend\User;

use App\Http\Requests\Request;

/**
 * Class ChangeUserPasswordRequest
 *
 * @package Step\Access\Presentation\Http\Requests\Backend\User
 */
class ChangeUserPasswordRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('change-user-password');
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
