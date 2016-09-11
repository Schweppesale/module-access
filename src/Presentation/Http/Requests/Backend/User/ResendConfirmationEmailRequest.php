<?php namespace Schweppesale\Access\Presentation\Http\Requests\Backend\User;

use App\Http\Requests\Request;

/**
 * Class ResendConfirmationEmailRequest
 *
 * @package Schweppesale\Access\Presentation\Http\Requests\Backend\User
 */
class ResendConfirmationEmailRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->can('resend-user-confirmation-email');
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
