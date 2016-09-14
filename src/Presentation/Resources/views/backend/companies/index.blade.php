@extends('backend.layouts.master')

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li class="active">{!! link_to_route('admin.access.companies.index', 'Organisations') !!}</li>
@stop

@section('page-header')
    <h1>
        Company Management
    <!--  <small>{{ trans('strings.backend.dashboard_title') }}</small> -->
    </h1>
    @include('access::backend.includes.partials.header-buttons')
@endsection

@section('content')



    @if($organisations->count())

        <div class="issues">
            <table class="table table-striped table-bordered table-hover">
                <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Created</th>

                    <th>Updated</th>

                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                @foreach($organisations as $organisation)

                    <tr>

                        <td>{{ $organisation->getId() }}</td>

                        <td>
                            <a href="{{ route('admin.access.companies.show', ['companyId' => $organisation->getId()]) }}">
                                {{ $organisation->getName() }}
                            </a>
                        </td>

                        <td>{{ $organisation->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
                        <td>
                            {{ $organisation->getUpdatedAt()->format('Y-m-d H:i:s') }}
                        </td>
                        <td>

                            <div class="edit">

                                <a class="btn btn-xs btn-primary"
                                   href="{{ route('admin.access.companies.edit', ['companyId' => $organisation->getId()]) }}">
                                    Edit
                                </a>

                            </div>
                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>
        </div> <!-- issues ends -->

    @else
        <h3>No Companies Available!</h3>
    @endif

@endsection