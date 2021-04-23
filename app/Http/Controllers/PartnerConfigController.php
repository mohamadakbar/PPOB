<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\ManageConfig;
use App\Menu;
use DB;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit(ManageConfig $manageConfig)
    {
        //
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
