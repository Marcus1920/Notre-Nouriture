@extends('master')
@section('content')

    <!-- Breadcrumb -->
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('/users') }}"> Home</a></li>
        <li><a href="{{ url('/activeUsers') }}"> Active App Users</a></li>
        <li><a href="{{ url('/') }}">De-activated App Users</a></li>
        <li class="active">De-Activate Form</li>
    </ol>
    <h4 class="page-title">De-Activate {{$user->name}} {{$user->surname}}</h4>

    <!-- Basic with panel-->
    <div class="block-area" id="basic">
        <h3 class="block-title">De-Activate Form</h3>
        <div class="tile p-15">
            {!! Form::open(['url' => 'InactivateUser/'.$user->id, 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"registrationForm" ]) !!}
            {!! Form::hidden('id') !!}

            <div class="form-group">
                {!! Form::label('Name', 'Name', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('name',$user->name,['class' => 'form-control input-sm','id' => 'name', "onfocus"=>"geolocate()", 'readonly']) !!}
                    @if ($errors->has('name'))<span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>@endif
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('Surname', 'Surname', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('surname',$user->surname,['class' => 'street_number form-control input-sm','id' => 'surname' , 'readonly']) !!}
                    @if ($errors->has('surname'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            {{--<div class="form-group">--}}
            {{--{!! Form::label('Gender', 'Gender', array('class' => 'col-md-2 control-label')) !!}--}}
            {{--<div class="col-md-6">--}}
            {{--{!! Form::text('gender',$user->gender,['class' => 'locality form-control input-sm','id' => 'gender' , 'required']) !!}--}}
            {{--@if ($errors->has('gender'))<span class="help-block"><strong>{{ $errors->first('gender') }}</strong></span>@endif--}}
            {{--</div>--}}
            {{--</div>--}}

            <div class="form-group">
                {!! Form::label('Interest', 'Interest', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('intrest',$user->UserRole->name,['class' => 'locality form-control input-sm','id' => 'intrest' , 'readonly']) !!}
                    @if ($errors->has('cellphone'))<span class="help-block"><strong>{{ $errors->first('cellphone') }}</strong></span>@endif
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('Travel Radius', 'Travel Radius', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('travelRadius ',$user->UserTravelRadius->kilometres,['class' => 'administrative_area_level_1 form-control input-sm','id' => 'email', 'readonly']) !!}
                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('Description', 'Description', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('descriptionOfAcces',$user->descriptionOfAcces ,['class' => 'administrative_area_level_1 form-control input-sm','id' => 'description','type'=>"password", 'readonly']) !!}
                    @if ($errors->has('password'))<span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>@endif
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(' Location', 'Location', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::text('location',$user->location,['class' => 'administrative_area_level_1 form-control input-sm','id' => 'location',  'type'=>"password",'readonly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label(' Active', 'Active', array('class' => 'col-md-2 control-label')) !!}
                <div class="col-md-6">
                    {!! Form::select('active',$selectUserStatuses,1,['class' => 'form-control input-sm' ,'id' => 'active']) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-6">
                    <button type="submit" id='submitMemberForm' class="btn btn-info btn-sm m-t-10">DEACTIVATE USER</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection
