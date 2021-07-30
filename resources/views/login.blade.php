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

            <h4 class="text-center mb5">Already a Member?</h4>
            <p class="text-center">Sign in to your account</p>
            
            <div class="mb20"></div>

            <section class="row text-center">
                <a href="/social/twitter" class="btn btn-social-icon btn-twitter-round"><i class="fa fa-twitter"></i></a>
                <a href="/social/facebook" class="btn btn-social-icon btn-facebook-round"><i class="fa fa-facebook"></i></a>
                <a href="/social/google" class="btn btn-social-icon btn-google-plus-round"><i class="fa fa-google-plus"></i></a>
            </section>
            
            <span class="line-thru">OR</span>

            {{Form::open(array('url'=>'/login','method'=>'post'))}}
                <div class="input-group mb15">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" placeholder="Enter Email Address" name="email" required="" value="{{Input::old('email')}}">
                </div><!-- input-group -->
                <div class="input-group mb15">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="password" required="">
                </div><!-- input-group -->
                
                <div class="clearfix">
                    <div class="pull-left">
                        <div class="ckbox ckbox-primary mt10">
                            <input type="checkbox" id="rememberMe" value="1">
                            <label for="rememberMe">Remember Me</label>
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">Sign In <i class="fa fa-angle-right ml5"></i></button>
                    </div>
                </div>                      
            {{Form::close()}}
            
        </div><!-- panel-body -->
        <div class="panel-footer">
            <a href="/forgotpassword" class="btn btn-block">Forgot password?</a>
            <a href="/signup" class="btn btn-primary btn-block">Not yet a Member? Create Account Now</a>
        </div><!-- panel-footer -->
    </div><!-- panel -->
            
</section>
@stop