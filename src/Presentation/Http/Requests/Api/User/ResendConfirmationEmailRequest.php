<?php namespace Schweppesale\Module\Access\Presentation\Http\Requests\Api\User;

use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class ResendConfirmationEmailRequest
 * @package Schweppesale\Module\Access\Presentation\Http\Requests\Api\User
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
