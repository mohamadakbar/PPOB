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
use App\Http\Requests\StoreGroupUserRequest;
use App\Http\Requests\UpdateGroupUserRequest;

class GroupUsersController extends Controller
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
        $title = " User Groups";
        $menu = $this->menu;

        return view('groupuser.index', compact('title', 'menu'));
    }

    public function menu($data, $parent = 0)
    {

        static $i = 1;
        // dd($role);
        if (isset($data[$parent])) {
            if ($parent == 0) $html = '<ul class="list-unstyled components">';
            else $html = '<ul class="collapse list-unstyled" id="homeSubmenu' . $parent . '">';
            $i++;
            $checked = "";
            foreach ($data[$parent] as $v) {
                $menu = json_decode($_COOKIE['menu']);
                // return $menu;
                if (in_array($v->id, $menu)) {
                    $child = $this->menu($data, $v->id);
                    $path = explode("/", request()->path());
                    if (empty($path[1])) $path[1] = 'home';
                    if ($path[1] == $v->url) $active = 'class="active"'; else $active = '';
                    $html .= "<li " . $active . ">";
                    if ($v->url !== '') {
                        if ($v->url == 'home') $url = url('/');
                        else $url = route($v->url . '.index');
                        $html .= '<a href="' . $url . '">' . $v->title . '</a>';
                    } else {
                        $html .= '<a href="#homeSubmenu' . $v->id . '" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">' . $v->title . '</a>';
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

    public function getGroupUsers()
    {
        return Datatables::of(Role::query())
            ->setRowId('{{$id}}')
            ->editColumn('created_at', function (Role $guser) {
                return $guser->created_at . " (" . $guser->created_at->diffForHumans() . ")";
            })
            ->editColumn('updated_at', function (Role $guser) {
                return $guser->updated_at . " (" . $guser->updated_at->diffForHumans() . ")";
            })
            ->editColumn('author', function ($guser) {
                $author = explode(" - ", $guser->author);
                return $author[0];
            })
            ->addColumn('action', function ($guser) {
                return view('datatable._action', [
                    'edit_url' => route('groupuser.edit', $guser->id),
                    'confirm_message' => 'Sure to delete ' . $guser->name . '?'
                ]);
            })
            ->addColumn('chkid', function ($guser) {
                return view('datatable._checked', [
                    'id' => $guser->id
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
        $title  = "User Groups";
        $gen    = "Add New";
        $url    = "groupuser";

        $menu = DB::table('ppob_config.menu')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menus  = $this->menunya($data);
        $menu   = $this->menu($data);

        return view('groupuser.create', compact("title", "gen", "menu", "menus", "url"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupUserRequest $request)
    {

        //Insert
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        $guser = new Role;
        $guser->name = $request->name;
        $guser->display_name = $request->display_name;
        $guser->description = $request->description;
        $guser->role = json_encode($request->role);
        $guser->status = $request->status;
        $guser->author = $author;
        $guser->save();

        $audittail = [
            'audit_menu' => 'Users',
            'audit_submenu' => 'User Groups',
            'audit_action' => 'Add',
            'audit_desc_after' => json_encode($guser->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "<strong>$guser->name</strong> saved successfully"
        ]);
        return redirect()->route('groupuser.index');
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
        $guser  = Role::find($id);
        $title  = " Group Users";
        $gen    = "Edit";

        $menu = DB::table('ppob_config.menu')->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menus  = $this->menunya($data, 0, json_decode($guser['role']));
        $menu   = $this->menu($data);

        return view('groupuser.edit')->with(compact('guser', "title", "gen", "menu", "menus"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupUserRequest $request, $id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        $guser = Role::find($id);
        $auditbefore = $guser->getAttributes();
        //Update
        $guser->name = $request->name;
        $guser->display_name = $request->display_name;
        $guser->description = $request->description;
        $guser->status = $request->status;
        $guser->author = $author;
        $guser->role = json_encode($request->role);
        $guser->save();

        $audittail = [
            'audit_menu' => 'Users',
            'audit_submenu' => 'User Groups',
            'audit_action' => 'Edit',
            'audit_desc_before' => json_encode($auditbefore),
            'audit_desc_after' => json_encode($guser->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "$guser->name changed successfully"
        ]);
        return redirect()->route('groupuser.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Role::destroy($id);
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data deleted successfully"
        ]);
        return redirect()->route('groupuser.index');

    }

    public function deletegroupuser($id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        $user = Role::find($id);
        $user->delete();

        $audittail = [
            'audit_menu' => 'Users',
            'audit_submenu' => 'User Groups',
            'audit_action' => 'Delete',
            'audit_desc_after' => json_encode($user->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);
        // DB::table('roles')->where('id', $id)->delete();
        return "success";

    }

    public function deletegroupuser_real($id)
    {

        Role::destroy($id);
        return "success";

    }

    public function menunya($data, $parent = 0, $role = array())
    {

        static $i = 1;
        // dd($role);
        if (isset($data[$parent])) {
            $html = "<ul>";
            $i++;
            $checked = "";
            foreach ($data[$parent] as $v) {
                $child = $this->menunya($data, $v->id, $role);
                if (!empty($role)) {
                    if (in_array($v->id, $role)) $checked = "checked";
                    else $checked = "";
                }
                $html .= "<li>";
                $html .= '<input style="display:none;" id="accessgroupid_' . $parent . $v->menu_order . '" value="' . $v->id . '" type="checkbox" class="filled-in chk-col-blue" name="role[]" ' . $checked . '><label for="accessgroupid_' . $parent . $v->menu_order . '" id="accessgroupid-' . $parent . $v->menu_order . '">' . $v->title . '</label>';
                if ($child) {
                    $i--;
                    $html .= $child;
                }
                $html .= '</li>';
            }
            $html .= "</ul>";
            return $html;
        } else {
            return false;
        }
    }
}
