@extends('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.banned_users'))

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.banned', trans('menus.banned_users')) !!}</li>
@stop

@section('page-header')
    <h1>
    {{ trans('menus.banned_users') }}
    <!-- <small>{{ trans('menus.banned_users') }}</small> -->
    </h1>
@endsection

@section('content')

    @include('access::backend.includes.partials.header-buttons')

    <div class="issues">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>{{ trans('crud.users.id') }}</th>
                <th>{{ trans('crud.users.name') }}</th>
                <th>{{ trans('crud.users.email') }}</th>
                <th>{{ trans('crud.users.confirmed') }}</th>
                <th>{{ trans('crud.users.roles') }}</th>
                <th>{{ trans('crud.users.other_permissions') }}</th>
                <th class="visible-lg">{{ trans('crud.users.created') }}</th>
                <th class="visible-lg">{{ trans('crud.users.last_updated') }}</th>
                <th>{{ trans('crud.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @if ($users->count())
                @foreach ($users as $user)
                    <tr>
                        <td>{!! $user->getId() !!}</td>
                        <td>{!! $user->getName() !!}</td>
                        <td>{!! link_to("mailto:".$user->getEmail(), $user->getEmail()) !!}</td>
                        <td>
                            @if($user->isConfirmed())
                                <label class="label label-success">Yes</label>
                            @else
                                <label class='label label-danger'>No</label>
                            @endif
                        </td>
                        <td>
                            @if ($user->getRoles()->count() > 0)
                                @foreach ($user->getRoles() as $role)
                                    {!! $role->getName() !!}<br/>
                                @endforeach
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            @if ($user->getPermissions()->count() > 0)
                                @foreach ($user->getPermissions() as $perm)
                                    {!! $perm->getDisplayName() !!}<br/>
                                @endforeach
                            @else
                                None
                            @endif
                        </td>
                        <td class="visible-lg">{!! $user->getCreatedAt()->format('Y-m-d H:i:s') !!}</td>
                        <td class="visible-lg">{!! $user->getCreatedAt()->format('Y-m-d H:i:s') !!}</td>
                        <td>
                            @include('access::backend.includes.partials.user-action-buttons')
                        </td>
                    </tr>
                @endforeach
            @else
                <td colspan="9">{{ trans('crud.users.no_banned_users') }}</td>
            @endif
            </tbody>
        </table>
    </div> <!-- issues div ends -->

    <div class="pull-left">
        {!! $users->count() !!} {{ trans('crud.users.total') }}
    </div>

    <div class="pull-right">
        {{--{!! $users->render() !!}--}}
    </div>

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    {!! HTML::script('js/backend/plugin/nestable/jquery.nestable.js') !!}
@endsection