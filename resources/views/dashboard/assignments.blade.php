@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-pencil"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="fa fa-pencil"></i></a></li>
                    <li>Assignments</li>
                </ul>
                <h4>Assignments</h4>
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

            <div class="panel panel-default">
                <div class="panel-heading">List of all Assignments</div>
                    <div class="panel-body">

                        <table id="basicTable" class="table table-striped table-bordered responsive">

                            <a href="/assignments/new" class="btn btn-success pull-right" style="margin-left:10px; margin-top:3px"><i class="fa fa-pencil"></i> New assign.</a>

                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Course</th>
                                    <th>Student</th>
                                    <th>Machine</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Started</th>
                                    <th>Finished/Solved</th>
                                    <th>Percent</th>
                                    <th>Time Spent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            @foreach ($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->id }}</td>
                                <td>{{ $assignment->name }}</td>
                                <td>{{ $assignment->first_name.' '.$assignment->last_name }}</td>
                                <td>{{ $assignment->machine_id.' / '.$assignment->machine_name }}</td>

                                <td>
                                    @if ($assignment->status == "created")
                                      <span class="label label-success">Available</span>
                                    @elseif ($assignment->status == "open")
                                      <span class="label label-info">Opened</span>
                                    @elseif ($assignment->status == "finished")
                                      <span class="label label-danger">Finished</span>
                                    @elseif ($assignment->status == "finishedentry")
                                      <span class="label label-info">Time exceeded</span>
                                    @endif
                                </td>

                                <td><span class="label label-success">{{ Carbon::createFromTimestamp(strtotime($assignment->date_created))->diffForHumans() }}</span></td>

                                <td>
                                    <span class="label label-warning">
                                      {{ ($assignment->date_started == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_started))->diffForHumans() }}</span>
                                </td>
                                <td>
                                    <span class="label label-warning">
                                      {{ ($assignment->date_finished == NULL) ? "Not yet" : Carbon::createFromTimestamp(strtotime($assignment->date_finished))->diffForHumans() }}</span>
                                </td>

                                <td>
                                    <span class="label label-default">{{$assignment->percent or "0"}} %</span>
                                </td>

                                <td>
                                    <span class="label label-default">{{$assignment->time_percent or "0"}} %</span>
                                </td>

                                <td>
                                    <a href="/assignments/delete/{{$assignment->id}}" class="btn btn-danger btn-xs btn-icon icon-left"><i class="fa fa-times"></i> Delete</a>
                                    <a href="/assignments/view/{{$assignment->id}}" class="btn btn-info btn-xs btn-icon icon-left"><i class="fa fa-info-circle"></i> View</a>
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
            </div>

        </div><!-- row end -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->


@stop