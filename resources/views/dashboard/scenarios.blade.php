@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="glyphicon glyphicon-tasks"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-tasks"></i></a></li>
                    <li>Scenarios</li>
                </ul>
                <h4>Scenarios</h4>
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
                <div class="panel-heading"><i class="glyphicon glyphicon-tasks"></i> List of all Scenarios</div>
                    <div class="panel-body">

                        <table id="basicTable" class="table table-striped table-bordered responsive">

                        <a href="/scenarios/new" class="btn btn-success pull-right" style="margin-left:10px; margin-top:3px"><i class="glyphicon glyphicon-tasks"></i> New scenario</a>

                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Scenario Name</th>
                                    <th>Machine ID</th>
                                    <th>Machine Name</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            @foreach ($scenarios as $scenario)
                            <tr>
                                <td>{{ $scenario->id }}</td>
                                <td>{{ $scenario->name }}</td>
                                <td>{{ $scenario->vmachine_id }}</td>
                                <td>{{ $scenario->machine_name }}</td>
                                <td><span class="label label-success">{{ Carbon::createFromTimestamp(strtotime($scenario->created_at))->diffForHumans() }}</span></td>
                                
                                <td>
                                    <div class="btn-group mr5">
                                        <button type="button" class="btn btn-xs btn-default">Action</button>
                                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                          <li><a href="/scenarios/view/{{$scenario->id}}">View</a></li>
                                          <li><a href="/scenarios/edit/{{$scenario->id}}">Edit</a></li>
                                          <li class="divider"></li>
                                          <li><a href="/scenarios/delete/{{$scenario->id}}">Delete</a></li>
                                        </ul>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
            </div>

        </div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop
