<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Excel;
use App\Helpers\MenuHelper;
use App\Menu;
use App\AuditTrail;
use App\Product;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Rap2hpoutre\FastExcel\FastExcel;

class ProductController extends Controller
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
        $title  = " Manage Product";
        $menu   = $this->menu;
        return view('product.index', compact('title', 'menu'));
    }

    public function getProduct(Request $request)
    {
        $query = Product::with(['ProductCategoryOne', 'ProductTypeOne', 'ProductPartner']);
        if (isset($request->product_type_id)) {
            if ($request->product_type_id != "") {
                $query->where('manproduct_type_id', $request->product_type_id);
            }
        }
        if (isset($request->status)) {
            if ($request->status != "") {
                $query->where('manproduct_active', $request->status);
            }
        }

        $query->get();

        return Datatables::of($query)
            ->setRowId('{{$id}}')
            ->editColumn('created_at', function ($product) {
                return $product->created_at . " (" . \Carbon\Carbon::parse($product->created_at)->diffForHumans() . ")";
            })
            ->editColumn('manproduct_category_id', function ($product) {
                return $product->ProductCategoryOne->category_name;
            })
            ->editColumn('manproduct_partner_id', function ($product) {
                return $product->ProductPartner->partner_name;
            })
            ->editColumn('manproduct_type_id', function ($product) {
                return $product->ProductTypeOne->producttype_name;
            })
            ->editColumn('updated_at', function ($product) {
                return $product->updated_at . " (" . \Carbon\Carbon::parse($product->updated_at)->diffForHumans() . ")";
            })
            ->addColumn('action', function ($product) {
                return view('datatable._action', [
                    'edit_url' => url('adminpanel/product/' . $product->id . '/edit'),
                    'confirm_message' => 'Sure to delete ' . $product->name . '?'
                ]);
            })
            ->addColumn('chkid', function ($product) {
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
        $title  = " Manage Product";
        $gen    = "Add";
        $menu   = $this->menu;
        // $product_type       = DB::table('ppob_config.producttype')->pluck('producttype_name', 'id');
        $product_category   = DB::table('ppob_config.category')->pluck('category_name', 'id');
        $partner    = DB::table('ppob_config.partner')->pluck('partner_name','id');

        $inq = array(1 => "Inquiry", 2 => "Payment", 3 => "Reversal");

        //$data = array('product_type' => $product_type, 'product_category' => $product_category, 'product_partner' => $product_partner, 'inqType' => $inq);
        // $data = array('product_type' => $product_type, 'product_category' => $product_category, 'inqType' => $inq, 'partner' => $partner);
        $data = array('product_category' => $product_category, 'inqType' => $inq, 'partner' => $partner);
        return view('product.create', compact("title", "gen", "menu", "data"));
    }

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value  = $request->get('value');
        $dep    = $request->get('dependent');
        $data   = DB::table('ppob_config.producttype')
                ->where('producttype_category_id', $value)->get();
        foreach ($data as $row){
            $output = '<option value="'.$row->id.'">'.$row->producttype_name.'</option>';
            echo $output;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        //Insert to manproduct
        $product = new Product;
        $product->created_by            = $author;
        $product->manproduct_method     = $request->manproduct_method;
        $product->manproduct_type_id    = $request->manproduct_type_id;
        $product->manproduct_name       = $request->manproduct_name;
        $product->manproduct_code       = $request->manproduct_code;
        $product->manproduct_expired    = $request->manproduct_expired;
        $product->manproduct_active     = $request->manproduct_active;
        $product->manproduct_partner_id = $request->manproduct_partner_id;
        $product->manproduct_price_denom    = $request->manproduct_price_denom;
        $product->manproduct_category_id    = $request->manproduct_category_id;
        $product->manproduct_price_buttom   = $request->manproduct_price_buttom;
        $product->manproduct_price_cashback = $request->manproduct_price_cashback;
//        dd($request->cashback);

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
            'audit_menu' => 'Products',
            'audit_submenu' => 'Manage Product',
            'audit_action' => 'Add',
            'audit_desc_after' => json_encode($product->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "<strong>$product->name</strong> saved successfully"
        ]);
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title  = " Manage Product";
        $gen    = "Add";
        $menu   = $this->menu;
        // $product_type       = DB::table('ppob_config.producttype')->pluck('producttype_name', 'id');
        $partner    = DB::table('ppob_config.partner')->pluck('partner_name','id');
        $product    = Product::find($id);
        $product_category   = DB::table('ppob_config.category')->pluck('category_name', 'id');

        $inq = array(1 => "Inquiry", 2 => "Payment", 3 => "Reversal");

        //$data = array('product_type' => $product_type, 'product_category' => $product_category, 'product_partner' => $product_partner, 'inqType' => $inq);
        // $data = array('product_type' => $product_type, 'product_category' => $product_category, 'inqType' => $inq, 'partner' => $partner);
        $data = array('product_category' => $product_category, 'inqType' => $inq, 'partner' => $partner);
        return view('product.edit', compact("product","title", "gen", "menu", "data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;

        //$this->validate($request, ['productCode' => 'required|unique_with:products,partner_productCode,'. $id]);
        // $this->validate($request, ['partner_productCode' => 'required|unique_with:products,productCode,'. $id]);
        $product = Product::find($id);
//        $auditbefore = $product->getAttributes();

        //Update
        $product->created_by            = $author;
        $product->manproduct_method     = $request->manproduct_method;
        $product->manproduct_type_id    = $request->manproduct_type_id;
        $product->manproduct_name       = $request->manproduct_name;
        $product->manproduct_code       = $request->manproduct_code;
        $product->manproduct_expired    = $request->manproduct_expired;
        $product->manproduct_active     = $request->manproduct_active;
        $product->manproduct_partner_id = $request->manproduct_partner_id;
        $product->manproduct_price_denom    = $request->manproduct_price_denom;
        $product->manproduct_category_id    = $request->manproduct_category_id;
        $product->manproduct_price_buttom   = $request->manproduct_price_buttom;
        $product->manproduct_price_cashback = $request->manproduct_price_cashback;

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

//        $audittail = [
//            'audit_menu' => 'Products',
//            'audit_submenu' => 'Manage Product',
//            'audit_action' => 'Edit',
//            'audit_desc_before' => json_encode($auditbefore),
//            'audit_desc_after' => json_encode($product->getAttributes()),
//            'audit_username' => $author
//        ];
//        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "$product->name changed successfully"
        ]);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Product::destroy($id);
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data deleted successfully"
        ]);
        return redirect()->route('product.index');

    }

    public function deleteproduct($id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        $product = Product::find($id);

        $audittail = [
            'audit_menu' => 'Products',
            'audit_submenu' => 'Manage Product',
            'audit_action' => 'Delete',
            'audit_desc_after' => json_encode($product->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);
        Product::destroy($id);
        return "success";

    }

    function import(Request $request)
    {
        $author = User::find(Auth::id());
        $author = $author->name;

        $this->validate($request, [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();

        $collection = (new FastExcel())->import($path, function ($value) {
            return [
                'productName' => $value["productName"],
                'productCode' => $value["productCode"],
                'cashback' => $value["cashback"],
                'until' => $value["until"],
                'bottomPrice' => $value["bottomPrice"],
                'denom' => $value["denom"]
            ];

        });
        //dd($collection);

        foreach ($collection as $id => $value) {


            //dd($value);
            //Insert
            $product = new Product;
            $product->inqType = $request->inqType;
            $product->categoryId = $request->categoryId;
            $product->productTypeId = $request->productTypeId;
            $product->productName = $value["productName"];
            $product->productCode = $value["productCode"];
            $product->cashback = (empty($value["cashback"])) ? NULL : $value["cashback"];
            $product->until = (empty($value["until"])) ? NULL : $value["until"];
            $product->bottomPrice = (empty($value["bottomPrice"])) ? NULL : $value["bottomPrice"];
            $product->denom = (empty($value["denom"])) ? NULL : $value["denom"];
            $product->status = $request->status;
            $product->author = $author;

            $product->save();

            $audittail = [
                'audit_menu' => 'Products',
                'audit_submenu' => 'Manage Product',
                'audit_action' => 'Add',
                'audit_desc_after' => json_encode($product->getAttributes()),
                'audit_username' => $author
            ];
            $audit = AuditTrail::create($audittail);
        }

        //dd($product);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "<strong>$product->name</strong> saved successfully"
        ]);
        return redirect()->route('product.index');

    }
}
