@extends('backend.layouts.master')

@section ('title', trans('menus.permission_management') . ' | ' . trans('menus.edit_permission_group'))

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li>{!! link_to_route('admin.access.roles.permissions.index', trans('menus.permission_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.permission-group.edit', trans('menus.edit_permission_group'), $group->id) !!}</li>
@stop

@section('page-header')
    <h1>
        {{ trans('menus.permission_management') }}
                <!-- <small>{{ trans('menus.edit_permission_group') }}</small> -->
    </h1>

    @include('access::backend.includes.partials.header-buttons')
@endsection

@section('content')
    <div id="filters_show">
        <div class="container">
            <div class="row">

                <div class="create-issue-descript">
                    {!! Form::model($group, ['route' => ['admin.access.roles.permission-group.update', $group->id], 'class' => '', 'role' => 'form', 'method' => 'patch']) !!}

                    <div class="form-group col-md-12">
                        {!! Form::label('name', trans('validation.attributes.permission_group_name'), ['class' => 'control-label']) !!}
                                <!--<div class="col-lg-10">-->
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.permission_group_name')]) !!}
                                <!--</div>-->
                    </div><!--form control-->

                    <div class="form-group col-md-12">
                        <input type="submit" id="mousetrap-submit-button" class="create-filters btn create-issue-submit"
                               value="{{ trans('strings.save_button') }}"/>
                        <a href="{!! route('admin.access.roles.permissions.index') !!}" id="mousetrap-cancel-button"
                           class="create-filters btn cancel-create">{{ trans('strings.cancel_button') }}</a>
                    </div><!-- cancel and submit buttons -->

                    {!! Form::close() !!}
                </div><!-- createissue description ends -->

            </div>
        </div> <!-- container and row ends -->
    </div> <!-- ___________filters show ends -->
@stop