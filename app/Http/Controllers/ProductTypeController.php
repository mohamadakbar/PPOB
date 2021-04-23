<?php

namespace App\Http\Controllers;

use DB;
use App\Helpers\MenuHelper;
use App\Menu;
use Illuminate\Http\Request;
use App\ProductType;
use App\ProductCategory;
use App\AuditTrail;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreProdtypeRequest;
use App\Http\Requests\UpdateProdtypeRequest;

class ProductTypeController extends Controller
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
        $title = "Product Type";
        $menu = $this->menu;
        return view('prodtype.index', compact('title', 'menu'));
    }

    public function getProdtype(Request $request)
    {
        $query = ProductType::select(
            'id',
            'producttype_name',
            'producttype_category_id',
            'producttype_active',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at'
        )
            ->with(['ProductCategoryOne']);
        if (isset($request->product_category_id)) {
            if ($request->product_category_id != "") {
                $query->where('producttype_category_id', $request->product_category_id)->get();
            }
        }
        if (isset($request->product_type_id)) {
            if ($request->product_category_id != "") {
                $query->where('id', $request->product_type_id)->get();
            }
        }
        if (isset($request->status)) {
            if ($request->status != "") {
                $query->where('producttype_active', $request->status)->get();
            }
        }
//       $query->get();

        return Datatables::of($query)
            ->setRowId('{{$id}}')
            ->editColumn('producttype_category_id', function ($prodtype) {
                return $prodtype->ProductCategoryOne->category_name;
            })
            ->editColumn('created_by', function ($prodtype) {
                $author = explode(" - ", $prodtype->created_by);
                return $author[0];
            })
            ->editColumn('created_at', function ($prodtype) {
                return $prodtype->created_at . " (" . \Carbon\Carbon::parse($prodtype->created_at)->diffForHumans() . ")";
            })
            ->editColumn('updated_at', function ($prodtype) {
                return $prodtype->updated_at . " (" . \Carbon\Carbon::parse($prodtype->updated_at)->diffForHumans() . ")";
            })
            ->addColumn('action', function ($prodtype) {
                return view('datatable._action', [
                    'edit_url' => route('prodtype.edit', $prodtype->id),
                    'confirm_message' => 'Sure to delete ' . $prodtype->category_name . '?'
                ]);
            })
            ->addColumn('chkid', function ($prodtype) {
                return view('datatable._checked', [
                    'id' => $prodtype->id
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
        $title  = " Product Type";
        $gen    = "Add";
        $menu   = $this->menu;
        return view('prodtype.create', compact("title", "gen", "menu"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProdtypeRequest $request)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        //Insert
        $prodtype = new ProductType;
        $prodtype->producttype_name = $request->producttype_name;
        $prodtype->producttype_active = $request->producttype_active;
        $prodtype->producttype_category_id = $request->producttype_category_id;
        $prodtype->created_by = $author;
        $prodtype->save();

        $audittail = [
            'audit_menu' => 'Products',
            'audit_submenu' => 'Product Type',
            'audit_action' => 'Add',
            'audit_desc_after' => json_encode($prodtype->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "<strong>$prodtype->name</strong> saved successfully"
        ]);
        return redirect()->route('prodtype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return ProductType::query()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title  = " Product Type";
        $gen    = "Edit";
        $prodtype= ProductType::find($id);
        $menu = $this->menu;
        return view('prodtype.edit')->with(compact('prodtype', "title", "gen", "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        $prodtype = ProductType::find($id);
        $auditbefore = $prodtype->getAttributes();

        //Update
        $prodtype->producttype_name         = $request->producttype_name;
        $prodtype->producttype_active       = $request->producttype_active;
        $prodtype->producttype_category_id  = $request->producttype_category_id;
        $prodtype->created_by = $author;
        $prodtype->save();

        $audittail = [
            'audit_menu' => 'Products',
            'audit_submenu' => 'Product Type',
            'audit_action' => 'Edit',
            'audit_desc_before' => json_encode($auditbefore),
            'audit_desc_after' => json_encode($prodtype->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "$prodtype->name changed successfully"
        ]);
        return redirect()->route('prodtype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        ProductType::destroy($id);
        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Data deleted successfully"
        ]);
        return redirect()->route('prodtype.index');

    }

    public function deleteprodtype($id)
    {
        $author = User::find(Auth::id());
        $author = $author->name . " - " . $author->email;
        $product = ProductType::find($id);

        $audittail = [
            'audit_menu' => 'Products',
            'audit_submenu' => 'Product Type',
            'audit_action' => 'Delete',
            'audit_desc_after' => json_encode($product->getAttributes()),
            'audit_username' => $author
        ];
        $audit = AuditTrail::create($audittail);
        ProductType::destroy($id);
        return "success";

    }
}
