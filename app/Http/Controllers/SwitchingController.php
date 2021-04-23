<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Excel;
use Illuminate\Http\Request;
use App\Switching;
use App\SwitchingCustom;
use App\User;
use App\Exports\DepositExport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

// CONST PARTNER NAME
define('MITRACOMM', 'mitracomm');
define('PRISMALINK', 'prismalink');
define('BIMASAKTI', 'bimasakti');

class SwitchingController extends Controller
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
        $title = " Switching"; 
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        $dataByService = $this->getDataByService();
        $partners = $this->getAllPartner();
        return view('switching.index',compact('title', 'menu', 'dataByService', 'partners'));
    }

    public function getAllPartner()
    {
      $tablePartner = DB::table('sppob.partner');
      $tablePartner->select('id', 'name');
      $tablePartner->orderBy('name', 'ASC');
      $partners = $tablePartner->get();

      $partnerDict = [];
      foreach($partners as $partner){
        $partnerDict[$partner->id] = $partner;
      }
      return $partnerDict;
    }

    public function getDataByService()
    {
      $tablePartner = DB::table('sppob.partner');
      $tablePartner->select('id', 'logo_image');
      $resultPartners = $tablePartner->get();
      
      $partnerImage = [];
      foreach($resultPartners as $row){
        $partnerImage[$row->id] = $row->logo_image;
      }

      $tableSwitchingService = DB::table('sppob_trx.switchingservice');
      $tableSwitchingService->select('percentage', 'partnerId', 'trxCount', 'trxSuccess');
      $tableSwitchingService->orderBy('percentage', 'DESC');
      $results = $tableSwitchingService->get();

      $switchingResults = [];
      foreach($results as $rowSwitching){
        $image = "";
        if(isset($partnerImage[$rowSwitching->partnerId])){
          $image = $partnerImage[$rowSwitching->partnerId];
        }
        $switchingResults[] = (object)[
          'logo_image' => $image,
          'partnerId' => $rowSwitching->partnerId,
          'percentage' => $rowSwitching->percentage,
          'trxCount' => $rowSwitching->trxCount,
          'trxSuccess' => $rowSwitching->trxSuccess,
        ];
      }

      return $switchingResults;
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

    public function getSwitchByPrice(Request $request)
    {
      $dataProductPartner = DB::table('sppob.productpartner');
      $dataProductPartner->leftJoin('sppob.product', 'productpartner.productCode', '=', 'product.productCode');
      $dataProductPartner->leftJoin('sppob.partner', 'productpartner.partnerId', '=', 'partner.id');
      $statement = DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
      $dataProductPartner->select(DB::raw("
                                      productpartner.productCode, product.productName, productpartner.status,
                                      SUM(CASE partner.name WHEN '".MITRACOMM."' THEN price ELSE NULL END) as '".MITRACOMM."', 
                                      SUM(CASE partner.name WHEN '".PRISMALINK."' THEN price ELSE NULL END) as '".PRISMALINK."',
                                      SUM(CASE partner.name WHEN '".BIMASAKTI."' THEN price ELSE NULL END) as '".BIMASAKTI."'
                                    ")
                                  );
      // $dataProductPartner->orderBy('productpartner.id');
      $dataProductPartner->groupBy('productpartner.productCode');
      $dataProductPartner->get();

      return Datatables::of($dataProductPartner)
        ->addColumn('bestPrice', function($productPartners) {
          $collectionPrice = [];
          if($productPartners->mitracomm != NULL){
            $collectionPrice[] = $productPartners->mitracomm;
          }
          if($productPartners->prismalink != NULL){
            $collectionPrice[] = $productPartners->prismalink;
          }
          if($productPartners->bimasakti != NULL){
            $collectionPrice[] = $productPartners->bimasakti;
          }
          sort($collectionPrice);
          return 'Rp '.number_format($collectionPrice[0]);
        })
        ->filterColumn('mitracomm', function($query,$keyword){
          $query->where('partner.name', 'like', '%'.$keyword.'%');
        })
        ->filterColumn('prismalink', function($query,$keyword){
          $query->where('partner.name', 'like', '%'.$keyword.'%');
        })
        ->filterColumn('bimasakti', function($query,$keyword){
          $query->where('partner.name', 'like', '%'.$keyword.'%');
        })
        ->editColumn('mitracomm', function($productPartners) {
          $price = 'Not set';
          if($productPartners->mitracomm != null){            
            $price = 'Rp '.number_format($productPartners->mitracomm);
          }
          return $price;
        })
        ->editColumn('prismalink', function($productPartners) {
          $price = 'Not set';
          if($productPartners->prismalink != null){            
            $price = 'Rp '.number_format($productPartners->prismalink);
          }
          return $price;
        })
        ->editColumn('bimasakti', function($productPartners) {
          $price = 'Not set';
          if($productPartners->bimasakti != null){            
            $price = 'Rp '.number_format($productPartners->bimasakti);
          }
          return $price;
        })
        ->rawColumns(['link'])
        ->toJson();

    }   

    public function store(Request $request)
    {
      try {
        DB::beginTransaction();
        
        $getSwitch = Switching::where('clientId', $request->clientId)->first();
        if($getSwitch){
          $getSwitch->schema = $request->schema;
          $getSwitch->schemaDuration = $request->schemaDuration;
          $getSwitch->queryId = $request->queryId;
          $getSwitch->dbReference = 'sppob';
          $getSwitch->tableReference = 'product';
          $getSwitch->dateSet = date("Y-m-d H:i:s");

          $getSwitch->save();
        }else{
          //Insert
          $switching = new Switching;
          $switching->clientId = $request->clientId;
          $switching->clientName = $request->clientName;
          $switching->schema = $request->schema;
          $switching->schemaDuration = $request->schemaDuration;
          $switching->queryId = $request->queryId;
          $switching->dbReference = 'sppob';
          $switching->tableReference = 'product';
          $switching->dateSet = date("Y-m-d H:i:s");

          $switching->save();
        }

        // Jika schema 3 atau custom
        if($request->schema == 3){          
          $collectionPartner = json_decode($request->collectionpartner);
          if($collectionPartner){
            $getSwitchingCustom = SwitchingCustom::where('client_id', $request->clientId)->first();
            if($getSwitchingCustom){
              $getSwitchingCustom->updated_at = date('Y-m-d H:i:s');
              $getSwitchingCustom->collection_partner = $request->collectionpartner; 
              
              $getSwitchingCustom->save();
            }else{
              unset($getSwitchingCustom);
              $switchingCustom = new SwitchingCustom;
              $switchingCustom->client_id = $request->clientId;
              $switchingCustom->collection_partner = $request->collectionpartner;
              $switchingCustom->created_at = date('Y-m-d H:i:s');

              $switchingCustom->save();
            } 
          }
        }        

        return response()->json([
          "status"=>"success",
          "message"=>$request->clientName."saved successfully"
        ]);
    
        DB::commit();
    
    } catch (Throwable $e) {
        DB::rollback();
        return response()->json([
          "status"=>"failed",
          "message"=>$request->clientName."failed to save"
        ]);
    }   

      
      // return redirect()->route('switching.index');
	}
    public function getSwitching(Request $request)
    {
      $query = DB::table('manage_switching')
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
