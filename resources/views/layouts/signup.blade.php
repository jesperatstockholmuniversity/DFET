@extends('layouts.master')

@section('content')
  <section>
            
    <div class="panel panel-signup">

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

            <h4 class="text-center mb5">Create a new account</h4>
            <p class="text-center">Please enter your credentials below</p>
            
            <div class="mb20"></div>

            <section class="row text-center">
                <a href="/social/twitter" class="btn btn-social-icon btn-twitter-round"><i class="fa fa-twitter"></i></a>
                <a href="/social/facebook" class="btn btn-social-icon btn-facebook-round"><i class="fa fa-facebook"></i></a>
                <a href="/social/google" class="btn btn-social-icon btn-google-plus-round"><i class="fa fa-google-plus"></i></a>
            </section>
            
            <span class="line-thru">OR</span>
            
                {{Form::open(array('url'=>'/signup','method'=>'post'))}}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="firstname" placeholder="Enter Firstname" required="" value="{{Input::old('firstname')}}">
                        </div><!-- input-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" name="lastname" placeholder="Enter Lastname" required="" value="{{Input::old('lastname')}}">
                        </div><!-- input-group -->
                    </div>
                </div><!-- row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required="" value="{{Input::old('email')}}">
                        </div><!-- input-group -->
                    </div>
                </div>
                 <br />
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Enter Password" required="">
                        </div><!-- input-group -->
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb15">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required="">
                        </div><!-- input-group -->
                    </div>
                </div><!-- row -->
                <br />
                <div class="clearfix">
                    <!--div class="pull-left">
                        <div class="ckbox ckbox-primary mt5">
                            <input type="checkbox" id="agree" value="1">
                            <label for="agree">I agree with <a href="#">Terms and Conditions</a></label>
                        </div>
                    </div-->
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success">Create New Account <i class="fa fa-angle-right ml5"></i></button>
                    </div>
                </div>
            {{Form::close()}}
            
        </div><!-- panel-body -->
        <div class="panel-footer">
            <a href="/login" class="btn btn-primary btn-block">Already a Member? Sign In</a>
        </div><!-- panel-footer -->
    </div><!-- panel -->
            
</section>
@stop