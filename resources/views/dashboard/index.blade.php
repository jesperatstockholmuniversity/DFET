@extends('dashboard.master')

@section('content')

<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-home"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                    <li>Dashboard</li>
                </ul>
                <h4>Dashboard</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->
    
    <div class="contentpanel">

    @if ($errors->count())
        <div class="alert alert-danger">
            <button aria-hidden="true" class="close" type="button" data-dismiss="alert" type="button">×</button>
        
            @foreach ($errors->all() as $error)
            <ul>
                <li>{{ $error }}</li>
            </ul>
            @endforeach</div>
    @endif

        @if (Session::has('error_msg'))
            <div class="alert alert-danger">{{Session::get('error_msg')}}
            	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
        @endif

        @if (Session::has('success_msg'))
            <div class="alert alert-success">{{Session::get('success_msg')}}
            	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
        @endif
        
        <div class="row row-stat">
            <div class="col-md-3">
                <div class="panel panel-success-alt noborder">
                    <div class="panel-heading noborder">
                        <div class="panel-btns">
                            <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
			</div><!-- panel-btns -->
			
			@if ($user = Sentinel::getUser() && $user -> hasAccess('admin')) {{-- @auth('admin') @endauth --}}
				<a href="/courses"><div class="panel-icon"><i class="fa fa-suitcase"></i></div></a>
                        @else 
                        	<a href="/courses/list"><div class="panel-icon"><i class="fa fa-suitcase"></i></div></a>
                        @endif 
                        <div class="media-body">
                            <h5 class="md-title nomargin">Courses</h5>
                            <h1 class="mt5">{{ $courses }}</h1>
                        </div><!-- media-body -->
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-md-4 -->
            
            @if ($user = Sentinel::getUser() && $user ->hasAccess('admin'))
            <div class="col-md-3">
                <div class="panel panel-primary noborder">
                    <div class="panel-heading noborder">
                        <div class="panel-btns">
                            <a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div> <!-- panel-btns -->
                        <a href="/users"><div class="panel-icon"><i class="fa fa-users"></i></div></a>
                        <div class="media-body">
                            <h5 class="md-title nomargin">User Accounts</h5>
                            <h1 class="mt5">{{ $users }}</h1>
                        </div><!-- media-body -->
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-md-4 -->
            @endif

            <div class="col-md-3">
                <div class="panel panel-dark noborder">
                    <div class="panel-heading noborder">
                        <div class="panel-btns">
                            <a href="#" class="panel-close tooltips" data-toggle="tooltip" data-placement="left" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        @if ($user = Sentinel::getUser() && $user ->hasAccess('admin'))
                        <a href="/assignments"><div class="panel-icon"><i class="fa fa-pencil"></i></div></a>
                        @else 
                        <a href="/assignments/list"><div class="panel-icon"><i class="fa fa-pencil"></i></div></a>
                        @endif
                        <div class="media-body">
                            <h5 class="md-title nomargin">Assignments</h5>
                            <h1 class="mt5">{{ $assignments }}</h1>
                        </div><!-- media-body -->
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-md-4 -->

            @if ($user =  Sentinel::getUser() && $user ->hasAccess('admin'))
            <div class="col-md-3">
                <div class="panel panel-warning-alt noborder">
                    <div class="panel-heading noborder">
                        <div class="panel-btns">
                            <a href="#" class="panel-close tooltips" data-toggle="tooltip" data-placement="left" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        <a href="/vmachines"><div class="panel-icon"><i class="fa fa-hdd-o"></i></div></a>
                        
                        <div class="media-body">
                            <h5 class="md-title nomargin">Virtual machines</h5>
                            <h1 class="mt5">{{-- time() --}}</h1>
                        </div><!-- media-body -->
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div><!-- col-md-4 -->
            @endif
        </div><!-- row -->
        
    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->
@stop
