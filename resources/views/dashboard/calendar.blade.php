@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="fa fa-users"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-suitcase"></i></a></li>
                    <li>Calendar</li>
                </ul>
                <h4>Calendar</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div><!-- col-md-9 -->
            
        </div><!-- row -->

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->

@stop

@section('scripts')

{{ Html::script('js/fullcalendar.min.js')}}

<script type="text/javascript">
/* initialize the calendar */  
jQuery('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    events: '/search/events/admin',
    editable: false,
    droppable: false, // this allows things to be dropped onto the calendar !!!
    drop: function(date, allDay) { // this function is called when something is dropped
                  
        
    }
});
</script>
@stop
