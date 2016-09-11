@extends('backend.layouts.master')

@section ('title', 'User Management | Change User Password')

@section ('before-styles-end')
    {!! HTML::style('css/plugin/jquery.onoff.css') !!}
@stop

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            Dashboard
        </a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', 'User Management') !!}</li>
    <li>{!! link_to_route('admin.access.users.edit', "Edit ".$user->getName(), $user->getId()) !!}</li>
    <li class="active">{!! link_to_route('admin.access.user.change-password', 'Change Password', $user->getId()) !!}</li>
@stop

@section('page-header')
    <h1>
        New Password:
        <!--  <small>Change Password</small>-->
    </h1>
    @include('access::backend.includes.partials.header-buttons')
@endsection


@section('content')
    <div id="filters_show">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-1  col-md-10 create-issue-descript">

                    {!! Form::open(['route' => ['admin.access.user.change-password', $user->getId()], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

                    <div class="form-group form-inline col-md-12">
                        <label class="control-label">Password</label>
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div><!--form control-->

                    <div class="form-group form-inline col-md-12">
                        <label class="control-label">Confirm Password</label>
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div><!--form control-->

                    <div class="form-group col-md-12">
                        <input type="submit" id="mousetrap-submit-button" class="create-filters btn create-issue-submit"
                               value="Save"/>
                        <a href="{{route('admin.access.users.index')}}" id="mousetrap-cancel-button"
                           class="create-filters btn cancel-create">Cancel</a>
                    </div><!-- buttons end -->
                </div><!-- issues control details overall div -->


                {!! Form::close() !!}

            </div>
        </div> <!-- container and row ends -->
    </div> <!-- ___________filters show ends -->
@stop