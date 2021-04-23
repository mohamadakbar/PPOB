<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\Menu;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\AuditTrail;
use App\Role;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::orderBy('menu_order', 'ASC')->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $this->menu = MenuHelper::menus($data);
        $this->middleware('checkrole');
    }

    public function index()
    {
        $title  = " Manage Users";
        $menu   = $this->menu;
        return view('users.index', compact('title', 'menu'));
    }

    public function getUsers()
    {
        $query = User::select('users.*', 'user_groups.name as role_id', 'client.name as client_id')
            ->join('user_groups', 'user_groups.id', '=', 'users.role_id')
            ->leftJoin('client', 'client.id', '=', 'users.id_client')
            ->get();

        return Datatables::of($query)
            ->setRowId('{{$id}}')
            ->addColumn('action', function ($user) {
                return view('datatable._action', [
                    'edit_url' => route('manusers.edit', $user->id),
                    'confirm_message' => 'Sure to delete ' . $user->name . '?'
                ]);
            })
            ->addColumn('change_password', function ($user) {
                return view('datatable._changepassword', [
                    'changepass_url' => route('manusers.password', $user->id),
                ]);
            })
            ->addColumn('chkid', function ($user) {
                return view('datatable._checked', [
                    'id' => $user->id
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
        $title  = " Manage Users";
        $gen    = "Add New";
        $client = DB::table('client')->pluck('name', 'id');
        $product= DB::table('products')->pluck('name', 'id');
        $menu   = $this->menu;
        return view('users.create', compact("title", "gen", "client", "product", "menu"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        //Insert
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phonenumber = $request->phonenumber;
        $user->id_product = $request->id_product;
        $user->id_client = $request->id_client;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->author = $author;

        $user->save();

        $audittail = [
            'audit_menu' => 'Users',
            'audit_submenu' => 'Manage Users',
            'audit_action' => 'Add',
            'audit_desc_after' => json_encode($user->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        //Asign as member
        // $memberRole = Role::where('name', 'maker')->first();
        // $user->created_at = date("Y-m-d H:i:s");
        // $user->attachRole($memberRole);

        return response()->json([
            'finish' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title      = " Manage Users";
        $gen        = "Edit";
        $user       = User::find($id);
        $client     = DB::table('client')->pluck('name', 'id');
        $product    = DB::table('products')->pluck('name', 'id');
        $user['id_product'] = explode(",", $user['id_product']);
        $menu = $this->menu;
        return view('users.edit')->with(compact('user', "title", "gen", "client", "product", "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        $user = User::find($id);
        $auditbefore = $user->getAttributes();
        //Update
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phonenumber = $request->phonenumber;
        $user->email = $request->email;
        $user->id_product = $request->id_product;
        $user->id_client = $request->id_client;

        if ($request->password != "") {
            $user->password = Hash::make($request->password);
        }

        $user->status = $request->status;
        $user->role_id = $request->role_id;
        $user->author = $author;
        $user->save();

        $audittail = [
            'audit_menu' => 'Users',
            'audit_submenu' => 'Manage Users',
            'audit_action' => 'Edit',
            'audit_desc_before' => json_encode($auditbefore),
            'audit_desc_after' => json_encode($user->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "$user->name changed successfully"
        ]);
        return redirect()->route('manusers.index');
    }

    public function changepassword($id)
    {
        $title = " Manage Users";
        // $gen ="Edit";
        $gen = "Change Password";
        $client = DB::table('client')->pluck('name', 'id');
        $product = DB::table('products')->pluck('name', 'id');
        $user = User::find($id);
        $user['id_product'] = explode(",", $user['id_product']);
        $menu = DB::table('menu')
            ->orderBy('menu_order', 'asc')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menu = $this->menu($data);
        return view('users.changepassword')->with(compact('user', "title", "gen", "client", "product", "menu"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        User::destroy($id);
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data deleted successfully"
        ]);
        return redirect()->route('manusers.index');

    }

    public function deleteuser(Request $request)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        foreach ($request->ids as $id) {
            $user = User::find($id);

            $audittail = [
                'audit_menu' => 'Users',
                'audit_submenu' => 'Manage Users',
                'audit_action' => 'Delete',
                'audit_desc_after' => json_encode($user->getAttributes()),
                'audit_username' => $author
            ];
            $audit = AuditTrail::create($audittail);
        }

        $ids = $request->ids;
        User::whereIn('id', $ids)->delete();
        return response()->json([
            'finish' => 'success',
            'data' => $ids
        ]);

    }

    public function username($name)
    {

        $query = DB::table('users')->where('username', $name)->exists();

        if ($query == 1) {
            return "false";
        } else {
            return "true";
        }

    }

    public function checkhashpassword(Request $request)
    {

        if (Hash::check($request->old_password, $request->password_hash)) {
            return "success";
        } else {
            return "failed";
        }

    }
}
