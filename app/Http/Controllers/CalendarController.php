<?php
//namespace App\Http\Controllers;
//use Illuminate\Routing\Controller as BaseController;
namespace App\Http\Controllers;

class CalendarController extends Controller {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function showCalendar()
	{
		//return View::make('dashboard/calendar');
		return view('dashboard/calendar');
	}

	public function showUserCalendar()
	{
		return view('dashboard/usercalendar');
	}

	public function searchEvents()
	{
		$courses = Course::all();
		$assignments = Assignment::select(array(
			 					'assignment.id', 
			 					'assignment.enrollment_id',
			 					'assignment.vmachine_id',
			 					'assignment.date_created',
			 					'assignment.date_started',
			 					'assignment.date_finished',
			 					'assignment.status',
			 					'course.name',
			 					'enrollment.user_id',
			 					'users.first_name',
			 					'users.last_name',
			 					))
								->leftJoin('course', function($join) {
									$join->on('assignment.course_id', '=', 'course.id');
								})
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('users', function($join) {
									$join->on('enrollment.user_id', '=', 'users.id');
								})
								->get();

		$events = [];

		foreach ($courses as $course) 
		{
			$events[] = array(
								'id' => $course->id,
								'title' => $course->name,
								'start' => $course->created_at,
								'end' => $course->finish_at,
								'url' => '/courses/view/'.$course->id,
								'color' => 'green',
								'textColor' => 'white',
								);
		}

		foreach ($assignments as $assignment) 
		{
			$events[] = array(
								'id' => $assignment->id,
								'title' => 'Assignment for '.$assignment->first_name.' '. $assignment->last_name.' / '.$assignment->name,
								'start' => $assignment->date_created,
								'end' => $assignment->date_finished,
								'url' => '/assignments/view/'.$assignment->id,
								'color' => 'blue',
								'textColor' => 'white',
								);
		}

		return $events;
	}

	public function searchUserEvents()
	{
		$courses = Course::leftJoin('enrollment', function($join) {
									$join->on('enrollment.course_id', '=', 'course.id');
								})
								->where('enrollment.user_id', '=', Sentinel::getUser()->id)
								->get();

		$assignments = Assignment::select(array(
			 					'assignment.id', 
			 					'assignment.enrollment_id',
			 					'assignment.vmachine_id',
			 					'assignment.date_created',
			 					'assignment.date_started',
			 					'assignment.date_finished',
			 					'assignment.status',
			 					'course.name',
			 					'enrollment.user_id',
			 					'users.first_name',
			 					'users.last_name',
			 					))
								->leftJoin('course', function($join) {
									$join->on('assignment.course_id', '=', 'course.id');
								})
								->leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})
								->leftJoin('users', function($join) {
									$join->on('enrollment.user_id', '=', 'users.id');
								})
								->where('enrollment.user_id', '=', Sentinel::getUser()->id)
								->get();

		$events = [];

		foreach ($courses as $course) 
		{
			$events[] = array(
								'id' => $course->id,
								'title' => $course->name,
								'start' => $course->created_at,
								'end' => $course->finish_at,
								'url' => '/course/view/'.$course->id,
								'color' => 'green',
								'textColor' => 'white',
								);
		}

		foreach ($assignments as $assignment) 
		{

			$events[] = array(
								'id' => $assignment->id,
								'title' => 'New Assignment ('.$assignment->name.')',
								'start' => $assignment->date_created,
								'end' => $assignment->date_finished,
								'url' => '/assignments/take/'.$assignment->id,
								'color' => 'blue',
								'textColor' => 'white',
								);
		}

		return $events;
	}
}
