<?php
namespace App\Http\Controllers;
use App\Models\VMachine as VMachine;
use Carbon\Carbon;
use App\Http\Controllers;
use App\Models\Files as Files;
use App\Models\User as User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as Sentinel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class VMachinesController extends Controller {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function showVMachines()
	{
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

		$view = view('dashboard/vmachines');
		$view->with('vmachines',$vmachines);
        
		return $view;
	}

	public function deleteVMachine($id)
	{

        $this->operateVMachine($id,"delete");

		VMachine::where('id',$id)->delete();
		$scenarios = Scenario::where('vmachine_id', $id)->get();
		    
	    foreach ($scenarios as $scenario) 
	    {
    		$scenario->delete();
	    }

		Session::flash('success_msg', 'VMachine was successfully deleted.');
		return Redirect::to('/vmachines');
	}

    public function operateVMachine($id,$operation)
    {
        $endpoint = Config::get('settings.endpoint');
        $secret = Config::get('settings.secret');

        $vmachine = VMachine::where('id', $id)->first();

        if($operation == "shutdown")
            $vmachine->status = 0;
        elseif ($operation == "poweron") 
            $vmachine->status = 1;
        elseif ($operation == "poweroff")
            $vmachine->status = 2;
        elseif ($operation == "delete")
            $vmachine->status = 3; 
                    

        //http://193.138.1.220:64444/vmcontrol.php?vmname=wmini&secret=hopsasa
        $phpjson = file_get_contents($endpoint.'/vmcontrol.php?vmname='.$vmachine->machine_name.'&secret='.$secret.'&operation='.$operation);

        $data = json_decode($phpjson);

        if (!$phpjson) {
            Session::flash('error_msg', 'An error occurred while performing operation '.$operation);
            return Redirect::back();
        } else {
            Session::flash('success_msg', 'Operation: <strong>'.$operation.'</strong> was successfully executed.');
            //$vmachine->status = "0";
            $vmachine->save();
            return Redirect::back();
        }
    }

    public function serverLog()
    {
        $endpoint = Config::get('settings.endpoint');
        $secret = Config::get('settings.secret');

        $response = file_get_contents($endpoint.'/logdump.php?secret='.$secret);

        return $response;
    }

    public function newMachine()
    {
        $view = view('dashboard/newvmachine');
        return $view;
    }

    public function requestConsole($id, $assignId)
    {   
        $endpoint = Config::get('settings.endpoint');
        $secret = Config::get('settings.secret');

        $vmachine = VMachine::where('id', $id)->first();

        $phpjson = file_get_contents($endpoint.'/generateConsoleURL.php?vmname='.$vmachine->machine_name.'&secret='.$secret);

        $data = json_decode($phpjson);

        if (!$phpjson) {
            Session::flash('error_msg', 'Unable to request virtual machine console at this time. Please contact administrator.');
            //return Redirect::to('/assignments/take/'.$assignId);
            return Redirect::back();
        } else {

            $vmachine->console = $data->url;
            $vmachine->save();

            Session::flash('success_msg', 'Your virtual machine url was successfully generated. Now you can access remote console and proceed with the exam bellow.');
            //return Redirect::to('/assignments/take/'.$assignId);
            return Redirect::back();
        }
    }

	public function storeVMachine()
	{

		$input = Input::all();

		$endpoint = Config::get('settings.endpoint');
		$secret = Config::get('settings.secret');

        // 1 200 Seconds = 20 Minutes
        $ctx = stream_context_create(array ('http'=>array('timeout' => 1200, )));

		//$phpjson = file_get_contents($endpoint.'/createvmTest.php?secret='.$secret.'&time=600', false, $ctx); // testing
        $phpjson = file_get_contents($endpoint.'/createvm.php?secret='.$secret.'&scenario='.$input['scenario'], false, $ctx); // production

		$data = json_decode($phpjson);

		if (!$phpjson || $data->status != '0') {
			return "noresponse";
		} else {
			if (empty($input['course'])) return "nocourse";
			
			$course = Course::select ('id')
        					->where('name', 'LIKE', $input['course'] . '%')
        					->first();
        	
        	if($course->count() == 0) {
        		return "nocourse";
        	} else {
	    		$vmachine = new VMachine();
				$vmachine->course_id 	= $course->id;
				$vmachine->machine_id 	= $data->machine_id;
				$vmachine->machine_name = $data->machine_name;
				//$vmachine->status 	 	= 1;
                $vmachine->used         = 0;
                $vmachine->scenarios    = $input['scenario'];
				$vmachine->save();
        	}

        	if (empty($input['scenario'])) return "noscenario";

        	//return $input['scenario']

        	if ($input['scenario'] == 1 || $input['scenario'] == 3 || $input['scenario'] == 5 || $input['scenario'] == 7 ) {

        		$scenario = new Scenario();
        		// correct answer set
        		$scenario->vmachine_id				= $vmachine->id;
        		$scenario->type 					= "phishing";
        		$scenario->attacker_ip				= $data->scenarioPhishing->attacker->address;
        		$scenario->attacker_date 			= $data->scenarioPhishing->attacker->time;
        		$scenario->attacker_stolen_data 	= $data->scenarioPhishing->attacker->stolen;
        		// $scenario->attacker_entrypoint_file = $data->scenarioPhishing->entrypoint->file;
        		// $scenario->attacker_entrypoint_line = $data->scenarioPhishing->entrypoint->line;
        		// wrong answers set 1
        		$scenario->attacker_option1_ip				= $data->scenarioPhishing->attacker->options_ip[0];
        		$scenario->attacker_option1_date			= $data->scenarioPhishing->attacker->options_time[0];
        		$scenario->attacker_option1_stolen_data 	= $data->scenarioPhishing->attacker->options_stolen[0];
        		// $scenario->attacker_option1_entrypoint_file	= $data->scenarioPhishing->entrypoint->options[0]->file;
        		// $scenario->attacker_option1_entrypoint_line	= $data->scenarioPhishing->entrypoint->options[0]->line;
        		// // wrong answers set 2
        		$scenario->attacker_option2_ip				= $data->scenarioPhishing->attacker->options_ip[1];
        		$scenario->attacker_option2_date			= $data->scenarioPhishing->attacker->options_time[1];
        		$scenario->attacker_option2_stolen_data		= $data->scenarioPhishing->attacker->options_stolen[1];
        		// $scenario->attacker_option2_entrypoint_file	= $data->scenarioPhishing->entrypoint->options[1]->file;
        		// $scenario->attacker_option2_entrypoint_line	= $data->scenarioPhishing->entrypoint->options[1]->line;
        		$scenario->save();

        	} 

        	if ($input['scenario'] == 2 || $input['scenario'] == 3 || $input['scenario'] == 6 || $input['scenario'] == 7) {

        		$scenario = new Scenario();
        		// correct answer set
        		$scenario->vmachine_id				= $vmachine->id;
        		$scenario->type 					= "sql";
        		$scenario->attacker_ip 				= $data->scenarioSqlinjection->attacker->address;
        		$scenario->attacker_date 			= $data->scenarioSqlinjection->attacker->time;
        		$scenario->attacker_stolen_data 	= $data->scenarioSqlinjection->attacker->stolen;
        		$scenario->attacker_entrypoint_file = $data->scenarioSqlinjection->entrypoint->file;
        		$scenario->attacker_entrypoint_line = $data->scenarioSqlinjection->entrypoint->line;
        		// wrong answers set 1
        		$scenario->attacker_option1_ip 				= $data->scenarioSqlinjection->attacker->options_ip[0];
        		$scenario->attacker_option1_date			= $data->scenarioSqlinjection->attacker->options_time[0];
        		$scenario->attacker_option1_stolen_data		= $data->scenarioSqlinjection->attacker->options_stolen[0];
        		$scenario->attacker_option1_entrypoint_file = $data->scenarioSqlinjection->entrypoint->options[0]->file;
        		$scenario->attacker_option1_entrypoint_line = $data->scenarioSqlinjection->entrypoint->options[0]->line;
        		// wrong answers set 2
        		$scenario->attacker_option2_ip 				= $data->scenarioSqlinjection->attacker->options_ip[1];
        		$scenario->attacker_option2_date			= $data->scenarioSqlinjection->attacker->options_time[1];
        		$scenario->attacker_option2_stolen_data 	= $data->scenarioSqlinjection->attacker->options_stolen[1];
        		$scenario->attacker_option2_entrypoint_file = $data->scenarioSqlinjection->entrypoint->options[1]->file;
        		$scenario->attacker_option2_entrypoint_line = $data->scenarioSqlinjection->entrypoint->options[1]->line;
        		$scenario->save();

        	} 

        	if ($input['scenario'] == 4 || $input['scenario'] == 5 || $input['scenario'] == 6 || $input['scenario'] == 7) {

        		$scenario = new Scenario();
        		// correct answer set
        		$scenario->vmachine_id				= $vmachine->id;
        		$scenario->type  					= "ddos";
        		$scenario->attacker_ip 				= $data->scenarioDdos->attacker->address;
        		$scenario->attacker_date 			= $data->scenarioDdos->attacker->time;
        		// $scenario->attacker_stolen_data 	= "";
        		// $scenario->attacker_entrypoint_file = $data->scenarioDdos->entrypoint->file;
        		// $scenario->attacker_entrypoint_line = $data->scenarioDdos->entrypoint->line;
        		// wrong answers set 1
        		$scenario->attacker_option1_ip 				= $data->scenarioDdos->attacker->options_ip[0];
        		$scenario->attacker_option1_date 			= $data->scenarioDdos->attacker->options_time[0];
        		// $scenario->attacker_option1_stolen_data 	= "";
        		// $scenario->attacker_option1_entrypoint_file = $data->scenarioDdos->entrypoint->options[0]->file;
        		// $scenario->attacker_option1_entrypoint_line = $data->scenarioDdos->entrypoint->options[0]->line;
        		// wrong answers set 2
        		$scenario->attacker_option2_ip 				= $data->scenarioDdos->attacker->options_ip[1];
        		$scenario->attacker_option2_date 			= $data->scenarioDdos->attacker->options_time[1];
        		// $scenario->attacker_option2_stolen_data		= "";
        		// $scenario->attacker_option2_entrypoint_file = $data->scenarioDdos->entrypoint->options[1]->file;
        		// $scenario->attacker_option2_entrypoint_line = $data->scenarioDdos->entrypoint->options[1]->line;
        		$scenario->save();

        	}

            Session::flash('success_msg', 'VMachine was successfully created with scenarios.');
        	return "ok";

		}

	}

}
