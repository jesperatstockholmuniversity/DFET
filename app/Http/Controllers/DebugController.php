<?php

use Illuminate\Encryption\Encrypter;
use Cartalyst\Sentry\Sessions\NativeSession;

class DebugController extends Controller {

  public function __construct()
  {
    //$this->beforeFilter('csrf', $array('on' => 'post'));
  }

  public function showDebug()
  {
    $response = new Illuminate\Http\Response('DebugController');
    $view = View::make('dashboard/debug');

//    file_get_contents('http://172.24.2.6/src/api.php');



    $opts = array(
      'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n"
      )
    );
    $context = stream_context_create($opts);
    // Open the file using the HTTP headers set above
    $content = file_get_contents('http://172.24.2.6:81/src/api.php?operation=operation&id=autoclone08&action=destroy', false, $context);
    $json = json_decode($content, TRUE);
    var_dump($json);

    return $view;
  }

}
