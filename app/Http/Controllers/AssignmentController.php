<?php
namespace App\Http\Controllers;
use App\Models\Assignment as Assignment;
use App\Models\VMachine as VMachine;
use App\Models\Course as Course;
use App\Models\Enrollment as Enrollment;

class AssignmentController extends Controller {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function listAssignments()
	{

		$assignments = Assignment::listAssignments();

		$view = view('dashboard/assignmentslist')
					->with('assignments', $assignments);

		return $view;
	}

	public function showAssignments()
	{
		$assignments = Assignment::showAssignments();
		//echo "<pre>"; die($assignments);
		$view = view('dashboard/assignments');
		$view->with('assignments',$assignments);

		return $view;

	}

	public function viewAssignment($id)
	{
		//$assignment = Assignment::where('id', $id)->first();
		$assignment = Assignment::viewAssignment($id);

		$course = Course::where('id', $assignment->course_id)->first();

		$scenarios = Scenario::where('vmachine_id', $assignment->vmachine_id)->get();
		// $results = Result::select(array(
		// 			 	 	 	'result.scenario_id',
		// 			 	 	 	'result.question_type',
		// 			 	 	 	'result.answer',
		// 						))

		// 						->leftJoin('scenario', function($join) {
		// 							$join->on('result.scenario_id', '=', 'scenario.id');
		// 						})
		// 						->get();

		foreach ($scenarios as $scenario) {

			
			$results = Result::select(array(
					 	 	 	'result.question_type',
					 	 	 	'result.answer',
								))

								->leftJoin('scenario', function($join) {
									$join->on('result.scenario_id', '=', 'scenario.id');
								})
								->where('result.scenario_id', '=', $scenario->id)
								->get();
			$answer = new stdClass();
			foreach ($results as $result) {
				if($result->question_type == "attacker_ip")
					$answer->attacker_ip = $result->answer;
				elseif($result->question_type == "attacker_date")
					$answer->attacker_date = $result->answer;
				elseif($result->question_type == "attacker_stolen_data")
					$answer->attacker_stolen_data = $result->answer;
				elseif($result->question_type == "attacker_entrypoint_file")
					$answer->attacker_entrypoint_file = $result->answer;
				elseif($result->question_type == "attacker_entrypoint_line")
					$answer->attacker_entrypoint_line = $result->answer;
			}
			$scenario['result'] = $answer;
		}

		//dd("<pre>".$scenarios."</pre>");

		$vmachine = VMachine::where('id', $assignment->vmachine_id)->first();

		$view = view('dashboard/viewassignment');

		$view->with('assignment', $assignment)
			 ->with('scenarios', $scenarios)
			 ->with('vmachine', $vmachine)
			 ->with('course', $course);

		return $view;
	}

	public function newAssignment()
	{
		$vmachines = VMachine::where('used', 0)->get();

		$view = view('dashboard/newassignment');
		$view->with('vmachines', $vmachines);

		return $view;
	}

	public function storeAssignment(Request $request)
	{
		$input = $request->all();

		$name = explode(" ", $input['username']);

		$user = User::select ('id')
        					->where('first_name', 'LIKE', $name[0] . '%')
        					->orWhere('last_name', 'LIKE', $name[1] . '%')
        					->first();

		$course = Course::select ('id', 'user_id')
        					->where('name', 'LIKE', $input['course'] . '%')
        					->first();

        $enrolled = Enrollment::where('user_id',$user->id)->first();

        $vmachine = VMachine::where('id', $input['vmachine'] )->first();

        if(!isset($enrolled))
		{
			$enrollment = new Enrollment;
			$enrollment->user_id 	= $user->id;
			$enrollment->course_id	= $course->id;
			$enrollment->status 	= $input['status'];
			$enrollment->save();

			$assignment = new Assignment();
			$assignment->enrollment_id	= $enrollment->id;
			$assignment->course_id 		= $enrollment->course_id;
			$assignment->vmachine_id 	= $input['vmachine'];
			$assignment->teacher_id		= $course->user_id;
			$assignment->status 		= "created";
			$assignment->time 			= intval($input['time']);
			$assignment->save();

			$vmachine->used = 1;
			$vmachine->save();

			Session::flash('success_msg', $input['username'].' assignment was successfuly created on '.$input['course'].' course.');
			return Redirect::to('/assignments/new');
		} else {

			$assignment = new Assignment();
			$assignment->enrollment_id	= $enrolled->id;
			$assignment->course_id 		= $course->id;
			$assignment->vmachine_id 	= $input['vmachine'];
			$assignment->teacher_id		= $course->user_id;
			$assignment->status 		= "created";
			$assignment->time 			= $input['time'];
			$assignment->save();

			$vmachine->used = 1;
			$vmachine->save();

			$enrolled->status = "active";
			$enrolled->save();

			Session::flash('success_msg', $input['username'].' assignment was successfuly created on '.$input['course'].' course.');
			//Session::flash('error_msg', 'You have already enrolled '.$input['username'].' on '.$input['course'].' course.');
			return Redirect::to('/assignments/new');
		}

	}

