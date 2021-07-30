<?php

class SearchController extends BaseController {

	public function __construct()
	{
		//$this->beforeFilter('csrf', $array('on' => 'post'));
	}

	public function searchUser($query)
	{
        $results = User::select ('first_name', 'last_name')
        					->where('first_name', 'LIKE', $query . '%')
        					->orWhere('last_name', 'LIKE', $query . '%')
        					->get();
	    
       	$data = array();

        foreach ($results as $result) :
	        $data[] = array('name' => trim($result->first_name).' '.trim($result->last_name) );
	    endforeach;

	    return Response::json($data);
	}

	public function searchCourse($query)
	{
        $results = Course::select ('name')
        					->where('name', 'LIKE', $query . '%')
        					->get();
	    
        $data = array();

        foreach ($results as $result) :
	        $data[] = array('course' => $result->name );
	    endforeach;

	    return Response::json($data);
	}

}