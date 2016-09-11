@extends('backend.layouts.master')

@section ('title', trans('menus.role_management'))

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.index', trans('menus.role_management')) !!}</li>
@stop

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
                <!-- <small>{{ trans('menus.role_management') }}</small> -->
    </h1>
@endsection

@section('content')

    @include('access::backend.includes.partials.header-buttons')

    <div class="issues">

        <table class="table table-striped table-bordered table-hover">

            <thead>

            <tr>
                <th>{{ trans('crud.roles.role') }}</th>
                <th>{{ trans('crud.roles.number_of_users') }}</th>
                <th>{{ trans('crud.roles.sort') }}</th>
                <th>{{ trans('crud.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{!! $role->getName() !!}</td>
                    <td>{!! $role->getUsers()->count() !!}</td>
                    <td>{!! $role->getSort() !!}</td>
                    <td>
                        @if($role->getId() != 1)
                            @permission('edit-roles')
                            <a href="{!! route('admin.access.roles.edit', $role->getId()) !!}"
                               class="btn btn-xs btn-primary">
                                <i class="fa fa-pencil"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{!!trans('crud.edit_button') !!}">
                                </i>
                            </a>
                            @endauth
                        @endif

                        @if($role->getId() != 1)
                            @permission('delete-roles')
                            <a href="{!! route('admin.access.roles.destroy', $role->getId()) !!}"
                               class="btn btn-xs btn-danger"
                               data-method="delete">
                                <i class="fa fa-times"
                                   data-toggle="tooltip"
                                   data-placement="top"
                                   title="{!! trans('crud.delete_button') !!}">
                                </i>
                            </a>
                            @endauth
                        @endif

                    </td>

                    {{--<td>{!! $role->action_buttons !!}</td>--}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div> <!-- issues -->

    <div class="pull-left">
        {{ $roles->count() }} {{ trans('crud.roles.total') }}
    </div>

    <div class="pull-right">
        {{--        {{ $roles->render() }}--}}
    </div>

    <div class="clearfix"></div>
@stop