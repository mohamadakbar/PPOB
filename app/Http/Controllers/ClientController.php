<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\Menu;
use DB;
use Illuminate\Http\Request;
use App\Client;
use App\AuditTrail;
use App\User;
use App\ClientPrice;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
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
        $title  = " Client";
        $menu   = $this->menu;
        return view('client.index',compact('title', 'menu'));
    }

    public function getClient(Request $request)
    {
		$query = DB::table('sppob.client');

		   if(!empty($request->client) && isset($request->client)){
			  $query->where('client.id', $request->client);
		   }
		
        $query->select('client.*', 'client.name as client_name')
            ->get();
		
        return Datatables::of($query)
        ->setRowId('{{$id}}')

        ->editColumn('author', function($client) {
                  $author = explode(" - ", $client->author);
                    return $author[0] ;
        })
        ->addColumn('action_setprice', function($client){
            return view('datatable._action_setprice', [
                'edit_url' => route('client.setprice_list', $client->id),
                'confirm_message' => 'Sure to delete ' . $client->name . '?'
            ]);
        })
        ->addColumn('action', function($client){
          return view('datatable._action', [
            'edit_url' => route('client.edit', $client->id),
            'confirm_message' => 'Sure to delete ' . $client->name . '?'
          ]);
        })
        ->addColumn('chkid', function($client){
          return view('datatable._checked', [
            'id' => $client->id
          ]);
        })
        ->rawColumns(['link', 'action_setprice', 'action'])
        ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title  = "Client";
        $gen    = "Add";
        $menu   = $this->menu;
        return view('client.create',compact("title","gen", "menu"));
    }
	
	public function encrypt_func( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = 'Sprint1234!';
        $secret_iv = 'Fatmawati07';

        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }

        return $output;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;

      //Insert
      $client = new Client;
      $client->name = $request->name;
      $client->picEmail = $request->picEmail;
      $client->picPhone = $request->picPhone;
      $client->userid = $request->userid;
      $client->status = $request->status;
	  if($request->password != ""){
        $client->password = $this->encrypt_func($request->password,"e");
      }
      $client->author = $author;
      // dd($client->getAttributes());
      $client->save();

      $audittail = [
        'audit_menu'        => 'Client',
        'audit_action'      => 'Add',
        'audit_desc_after'  => json_encode($client->getAttributes()),
        'audit_username' => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"<strong>$client->name</strong> saved successfully"
      ]);
      return redirect()->route('client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
         return Client::query()->get();
    }

    public function setprice_list($id)
    {
        $client = Client::select("id", "name")->findOrFail($id);
        $title = "Edit Price"; 
        $gen = "";
        if(isset($client))
            $gen = $client->name; 

        // Category 
        $productCategories = DB::table('sppob.category')
                            ->select('id', 'name')->get();
        // Product Type
        $productTypes = DB::table('sppob.producttype')
                            ->select('id', 'name')->get();

        $subgen1 = "Edit Price";

        $menu = $this->menu;
        return view('client.setprice_list',compact('title', 'gen', 'subgen1', 'menu', 'productCategories', 'productTypes'));
    }

    public function getSetPrice(Request $request)
    {
		$query = DB::table('sppob.client');

		   if(!empty($request->client) && isset($request->client)){
			  $query->where('client.id', $request->client);
		   }
		
        $query->select('client.*', 'client.name as client_name')
            ->get();
		
        return Datatables::of($query)
        ->setRowId('{{$id}}')

        ->editColumn('author', function($client) {
                  $author = explode(" - ", $client->author);
                    return $author[0] ;
        })
        ->addColumn('action_setprice', function($client){
            return view('datatable._action_setprice', [
                'edit_url' => route('client.setprice_list', $client->id),
                'confirm_message' => ''
            ]);
        })
        ->addColumn('action', function($client){
          return view('datatable._action', [
            'edit_url' => route('client.edit', $client->id),
            'confirm_message' => 'Sure to delete ' . $client->name . '?'
          ]);
        })
        ->addColumn('chkid', function($client){
          return view('datatable._checked', [
            'id' => $client->id
          ]);
        })
        ->rawColumns(['link', 'action_setprice', 'action'])
        ->toJson();
    }

    public function getClientPrice(Request $request)
    {
      $products = DB::table('sppob.product');
      $products->leftJoin('sppob.productpartner', 'productpartner.productCode', '=', 'product.productCode');
      $products->leftJoin('sppob.category', 'product.categoryId', '=', 'category.id');
      $products->leftJoin('sppob.producttype', 'product.productTypeId', '=', 'producttype.id');
      $products->leftJoin('sppob.clientprice', function($join) use($request){
        $join->on('clientprice.product_id', '=', 'product.id')->where('clientprice.client_id', $request->clientID);
      });
      if(isset($request->productCategoryID) && $request->productCategoryID != ""){
        $products->where('product.categoryId', $request->productCategoryID);
      }
      if(isset($request->productType) && $request->productType != ""){
        $products->where('product.productTypeId', $request->productType);
      }
      if(isset($request->status) && $request->status != ""){
        if($request->status == 'inactive'){
          $status = 0;
        }else{
          $status = 1;
        }
        $products->where('productpartner.status', $status);
      }
      $products->select('productpartner.productCode', 'product.id as product_id', 'product.bottomPrice', 'productpartner.status', 'productpartner.price as partnerPrice', 'product.productName', 'category.name as categoryName', 'producttype.name as productTypeName', 'clientprice.price as clientPrice', 'clientprice.price_type')
                        ->get();
      return Datatables::of($products)
            ->editColumn('bottomPrice', function($products) {
              $bottomPrice = 'Rp '.number_format($products->bottomPrice);
              return $bottomPrice;
            })
            ->filterColumn('price', function($query,$keyword){
              $query->where('productpartner.price', 'like', '%'.$keyword.'%');
              $query->where('clientprice.price', 'like', '%'.$keyword.'%');
            })
            ->editColumn('price', function($products) {
              if($products->clientPrice != '' && $products->clientPrice){
                $price = $products->clientPrice;
              }else{
                $price = $products->partnerPrice;
              }
              $price = 'Rp '.number_format($price);
              return $price;
            })
            ->addColumn('action', function($products){
              return view('datatable._action_editprice', [
                'edit_url' => "#",
                'confirm_message' => '',
                'bottomPrice' => $products->bottomPrice,
                'manualPrice' => $products->clientPrice,
                'priceType' => $products->price_type, // priceType 1 = bottomPrice jika 2 = manualPrice
                'productName' => $products->productName,
                'productID' => $products->product_id
              ]);
            })
            ->rawColumns(['link', 'action'])
            ->toJson();
    }

    public function postEditClientPrice(Request $request)
    {
      $clientID = $request->client_id;
      $product_id = $request->product_id;
      $set_price = $request->set_price;
      $price_type = $request->price_type;

      $clientPrice = ClientPrice::where('client_id', $clientID)
                    ->where('product_id', $product_id)
                    ->first();

      if($clientPrice){
        $clientPrice->price = $set_price;
        $clientPrice->price_type = $price_type;
        $clientPrice->updated_at = date('Y-m-d H:i:s');
        $clientPrice->save();

        $responseData = [
          'status' => 'success',
          'message' => 'Success saving data'
        ];
      }else{
        unset($clientPrice);
        $save = ClientPrice::create([
            'client_id' => $clientID,
            'product_id' => $product_id,
            'price' => $set_price,
            'price_type' => $price_type
        ]);

        if($save){
          $responseData = [
            'status' => 'success',
            'message' => 'Success saving new data'
          ];
        }else{
          $responseData = [
            'status' => 'failed',
            'message' => 'Failed saving data'
          ];
        }

      }

      return response()->json($responseData);
    }
    public function edit($id)
    {
      $title = " Client";
      $gen ="Edit";   
      $client = Client::find($id);
      $client['password'] = $this->encrypt_func($client['password'],"d");
      $menu = $this->menu;
      return view('client.edit')->with(compact('client',"title","gen", "menu"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;
      $client = Client::find($id);
      $auditbefore = $client->getAttributes();
      // dd($auditbefore);

      //Update
      $client->name = $request->name;
      $client->userid = $request->userid;
     if($request->password != ""){
        $client->password = $this->encrypt_func($request->password,"e");
      }
      //$client->ip_source = $request->ip_source;

      $client->picEmail = $request->picEmail;
      $client->picPhone = $request->picPhone;
      $client->status = $request->status;
      $client->author = $author;
      $client->save();

      $audittail = [
        'audit_menu'        => 'Client',
        'audit_action'      => 'Edit',
        'audit_desc_before' => json_encode($auditbefore),
        'audit_desc_after'  => json_encode($client->getAttributes()),
        'audit_username'  => $author
      ];
      $audit = AuditTrail::create($audittail);

      Session::flash("flash_notification", [
        "level"=>"success",
        "message"=>"$client->name changed successfully"
      ]);
      return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      Client::destroy($id);
      Session::flash("flash_notification", [
      "level"=>"success",
      "message"=>"Data deleted successfully"
      ]);
      return redirect()->route('client.index');

    }
    public function deleteclient($id)
    {

      $author = User::find(Auth::id());
      $author = $author->name." - ".$author->email;
      $client = Client::find($id);

      $audittail = [
        'audit_menu'        => 'Client',
        'audit_action'      => 'Delete',
        'audit_desc_after'  => json_encode($client->getAttributes()),
        'audit_username'    => $author
      ];
      $audit = AuditTrail::create($audittail);
      Client::destroy($id);

      return "success";

    }
}
