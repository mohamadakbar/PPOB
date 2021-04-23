<?php

namespace App\Http\Controllers;

use App\Bank;
use DB;
use Illuminate\Http\Request;
use App\ProductPartner;
use App\HistoryTrx;
use App\User;
use App\AuditTrail;
use App\Vendor_Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreProdPartnerRequest;
use App\Http\Requests\UpdateProdPartnerRequest;
use Illuminate\Support\Facades\Cache;

class ProductPartnerController extends Controller
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
        $title = " Partners";
        $menu = DB::table('menu')
            ->orderBy('menu_order', 'asc')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menu = $this->menu($data);
        return view('prodpartner.index', compact('title', 'menu'));
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

    public function getProdpartner(Request $request)
    {
        if(!empty($request->partner) && isset($request->partner)){
            $query = ProductPartner::where('id', $request->partner)->get();
        }else{
            $query = ProductPartner::with('getBank')->get();
        }

        return Datatables::of($query)
            ->setRowId('{{$id}}')
            ->editColumn('created_at', function (ProductPartner $prodpartner) {
                //return $prodpartner->created_at." (".$prodpartner->created_at->diffForHumans().")";
                return $prodpartner->created_at;
            })
            ->editColumn('deposit', function (ProductPartner $prodpartner) {
                return 'Rp.' . number_format($prodpartner->deposit);
            })
            ->editColumn('updated_at', function (ProductPartner $prodpartner) {
                //return $prodpartner->updated_at." (".$prodpartner->updated_at->diffForHumans().")";
                return $prodpartner->updated_at;
            })
            ->editColumn('partner_bank', function (ProductPartner $prodpartner) {
//                dd($prodpartner->getBank);
                return $prodpartner->getBank->bank_name;
            })
            ->editColumn('author', function ($prodpartner) {
                $author = explode(" - ", $prodpartner->author);
                return $author[0];
            })
            ->addColumn('productBtn', function ($productBtn) {
                $productBtn = '<button class="btn btn-sm btn-info productBtn" id="getlistprodpartner/' . $productBtn->id . '">Product</button>';
                return $productBtn;
            })
            ->addColumn('action', function ($prodpartner) {
                return view('datatable._action', [
                    'edit_url' => url('adminpanel/prodpartner/' . $prodpartner->id . '/edit'),
                    'confirm_message' => 'Sure to delete ' . $prodpartner->name . '?'
                ]);
            })
            ->addColumn('chkid', function ($prodpartner) {
                return view('datatable._checked', [
                    'id' => $prodpartner->id
                ]);
            })
            ->rawColumns(['link', 'action'])
            ->toJson();
    }

    public function getBank()
    {
        $bank   = Bank::all();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = " Partners";
        $gen = "Add";
        $menu = DB::table('menu')
            ->orderBy('menu_order', 'asc')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menu = $this->menu($data);
        return view('prodpartner.create', compact("title", "gen", "menu", "data"));
    }

    public function fetchBank(Request $request){
        $select = $request->get('select');
        $value  = $request->get('value');
        $dep    = $request->get('dependent');

        $data   = Bank::where('id', $value)->get();

        foreach ($data as $row){
            $output = $row->bank_code;
            echo $output;
        }

    }

    public function getCachebody()
    {

        //Get cache body type
        $type = Cache::pull('formtype');
        $param = "";
        if ($type == "form") {

            $key = Cache::pull('param_key');
            $key = explode(",", $key);
            $count_key = count($key);

            $value = Cache::pull('param_value');
            $value = explode(",", $value);

            foreach ($key as $id => $value_key) {

                if ($value[$id] != "") {
                    $val = $value[$id];
                } else {
                    $val = "@$value_key@";
                }
                $param .= $value_key;
                $param .= "=";
                $param .= $val;
                if ($id < ($count_key - 1)) $param .= "&";
            }

        } else {
            $param_body = Cache::pull('param_body');
            // $param_body = base64_decode($param_body);
            $param = $param_body;
        }
        return $param;

    }

    public function getCacheauth()
    {

        //Get cache auth
        $type = Cache::pull('authtype');
        $auth = "";

        if ($type == "basic") {

            $uname = Cache::pull('uname');
            $passwd = Cache::pull('passwd');
            $auth = $uname . "&" . $passwd;

        } elseif ($type == "key") {

            $apikey = Cache::pull('apikey');
            $apivalue = Cache::pull('apivalue');
            $auth = $apikey . "&" . $apivalue;

        } elseif ($type == "token") {

            $token = Cache::pull('token');
            $auth = $token;

        }
        return $auth;

    }

    public function getCacheresp()
    {

        //Get cache resp
        $type = Cache::pull('resptype');
        $param = "";
        if ($type == "form") {

            $rcode = Cache::pull('resp_code');
            $rcode = explode(",", $rcode);
            $count_code = count($rcode);

            $rdesc = Cache::pull('resp_desc');
            $rdesc = explode(",", $rdesc);

            foreach ($rcode as $id => $desc) {
                $param .= $desc;
                $param .= "=";
                $param .= $rdesc[$id];
                if ($id < ($count_code - 1)) $param .= "&";
            }

        }
        return $param;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdPartnerRequest $request)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

//      if($request->file('logo')){
//        $target_dir = public_path("images/");
//        $file = $request->file('logo');
//        $fileName = $request->name.".".$file->getClientOriginalExtension();
//        $file->move($target_dir,$fileName);
//        //update
//        $prodpartner->logo_image = $fileName;
//      }

        $partner_threshold_deposit = 0;
        if ($request->thresholdDeposit != "") {
            $partner_threshold_deposit = str_replace(',', '', $request->thresholdDeposit);
        }
        $partner_deposit = 0;
        if ($request->deposit != "") {
            $partner_deposit = str_replace(',', '', $request->deposit);
        }

        // insert to partner
        $prodpartner = new ProductPartner;
        $prodpartner->partner_name = $request->partner_name;
        $prodpartner->partner_pic = $request->partner_pic;
        $prodpartner->partner_nohp = $request->partner_nohp;
        $prodpartner->partner_email = $request->partner_email;
        $prodpartner->partner_norek = $request->partner_norek;
        $prodpartner->partner_bank = $request->partner_bank;
        $prodpartner->partner_bank_code = $request->partner_bank_code;
        $prodpartner->partner_deposit = $partner_deposit;
        $prodpartner->partner_active = $request->partner_active;
        $prodpartner->created_by = $author;
        $prodpartner->partner_threshold_deposit = $partner_threshold_deposit;
//      $prodpartner->method = $request->method;
//      $prodpartner->url = $request->url;
//      $prodpartner->protocol = $request->protocol;
//      $prodpartner->bodytype = $request->body_type;
//      $prodpartner->params = $param;
//      $prodpartner->authorization = $request->authorization;
//      $prodpartner->params_auth = $auth;
//      if($request->useheader!="") $prodpartner->header = $request->useheader;
//      $prodpartner->connectiontype = $request->contype;
//      $prodpartner->timeoutTime = $request->timeout;
//      $prodpartner->success_code = $succ;
//       $prodpartner->separator = $request->separator;
        $prodpartner->save();

//	  $historyTrx = new HistoryTrx;
//	  $historyTrx->partnerId = $prodpartner->id;
//	  $historyTrx->partnerName = $prodpartner->name;
//	  $historyTrx->save();

        // insert to audit trail
        $audittail = [
            'audit_menu' => 'Manage Partners',
            'audit_action' => 'Add',
            'audit_desc_after' => json_encode($prodpartner->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        //Last inserted id
        // $insertedId = $prodpartner->id;

        // //Insert partner response
        // if($succ!=""){
        //   $succarr=explode("&",$succ);
        //   foreach($succarr as $vsucc){
        //     $vsucc=explode("=",$vsucc);
        //     $respvend = new Vendor_Response;
        //     $respvend->product_partner_id = $insertedId;
        //     $respvend->response_code = $vsucc[0];
        //     $respvend->response_desc = $vsucc[1];
        //     $respvend->save();
        //   }
        // }

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "<strong>$prodpartner->name</strong> saved successfully"
        ]);
        Cache::flush();
        return redirect()->route('prodpartner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
        return ProductPartner::query()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = " Partners";
        $gen = "Edit";
        $prodpartner = ProductPartner::find($id);

//      dd($prodpartner->partner_bank);
        $menu = DB::table('menu')
            ->orderBy('menu_order', 'asc')
            ->get();
        $data = array();
        foreach ($menu as $order) {
            $data[$order->parent_id][] = $order;
        }
        $menu = $this->menu($data);
//        dd($prodpartner);
        return view('prodpartner.edit')->with(compact('prodpartner', "title", "gen", "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdPartnerRequest $request, $id)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        $prodpartner = ProductPartner::find($id);
        $auditbefore = $prodpartner->getAttributes();

//        if ($request->file('logo')) {
//            $target_dir = public_path("images/");
//            $file = $request->file('logo');
//            $fileName = $request->name . "." . $file->getClientOriginalExtension();
//            $file->move($target_dir, $fileName);
//            //update
//            $prodpartner->logo_image = $fileName;
//        }

        $thresholdDeposit = 0;
        if ($request->partner_threshold_deposit != "") {
            $thresholdDeposit = str_replace(',', '', $request->partner_threshold_deposit);
        }
        $deposit = 0;
        if ($request->partner_deposit != "") {
            $deposit = str_replace(',', '', $request->partner_deposit);
        }

        // update partner
        $prodpartner->partner_name      = $request->partner_name;
        $prodpartner->partner_pic       = $request->partner_pic;
        $prodpartner->partner_nohp      = $request->partner_nohp;
        $prodpartner->partner_email     = $request->partner_email;
        $prodpartner->partner_norek     = $request->partner_norek;
        $prodpartner->partner_bank      = $request->partner_bank;
        $prodpartner->partner_bank_code = $request->partner_bank_code;
        $prodpartner->partner_deposit   = $deposit;
        $prodpartner->partner_active    = $request->partner_active;
        $prodpartner->created_by        = $author;
        $prodpartner->partner_threshold_deposit = $thresholdDeposit;
        $prodpartner->save();

        $historyTrx = HistoryTrx::where("partnerId", $id)->first();
        if ($historyTrx) {
            $historyTrx->partnerId      = $id;
            $historyTrx->partnerName    = $request->partner_name;
            $historyTrx->save();
        }

        // insert to audit trail
        $audittail = [
            'audit_menu' => 'Manage Partners',
            'audit_action' => 'Edit',
            'audit_desc_before' => json_encode($auditbefore),
            'audit_desc_after' => json_encode($prodpartner->getAttributes()),
            'audit_username' => $author
        ];
        AuditTrail::create($audittail);


        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "$request->name changed successfully"
        ]);
        return redirect()->route('prodpartner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        ProductPartner::destroy($id);
        HistoryTrx::where("partnerId", $id)->delete();
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data deleted successfully"
        ]);
        return redirect()->route('prodpartner.index');

    }

    public function deletepartner($id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        $product = ProductPartner::find($id);

        $audittail = [
            'audit_menu' => 'Manage Partners',
            'audit_action' => 'Delete',
            'audit_desc_after' => json_encode($product->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        ProductPartner::where("id", $id)->delete();
        HistoryTrx::where("partnerId", $id)->delete();
        return "success";

    }
}
