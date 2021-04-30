<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\ManageConfig;
use App\Menu;
use App\PartnerConfig;
use DB;
use Illuminate\Http\Request;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PartnerConfigController extends Controller
{
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "  Manage Config";
        $menu = $this->menu;

        return view('partner-config.index',compact('title', 'menu'));
    }

    public function getPartnerConf(Request $request)
    {
        if (!empty($request->partner) && isset($request->partner)) {
            // dd($request->partner);
            $query = PartnerConfig::where('partnerconfig_partner_id', $request->partner)->get();
        }else{
            $query = PartnerConfig::with('Partner');
        }
        // if (!empty($request->id) && isset($request->id)){
        //     $query = ProductCategory::where('id', $request->id)->get();
        // }
        // if (!empty($request->id) && isset($request->id) && !empty($request->status) && isset($request->status)) {
        //     $query = ProductCategory::where('category_active', $request->status)->where('id', $request->id)->get();
        // }
        // if (empty($request->status) && empty($request->id)){
        //     $query = ProductCategory::all();
        // }

        return Datatables::of($query)
        ->setRowId('{{$id}}')
        ->editColumn('author', function($partner) {
                  $author = explode(" - ", $partner->partnerconfig_created_by);
                    return $author[0] ;
        })
        ->editColumn('partnerconfig_partner_id', function ($partner) {
            return $partner->partner->partner_name;
        })
        ->addColumn('action', function($partner){
          return view('datatable._action', [
            'edit_url' => route('partner-config.edit', $partner->id),
            'confirm_message' => 'Sure to delete ' . $partner->partnerconfig_name . '?'
          ]);
        })
        ->addColumn('chkid', function($partner){
          return view('datatable._checked', [
            'id' => $partner->id
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ManageConfig  $manageConfig
     * @return \Illuminate\Http\Response
     */
    public function show(ManageConfig $manageConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ManageConfig  $manageConfig
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return $id;
        // return " sini";
        $title      = " Partner Config";
        $menu       = $this->menu;
        $partner    = PartnerConfig::with('Partner')->find($id);
        // return $partner;

        return view('partner-config.edit',compact('partner','title', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ManageConfig  $manageConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ManageConfig $manageConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ManageConfig  $manageConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManageConfig $manageConfig)
    {
        //
    }
}
