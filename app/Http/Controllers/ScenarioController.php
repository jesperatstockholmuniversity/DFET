<?php
namespace App\Http\Controllers;
use App\Models\Course as Course;
use App\Models\VMachine as VMachine;
use App\Models\Scenario as Scenario;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class ScenarioController extends Controller {

  public function __construct() {
    //$this->beforeFilter('csrf', $array('on' => 'post'));
  }

  public function showScenarios() {
    $vmachines = VMachine::select(array(
                                'vmachine.id',
                                'vmachine.course_id',
                                'vmachine.machine_id',
                                'vmachine.machine_name',
                                'vmachine.status',
                                'vmachine.used',
                                'vmachine.created_at',
                                'vmachine.scenarios',
                                'course.id AS course_id',
                                'course.name'
                            ))
                            ->leftJoin('course', function($join) {
                                $join->on('vmachine.course_id', '=', 'course.id');
                            })->get();

    $scenarios = Scenario::select(array(
            'scenario.id',
            'scenario.vmachine_id',
            'scenario.created_at',
            'vmachine.machine_name'))
        ->leftJoin('vmachine', function($join) {
            $join->on('scenario.vmachine_id', '=', 'vmachine.id');
        })
        ->get();

        $view = view('dashboard/scenarios');
        $view->with('vmachines',$vmachines);
        $view->with('scenarios',$scenarios);
        
        return $view;
  }

  public function newScenario() {
    $vmachines = VMachine::all();

    $view = view('dashboard/newscenario');
    $view->with('vmachines',$vmachines);

    return $view;
  }

  public function viewScenario($id) {
    $scenario = Scenario::where('id', $id)->first();
    $vmachine = VMachine::where('id', $scenario->vmachine_id)->first();
    $questions = ScenarioQuestion::select(array(
            'scenario_questions.id',
            'scenario_questions.question',
            'scenario_questions.hash_offset',
            'scenario_questions.created_at'
        ))->where('scenario_id', $id)
        ->get();
    $view = view('dashboard/viewscenario');
    $view->with('scenario',$scenario);
    $view->with('vmachine',$vmachine);
    $view->with('questions',$questions);
    return $view;
  }

  public function storeScenario() {
    $input = Input::all();
    $questions = Input::get('questions');
    $vmachine = VMachine::where('id', $input['vmachineId'])->first();

    if (empty($input['vmachineId'])) return "{\"status\": \"no_vmachineId\"}";
    if (empty($input['scenarioName'])) return "{\"status\": \"no_scenarioName\"}";

    foreach($questions as $question) {
        if (empty($question['question'])) return "{\"status\": \"no_question\"}";
        //if ($question['hash_offset'] && empty($question['hash_offset'])) return "{\"status\": \"no_hash_offset\"}";
        //if ($question['text_answer'] && empty($question['text_answer'])) return "{\"status\": \"no_text_answer\"}";
    }

    $scenario = new Scenario();
    $scenario->vmachine_id = $input['vmachineId'];
    $scenario->type = "phishing";
    $scenario->name = $input['scenarioName'];
    $scenario->save();

    $placeholders = "";
    $scenarioQuestions = array();
    foreach($questions as $question) {
        $scenarioQuestion = new ScenarioQuestion();
        $scenarioQuestion->scenario_id = $scenario->id;
        $scenarioQuestion->question = $question['question'];
        if (isset($question['hash_offset'])) {
            $scenarioQuestion->hash_placeholder = $question['hash_offset'];
        }
        if (isset($question['text_answer'])) {
            $scenarioQuestion->text_answer = $question['text_answer'];
        }
        $scenarioQuestion->save();

        if (isset($scenarioQuestion->hash_placeholder)) {
            $placeholders = $placeholders . $scenarioQuestion->id . "," . $scenarioQuestion->hash_placeholder;
            $placeholders = $placeholders . "|";
            $scenarioQuestions[] = $scenarioQuestion;
        }
    }

    // If the placeholders variable has not been populated, let's return no more processing is needed.
    if ($placeholders === "") {
        return "{\"status\": \"ok\"}";
    }

    $placeholders = rtrim($placeholders, "|");

    $url = 'http://sirius.cs2lab.dsv.su.se:81/src/api.php?operation=findoffsets&id='.$vmachine->machine_id.'&placeholders='.$placeholders;

    // Send request to API to clone new VM
    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n",
        'timeout'=>3600
      )
    );
    $context = stream_context_create($opts);
    $content = file_get_contents($url, false, $context);
    $json = json_decode($content, TRUE);

    if ($json["status"] == "NoFile") {
        Session::flash('error_msg', 'Error: The VMachine .img not found.');
    } else if ($json["status"] == "EmptyOutput") {
        Session::flash('error_msg', 'Error: The placeholder for question: ' . $json["questionID"] . " is not found");
    } else if ($json["status"] == "MultipleMatches") {
        Session::flash('error_msg', 'Error: The placeholder for question: ' . $json["questionID"] . " is not unique");
    } else if ($json["status"] == "EmptyOffset") {
        Session::flash('error_msg', 'Error: The placeholder for question: ' . $json["questionID"] . " is not found");
    }

    if ($json["status"] != "OK") {
        foreach($scenarioQuestions as $scenarioQuestion) {
            $scenarioQuestion->delete();
        }
        $scenario->delete();
    }

    if ($json["status"] == "OK") {
        foreach($json["offsets"] as $offset) {
            $scenarioQuestion = ScenarioQuestion::where('id', $offset["id"])->first();
            $scenarioQuestion->hash_offset = $offset["offset"];
            $scenarioQuestion->save();
        }
        Session::flash('success_msg', 'Scenario was successfully created.');
    }

    return "{\"status\": \"ok\"}";
  }

  public function updateScenario($id) {

    $input = Input::all();
    $questions = Input::get('questions');
    
    if (empty($input['vmachineId'])) return "{\"status\": \"no_vmachineId\"}";
    if (empty($input['scenarioName'])) return "{\"status\": \"no_scenarioName\"}";

    if ($questions) {
        foreach($questions as $question) {
            if (empty($question['question'])) return "{\"status\": \"no_question\"}";
            if (empty($question['hash_offset'])) return "{\"status\": \"no_hash_offset\"}";
        }
    }

    $scenario = Scenario::where('id', $id)->first();
    $scenario->vmachine_id = $input['vmachineId'];
    $scenario->type = "phishing";
    $scenario->name = $input['scenarioName'];
    $scenario->save();

    $dbQuestions = ScenarioQuestion::select(array('scenario_questions.id'))->where('scenario_id', $id)->get();
    foreach($dbQuestions as $dbQuestion) {
        $found = false;
        if ($questions) {
            foreach($questions as $question) {
                if ($dbQuestion->id == $question['id']) {
                    $found = true;
                }
                if ($found) break;
            }
        }
        if ($found == false) {
            $dbQuestion->delete();
        }
    }

    if ($questions) {
        foreach($questions as $question) {
            if ($question['id'] >= 0) {
                $scenarioQuestion = ScenarioQuestion::where('id', $question['id'])->first();
            } else {
                $scenarioQuestion = new ScenarioQuestion();
            }
            $scenarioQuestion->scenario_id = $scenario->id;
            $scenarioQuestion->question = $question['question'];
            $scenarioQuestion->hash_offset = $question['hash_offset'];
            $scenarioQuestion->save();
        }
    }
    
    Session::flash('success_msg', 'Scenario was successfully updated.');

    return "{\"status\": \"ok\"}";
  }

  public function editScenario($id) {
    $scenario = Scenario::where('id', $id)->first();
    $vmachine = VMachine::where('id', $scenario->vmachine_id)->first();
    $questions = ScenarioQuestion::select(array(
            'scenario_questions.id',
            'scenario_questions.question',
            'scenario_questions.hash_offset',
            'scenario_questions.created_at'
        ))->where('scenario_id', $id)
        ->get();
    $view = view('dashboard/viewscenario');
    $view->with('scenario',$scenario);
    $view->with('vmachine',$vmachine);
    $view->with('questions',$questions);
    
    $view = view('dashboard/editscenario');
    $view->with('scenario', $scenario);
    $view->with('vmachine', $vmachine);
    $view->with('questions', $questions);
    return $view;
  }

  public function deleteScenario($id) {
    $scenario = Scenario::where('id',$id)->first();
    $scenarioQuestions = ScenarioQuestion::where('scenario_id', $id)->get();

    foreach ($scenarioQuestions as $scenarioQuestion) 
    {
        $scenarioQuestion->delete();
    }

    $scenario->delete();

    Session::flash('success_msg', 'Scenario was successfully deleted.');
    return Redirect::to('/scenarios');
  }

  public function newScenarioQuestion($id) {
    $scenario = Scenario::where('id', $id)->first();
    $view = view('dashboard/editscenario');
    return $view;
  }

  public function deleteScenarioQuestion($id) {
    $scenarioQuestion = ScenarioQuestion::where('id', $id)->first();
    $scenarioId = $scenarioQuestion->scenario_id;
    $scenarioQuestion->delete();
    return Redirect::to('/scenarios/view/' . $scenarioId);
  }

}
