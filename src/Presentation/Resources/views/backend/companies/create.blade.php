@extends('backend.layouts.master')

@section('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.companies.index', 'Organisations') !!}</li>
    <li class="active">{!! link_to_route('admin.access.companies.create', 'Create Company') !!}</li>
@stop

@section('page-header')
    <h1>
        Company Management
    <!-- <small>{{ trans('strings.backend.dashboard_title') }}</small> -->
    </h1>

    @include('access::backend.includes.partials.header-buttons')
@endsection

@section('content')
    <div id="filters_show">
        <div class="container">
            <div class="row">

                <div class="col-md-12 create-issue-descript">
                    {!! Form::open(['url' => route('admin.access.companies.store')]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Company Name') !!}<br/>
                        {!! Form::text('name', null, ['required' => true]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('description', 'Company Description') !!}<br/>
                        {!! Form::textarea('description', null) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Save', ['class' => 'create-filters btn create-issue-submit']) !!}
                    </div>
                    {!! Form::close() !!}
                </div><!-- col 12 ends -->

            </div>
        </div> <!-- container and row ends -->
    </div> <!-- ___________filters show ends -->
@endsection