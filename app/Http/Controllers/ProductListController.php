<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Product;
use App\AuditTrail;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductListController extends Controller
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
        $title = " Product List List";
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        return view('productList.index',compact('title', 'menu'));
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

    public function getProduct(Request $request)
    {
       $query = Product::select(
           'id',
           'manproduct_name',
           'manproduct_code',
           'manproduct_expired',
           'manproduct_price_cashback',
           'manproduct_price_denom',
           'manproduct_price_bottom',
           'manproduct_price_biller',
           'manproduct_price_admin',
           'manproduct_partner_id',
           'manproduct_category_id',
           'manproduct_method',
           'manproduct_active',
           'manproduct_type_id',
           'created_by',
           'created_at'
                )
                ->with(['ProductCategoryOne', 'ProductTypeOne']);
      // Fake Column
      $query->addSelect(DB::raw("'-' as partner_name"));
      $query->addSelect(DB::raw("'-' as adminFee"));

	    if(!empty($request->categoryId) && isset($request->categoryId)){
        $query->where('manproduct_category_id', $request->categoryId);
      }
      if(!empty($request->id) && isset($request->id)){
        $query->where('manproduct_type_id', $request->id);
      }
      if(!empty($request->status) && isset($request->status)){
          $query->where('manproduct_active', $request->status);
       }

	   $query->get();

        return Datatables::of($query)
        ->setRowId('{{$id}}')
        ->filterColumn('partner_name', function($query,$keyword){
          return null;
        })
        ->filterColumn('adminFee', function($query,$keyword){
          return null;
        })
        ->filterColumn('manproduct_category_id', function($query,$keyword){
          $query->whereHas('ProductCategoryOne', function($q) use($keyword){
            $q->where('category_name', $keyword);
          });
        })
        ->filterColumn('manproduct_type_id', function($query,$keyword){
          $query->whereHas('ProductTypeOne', function($q) use($keyword){
            $q->where('producttype_name', $keyword);
          });
        })
        ->filterColumn('adminFee', function($query,$keyword){
          return null;
        })
        ->editColumn('manproduct_category_id', function($product) {
          return $product->ProductTypeOne->producttype_name;
        })
        ->editColumn('manproduct_type_id', function($product) {
          return $product->ProductCategoryOne->category_name;
        })
        ->editColumn('manproduct_price_denom', function($product) {
          if($product->manproduct_price_denom){
            return number_format($product->manproduct_price_denom);
          };
        })
        ->editColumn('manproduct_price_bottom', function($product) {
          if($product->manproduct_price_denom){
            return number_format($product->manproduct_price_bottom);
          };
        })
        ->addColumn('action', function($product){
          return view('datatable._action', [
            'edit_url' => route('product.edit', $product->id),
            'confirm_message' => 'Sure to delete ' . $product->name . '?'
          ]);
        })
        ->addColumn('chkid', function($product){
          return view('datatable._checked', [
            'id' => $product->id
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
        $title = " Product List";
        $gen ="Add";
        $menu = DB::table('menu')
                ->orderBy('menu_order', 'asc')
                ->get();
        $data =array();
        foreach ($menu as $order) {
            $data[$order->parent_id][]=$order;
        }
        $menu = $this->menu($data);
        $product_type = DB::table('product_type')->pluck('name','id');
        $product_category = DB::table('product_category')->pluck('name','id');
        $product_partner = DB::table('product_partner')->pluck('name','id');
        $data = array('product_type' => $product_type, 'product_category' => $product_category, 'product_partner' => $product_partner);
        return view('product.create',compact("title","gen", "menu", "data"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
	  $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      //Insert
      $product = new Product;
      $product->name = $request->name;
      $product->partnerId = $request->partnerId;
      $product->categoryId = $request->categoryId;
      $product->productTypeId = $request->productTypeId;
      $product->cashback = $request->cashback;
      $product->basePrice = $request->basePrice;
      $product->denom = $request->denom;
      $product->retailPrice = $request->retailPrice;
      $product->adminFee = $request->adminFee;
      $product->status = $request->status;

      /*$product->productCode = $request->productCode;
      $product->partner_productCode = $request->partner_productCode;
      $product->denom = $request->denom;
      $product->product_price = $request->product_price;
      $product->partner_product_price = $request->partner_product_price;
      $product->discount_type = $request->discount_type;
      $product->discount_value = $request->discount_value;
      $product->status = $request->status;
      $product->author = $author;*/
      $product->save();

      $audittail = [
        'audit_menu'        => 'Products',
        'audit_submenu'     => 'Product List',
        'audit_action'      => 'Add',
        'audit_desc_after'  => json_encode($product->getAttributes()),
        'audit_username' => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$product->name</strong> saved successfully"
      ]);
      return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $title = " Product List";
      $gen ="Edit";
      //$client = Client::find($id);
      $menu = DB::table('menu')
              ->orderBy('menu_order', 'asc')
              ->get();
      $data =array();
      foreach ($menu as $order) {
          $data[$order->parent_id][]=$order;
      }
      $menu = $this->menu($data);
      $product_type = DB::table('product_type')->pluck('name','id');
      $product_category = DB::table('product_category')->pluck('name','id');
      $product_partner = DB::table('product_partner')->pluck('name','id');
      $product = Product::find($id);
	  //dd($product);
      $data = array('product' => $product, 'product_type' => $product_type, 'product_category' => $product_category, 'product_partner' => $product_partner);
      //return view('product.edit')->with(compact("title","gen","menu",'data'));
      return view('product.edit')->with(compact("title","gen","menu",'data','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      //$this->validate($request, ['productCode' => 'required|unique_with:products,partner_productCode,'. $id]);
      // $this->validate($request, ['partner_productCode' => 'required|unique_with:products,productCode,'. $id]);
      $product = Product::find($id);
      $auditbefore = $product->getAttributes();

      //Update
      $product->partnerId = $request->partnerId;
      $product->categoryId = $request->categoryId;
      $product->productTypeId = $request->productTypeId;
      $product->name = $request->name;
      $product->cashback = $request->cashback;
      $product->basePrice = $request->basePrice;
      $product->denom = $request->denom;
      $product->retailPrice = $request->retailPrice;
      $product->adminFee = $request->adminFee;
      $product->status = $request->status;

      /*$product->productCode = $request->productCode;
      $product->partner_productCode = $request->partner_productCode;
      $product->denom = $request->denom;
      $product->product_price = $request->product_price;
      $product->partner_product_price = $request->partner_product_price;
      $product->discount_type = $request->discount_type;
      $product->discount_value = $request->discount_value;
      $product->status = $request->status;
      $product->author = $author;*/
      $product->save();

      $audittail = [
        'audit_menu'        => 'Products',
        'audit_submenu'     => 'Product List',
        'audit_action'      => 'Edit',
        'audit_desc_before' => json_encode($auditbefore),
        'audit_desc_after'  => json_encode($product->getAttributes()),
        'audit_username'  => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"$product->name changed successfully"
      ]);
      return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      Product::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('product.index');

    }
    public function deleteproduct($id)
    {
      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;
      $product = Product::find($id);

      $audittail = [
        'audit_menu'        => 'Products',
        'audit_submenu'     => 'Product List',
        'audit_action'      => 'Delete',
        'audit_desc_after'  => json_encode($product->getAttributes()),
        'audit_username'    => $author
      ];
      $audit = AuditTrail::create($audittail);

      Product::destroy($id);
      return "success";

    }
}
