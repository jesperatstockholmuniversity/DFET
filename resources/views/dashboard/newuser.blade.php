@extends('dashboard.master')

<script type="text/javascript">

function readURL(input) {
   if (input.files && input.files[0]) {
       var reader = new FileReader();
       reader.onload = function(e) {
           $('#avatar').attr('src', e.target.result);
       }

       reader.readAsDataURL(input.files[0]);
   }
}
</script>

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-users"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-user"></i></a></li>
                    <li><a href="/users">Users</a></li>
                    <li>New user</li>
                </ul>
                <h4>New user</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
    
    @if($errors->count())
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

        {{Form::open(array('url'=>'/users/new/','method'=>'post', 'files' => true, 'class'=>'form-horizontal form-bordered'))}}
        <div class="row">                                
            <div class="col-md-7">
        	    <div class="panel panel-default">
        	        <div class="panel-heading">
        	            <h4 class="panel-title">Create profile</h4>
        	            <p>To create new user profile follow the steps below.</p>
        	        </div><!-- panel-heading -->
        	        
        	        <div class="panel-body nopadding">
        	
        	                <div class="form-group">
        	                	<label class="col-sm-4 control-label" for="readonlyinput">E-mail</label>
        	                	<div class="input-group mb15 col-sm-8">
        	                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        	                        <input type="text" name="email" placeholder="Enter Email" value="old-email" class="form-control">
        	                    </div>
        	                    
        						<label class="col-sm-4 control-label" for="readonlyinput">Firstname</label>
        	                	<div class="input-group mb15 col-sm-8">
        	                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        	                        <input type="text" name="firstname" placeholder="Enter Firstname" value="Old First Name" class="form-control">
        	                    </div>
        	                    
        	                    <label class="col-sm-4 control-label" for="readonlyinput">Lastname</label>
        	                	<div class="input-group mb15 col-sm-8">
        	                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        	                        <input type="text" name="lastname" placeholder="Enter Lastname" value="Old Last Name" class="form-control">
        	                    </div>
                           
        	                    <label class="col-sm-4 control-label">Password</label>
        	                    <div class="input-group mb15 col-sm-8">
        	                    	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        	                        <input type="password" name="password" placeholder="Enter Password" title="" data-trigger="hover" class="form-control">
        	                    </div>
        	                </div><!-- form-group -->

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="readonlyinput">Address</label>
                                <div class="input-group mb15 col-sm-8">
                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                    <input type="text" name="address" placeholder="Enter Address" value="Old Address" class="form-control">
                                </div>
                                
                                <label class="col-sm-4 control-label" for="readonlyinput">Organization</label>
                                <div class="input-group mb15 col-sm-8">
                                    <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                                    <input type="text" name="organization" placeholder="Enter Organization" value="Old Organisation" class="form-control">
                                </div>
                           
                            </div><!-- form-group -->
        	                
        	                <div class="form-group">
                                <label class="col-sm-4 control-label">Activated</label>
                                <div class="col-sm-8">
                                    <select id="activated" name="activated" data-placeholder="Choose One" class="width100p" required>
                                        <option value="">Choose One</option>
                                        <option value="1">True</option>
                                        <option value="0">False</option>
                                    </select>
                                    <label class="error" for="activated"></label>
                                </div>
                            </div><!-- form-group -->
                            
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Group</label>
                                <div class="col-sm-8">
                                    <select id="group" name="group" data-placeholder="Choose One" class="width100p" required>
                                    	<option value="">Choose One</option>
                                    	@foreach ($groups as $group)
                                        <option value="group-id">{{ $group }}</option>
                                        @endforeach
                                    </select>
                                    <label class="error" for="group"></label>
                                </div>
                            </div><!-- form-group -->

                            <div class="form-group">
                                <label class="col-sm-4 control-label">User Permission</label>
                                <div class="col-sm-8">
                                    <select id="permission" name="permission" data-placeholder="Choose One" class="width100p" required>
                                        <option value="">Choose One</option>
                                        <option value="1">Administrator</option>
                                        <option value="0">Normal User</option>
                                    </select>
                                    <label class="error" for="permission"></label>
                                </div>
                            </div><!-- form-group -->
                            
        	                       
        	        </div><!-- panel-body -->
        	        
        	        <div class="panel-footer">
                        <button type="submit" class="btn btn-primary mr5">Submit</button>
                        <button class="btn btn-default" type="reset">Reset</button>
                    </div><!-- panel-footer"-->
        	    </div>
            
            </div>

            <div class="col-sm-4 col-md-4">
                <div class="text-center span3 well">
                  <img src="/images/default_avatar.png" id="avatar" class="img-circle img-offline img-responsive img-profile" alt="">
                  <input type="file" id="input" name="file" class="text-center center-block well well-sm" onchange="readURL(this)">
                </div>
            </div>

        </div><!-- end row -->

        {{Form::close()}}
       
    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop

