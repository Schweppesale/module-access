@extends('backend.layouts.master')

@section ('breadcrumbs')
    <li>
        <a href="{!!route('backend.dashboard')!!}">
            <!--<i class="fa fa-dashboard"></i>-->
            <i class="fa fa-circle text-success"></i>
            {{ trans('menus.dashboard') }}
        </a>
    </li>
    <li>{!! link_to_route('admin.access.companies.index', 'Companies') !!}</li>
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

    <div class="company">

        <div class="created">
            <p>Created on {{ $organisation->getCreatedAt()->format('Y-m-d H:i:s') }}</p>

            <p>Last updated on {{ $organisation->getUpdatedAt()->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="name peggy-access-name">
            <b>Name</b>:
            {{ $organisation->getName() }}
        </div>

        @if($description = $organisation->getDescription())
            <div class="description peggy-access-co-descript">
                <b>Description:</b>
                {!! textile()->parseRestricted($description) !!}
            </div>
        @endif


    </div> <!-- company div ends -->

    <div id="filters_show">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-1  col-md-10 create-issue-descript">
                    <div class="attachments">
                        <h3>Logo</h3>
                        {!! Form::open(['id' => 'my-dropzone', 'class' => 'dropzone', 'url' => route('admin.access.companies.logo.store', ['companyId' => $organisation->getId()])]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container and row ends -->
@endsection

@section('after-scripts-end')

    <script type="text/javascript">

        (function () {

            var attachments = $.parseJSON('{!! json_encode($organisation->getLogo()) !!}');

            Dropzone.options.myDropzone = {

                init: function () {

                    thisDropzone = this;
//                    thisDropzone.on("addedfile", function(file) {
//                        for(existing in thisDropzone.getAcceptedFiles()) {
//                            existing.removeFile();
//                        }
//                    });

                    $(attachments).each(function (index, val) {

                        var mockFile = {name: val.file.name, size: val.file.size};

                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);

                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, val.file.path);

                    });

                }
            };

        }());

    </script>

@stop