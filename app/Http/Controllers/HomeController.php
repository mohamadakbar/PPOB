<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\Menu;
use DB;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public $role;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $menu = Menu::orderBy('menu_order', 'ASC')->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $this->menu = MenuHelper::menus($data);
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title  = "  Dashboard";
        $menu   = $this->menu;
        return view('home', compact('title', 'menu'));
    }

}
