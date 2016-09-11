@permission('edit-users')
<a href="{!! route('admin.access.users.edit', $user->getId()) !!}"
   class="btn btn-xs btn-primary">
    <i class="fa fa-pencil"
       data-toggle="tooltip"
       data-placement="top"
       title="{!! trans('crud.edit_button') !!}">

    </i>
</a>
@endauth

@permission('change-user-password')
<a href="{!! route('admin.access.user.change-password', $user->getId()) !!}"
   class="btn btn-xs btn-info">
    <i class="fa fa-refresh"
       data-toggle="tooltip"
       data-placement="top"
       title="{!! trans('crud.change_password_button') !!}">
    </i>
</a>
@endauth

@if($user->isConfirmed() == false)

    @permission('resend-user-confirmation-email')

    <a href="{!! route('admin.account.confirm.resend', $user->getId()) !!}"
       class="btn btn-xs btn-success">
        <i class="fa fa-refresh"
           data-toggle="tooltip"
           data-placement="top"
           title="Resend Confirmation E-mail">
        </i>
    </a>

    @endauth

@endif

@if($user->getStatus() == 0)

    @permission('reactivate-users')

    <a href="{!! route('admin.access.user.activate', $user->getId()) !!}"
       class="btn btn-xs btn-success">
        <i class="fa fa-play"
           data-toggle="tooltip"
           data-placement="top"
           title="{!! trans('crud.activate_user_button') !!}">
        </i>
    </a>

    @endauth

@elseif($user->getStatus() == 1)

    @if($user->getId() != 1)

        @permission('deactivate-users')

        <a href="{!! route('admin.access.user.deactivate', $user->getId()) !!}"
           class="btn btn-xs btn-warning">
            <i class="fa fa-pause"
               data-toggle="tooltip"
               data-placement="top"
               title="{!! trans('crud.deactivate_user_button') !!}">
            </i>
        </a>

        @endauth

        @permission('ban-users')

        <a href="{!! route('admin.access.user.ban', $user->getId()) !!}"
           class="btn btn-xs btn-danger">
            <i class="fa fa-times"
               data-toggle="tooltip"
               data-placement="top"
               title="{!! trans('crud.ban_user_button')!!}">
            </i>
        </a>

        @endauth

    @endif

@elseif($user->getStatus() == 2)

    @permission('reactivate-users')

    <a href="{!! route('admin.access.user.activate', $user->getId())!!}"
       class="btn btn-xs btn-success">
        <i class="fa fa-play"
           data-toggle="tooltip"
           data-placement="top"
           title="{!! trans('crud.activate_user_button') !!}">
        </i>
    </a>

    @endauth

    @permission('delete-users')

    <a href="{!! route('admin.access.users.destroy', $user->getId()) !!}"
       data-method="delete"
       class="btn btn-xs btn-danger">
        <i class="fa fa-trash"
           data-toggle="tooltip"
           data-placement="top"
           title="{!! trans('crud.delete_button') !!}">
        </i>
    </a>

    @endauth

@endif