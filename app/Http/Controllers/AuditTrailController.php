<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use App\Menu;
use DB;
use Illuminate\Http\Request;
use App\AuditTrail;
use App\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use function MongoDB\BSON\toJSON;

class AuditTrailController extends Controller
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
        $title  = " Audit Trail";
        $menu   = $this->menu;

        return view('audit-trail.index',compact('title', 'menu'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getauditall(){
        return DataTables::of(AuditTrail::all())->make(true);
    }

    public function getauditbyfilter(Request $request)
    {
        $audit = AuditTrail::where('audit_username', 'LIKE', "%$request->audit_username%")
                 ->where('audit_time_log', '>=', date("Y-m-d", strtotime($request->timeStart))." 00:00:01")
                 ->where('audit_time_log', '<=', date("Y-m-d", strtotime($request->timeEnd))." 23:59:59");
        return DataTables::of($audit)->make(true);
    }

    public function exportaudit(Request $request)
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
}
