@extends('backend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">

                    {!! Form::open(['route' => ['admin.profile.update'], 'class' => 'form-horizontal', 'method' => 'patch']) !!}

                    <div class="form-group col-md-12 ">
                        {!! Form::label('name', 'Name', ['class' => ' control-label']) !!}
                        {!! Form::input('name', 'name', $user->getName(), ['class'=> 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-12 ">
                        {!! Form::label('email', 'Email', ['class' => ' control-label']) !!}
                        {!! Form::input('email', 'email', $user->getEmail(), ['class'=> 'form-control']) !!}
                    </div>

                    <div class="form-group col-md-12 ">
                        {!! Form::submit('Save', ['class' => 'create-filters btn create-issue-submit']) !!}
                    </div>

                    {!! Form::close() !!}
                </div><!--panel body-->

            </div><!-- panel -->

            <div>
                <a href="{{ route('admin.profile.password.edit') }}">Change Password</a>
            </div>

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection