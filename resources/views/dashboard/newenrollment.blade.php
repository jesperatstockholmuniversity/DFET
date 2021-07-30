@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-suitcase"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="fa fa-suitcase"></i></a></li>
                    <li><a href="/courses">Courses</a>
                    <li>User enrollment</li>
                </ul>
                <h4>User enrollment</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

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

    <div class="contentpanel">

         {{Form::open(array('url'=>'/courses/enroll/','method'=>'post', 'class'=>'panel-wizard'))}}
         <div class="panel panel-primary">
            <div class="panel-heading">New User Enrollment</div>
                <div class="panel-body">

                    
                    <div class="form-group">
                        <label class="col-sm-4">Username</label>
                        <div class="col-sm-8">
                            <input class="name form-control" name="username" type="text" placeholder="Firstname or Lastname">
                        </div>
                    </div><!-- form-group -->
                    
                    
                    <div class="form-group">
                        <label class="col-sm-4">Course</label>
                        <div class="col-sm-8">
                            <input class="course form-control" name="course" type="text" placeholder="Course Name">
                        </div>
                    </div><!-- form-group -->

                    <div class="form-group">
                        <label class="col-sm-4">Status</label>
                        <div class="col-sm-8">
                            <select id="status" name="status" data-placeholder="Choose One" class="width100p" required>
                                <option value="">Choose One</option>
                                <option value="active">Active</option>
                                <option value="inreview">Inreview</option>
                            </select>
                            <label class="error" for="status"></label>
                        </div>
                    </div><!-- form-group -->

                </div><!-- panel body -->
                <div class="panel-footer">
                    <button class="btn btn-primary mr5" id="submit_btn">Submit</button>
                </div><!-- panel-footer"-->
        </div>
            
        {{Form::close()}}            

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop