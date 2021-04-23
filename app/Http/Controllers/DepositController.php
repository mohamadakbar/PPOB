<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Excel;
use Illuminate\Http\Request;
use App\Deposit;
use App\Exports\DepositExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class DepositController extends Controller
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
        $title = " Deposit"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('deposit.index',compact('title', 'menu'));
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
    

    public function getDeposit(Request $request)
    {
      $query = DB::table('deposit')
            ->join('product_partner', 'product_partner.id', '=', 'deposit.partnerId')
            ->where('deposit.date', '>=', date("Y-m-d", strtotime($request->timeStart))." 00:00:01")
            ->where('deposit.date', '<=', date("Y-m-d", strtotime($request->timeEnd))." 23:59:59");

            if(!empty($request->partner) && isset($request->partner)){
              $query->where('deposit.partnerId', $request->partner);      
            }

            $query->select('deposit.*', 'product_partner.name as partnerId')
            ->get();


        return Datatables::of($query)
        ->setRowId('{{$id}}')
        ->editColumn('date', function($deposit) {
                    return date("d F Y", strtotime($deposit->date));
        })
        ->editColumn('debit', function($deposit) {
                  if(!empty($deposit->debit)){
                    return 'Rp. '.number_format($deposit->debit);
                  }else return "-";
        })
        ->editColumn('credit', function($deposit) {
                  if(!empty($deposit->credit)){
                    return 'Rp. '.number_format($deposit->credit);
                  }else return "-";
        })
        ->editColumn('saldo', function($deposit) {
                  if(!empty($deposit->saldo)){
                    return 'Rp. '.number_format($deposit->saldo);
                  }else return "-";
        })
        ->rawColumns(['link', 'action'])
        ->toJson();
    }

    public function excel(Request $request)
    {
        $datas = DB::table('deposit')
            ->join('product_partner', 'product_partner.id', '=', 'deposit.partnerId')
            ->select('deposit.*', 'product_partner.name as partnerId')
            ->get();
            // ->where('deposit.date', '>=', date("Y-m-d", strtotime($request->timeStart))." 00:00:01")
            // ->where('deposit.date', '<=', date("Y-m-d", strtotime($request->timeEnd))." 23:59:59");

            // if(!empty($request->partner) && isset($request->partner)){
            //   $query->where('deposit.partnerId', $request->partner);      
            // }

            // $query->select('deposit.*', 'product_partner.name as partnerId')
            // ->get();

        return view('deposit.excel',compact('datas', 'menu'));

    }

    public function exportExcel()
    {
      ob_end_clean(); 
      ob_start();
        $nama_file = 'deposit_history'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new DepositExport, $nama_file);

    }

}
