@extends('backend.layouts.master')

@section ('title', trans('menus.user_management') . ' | ' . trans('menus.edit_user'))

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.users.edit', trans('menus.edit_user')) !!}</li>
@stop

@section('page-header')

    <h1>
    {{ trans('menus.user_management') }}
    <!-- <small>{{ trans('menus.edit_user') }}</small> -->
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

                <div class="col-md-10 col-md-offset-1 create-issue-descript">


                    {!! Form::model($user, ['route' => ['admin.access.users.update', $user->getId()], 'class' => '', 'role' => 'form', 'method' => 'PATCH']) !!}


                    <div class="form-group col-md-12">
                        {!! Form::label('name', trans('validation.attributes.name'), ['class' => ' control-label']) !!}
                        {!! Form::text('name', $user->getName(), ['class' => 'form-control', 'placeholder' => trans('strings.full_name')]) !!}
                    </div><!--form control-->


                    <div class="form-group col-md-12">
                        {!! Form::label('email', trans('validation.attributes.email'), ['class' => ' control-label']) !!}
                        {!! Form::text('email', $user->getEmail(), ['class' => 'form-control', 'placeholder' => trans('validation.attributes.email')]) !!}
                    </div><!--form control-->

                    {{--<div class="form-group">--}}
                    {{--{!! Form::label('company', 'Company', ['class' => ' control-label']) !!}--}}
                    {{--<select name="company_id" class="selectpicker">--}}

                    {{--<option value="0">Assign a company</option>--}}

                    {{--@foreach($organisations as $organisation)--}}

                    {{--<option value="{{ $organisation->getId() }}"--}}
                    {{--{{ !empty($user->company_id) && $user->company_id == $organisation->getId() ? 'SELECTED' : ''}}>{{ $organisation->getName() }}</option>--}}

                    {{--@endforeach--}}

                    {{--</select>--}}
                    {{--</div><!--form control-->--}}

                    @if ($user->getId() != 1)
                        <div class="row">

                            <div class="form-group col-md-2 col-xs-6">

                                <label class="col-md-6 col-xs-6 control-label">{{ trans('validation.attributes.active') }}</label>

                                <div class="col-md-6 col-xs-6">

                                    <input type="checkbox" value="1"
                                           name="status" {{$user->getStatus() == 1 ? 'checked' : ''}} />
                                </div>

                            </div><!--form control-->

                            <div class="form-group col-md-3 col-xs-6">

                                <label class="col-md-8 col-xs-8 control-label">{{ trans('validation.attributes.confirmed') }}</label>

                                <div class="col-md-4 col-xs-4">
                                    <input type="checkbox" value="1"
                                           name="confirmed" {{$user->isConfirmed() == 1 ? 'checked' : ''}} />

                                </div>

                            </div><!--form control-->

                        </div><!-- row -->

                        <div class="row">

                            <div class="form-group col-md-12">

                                <label class="control-label col-md-12">{{ trans('validation.attributes.associated_roles') }}</label>

                                @if (count($roles) > 0)

                                    @foreach($roles as $role)

                                        <div class="col-md-4">

                                            <input type="checkbox" value="{{$role->getId()}}" name="assignees_roles[]"
                                                   id="role-{{$role->getId()}}" {{ (in_array($role->getId(), $user->getRoles()->map(function($entity){
                                                            return $entity->getId();
                                                    })->toArray())) ? 'CHECKED' : '' }}/>

                                            <label for="role-{{$role->getId()}}">{!! $role->getName() !!}</label>
                                            <a href="#" data-role="role_{{$role->getId()}}"
                                               class="show-permissions small">
                                                (<span class="show-hide">Show</span> Permissions)</a><br/>

                                            <div class="permission-list hidden" data-role="role_{{$role->getId()}}">
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
                                        </div><!--col-md-4-->
                                    @endforeach
                                @else
                                    No Roles to set

                                @endif
                            </div><!--form control-->
                        </div><!--row-->

                        <div class="form-group col-md-12">
                            @include('access::backend.includes.partials.permissions-tree', ['entity_permissions' => $user->getPermissions()->map(function($entity){
                                return $entity->getId();
                            })->toArray()])
                        </div><!--form control-->

                    @endif

                    <div class="form-group col-md-12">
                        <input type="submit" id="mousetrap-submit-button" class="create-filters btn create-issue-submit"
                               value="{{ trans('strings.save_button') }}"/>
                        <a id="mousetrap-cancel-button" href="{!! route('admin.access.roles.index') !!}"
                           class="create-filters btn cancel-create">{{ trans('strings.cancel_button') }}</a>
                    </div><!-- buttons end -->


                    {!! Form::hidden('permissions') !!}

                    @if ($user->getId() == 1)
                        {!! Form::hidden('status', 1) !!}
                        {!! Form::hidden('confirmed', 1) !!}
                        {!! Form::hidden('assignees_roles[]', 1) !!}
                    @endif

                    {!! Form::close() !!}

                </div> <!-- col-md-6 col-md-offset-3 -->

            </div>
        </div> <!-- container and row ends -->
    </div> <!-- ___________filters show ends -->
@stop