	public function newUserAssignment($enrollId,$teacherId)
	{
		$enrollment = Enrollment::select(array(
						        'enrollment.id',
						        'enrollment.user_id',
						        'enrollment.course_id',
						        'users.id AS user_id',
						        'users.first_name',
						        'users.last_name',
						        'course.name'
						    ))
							->leftJoin('users', function($join) {
								$join->on('enrollment.user_id', '=', 'users.id');
							})
							->leftJoin('course', function($join) {
								$join->on('enrollment.course_id', '=', 'course.id');
							})
							->where('enrollment.id',$enrollId)
							->first();

		$teacher = User::where('id',$teacherId)->first();

		$vmachines = VMachine::where('used', 0)->get();

		$view = View::make('dashboard/newuserassignment');
		$view->with('enrollment', $enrollment);
		$view->with('teacher', $teacher);
		$view->with('vmachines', $vmachines);

		return $view;
	}

	public function storeUserAssignment()
	{
		$input = Input::all();

		$assignment = new Assignment();
		$assignment->enrollment_id	= $input['enrollId'];
		$assignment->course_id 		= $input['courseId'];
		$assignment->vmachine_id 	= $input['vmachine'];
		$assignment->teacher_id		= $input['teacherId'];
		$assignment->status 		= "created";
		$assignment->time 			= intval($input['time']);
		$assignment->save(); 

		$vmachine = VMachine::where('id', $input['vmachine'] )->first();

		$vmachine->used = 1;
		$vmachine->save();

		Session::flash('success_msg', 'User assignment was successfully created.');
		return Redirect::to('/assignments');
	}

	public function takeAssignment($id)
	{
		$assignment = Assignment::where('id', $id)->first();

		$course = Course::where('id', $assignment->course_id)->first();

		$scenarios = Scenario::where('vmachine_id', $assignment->vmachine_id)->get();

		$vmachine = VMachine::where('id', $assignment->vmachine_id)->first();

		$view = view('dashboard/takeassignment');

		if($assignment->date_started == NULL){
			$assignment->date_started = date('Y-m-d H:i:s');
			$assignment->status = "open";
			$assignment->save();
		}

		$view->with('assignment', $assignment)
			 ->with('scenarios', $scenarios)
			 ->with('vmachine', $vmachine)
			 ->with('course', $course);

		return $view;
	}

