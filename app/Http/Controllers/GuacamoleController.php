<?php

use Illuminate\Encryption\Encrypter;
use Cartalyst\Sentry\Sessions\NativeSession;

class GuacamoleController extends BaseController {

  public function __construct()
  {
    
  }

  public function verifyCookie()
  {
    die();
    $machine_id = Session::get('targetvm_machine_id', 'FAILED');
    $machine_name = Session::get('targetvm_machine_name', 'FAILED');
    $jsonResponse = array();
    $jsonResponse["connection_id"] = $machine_id;
    $jsonResponse["connection_name"] = $machine_name;
    $response = new Response();
    $response->json($jsonResponse, 200)->send();
  }
}