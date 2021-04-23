<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Excel;
use Illuminate\Http\Request;
use App\Helpers\MenuHelper;
use App\Menu;
use App\SprintCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

use App\Http\Requests\StoreSprintCodeRequest;
use App\Http\Requests\UpdateSprintCodeRequest;

class SprintCodeController extends Controller
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
        $title = " Sprint Response Code"; 
        $menu = $this->menu;
        return view('sprintcode.index',compact('title', 'menu'));
    }
    
	public function getSprintcode()
    {
        return Datatables::of(SprintCode::query())
		->setRowId('{{$id}}')
        ->addColumn('action', function($sprintCode){
          return view('datatable._action', [
            'edit_url' => route('sprint-code.edit', $sprintCode->id),
            'confirm_message' => 'Sure to delete ' . $sprintCode->responseCode . '?'
          ]);
        })
        ->addColumn('chkid', function($sprintCode){
          return view('datatable._checked', [
            'id' => $sprintCode->id
          ]);
        })
        ->rawColumns(['link', 'action'])
		->toJson();
    }
	
	public function create()
    {
        $title = " Sprint Response Code";
        $gen ="Add";   
        $menu = $this->menu;
        $sprintCode = array();
        return view('sprintcode.create')->with(compact("title","gen","menu","sprintCode"));
    }
	
    public function store(Request $request)
    {
        //Insert
        $responsecodes = $request->responsecode;
        $status = $request->status;
        $descriptions = $request->description;

        $save_data = [];
        foreach($responsecodes as $key => $code){
            if($responsecodes[$key] != null && $status[$key] != null){
                $save_data[] = [
                    'responseCode' => $responsecodes[$key],
                    'status' => $status[$key],
                    'description' => $descriptions[$key],
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        if(count($save_data) > 0){
            SprintCode::insert($save_data);
            $finish   = "success";
            $message  = "Success saving data";
        }else{
          $finish = "failed";
          $message = "Failed saving data";
        }
        return response()->json([
            'finish' => $finish,
            'message' => $message,
            'number_of_data' => count($save_data)
        ]);
	}
	
	public function edit($id)
    {
	  $title = " Sprint Response Code";
      $gen ="Edit";   
      $menu = $this->menu;

      $sprintCode = sprintCode::find($id);

      //$data = array('product' => $product, 'product_type' => $product_type, 'product_category' => $product_category, 'inqType' => $inq);
      return view('sprintcode.edit')->with(compact("title","gen","menu","sprintCode"));
	}
	
	public function update(Request $request, $id)
  {
    $ids            = $request->id;
    $responsecodes  = $request->responsecode;
    $status         = $request->status;
    $descriptions   = $request->description;

    foreach($ids as $key => $id){
      if($responsecodes[$key] != null && $status[$key] != null){
        $SprintCode                = SprintCode::find($id);
        $SprintCode->responseCode  = $responsecodes[$key];
        $SprintCode->status        = $status[$key];
        $SprintCode->description   = $descriptions[$key];
        $SprintCode->updated_at    = date('Y-m-d H:i:s');

        $SprintCode->save();
      }else{
        return response()->json([
          'finish' => 'failed',
          'message' => 'Failed saving data!'
        ]);
      }
    }

    return response()->json([
      'finish' => 'success',
      'message' => 'You has success saving data'
    ]);
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
	
	public function destroy($id)
    {

      SprintCode::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('sprint-code.index');

    }
    public function deleteSprintCode($id)
    {

      SprintCode::destroy($id);
      return response()->json([
        'finish' => 'success',
        'message' => 'Data successfully delete'
      ]);

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
