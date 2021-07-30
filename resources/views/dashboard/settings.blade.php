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
                <i class="fa fa-user"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-user"></i></a></li>
                    <li>Edit profile</li>
                </ul>
                <h4>Edit profile</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">
    
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
    
    {{Form::open(array('url'=>'/users/settings/'.$user->id,'method'=>'post', 'files' => true, 'class'=>'form-horizontal form-bordered'))}}
    <div class="row">           
	    <div class="col-md-7">
	    
		    <div class="panel panel-default">
		        <div class="panel-heading">
		            <h4 class="panel-title">Update settings</h4>
		            <p>To edit the profile settings in your account follow the steps below.</p>
		        </div><!-- panel-heading -->

		        <div class="panel-body nopadding">
		
	                <div class="form-group">
	                	<label class="col-sm-4 control-label" for="readonlyinput">E-mail</label>
	                	<div class="input-group mb15 col-sm-8">
	                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
	                        <input type="text" name="email" placeholder="Enter Email" value="{{$user->email}}" class="form-control">
	                    </div>
	                    
						<label class="col-sm-4 control-label" for="readonlyinput">Firstname</label>
	                	<div class="input-group mb15 col-sm-8">
	                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	                        <input type="text" name="firstname" placeholder="Enter Firstname" value="{{$user->first_name}}" class="form-control">
	                    </div>
	                    
	                    <label class="col-sm-4 control-label" for="readonlyinput">Lastname</label>
	                	<div class="input-group mb15 col-sm-8">
	                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	                        <input type="text" name="lastname" placeholder="Enter Lastname" value="{{$user->last_name}}" class="form-control">
	                    </div>
	                </div><!-- form-group -->

	                <div class="form-group">
                        <label class="col-sm-4 control-label" for="readonlyinput">Address</label>
                        <div class="input-group mb15 col-sm-8">
                            <span class="input-group-addon"><i class="fa fa-home"></i></span>
                            <input type="text" name="address" placeholder="Enter Address" value="{{$profile->address or ""}}" class="form-control">
                        </div>
                        
                        <label class="col-sm-4 control-label" for="readonlyinput">Organization</label>
                        <div class="input-group mb15 col-sm-8">
                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>
                            <input type="text" name="organization" placeholder="Enter Organization" value="{{$profile->organization or ""}}" class="form-control">
                    	</div>
                    </div>
	
	                <div class="form-group">	                    
	                    <label class="col-sm-4 control-label">New Password</label>
	                    <div class="input-group mb15 col-sm-8">
	                    	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	                        <input type="password" name="password" placeholder="Enter New Password" title="" data-toggle="tooltip" data-trigger="hover" class="form-control tooltips" data-original-title="This field is only needed if you change your password">
	                    </div>
	                    
	                    <label class="col-sm-4 control-label">Confirm Password</label>
	                    <div class="input-group mb15 col-sm-8">
	                    	<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
	                        <input type="password" name="password_confirmation" placeholder="Confirm Password" title="" data-toggle="tooltip" data-trigger="hover" class="form-control tooltips" data-original-title="This field is only needed if you change your password">
	                    </div>
	
	                    
	                </div><!-- form-group -->

	                 <!--div class="form-group">
                        <label class="col-sm-4 control-label">Activated</label>
                        <div class="col-sm-8">
                            <select id="activated" name="activated" data-placeholder="Choose One" class="width100p" required>
                                <option value="">Choose One</option>
                                <option value="1" {{($user->activated==1) ? 'selected': '' }}>True</option>
                                <option value="0" {{($user->activated==0) ? 'selected': '' }}>False</option>
                            </select>
                            <label class="error" for="activated"></label>
                        </div>
                    </div--><!-- form-group -->
                               
		        </div><!-- panel-body -->
		        
		        <div class="panel-footer">
	                <button type="submit" class="btn btn-primary mr5">Submit</button>
	            </div><!-- panel-footer"-->
		    </div>
	    
	    </div>
	    
	    <div class="col-sm-4 col-md-4">
	        <div class="text-center span3 well">
	          <img src="{{ isset($avatar->filename) ? '/uploads/avatars/'.$avatar->filename : '/images/default_avatar.png' }}" id="avatar" class="img-circle img-offline img-responsive img-profile" alt="">
	          <input type="file" id="input" name="file" class="text-center center-block well well-sm" onchange="readURL(this)">
	        </div>
	    </div>

   </div><!-- end row -->
   {{Form::close()}}
       
    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop

