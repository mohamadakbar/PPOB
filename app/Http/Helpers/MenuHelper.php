<?php
namespace App\Helpers;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class MenuHelper{

    public static function menu()
    {
        $menu = DB::table('menu')
            ->orderBy('menu_order', 'asc')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }

        MenuHelper::menus($data);
    }

    public static function menus($data, $parent = 0){
        static $i = 1;
        if (isset($data[$parent])) {
            if($parent == 0) $html = '<ul class="list-unstyled components">';
            else $html = '<ul class="collapse list-unstyled" id="homeSubmenu'.$parent.'">';
            $i++; $checked = "";
            foreach ($data[$parent] as $v) {
                $menu = json_decode($_COOKIE['menu']);
                //   dd($v);
                if (in_array($v->id, $menu)){
//                    dd($menu);
                    $child = MenuHelper::menus($data, $v->id);
                    //   dd($v);
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

}

?>
