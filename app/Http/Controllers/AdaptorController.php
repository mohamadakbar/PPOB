<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Adaptor;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreAdaptorRequest;
use App\Http\Requests\UpdateAdaptorRequest;

class AdaptorController extends Controller
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
        $title = " Manage Adaptor"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('adaptor.index',compact('title', 'menu'));
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
    
    public function getAdaptor(Request $request)
    {
		
       $query = DB::table('adaptor')
            ->join('product_partner', 'product_partner.id', '=', 'adaptor.partnerId');
        
	   if(!empty($request->partner) && isset($request->partner)){
          $query->where('adaptor.partnerId', $request->partner);
       }

       if(!empty($request->status) && isset($request->status)){
          $query->where('adaptor.status', $request->status);
       }
	   
	   $query->select('adaptor.*', 'product_partner.name as partner_name')
            ->get();

        return Datatables::of($query)
        ->setRowId('{{$id}}')

        ->addColumn('action', function($adaptor){
          return view('datatable._action', [
            'edit_url' => route('adaptor.edit', $adaptor->id),
            'confirm_message' => 'Sure to delete ?'
          ]);
        })
        ->addColumn('chkid', function($adaptor){
          return view('datatable._checked', [
            'id' => $adaptor->id
          ]);
        })
        ->rawColumns(['link', 'action'])
		
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = " Manage Adaptor";
        $gen ="Add";   
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        $product_partner = DB::table('product_partner')->pluck('name','id');
        $data = array('product_partner' => $product_partner);
        return view('adaptor.create',compact("title","gen", "menu", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdaptorRequest $request)
    {
	  $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      //Insert
      $adaptor = new Adaptor;
      $adaptor->partnerId = $request->partnerId;
      $adaptor->code = $request->code;
      $adaptor->desc = $request->desc;
      $adaptor->status = $request->status;
      $adaptor->save();

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$adaptor->name</strong> saved successfully"
      ]);
      return redirect()->route('adaptor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $title = " Manage Adaptor";
      $gen ="Edit";   
      //$client = Client::find($id);
      $menu = DB::table('menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);
      $product_partner = DB::table('product_partner')->pluck('name','id');
      $adaptor = Adaptor::find($id);

      $data = array('adaptor' => $adaptor, 'product_partner' => $product_partner);
	  
      return view('adaptor.edit')->with(compact("title","gen","menu",'data','adaptor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdaptorRequest $request, $id)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      $adaptor = Adaptor::find($id);

      //Update
      $adaptor->partnerId = $request->partnerId;
      $adaptor->code = $request->code;
      $adaptor->desc = $request->desc;
      $adaptor->status = $request->status;

      $adaptor->save();

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"$adaptor->name changed successfully"
      ]);
      return redirect()->route('adaptor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      Adaptor::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('adaptor.index');

    }
    public function deleteadaptor($id)
    {

      Adaptor::destroy($id);
      return "success";

    }
}
