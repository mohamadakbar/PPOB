<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ProductForPartner;
use App\ProductPartner;
use App\HistoryTrx;
use App\AuditTrail;
use App\User;
use App\Vendor_Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreProductForPartnerRequest;
use App\Http\Requests\UpdateProductForPartnerRequest;
use Illuminate\Support\Facades\Cache;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Illuminate\Support\Collection;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ProductForPartnerController extends Controller
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
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('prodpartner.index',compact('title', 'menu'));
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

    public function getProdForpartner($id)
    {
		$partnerName = ProductPartner::find($id);
        $title = " Product List ".$partnerName["name"];
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('prodforpartner.index',compact('title', 'menu', 'id'));
    }

	public function getList($id)
    {
        return Datatables::of(ProductForPartner::query()->where('partnerId', '=', $id)->orderBy('id', 'desc'))
        ->setRowId('{{$id}}')
        ->editColumn('created_at', function(ProductForPartner $data) {
                    //return $data->created_at." (".$data->created_at->diffForHumans().")";
                    return $data->created_at;
        })
        ->editColumn('partnerProductName', function(ProductForPartner $data) {
                    return  $data->partnerProductName .' - '. $data->productCode;
        })
        ->editColumn('price', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->price);
        })
        ->editColumn('adminFee', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->adminFee);
        })
        ->editColumn('cashback', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->cashback);
        })
        ->editColumn('updated_at', function(ProductForPartner $data) {
                    //return $data->updated_at." (".$data->updated_at->diffForHumans().")";
                    return $data->updated_at;
        })
        ->editColumn('author', function($data) {
                  $author = explode(" - ", $data->author);
                    return $author[0] ;
        })
        ->addColumn('action', function($data){
          return view('datatable._action', [
            'edit_url' => route('prodforpartner.edit', $data->id),
            'confirm_message' => 'Sure to delete ' . $data->name . '?'
          ]);
        })
        ->addColumn('chkid', function($data){
          return view('datatable._checked', [
            'id' => $data->id
          ]);
        })
        ->rawColumns(['link', 'action'])
        ->toJson();
    }

	public function getListByProductCode(Request $request)
    {

        return Datatables::of(ProductForPartner::query()
		->select('productpartner.*', 'partner.name as partnerName')
		->where('productCode', '=', $request->id)
		->join('sppob.partner', 'productpartner.partnerId', '=', 'partner.id')
		->orderBy('productpartner.id', 'desc'))

        ->setRowId('{{$id}}')
        ->editColumn('created_at', function(ProductForPartner $data) {
                    //return $data->created_at." (".$data->created_at->diffForHumans().")";
                    return $data->created_at;
        })
        ->editColumn('partnerProductName', function(ProductForPartner $data) {
                    return  $data->partnerProductName .' - '. $data->productCode;
        })
        ->editColumn('price', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->price);
        })
        ->editColumn('adminFee', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->adminFee);
        })
        ->editColumn('cashback', function(ProductForPartner $data) {
                    return  'Rp.'.number_format($data->cashback);
        })
        ->editColumn('updated_at', function(ProductForPartner $data) {
                    //return $data->updated_at." (".$data->updated_at->diffForHumans().")";
                    return $data->updated_at;
        })
        ->editColumn('author', function($data) {
                  $author = explode(" - ", $data->author);
                    return $author[0] ;
        })
        ->addColumn('action', function($data){
          return view('datatable._action', [
            'edit_url' => route('prodforpartner.edit', $data->id),
            'confirm_message' => 'Sure to delete ' . $data->name . '?'
          ]);
        })
        ->addColumn('chkid', function($data){
          return view('datatable._checked', [
            'id' => $data->id
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
        $title = " Product Partners";
        $gen ="Add Product";
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }

		/*$product_type = DB::table('sppob.producttype')->pluck('name','id');
        $product_category = DB::table('sppob.category')->pluck('name','id');
		$inq = array(1 => "Payment", 2 => "Purchase");*/

		$product = DB::table('sppob.product')->pluck('productName','productCode');
		//$product = [];

        $menu = $this->menu($data);
		//$data = array('productSprint' => $product);
		$data = array('productPartner' => $product);
        return view('prodforpartner.create',compact("title","gen", "menu", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductForPartnerRequest $request)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;



      //Insert
      $prodforpartner = new ProductForPartner;
      $prodforpartner->partnerId = $request->partnerId;
      $prodforpartner->productCode = $request->productSprint;
      $prodforpartner->partnerProductName = $request->partnerProductName;
      $prodforpartner->partnerProductCode = $request->partnerProductCode;
      $prodforpartner->price = $request->price;
      $prodforpartner->denom = $request->denom;
      $prodforpartner->cashback = $request->cashback;
      $prodforpartner->adminFee = $request->adminFee;
      $prodforpartner->status = $request->status;
      $prodforpartner->author = $author;

      $prodforpartner->save();

      $audittail = [
        'audit_menu'        => 'Manage Partners',
        'audit_submenu'     => 'Product List Partner',
        'audit_action'      => 'Add',
        'audit_desc_after'  => json_encode($prodforpartner->getAttributes()),
        'audit_username' => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$prodforpartner->name</strong> saved successfully"
      ]);
      Cache::flush();
      return redirect()->route('prodforpartner.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show()
    {
         return ProductforPartner::query()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $title = " Product Partners";
      $gen ="Edit";
      $prodforpartner = ProductForPartner::find($id);
      $menu = DB::table('menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);

	  $product = DB::table('sppob.product')->pluck('productName','productCode');
	  $data = array('productPartner' => $product);
      return view('prodforpartner.edit')->with(compact('prodforpartner',"title","gen", "menu", 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $author = User::find(Auth::id());
      $author = $author->name;


      $prodforpartner = ProductForPartner::find($id);
      $auditbefore = $prodforpartner->getAttributes();

      //Update
//      $prodforpartner->partnerId = $request->partnerId; // comment karena tdk perlu partnerid lagi untuk proses update
      $prodforpartner->productCode = $request->productSprint;
      $prodforpartner->partnerProductName = $request->partnerProductName;
      $prodforpartner->partnerProductCode = $request->partnerProductCode;
      $prodforpartner->price = $request->price;
      $prodforpartner->denom = $request->denom;
      $prodforpartner->cashback = $request->cashback;
      $prodforpartner->adminFee = $request->adminFee;
      $prodforpartner->status = $request->status;
      $prodforpartner->author = $author;

      $prodforpartner->save();

      $audittail = [
        'audit_menu'        => 'Manage Partner',
        'audit_submenu'     => 'Product List Partner',
        'audit_action'      => 'Edit',
        'audit_desc_before' => json_encode($auditbefore),
        'audit_desc_after'  => json_encode($prodforpartner->getAttributes()),
        'audit_username'  => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"$prodforpartner->name changed successfully"
      ]);
      return redirect()->route('prodforpartner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      ProductForPartner::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('prodforpartner.index');

    }
    public function deleteproductforpartner($id)
    {


      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;
      $product = ProductForPartner::find($id);

      $audittail = [
        'audit_menu'        => 'Manage Partners',
        'audit_submenu'     => 'Product List Partner',
        'audit_action'      => 'Delete',
        'audit_desc_after'  => json_encode($product->getAttributes()),
        'audit_username'    => $author
      ];
      $audit = AuditTrail::create($audittail);
      ProductForPartner::where("id", $id)->delete();
      return "success";

    }

	function import(Request $request)
    {
	  $author = User::find(Auth::id());
      $author = $author->name;

     $this->validate($request, [
      'select_file'  => 'required|mimes:xls,xlsx'
     ]);

     $path = $request->file('select_file')->getRealPath();

	 $collection = (new FastExcel())->import($path, function ($value) {
		return [
			'partnerId' => $value["partnerId"],
			'productCode' => $value["productCode"],
			'partnerProductName' => $value["partnerProductName"],
			'partnerProductCode' => $value["partnerProductCode"],
			'price' => $value["price"],
			'denom' => $value["denom"],
			'cashback' => $value["cashback"],
			'adminFee' => $value["adminFee"],
			'status' => $value["status"]
		];

	 });
	  //dd($collection);

	  foreach ($collection as $id => $value){
		  if($value["status"] !== "" || $value["partnerId"] !== "" || $value["productCode"] !== ""){

			  //dd($value);
			  //Insert
			  $prodforpartner = new ProductForPartner;
			  $prodforpartner->partnerId = (empty($value["partnerId"]))?NULL:$value["partnerId"];
			  $prodforpartner->productCode = (empty($value["productCode"]))?NULL:$value["productCode"];
			  $prodforpartner->partnerProductName = (empty($value["partnerProductName"]))?NULL:$value["partnerProductName"];
			  $prodforpartner->partnerProductCode = (empty($value["partnerProductCode"]))?NULL:$value["partnerProductCode"];
			  $prodforpartner->price = (empty($value["price"]))?NULL:$value["price"];
			  $prodforpartner->denom = (empty($value["denom"]))?NULL:$value["denom"];
			  $prodforpartner->cashback = (empty($value["cashback"]))?NULL:$value["cashback"];
			  $prodforpartner->adminFee = (empty($value["adminFee"]))?NULL:$value["adminFee"];
			  $prodforpartner->status = (empty($value["status"]))?NULL:$value["status"];
			  $prodforpartner->author = $author;

			  $prodforpartner->save();
		  }
	  }

	  //dd($prodforpartner);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$prodforpartner->name</strong> saved successfully"
      ]);
      return redirect()->route('prodforpartner.index');

    }
}
