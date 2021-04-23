<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Role_User;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleUsersController extends Controller
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
        $title = "Role Users"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('roleuser.index',compact('title', 'menu'));
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
    
    public function getRoleUsers()
    {
        return Datatables::of(Role_User::query())
        ->setRowId('{{$id}}')

        ->editColumn('role_id', function(Role_User $roleuser) {
                    return $roleuser->role->name;
        })
        ->editColumn('user_id', function(Role_User $roleuser) {
                    return $roleuser->user->name;
        })
        ->editColumn('created_at', function(Role_User $roleuser) {
                    return $roleuser->created_at;
        })
        ->editColumn('updated_at', function(Role_User $roleuser) {
                    return $roleuser->updated_at;
        })
        ->editColumn('author', function($roleuser) {
                  $author = explode(" - ", $roleuser->author);
                    return $author[0] ;
        })
        ->addColumn('action', function($roleuser){
          return view('datatable._action', [
            'edit_url' => route('roleusers.edit', $roleuser->id),
            'confirm_message' => 'Sure to delete ' . $roleuser->name . '?'
          ]);
        })
        ->addColumn('chkid', function($roleuser){
          return view('datatable._checked', [
            'id' => $roleuser->id
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
        $title = " Role Users";
        $gen ="Add";   
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('roleuser.create',compact("title","gen", "menu"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {

      //Insert
      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      $roleuser = new Role_User;
      $roleuser->role_id = $request->role_id;
      $roleuser->user_id = $request->user_id;
      $roleuser->user_type = 'App\User';
      $roleuser->status = $request->status;
      $roleuser->author = $author;
      $roleuser->save();

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$roleuser->user_id</strong> saved successfully"
      ]);
      return redirect()->route('roleusers.index');
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
      $title = " Role Users";
      $gen ="Edit";   
      $roleuser = Role_User::find($id);
      $menu = DB::table('menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);
      return view('roleuser.edit')->with(compact('roleuser',"title","gen", "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      $roleuser = Role_User::find($id);
      //Update
      $roleuser->role_id = $request->role_id;
      $roleuser->user_type = 'App\User';
      $roleuser->status = $request->status;
      $roleuser->author = $author;
      $roleuser->save();

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"$roleuser->user_id changed successfully"
      ]);
      return redirect()->route('roleusers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      Role_User::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('roleusers.index');

    }
    public function deleteroleuser($id)
    {

      Role_User::destroy($id);
      return "success";

    }
}
