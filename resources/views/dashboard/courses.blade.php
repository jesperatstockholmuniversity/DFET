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

    <div class="panel panel-default">
        <div class="panel-heading">List of all Courses</div>
            <div class="panel-body">

                <table id="basicTable" class="table table-striped table-bordered responsive">
                    
                    <a href="/courses/new" class="btn btn-success pull-right" style="margin-left:10px; margin-top:3px"><i class="fa fa-suitcase"></i> New course</a>

                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created</th>
                            <th>Pending Enrolls</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td><a href="/courses/view/{{$course->id}}">{{ $course->name }}</a></td>
                        <td><span class="label label-success">{{-- Carbon::createFromTimestamp(strtotime($course->created_at))->diffForHumans() --}} {{ time() }}</span></td>

                        <td>{{-- $enrollreviews --}}</td>

                        <td>
                            <a href="/courses/edit/{{$course->id}}" class="btn btn-default btn-xs btn-icon icon-left"><i class="fa fa-pencil"></i> Edit</a>
                            <a href="/courses/delete/{{$course->id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Delete</a>
                            <a href="/courses/view/{{$course->id}}" class="btn btn-primary btn-xs btn-icon icon-left"><i class="fa fa-suitcase"></i> View</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
    </div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop
