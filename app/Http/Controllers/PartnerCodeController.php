<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Excel;
use Illuminate\Http\Request;
use App\PartnerCode;
use App\ProductPartner;
use App\SprintCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

use App\Http\Requests\StoreUpdatePartnerCodeRequest;
use App\Http\Requests\UpdatePartnerCodeRequest;

class PartnerCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
      $this->middleware('checkrole');
    }

    public function index()
    {
        $title = " Partner Response Code"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $partners = ProductPartner::select('name')->get();
        $sprintCodes = SprintCode::select('status')->get();
        $menu = $this->menu($data);
        return view('partnercode.index',compact('title', 'menu', 'partners', 'sprintCodes'));
    }

    public function menu($data, $parent = 0){

      static $i = 1;
      // dd($role);
      if (isset($data[$parent])) {
          if($parent == 0) $html = '<ul class="list-unstyled components">';
          else $html = '<ul class="collapse list-unstyled" id="homeSubmenu'.$parent.'">';
          $i++; $checked = "";
          foreach ($data[$parent] as $v) {
              $menu = json_decode($_COOKIE['menu']);
              if (in_array($v->id, $menu)){
                  $child = $this->menu($data, $v->id);
                  $path = explode("/", request()->path());
                  if(empty($path[1])) $path[1] = 'home';
                  if($path[1] == $v->url) $active = 'class="active"'; else $active = '';
                  $html .= "<li ".$active.">";
                  if($v->url!== ''){
                      if($v->url== 'home') $url = url('/');
                      else $url = route($v->url.'.index');
                      $html .= '<a href="'.$url.'">'.$v->title.'</a>';
                  }else{
                      $html .= '<a href="#homeSubmenu'.$v->id.'" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">'.$v->title.'</a>';
                  }
                  if ($child) {
                      $i--;
                      $html .= $child;
                  }
                  $html .= '</li>';
              }
          }
          $html .= "</ul>";
          return $html;
      } else {
          return false;
      }
    }
    
	public function getPartnercode(Request $request)
    {
		$query = DB::table('sppob_trx.partnerresponsecode');
		
		if(!empty($request->partner) && isset($request->partner)){
		
		  if($request->partner !== "Choose Partner" && $request->partner !== ""){
			$query->where('partner', $request->partner);  
		  }
    }
    
    if(!empty($request->sprint_status) && isset($request->sprint_status)){
      if(count($request->sprint_status) > 0){
        $query->whereIn('markedas', $request->sprint_status);
      }
    }
		
	    $query->select('partnerresponsecode.*')->get();
			
        return Datatables::of($query)
		->setRowId('{{$id}}')
        ->addColumn('action', function($partnerCode){
          return view('datatable._action', [
            'edit_url' => route('partner-code.edit', $partnerCode->id),
            'confirm_message' => 'Sure to delete ' . $partnerCode->responseCode . '?'
          ]);
        })
        ->addColumn('chkid', function($partnerCode){
          return view('datatable._checked', [
            'id' => $partnerCode->id
          ]);
        })
        ->rawColumns(['link', 'action'])
		->toJson();
    }
	
	public function create()
  {
      $title = " Partner Response Code";
      $gen ="Add";   
      $menu = DB::table('menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);
    $partnercode = array();
    
    $partner = ProductPartner::All();
    $listPartner = array(""=>"--Choose Partner--");
    foreach ($partner as $key => $value) {
      $listPartner[$value["name"]]=$value["name"];
        }
    
    $SprintCode = SprintCode::All();
    $ListSprintCode = array("" => "--Choose Marked as--");
    foreach ($SprintCode as $key => $value) {
      $ListSprintCode[$value["status"]]=$value["status"];
    }
  
    return view('partnercode.create')->with(compact("title","gen","menu","partnercode","listPartner","ListSprintCode"));
  }
	
    public function store(Request $request)
    {
      //Insert
      $partners = $request->partner;
      $responsecodes = $request->responseCode;
      $markedas = $request->markedas;
      $descriptions = $request->description;

      $save_data = [];
      foreach($partners as $key => $partner){
          if($partners[$key] != null && $responsecodes[$key] != null && $markedas[$key] != null){
              $save_data[] = [
                  'partner' => $partner,
                  'responseCode' => $responsecodes[$key],
                  'markedas' => $markedas[$key],
                  'description' => $descriptions[$key],
                  'created_at' => date('Y-m-d H:i:s')
              ];
          }
      }

      $number_of_save_data = count($save_data);
      if($number_of_save_data > 0){
          PartnerCode::insert($save_data);
          $finish   = "success";
          $message  = "<b>".$number_of_save_data."</b> New Response Code Successfully Added";
      }else{
        $finish = "failed";
        $message = "Failed saving data";
      }
      return response()->json([
          'finish' => $finish,
          'message' => $message,
          'number_of_data' => $number_of_save_data
      ]);
	}
	
	public function edit($id)
    {
	  $title = " Partner Response Code";
      $gen ="Edit";   
      $menu = DB::table('sppob.menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);

      $partnercode = PartnerCode::find($id);
	  
	  	$partner = ProductPartner::All();
		$listPartner = array(""=>"--Choose Partner--");
		foreach ($partner as $key => $value) {
		  $listPartner[$value["name"]]=$value["name"];
        }
		
		$SprintCode = SprintCode::All();
		$ListSprintCode = array("" => "--Choose Marked as--");
		foreach ($SprintCode as $key => $value) {
		  $ListSprintCode[$value["status"]]=$value["status"];
        }

      return view('partnercode.edit')->with(compact("title","gen","menu","partnercode","listPartner","ListSprintCode"));
	}
	
	public function update(Request $request, $id)
  {
    $ids            = $request->id;
    $partners       = $request->partner;
    $responsecodes  = $request->responseCode;
    $markedas       = $request->markedas;
    $descriptions   = $request->description;

    foreach($ids as $key => $id){
      if($partners[$key] != null && $responsecodes[$key] != null && $markedas[$key] != null){
        $partner                = PartnerCode::find($id);
        $partner->partner       = $partners[$key];
        $partner->responseCode  = $responsecodes[$key];
        $partner->markedas      = $markedas[$key];
        $partner->description   = $descriptions[$key];
        $partner->updated_at    = date('Y-m-d H:i:s');

        $partner->save();
      }else{
        return response()->json([
          'finish' => 'failed',
          'message' => 'Failed saving data!'
        ]);
      }
    }

    return response()->json([
      'finish' => 'success',
      'message' => 'You has success saving data'
    ]);
  }
	
	public function destroy($id)
    {

      PartnerCode::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('partner-code.index');

    }
    public function deletepartnercode($id)
    {

      PartnerCode::destroy($id);
      return response()->json([
        'finish' => 'success',
        'message' => 'Data successfully delete'
      ]);

    }

}
