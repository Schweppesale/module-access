@extends('backend.layouts.master')

@section ('title', trans('menus.role_management') . ' | ' . trans('menus.edit_role'))

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li>{!! link_to_route('admin.access.roles.index', trans('menus.role_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.edit', trans('strings.edit') . ' ' . $role->getName(), $role->getId()) !!}</li>
@stop

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
                <!--  <small>{{ trans('menus.edit_role') }}</small> -->
    </h1>
    @include('access::backend.includes.partials.header-buttons')
@endsection

@section('after-styles-end')
    {!! HTML::style('css/backend/plugin/jstree/themes/default/style.min.css') !!}
@stop

@section('content')

    <div id="filters_show">

        <div class="container">

            <div class="row">

                {!! Form::model($role, ['route' => ['admin.access.roles.update', $role->getId()], 'class' => '', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role']) !!}

                <div class="col-md-12 create-issue-descript">


                    <div class="form-group col-md-4">

                        {!! Form::label('name', trans('validation.attributes.role_name'), ['class' => 'control-label']) !!}

                        {!! Form::text('name', $role->getName(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.role_name')]) !!}
                    </div><!--form control-->

                    <div class="form-group col-md-4">

                        {!! Form::label('name', trans('validation.attributes.role_sort'), ['class' => 'control-label']) !!}

                        {!! Form::text('sort', $role->getSort(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.role_sort')]) !!}

                    </div><!--form control-->

                    <div class="form-group col-md-8">

                        <label class="control-label">{{ trans('validation.attributes.associated_permissions') }}</label>

                        <!-- <div class="col-lg-10"> -->
                        @if ($role->getId() != 1)
                            {{-- Administrator has to be set to all --}}
                            {!! Form::select('associated-permissions', array('all' => 'All', 'custom' => 'Custom'), $role->getAll() ? 'all' : 'custom', ['class' => 'selectpicker form-control']) !!}
                        @else
                            <span class="label label-success">All</span>
                        @endif

                        <div id="available-permissions" {!! ($role->getAll() == 1) ? ' class="hidden"' : '' !!}>

                            @include('access::backend.includes.partials.permissions-tree', ['entity_permissions' => $role->getPermissions()->map(function($entity){
                                                            return $entity->getId();
                                                        })->toArray()])
                        </div><!--available permissions-->

                    </div><!--form control-->

                </div>

                <div class="form-group col-md-12">

                    <input type="submit" id="mousetrap-submit-button" class="create-filters btn create-issue-submit"
                           value="{{ trans('strings.save_button') }}"/>

                    <a href="{!! route('admin.access.roles.index') !!}" id="mousetrap-cancel-button"
                       class="create-filters btn cancel-create">{{ trans('strings.cancel_button') }}</a>

                </div><!-- buttons end -->

                {!! Form::hidden('permissions') !!}
                {!! Form::close() !!}

            </div>

        </div> <!-- container and row ends -->

    </div> <!-- ___________filters show ends -->

@stop