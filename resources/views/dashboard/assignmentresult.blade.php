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
                    <li><a href="/assignments/lists"><i class="fa fa-pencil"></i></a></li>
                    <li><a href="/assignments/list">Assignments</a></li>
                    <li>Assignment Result</li>
                </ul>
                <h4>Assignment Result</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <div class="row row-stat">

            @if ($success == 2)
                <div class="alert alert-danger">{{ $error_msg }}
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>
            @endif

            <div class="col-md-6">
                <div class="panel {{ ($success == 0 || $success == 2) ? 'panel-dark-alt' : 'panel-success' }} noborder">
                    <div class="panel-heading noborder">
                        <div class="panel-btns" style="display: none;">
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" data-placement="left" title="" data-original-title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        <div class="panel-icon">
                            {{ ($success == 0 || $success == 2) ? '<i class="fa fa-frown-o"></i>' : '<i class="fa fa-smile-o"></i>' }}
                        </div>
                        <div class="media-body">
                            <h5 class="md-title nomargin">
                                {{ ($success == 0 || $success == 2) ? 'Failure!' : 'Success!' }}
                                {{ ($success == 2) ? '- If you wouldn\'t spent that much time, your score could be:' : '' }}
                            </h5>
                            <h1 class="mt5">{{$percent}}%</h1>
                        </div><!-- media-body -->
                        <hr>
                        <div class="clearfix mt20">
                            <div class="pull-left">
                                <h4 class="nomargin">{{ ($success == 0 || $success == 2) ? 'Sorry, you didn\'t pass the exam' : 'You have successfully completed the course assignment.'}}</h4><br/>
                                <h5 class="md-title nomargin">Results:</h5>
                            </div>
                        </div>

                        <div class="pull-right">
                            Overall Success
                        </div>

                        <div class="clearfix mt20">

                             <div class="progress">
                                
                                <div style="width: {{$percent}}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{$percent}}" role="progressbar" class="progress-bar 
                                @if($percent < 50 )
                                    progress-bar-danger
                                @elseif ($percent >= 50)
                                    progress-bar-success
                                @endif
                                ">             
                                    {{$percent}}%
                                </div>
                            </div>
                        </div>

                        <div class="pull-right">
                            Time spent on the assignment
                        </div>

                        <div class="clearfix mt20">

                            <div class="progress">
                                <div style="width: {{ $time }}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{ $time }}" role="progressbar" class="progress-bar 
                                @if ($time < 50 )
                                    progress-bar-success
                                @elseif ($time >= 50)
                                    progress-bar-danger
                                @endif
                                ">                                
                                    {{ ($time < 0) ? 1 : $time }}%
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    </div><!-- panel-body -->
                </div><!-- panel -->
            </div>

        </div><!-- end row -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->


@stop