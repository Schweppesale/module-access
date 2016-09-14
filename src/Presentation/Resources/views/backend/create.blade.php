@extends('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.create_user'))

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}">
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}</a></li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.create', trans('menus.create_user')) !!}</li>
@stop

@section('page-header')
    <h1>
    {{ trans('menus.create_user') }}
    <!-- <small>{{ trans('menus.create_user') }}</small> -->
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

                {!! Form::open(['route' => 'admin.access.users.store', 'class' => '', 'role' => 'form', 'method' => 'post']) !!}

                <div class="col-md-6 create-issue-descript">

                    <div class="form-group col-md-12 ">
                        {!! Form::label('name', trans('validation.attributes.name'), ['class' => ' control-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.full_name')]) !!}
                    </div><!--form control-->

                    {{--<div class="form-group">--}}
                    {{--{!! Form::label('company', 'Company', ['class' => 'col-lg-2 control-label']) !!}--}}
                    {{--<div class="col-lg-10">--}}
                    {{--<select name="company_id">--}}
                    {{--<option value="0">Assign a company</option>--}}
                    {{--@foreach($organisations as $organisation)--}}
                    {{--<option value="{{ $organisation->getId() }}"--}}
                    {{--{{ !empty($user->company_id) && $user->company_id == $organisation->getId() ? 'SELECTED' : ''}}>{{ $organisation->getName() }}</option>--}}

                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div><!--form control-->--}}


                    <div class="form-group associated-roles-additional col-md-12">
                        <label class="  control-label">{{ trans('validation.attributes.associated_roles') }}</label>
                        <!-- <div class="col-lg-3">-->
                        @if (count($roles) > 0)
                            @foreach($roles as $role)
                                <div class="row">

                                    <div class="col-md-12">

                                        {!! Form::checkbox('assignees_roles[]', $role->getId()) !!}

                                        {!! Form::label('role-' . $role->getId(), $role->getName()) !!}

                                    </div><!-- for checkboxes -->

                                    <div class="permission-list hidden col-md-12" data-role="role_{{$role->getId()}}">

                                        @if ($role->getAll())
                                            All Permissions<br/><br/>
                                        @else
                                            @if (count($role->getPermissions()) > 0)
                                                <blockquote class="small">
                                                    @foreach ($role->getPermissions() as $perm)
                                                        {{$perm->getDisplayName()}}<br/>
                                                    @endforeach
                                                </blockquote>
                                            @else
                                                No Permissions<br/><br/>
                                            @endif
                                        @endif
                                    </div><!--permission list-->


                                </div>
                            @endforeach
                        @else
                            No Roles to set
                    @endif
                    <!--  </div>-->
                    </div><!--form control-->

                    <div class="col-md-12 ">
                        <a class="create-filters btn filter-permissions-show" href="#permission_dependencies"
                           data-toggle="collapse">Show Permissions</a>
                    </div>

                </div>


                <div class="col-md-6 create-issue-descript">
                    <div class="form-group col-md-12 ">
                        {!! Form::label('email', trans('validation.attributes.email'), ['class' => ' control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                    </div><!--form control-->

                    <div class="form-group col-md-12 ">
                        {!! Form::label('password', trans('validation.attributes.password'), ['class' => ' control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div><!--form control-->

                    <div class="form-group col-md-12 ">
                        {!! Form::label('password_confirmation', trans('validation.attributes.password_confirmation'), ['class' => ' control-label']) !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div><!--form control-->


                    <div class="form-group col-md-3">

                        {!! Form::checkbox('status', 1) !!}
                        {!! Form::label('status', trans('validation.attributes.active')) !!}

                    </div><!--form control-->

                    <div class="form-group col-md-3">

                        {!! Form::checkbox('confirmed', 1) !!}
                        {!! Form::label('confirmed', trans('validation.attributes.confirmed')) !!}

                    </div><!--form control-->

                    <div class="form-group col-md-6">

                        {!! Form::checkbox('confirmation_email', 1) !!}
                        <label class=" control-label">{{ trans('validation.attributes.send_confirmation_email') }}<br/>
                            <small>{{ trans('strings.if_confirmed_is_off') }}</small>
                        </label>
                    </div><!--form control-->

                </div>


                <div id="permission_dependencies" class="collapse form-group">
                    <div class="col-md-12 create-issue-descript">
                        @include('access::backend.includes.partials.permissions-tree', ['entity_permissions'=> []])
                    </div>
                </div>

                <div class="form-group col-md-12">

                    <input type="submit" id="mousetrap-submit-button" class="create-filters btn create-issue-submit"
                           value="{{ trans('strings.save_button') }}"/>

                    <a id="mousetrap-cancel-button" href="{!! route('admin.access.roles.index') !!}"
                       class="create-filters btn cancel-create">{{ trans('strings.cancel_button') }}</a>

                </div>

                {!! Form::hidden('permissions') !!}

                {!! Form::close() !!}

            </div>
        </div> <!-- container and row ends -->
    </div> <!-- ___________filters show ends -->
@stop