@extends('backend.layouts.master')

@section ('title', trans('menus.role_management') . ' | ' . trans('menus.create_role'))

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li>{!! link_to_route('admin.access.roles.index', trans('menus.role_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.create', trans('menus.create_role')) !!}</li>
@stop


@section('page-header')
    <h1>
    {{ trans('menus.create_role') }}
    <!-- <small>{{ trans('menus.create_role') }}</small> -->
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

                {!! Form::open(['route' => 'admin.access.roles.store', 'class' => ' ', 'role' => 'form', 'method' => 'post', 'id' => 'create-role']) !!}

                <div class="col-md-12 create-issue-descript">

                    @if($message = session('message'))

                        <div class="form-group ">

                            <div class="">

                                {{ $message }}

                            </div>

                        </div>

                    @endif

                </div>

                <div class="col-md-12 create-issue-descript">

                    <div class="form-group col-md-6 col-xs-6">

                    {!! Form::label('name', trans('validation.attributes.role_name'), ['class' => 'control-label']) !!}

                    <!-- <div class=""> -->

                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.role_name')]) !!}

                    <!-- </div> -->

                    </div><!--form control-->

                    <div class="form-group col-md-6 col-xs-6">

                        {!! Form::label('name', trans('validation.attributes.role_sort'), ['class' => ' control-label']) !!}

                        <div class="">

                            {!! Form::text('sort', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.role_sort')]) !!}

                        </div>

                    </div><!--form control-->
                </div>

                <div class="col-md-12 create-issue-controls">

                    <div class="form-group col-md-12">

                        <label class="control-label">{{ trans('validation.attributes.associated_permissions') }}</label>

                        <div class="">

                            {!! Form::select('associated-permissions', array('all' => 'All', 'custom' => 'Custom'), 'all', ['class' => 'selectpicker form-control']); !!}

                            <div id="available-permissions" class="hidden">

                                @include('access::backend.includes.partials.permissions-tree', ['entity_permissions' => []])

                            </div><!--available permissions-->

                        </div><!--col-lg-3-->

                    </div><!--form control-->

                    <div class="form-group col-md-12">

                        <input type="submit" id="mousetrap-submit-button" id="mousetrap-submit-button"
                               class="create-filters btn create-issue-submit"
                               value="{{ trans('strings.save_button') }}"/>

                        <a href="{!! route('admin.access.roles.index') !!}" id="mousetrap-cancel-button"
                           class="create-filters btn cancel-create">{{ trans('strings.cancel_button') }}</a>

                    </div>

                </div><!-- end of col-12 which houses dropdown and submit buttons -->

            <!--   <div class="well">
                       <div class="pull-left">
                            <a href="{!! route('admin.access.roles.index') !!}" class="btn btn-danger btn-xs">{{ trans('strings.cancel_button') }}</a>
                        </div>

                        <div class="pull-right">
                            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
                        </div>
                        <div class="clearfix"></div>
                    </div> --well-->

                {!! Form::hidden('permissions') !!}

                {!! Form::close() !!}

            </div>

        </div> <!-- container and row ends -->

    </div> <!-- ___________filters show ends -->

@stop