	public function checkAssignment()
	{
		$input = Input::all();
		
		$assignment = Assignment::where('id', $input['assignment'])->first();

		$scenarios = Scenario::where('vmachine_id', $assignment->vmachine_id)->get();

		if($assignment->status == "finished" || $assignment->status == "finishedentry") {
			Session::flash('error_msg', 'Oh snap! Looks like you\'ve already submted your answers!');
			return Redirect::to('/assignments/list/');
		}

		foreach ($scenarios as $scenario) {
			if($scenario->type == "phishing"){

				if(empty($input['ip_'.$scenario->id]) || empty($input['date_'.$scenario->id]) || empty($input['sd_'.$scenario->id])) 
				{
					Session::flash('error_msg', 'There are missing answeres in Phising section. Please fill out entire form completely.');
			    	return Redirect::to('/assignments/take/'.$assignment->id)->withInput();
				} else {
					
					$res = ($scenario->attacker_ip == $input['ip_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_ip";
					$result->answer 		= $input['ip_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_date == $input['date_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_date";
					$result->answer 		= $input['date_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					// $res = ($scenario->attacker_entrypoint_file == $input['epf_'.$scenario->id]) ? 'positive' : 'negative';

					// $result = new Result();
					// $result->scenario_id 	= $scenario->id;
					// $result->question_type 	= "attacker_entrypoint_file";
					// $result->answer 		= $input['epf_'.$scenario->id];
					// $result->result 		= $res;
					// $result->save();

					// $res = ($scenario->attacker_entrypoint_line == $input['epl_'.$scenario->id]) ? 'positive' : 'negative';

					// $result = new Result();
					// $result->scenario_id 	= $scenario->id;
					// $result->question_type 	= "attacker_entrypoint_line";
					// $result->answer 		= $input['epl_'.$scenario->id];
					// $result->result 		= $res;
					// $result->save();

					$res = ($scenario->attacker_stolen_data == $input['sd_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_stolen_data";
					$result->answer 		= $input['sd_'.$scenario->id];
					$result->result 		= $res;
					$result->save();
				}
			}
			elseif($scenario->type == "sql"){

				if(empty($input['ip_'.$scenario->id]) || empty($input['date_'.$scenario->id]) || empty($input['epf_'.$scenario->id]) || empty($input['epl_'.$scenario->id]) || empty($input['sd_'.$scenario->id])) 
				{
					Session::flash('error_msg', 'There are missing answeres in SQL section. Please fill out entire form completely.');
			    	return Redirect::to('/assignments/take/'.$assignment->id)->withInput();
				} else {
					
					$res = ($scenario->attacker_ip == $input['ip_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_ip";
					$result->answer 		= $input['ip_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_date == $input['date_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_date";
					$result->answer 		= $input['date_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_entrypoint_file == $input['epf_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_entrypoint_file";
					$result->answer 		= $input['epf_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_entrypoint_line == $input['epl_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_entrypoint_line";
					$result->answer 		= $input['epl_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_stolen_data == $input['sd_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_stolen_data";
					$result->answer 		= $input['sd_'.$scenario->id];
					$result->result 		= $res;
					$result->save();
				}
			}
			elseif($scenario->type == "ddos"){

				if(empty($input['ip_'.$scenario->id]) || empty($input['date_'.$scenario->id])) 
				{
					Session::flash('error_msg', 'There are missing answeres in DDOS section. Please fill out entire form completely.');
			    	return Redirect::to('/assignments/take/'.$assignment->id)->withInput();
				} else {
					
					$res = ($scenario->attacker_ip == $input['ip_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_ip";
					$result->answer 		= $input['ip_'.$scenario->id];
					$result->result 		= $res;
					$result->save();

					$res = ($scenario->attacker_date == $input['date_'.$scenario->id]) ? 'positive' : 'negative';

					$result = new Result();
					$result->scenario_id 	= $scenario->id;
					$result->question_type 	= "attacker_date";
					$result->answer 		= $input['date_'.$scenario->id];
					$result->result 		= $res;
					$result->save();
				}
			}
		}

		// time check
		$finished = date('Y-m-d H:i:s');
		$now = strtotime($finished);
		$begin = strtotime($assignment->date_started);
		$end = $begin + $assignment->time*60;

		//$time = round(($end-$begin)/($begin-$now) * 100);
		$time = round(($now-$begin)/($end-$begin)*100);

		// Calculate and display results
		$assignment->date_finished = $finished;
		$total = Result::leftJoin('scenario', function($join) {
									$join->on('result.scenario_id', '=', 'scenario.id');
								})
								->where('vmachine_id', '=', $assignment->vmachine_id)
								->count();

		$positive = Result::leftJoin('scenario', function($join) {
								$join->on('result.scenario_id', '=', 'scenario.id');
							})
							->where('vmachine_id', '=', $assignment->vmachine_id)
							->where('result.result', '=', 'positive')
							->count();
		
		$percent = round($positive/$total * 100);
		$total = $total / 2;

		if($positive >= $total){
			$success = 1;
			$assignment->result = 'positive';
		} else {
			$success = 0;
			$assignment->result = 'negative';
		}

		$assignment->percent = $percent;
		$assignment->time_percent = $time;

		if($end < $now){
			// run out of time
			$success = 2;

			//$assignment->date_finished = $finished;
			$assignment->result = 'negative';
			$assignment->status = "finishedentry";
			$assignment->save();

			$view = view('dashboard/assignmentresult');
			$view->with('percent', $percent)
				 ->with('time', $time)
				 ->with('success', $success)
				 ->with('error_msg', '<i class="fa fa-frown-o"></i> Sorry, you have spent more than '.$assignment->time.' minutes, which was requested time to finish this assignment.');
			return $view;
		} else {
			//$assignment->date_finished = $finished;
			$assignment->status = "finished";
			
			$assignment->save();

			$view = view('dashboard/assignmentresult');
			$view->with('percent', $percent)
				 ->with('time', $time)
				 ->with('success', $success);
			return $view;
		}
	}

	public function showResult()
	{
		$percent = 40;
		$success = 0;
		$time = -300;

		$view = view('dashboard/assignmentresult');
			$view->with('percent', $percent)
				 ->with('time', $time)
				 ->with('success', $success);
			return $view;
	}

	public function deleteAssignment($id) 
	{
        $assignment = Assignment::where('id', $id)->first();

        $scenarios = Scenario::select('id')->where('vmachine_id', $assignment->vmachine_id)->get();

        foreach($scenarios as $scenario){
            Result::where('scenario_id', $scenario->id)->delete();
        }

        $vmachine = VMachine::where('id', $assignment->vmachine_id)->first();

        $vmachine->used = 0;
        $vmachine->console = NULL;
        $vmachine->save();

        $assignment->delete();

		Session::flash('success_msg', 'Assignment was successfully deleted.');
		return Redirect::to('/assignments');
	}

}
