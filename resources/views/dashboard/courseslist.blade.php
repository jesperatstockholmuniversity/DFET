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
                    <li>Courses</li>
                </ul>
                <h4>Courses</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

      <div class="row row-stat">

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

          {{ $courses->links() }}
          <div class="panel panel-dark-head">
              <div class="panel-heading">
                  <h4 class="panel-title">Available courses</h4>                  
                  <small>Enroll on your chosen course. After your enrollment is confirmed you'll be able to view details and learning material.</small>
              </div><!-- panel-heading -->
              <div class="panel-body">
                  
                  <div class="results-list">

                     @foreach ($courses as $course)
                        <div class="media">
                          <a href="#" class="pull-left">
                            <img alt="" src="{{ isset($course->filename) ? '/uploads/courses/'.$course->filename : '/images/default_course.jpg' }}" class="media-object thumbnail">
                          </a>
                          <div class="media-body">
                            <h4 class="filename text-primary">{{$course->name}}</h4>
                            
                              @if ($course->status == '')
                              <a href="/courses/enroll/{{$course->id}}">
                                <button class="btn btn-default btn-lg pull-right" type="button">Enroll for Course</button>
                              </a>
                              @elseif ($course->status == 'inreview')
                                <button class="btn btn-warning btn-lg pull-right" type="button">Waiting for Confirmation</button>
                              @elseif ($course->status == 'active')
                                <a href="/course/view/{{$course->id}}">
                                  <button class="btn btn-success btn-lg pull-right" type="button">View Course</button>
                                </a>
                              @endif

                            <small class="text-muted">Published by: {{$course->first_name.' '.$course->last_name}}</small><br>
                            <small class="text-muted">Created: {{ Carbon::createFromTimestamp(strtotime($course->created_at))->diffForHumans() }}</small><br>
                            <small class="text-muted">Modified: {{ Carbon::createFromTimestamp(strtotime($course->updated_at))->diffForHumans() }}</small>
                          </div>
                        </div>
                    @endforeach    

                  </div><!-- results-list -->
              </div><!-- panel-body -->
          </div><!-- panel -->
          
          {{ $courses->links() }}
                    

      </div><!-- end row -->
            
    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop