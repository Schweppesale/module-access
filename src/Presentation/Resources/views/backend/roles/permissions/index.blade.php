@extends('backend.layouts.master')

@section ('title', trans('menus.permission_management'))

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a>
    </li>
    <li>{!! link_to_route('admin.access.users.index', trans('menus.user_management')) !!}</li>
    <li class="active">{!! link_to_route('admin.access.roles.permissions.index', trans('menus.permission_management')) !!}</li>
@stop

@section('page-header')
    <h1>
        {{ trans('menus.user_management') }}
                <!-- <small>{{ trans('menus.permission_management') }}</small> -->
    </h1>
@endsection

@section('after-styles-end')
    {!! HTML::style('css/backend/plugin/nestable/jquery.nestable.css') !!}
@stop

@section('content')
    @include('access::backend.includes.partials.header-buttons')

    <div>

        <!-- Tab panes -->
        <div id="groups" style="padding-top:20px">

            <div class="row">

                <div class="col-lg-8">

                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                        {{--<tr>--}}
                        {{--<th>{{ trans('crud.permissions.groups.name') }}</th>--}}
                        {{--<th>{{ trans('crud.actions') }}</th>--}}
                        {{--</tr>--}}
                        </thead>
                        <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>
                                    {!! $group->getName() !!}

                                    @if ($group->getPermissions()->count())
                                        <div style="padding-left:40px;font-size:.8em">
                                            @foreach ($group->getPermissions() as $permission)
                                                {!! $permission->getDisplayName() !!}<br/>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                </td>
                            </tr>

                            @if ($group->getChildren()->count())
                                @foreach ($group->getChildren() as $child)
                                    <tr>
                                        <td style="padding-left:40px">
                                            <em>{!! $child->getName() !!}</em>

                                            @if ($child->getPermissions()->count())
                                                <div style="padding-left:40px;font-size:.8em">
                                                    @foreach ($child->getPermissions() as $permission)
                                                        {!! $permission->getDisplayName() !!}<br/>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td style="padding-left:40px">
                                        No Permission Groups
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div><!--col-lg-8-->

            </div><!--row-->

        </div><!--groups-->

    </div><!--permission tabs-->
@stop

@section('after-scripts-end')
    {!! HTML::script('js/backend/plugin/nestable/jquery.nestable.js') !!}

    <script>
        $(function () {
            var hierarchy = $('.permission-hierarchy');
            hierarchy.nestable({maxDepth: 2});

            hierarchy.on('change', function () {
                @permission('sort-permission-groups')
                    $.ajax({
                    url: "{!! route('admin.access.roles.groups.update-sort') !!}",
                    type: "post",
                    data: {data: hierarchy.nestable('serialize')},
                    success: function (data) {
                        if (data.status == "OK")
                            toastr.success("Hierarchy successfully saved.");
                        else
                            toastr.error("An unknown error occurred.");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr.error("An unknown error occurred: " + errorThrown);
                    }
                });
                @else
                    toastr.error("You do not have permission to do that.");
                @endauth

            });
        });
    </script>
@stop