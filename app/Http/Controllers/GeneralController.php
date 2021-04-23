<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GeneralController extends Controller
{

  public function __construct()
  {
    $this->middleware('checkrole');
  }

  /**
   * Store a newly created cache in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store_formtype(Request $request)
  {
    //Put cache
    Cache::flush();
    if($request->type == "form"){
      Cache::put('formtype', $request->type, $request->expiration);
      Cache::put('param_key', $request->keys, $request->expiration);
      Cache::put('param_value', $request->values, $request->expiration);
    }else{
      Cache::put('formtype', $request->type, $request->expiration);
      Cache::put('param_body', $request->json, $request->expiration);
    }
    return "OK";
  }

  public function store_authtype(Request $request)
  {
    //Put cache
    if (!Cache::has('formtype')) {
      Cache::flush();
    }

    if($request->auth == "basic"){
      Cache::put('authtype', $request->auth, $request->expiration);
      Cache::put('uname', $request->uname, $request->expiration);
      Cache::put('passwd', $request->passwd, $request->expiration);
    }elseif($request->auth == "key"){
      Cache::put('authtype', $request->auth, $request->expiration);
      Cache::put('apikey', $request->apikey, $request->expiration);
      Cache::put('apivalue', $request->apivalue, $request->expiration);
    }else{
      Cache::put('authtype', $request->auth, $request->expiration);
      Cache::put('token', $request->token, $request->expiration);
    }
    return "OK";
  }

  public function store_resptype(Request $request)
  {
    //Put cache
    if (!Cache::has('formtype')) {
      Cache::flush();
    }
    if($request->type == "form"){
      Cache::put('resptype', $request->type, $request->expiration);
      Cache::put('resp_code', $request->rcode, $request->expiration);
      Cache::put('resp_desc', $request->rdesc, $request->expiration);
    }
    return "OK";
  }

}
