<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Reporting;
use Yajra\DataTables\Facades\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportingController extends Controller
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
        $title = " Reporting"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('reporting.index',compact('title', 'menu'));
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
    

    public function getReporting(Request $request)
    {
        $dataReporting = $this->dataReporting($request);
        return Datatables::of($dataReporting)
        ->setRowId('{{$id}}')
        ->editColumn('id_partner', function($reporting) {
            return $reporting->productPartnerOne->name;
        })
        ->editColumn('id_type', function($reporting) {
          return $reporting->productTypeOne->name;
        })
        ->editColumn('id_category', function($reporting) {
          return $reporting->productCategoryOne->name;
        })
        ->editColumn('id_client', function($reporting) {
          return $reporting->clientOne->name;
        })
        ->editColumn('denom', function($reporting) {
                  if(!empty($reporting->denom)){
                    return 'Rp. '.number_format($reporting->denom);
                  }else return "-";
        })
        ->editColumn('prepaid', function($reporting) {
                  if(!empty($reporting->prepaid)){
                    return 'Rp. '.number_format($reporting->prepaid);
                  }else return "-";
        })
        ->editColumn('postpaid', function($reporting) {
                  if(!empty($reporting->postpaid)){
                    return 'Rp. '.number_format($reporting->postpaid);
                  }else return "-";
        })
        ->editColumn('biaya_admin', function($reporting) {
                  if(!empty($reporting->biaya_admin)){
                    return 'Rp. '.number_format($reporting->biaya_admin);
                  }else return "-";
        })
        ->editColumn('sprint_to_biller', function($reporting) {
                  if(!empty($reporting->sprint_to_biller)){
                    return 'Rp. '.number_format($reporting->sprint_to_biller);
                  }else return "-";
        })
        ->editColumn('cashback', function($reporting) {
                  if(!empty($reporting->cashback)){
                    return 'Rp. '.number_format($reporting->cashback);
                  }else return "-";
        })
        ->editColumn('margin', function($reporting) {
                  if(!empty($reporting->margin)){
                    return 'Rp. '.number_format($reporting->margin);
                  }else return "-";
        })
        ->rawColumns(['link', 'action'])
        ->toJson();
    }

    public function dataReporting($request)
    {
      $query  = Reporting::select(
        'id',
        'id_partner', 
        'id_client',
        'id_type',
        'id_category',
        'product_name',
        'id_client',
        'denom',
        'prepaid',
        'postpaid',
        'biaya_admin',
        'sprint_to_biller',
        'cashback',
        'margin',
        'date'
      )
      ->with(
        ['productPartnerOne', 'productTypeOne', 'productCategoryOne', 'clientOne']
      )
      ->where('date', '>=', date("Y-m-d", strtotime($request->timeStart))." 00:00:01")
      ->where('date', '<=', date("Y-m-d", strtotime($request->timeEnd))." 23:59:59");

      if(!empty($request->partner) && isset($request->partner)){
        $query->where('id_partner', $request->partner);      
      }
      if(!empty($request->client) && isset($request->client)){
        $query->where('id_client', $request->client);      
      }
      if(!empty($request->category) && isset($request->category)){
        $query->where('id_category', $request->category);      
      }
      if(!empty($request->type) && isset($request->type)){
        $query->where('id_type', $request->type);      
      }
      if(!empty($request->product_name) && isset($request->product_name)){
        $query->where('product_name', 'LIKE', '%'.$request->product_name.'%');      
      }

      return $query->get();
    }

    public function exportExcel(Request $request)
    {
      $reportings = $this->dataReporting($request);
      $sheets = [];
      if(count($reportings) > 0){
        foreach($reportings as $report){
          $sheets[] = (array)[
            'Partner Name' => $report->productPartnerOne->name,
            'Category' => $report->productCategoryOne->name,      
            'Product Type' => $report->productTypeOne->name,         
            'Product Name' => $report->product_name,     
            'Client' => $report->clientOne->name,
            'Denom' => $report->denom,
            'Prepaid' => $report->prepaid,
            'Postpaid' => $report->postpaid,
            'Biaya Admin' => $report->biaya_admin,
            'Sprint to Biller' => $report->sprint_to_biller,
            'Cashback' => $report->cashback,
            'Margin' => $report->margin
          ];
        };
        return (new FastExcel($sheets))
        ->download('reporting.xlsx');
      }
        

    }

    public function exportReport()
    {
    //     $nama_file = 'reporting_history'.date('Y-m-d_H-i-s').'.xlsx';
    //     return Excel::download(new ReportingExport, $nama_file);

    }

}
