@extends('layouts.master')

@section('content')
<section>
    <div class="panel panel-signin">

        @if($errors->has())
            <div class="alert alert-danger">
            <button aria-hidden="true" class="close" type="button" data-dismiss="alert" type="button">×</button>
    
            @foreach ($errors->all() as $error)
            <ul>
                <li>{{ $error }}</li>
            </ul>
            @endforeach</div>
        @endif

        @if(Session::has('error_msg'))
            <div class="alert alert-danger">{{Session::get('error_msg')}}
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
        @endif

        @if(Session::has('success_msg'))
            <div class="alert alert-success">{{Session::get('success_msg')}}
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
        @endif

        <div class="panel-body">

            <h4 class="text-center mb5">Forgot your password?</h4>
            <p class="text-center">Enter new password</p>
            
            <div class="mb30"></div>
            
            {{Form::open(array('url'=>'/newpassword','method'=>'post'))}}
                <div class="input-group mb15">
                    <input type="hidden" class="form-control" name="email" value="{{Input::get('email')}} ">
                    <input type="hidden" class="form-control" name="resetcode" value="{{Input::get('resetcode')}} ">
                </div>
                <div class="input-group mb15">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" placeholder="New Password" name="password" required="">
                </div>
                <div class="input-group mb15">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required="" >
                </div>
                
                <div class="clearfix">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">Save <i class="fa fa-angle-right ml5"></i></button>
                    </div>
                </div>               
            {{Form::close()}}
            
        </div><!-- panel-body -->
        <div class="panel-footer">
            <a href="/login" class="btn btn-primary btn-block">Already a Member? Sign in</a>
            <a href="/signup" class="btn btn-success btn-block">Not yet a Member? Create Account Now</a>
        </div><!-- panel-footer -->
    </div><!-- panel -->
            
</section>
@stop