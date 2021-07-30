@extends('dashboard.master')

@section('content')
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="glyphicon glyphicon-hdd"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="/"><i class="glyphicon glyphicon-hdd"></i></a></li>
                    <li><a href="/vmachines">Virtual Machines</a></li>
                    <li>New Virtual</li>
                </ul>
                <h4>New Virtual</h4>
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

    <div class="panel panel-primary">
        <div class="panel-heading"><i class="glyphicon glyphicon-hdd"></i> New Virtual Machine</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-4">Choose Course</label>
                    <div class="col-sm-8">
                        <input class="course form-control" id="course" name="course" type="text" placeholder="Course Name">
                    </div>
                </div><!-- form-group -->
                <div class="form-group">
                    <label class="col-sm-4">Scenario types</label>
                    <div class="col-sm-8">     
                        <div class="ckbox ckbox-primary">
                            <input type="checkbox" name="ch1" value="1" id="checkboxPrimary">
                            <label for="checkboxPrimary">Phishing</label>
                        </div>
                          
                        <div class="ckbox ckbox-success">
                            <input type="checkbox" name="ch1" value="2" id="checkboxSuccess">
                            <label for="checkboxSuccess">SQL Injection</label>
                        </div>
                          
                        <div class="ckbox ckbox-danger">
                            <input type="checkbox" name="ch1" value="4" id="checkboxDanger">
                            <label for="checkboxDanger">DDOS</label>
                        </div>
                        
                    </div>
                </div><!-- form-group -->
            </div><!-- panel body -->
            <div class="panel-footer">
                <button class="btn btn-primary mr5" id="submit_btn">Submit</button>
            </div><!-- panel-footer"-->
    </div>

    </div><!-- contentpanel -->
    
</div><!-- mainpanel -->


<!-- Progress -->
<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Processing...</h4>
      </div>
      <div class="modal-body">
        <div class="progress">
          <div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- show response error -->
<div id="showError" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Warning</h4>
            </div>
            <div class="modal-body">
                <h5><p><span class="text-danger">Server response:</span> <span id="errorResponse"></span></p></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@stop

@section('scripts')
<script type="text/javascript">
$(function(){
    $('#submit_btn').click(function(event) {

        $("#pleaseWaitDialog").modal('show');
        
        var scenario=0;
        var course = $('#course').val();

        $.each($("input:checkbox:checked"), function(){            
            scenario+=parseInt($(this).val());
        });

        var dataString = 'course='+course+'&scenario='+scenario;

        var request = $.ajax({
            url: "/vmachines/new",
            type: "POST",
            data: dataString,
            dataType: "html"
        });
        
        request.done(function(msg) {
            $("#pleaseWaitDialog").modal('hide');
            if(msg == "noresponse"){
                $("#errorResponse").text("there was no response from server or error occured while creating virtual machine.");
                $("#showError").modal('show');
            } else if(msg == "nocourse") {
                $("#errorResponse").text("Given course does not exist. Please try different name.");
                $("#showError").modal('show');
            } else if(msg == "noscenario") {
                $("#errorResponse").text("No scenario selected. Please select type of scenario.");
                $("#showError").modal('show');
            } else if(msg == "ok"){
                window.location.href = "/vmachines";
            }
        });

        request.fail(function(jqXHR, textStatus) {
            $("#pleaseWaitDialog").modal('hide');
            //alert( "Request failed: " + textStatus );
            $("#errorResponse").text("there was no response from server or error occured while creating virtual machine.");
            $("#showError").modal('show');
        });
    });
});
</script>
@stop