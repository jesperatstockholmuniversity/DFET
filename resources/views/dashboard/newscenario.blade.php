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
                    <li><a href="/scenarios">Scenarios</a></li>
                    <li>New Scenario</li>
                </ul>
                <h4>New Scenario</h4>
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
        <div class="panel-heading"><i class="glyphicon glyphicon-tasks"></i> New Scenario</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-4">Scenario Name</label>
                    <div class="col-sm-8">
                        <input class="course form-control" id="scenario" name="scenario" type="text" placeholder="Scenario Name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4">Virtual Machine</label>
                    <div class="col-sm-8">
                        <select id="vmachine" name="vmachine" data-placeholder="Choose One" class="width100p" required>
                            <option value="">Choose One</option>
                            @foreach ($vmachines as $vmachine)
                            <option value="{{$vmachine->id}}">
                                {{$vmachine->machine_name}} (ID: {{$vmachine->machine_id}})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div><!-- form-group -->

                <div id="question-container"></div>

                <div class="form-group">
                    <div class="col-sm-4">
                        <input class="course form-control btn btn-primary" id="add_question1" name="question1" type="button" value="Add a hash question">
                    </div>
                    <div class="col-sm-4">
                        <input class="course form-control btn btn-primary" id="add_question2" name="question2" type="button" value="Add a text question">
                    </div>
                    <div class="col-sm-4">
                        <input class="course form-control btn btn-primary" id="add_question3" name="question3" type="button" value="Add a hash+test question">
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
    function createQuestion(isHash, isText){

      var divQuestion = $('<div class="form-group question">');
      var divQuestionName = $('<div class="col-sm-10">');
      var divQuestionOffset = $('<div class="col-sm-12">');
      var divQuestionDelete = $('<div class="col-sm-2">');
      var divQuestionTextAnswer = $('<div class="col-sm-12">');
      var inputQuestionName = $('<input class="course form-control" name="question" type="text" placeholder="Question Text">');
      var inputQuestionOffset = $('<input class="course form-control" name="hash_offset" type="text" placeholder="Original Hash Sum">');
      var inputQuestionTextAnswer = $('<input class="course form-control" name="text_answer" type="text" placeholder="Expected text answer">');
      var buttonQuestionDelete = $('<button class="form-control btn btn-danger" name="delete" type="button">');
      var glyphQuestionDelete = $('<span class="glyphicon glyphicon-remove">');

      var deleteButtonCallback = function() {
        buttonQuestionDelete.unbind('click');
        divQuestion.remove();
      };
      buttonQuestionDelete.bind('click', deleteButtonCallback);

      buttonQuestionDelete.append(glyphQuestionDelete);
      divQuestionName.append(inputQuestionName);
      divQuestionOffset.append(inputQuestionOffset);
      divQuestionDelete.append(buttonQuestionDelete);
      divQuestion.append(divQuestionName);
      divQuestionTextAnswer.append(inputQuestionTextAnswer);

      divQuestion.append(divQuestionDelete);
      if (isHash) {
        divQuestion.append(divQuestionOffset);
      }
      if (isText) {
        divQuestion.append(divQuestionTextAnswer);
      }

      return divQuestion;
    }

    $('#add_question1').click(function(event) {
      $('#question-container').append(createQuestion(true, false));
    });

    $('#add_question2').click(function(event) {
      $('#question-container').append(createQuestion(false, true));
    });

    $('#add_question3').click(function(event) {
      $('#question-container').append(createQuestion(true, true));
    });

    $('#submit_btn').click(function(event) {
        $("#pleaseWaitDialog").modal('show');
        
        var questions = [];
        var qC = document.getElementById('question-container');
        var qCChildren = [].slice.call(qC.children);
        qCChildren.forEach(function(element) {
            var inputs = element.getElementsByTagName('input');
            inputs = Array.prototype.slice.call(inputs);
          
            var attributes = {};
            inputs.forEach(function(input) {
              if(!input.value || !input.name) {
                return;
              }

              attributes[input.name] = input.value;
            });

            questions.push(attributes);
        });

        var vmachine = $('#vmachine').val();
        var scenarioName = $('#scenario').val();

        var dataObject = {
          vmachineId: vmachine,
          scenarioName: scenarioName,
          questions: questions
        };

        var request = $.ajax({
            url: "/scenarios/store",
            type: "POST",
            data: dataObject,
            dataType: "json"
        });

        request.done(function(msg) {
          $("#pleaseWaitDialog").modal('hide');

          if(msg['status'] == "noresponse"){
            $("#errorResponse").text("There was no response from server or error occured while creating scenario.1");
            $("#showError").modal('show');
          } else if(msg['status'] == "no_vmachineId") {
            $("#errorResponse").text("Virtual Machine does not exist.");
            $("#showError").modal('show');
          } else if(msg['status'] == "no_scenarioName") {
            $("#errorResponse").text("Scenario name must be specified.");
            $("#showError").modal('show');
          } else if(msg['status'] == "no_question") {
            $("#errorResponse").text("Question Text must be specified.");
            $("#showError").modal('show');
          } else if(msg['status'] == "no_hash_offset") {
            $("#errorResponse").text("Hash Offset must be specified.");
            $("#showError").modal('show');
          }  else if(msg['status'] == "no_text_answer") {
            $("#errorResponse").text("Text Answer must be specified.");
            $("#showError").modal('show');
          } else if(msg['status'] == "ok") {
            window.location.href = "/scenarios";
          }
        });

        request.fail(function(jqXHR, textStatus) {
            $("#pleaseWaitDialog").modal('hide');
            $("#errorResponse").text("There was no response from server or error occured while creating scenario.2");
            $("#showError").modal('show');
        });
    });
});
</script>
@stop
