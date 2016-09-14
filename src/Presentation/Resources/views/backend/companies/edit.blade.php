@extends('backend.layouts.master')

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.companies.index', 'Organisations') !!}</li>
    <li class="active">Here</li>
@stop

@section('page-header')
    <h1>
        Company Management
    <!-- <small>{{ trans('strings.backend.dashboard_title') }}</small> -->
    </h1>
@endsection

@section('content')

    @include('access::backend.includes.partials.header-buttons')


    {!! Form::open(['url' => route('admin.access.companies.update', ['companyId' => $organisation->getId()])]) !!}

    <div class="form-group">

        {!! Form::label('name', 'Name') !!}<br/>
        {!! Form::text('name', $organisation->getName(), ['required' => true]) !!}

    </div>

    <div class="form-group">

        {!! Form::label('description', 'Description') !!}<br/>
        {!! Form::textarea('description', $organisation->getDescription()) !!}

    </div>

    <div class="form-group">

        {!! Form::hidden('companyId', $organisation->getId()) !!}
        {!! Form::hidden('_method', 'PUT') !!}

        {!! Form::submit('Save') !!}

    </div>

    {!! Form::close() !!}

@endsection