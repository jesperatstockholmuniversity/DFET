<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class VMachine extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vmachine';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	public static function profileVMachines($userId)
	{
		return VMachine::select(array(
						        'vmachine.id',
						        'vmachine.course_id',
						        'vmachine.machine_id',
						        'vmachine.machine_name',
						        'vmachine.status',
						        'vmachine.created_at',
                                'vmachine.scenarios',
						        'course.id AS course_id',
						        'course.name',
						    ))
							->leftJoin('course', function($join) {
								$join->on('vmachine.course_id', '=', 'course.id');
							})
							->leftJoin('assignment', function($join) {
								$join->on('assignment.vmachine_id', '=', 'vmachine.id');
							})
							->leftJoin('enrollment', function($join) {
								$join->on('enrollment.id', '=', 'assignment.enrollment_id');
							})
							//->whereIn('assignment.enrollment_id',( is_array($enrollments) && count($enrollments) ) ? $enrollments : [0])
							->where('enrollment.user_id', '=', $userId)
							->get();
	}

}
