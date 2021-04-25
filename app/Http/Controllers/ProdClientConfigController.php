<?php

namespace App\Http\Controllers;

use App\ProdClientConfig;
use Illuminate\Http\Request;
use App\Helpers\MenuHelper;
use App\Menu;

class ProdClientConfigController extends Controller
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
        $title  = " Product Client Config";
        $menu   = $this->menu;
        return view('prodclient-config.index', compact('title', 'menu'));
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
     * @param  \App\ProdClientConfig  $prodClientConfig
     * @return \Illuminate\Http\Response
     */
    public function show(ProdClientConfig $prodClientConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdClientConfig  $prodClientConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdClientConfig $prodClientConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdClientConfig  $prodClientConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdClientConfig $prodClientConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdClientConfig  $prodClientConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdClientConfig $prodClientConfig)
    {
        //
    }
}
