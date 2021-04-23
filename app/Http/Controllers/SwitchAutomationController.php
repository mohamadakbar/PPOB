<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\SwitchingCustom;
use App\SwitchingCustomDetail;

class SwitchAutomationController extends Controller
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
        $responseCodes = $this->getAllResponseCode();

        return view('switch-automation.index',compact('title', 'menu', 'responseCodes'));
    }

    public function getAllResponseCode()
    {
        $responseCodes = DB::table('sppob_trx.sprintresponsecode');
        $responseCodes->select('id', 'responseCode', 'status');
        $results = $responseCodes->get();

        return $results;
    }

    public function storeDetail(Request $request)
    {
        if($request->switchingCustomDetailId != ""){
            $dataSwitchingCustomDetail = SwitchingCustomDetail::where('id', $request->switchingCustomDetailId)->first();
            if($dataSwitchingCustomDetail){
                $isactive = 0;
                if($request->status == "true"){
                    $isactive = 1;
                }
                $dataSwitchingCustomDetail->isactive        = $isactive;
                $dataSwitchingCustomDetail->response_code   = $request->status_response;
                $dataSwitchingCustomDetail->condition       = $request->condition;
                $dataSwitchingCustomDetail->value           = $request->values;
                $dataSwitchingCustomDetail->period          = $request->period;
                $dataSwitchingCustomDetail->reset_after     = $request->reset_after;            
                $dataSwitchingCustomDetail->updated_at      = date('Y-m-d H:i:s');

                $dataSwitchingCustomDetail->save();
            }
            

            $results = [
                'status' => 'success',
                'message' => 'Data success Updated'
            ];
        }else{
            $switchingCustomDetail = new SwitchingCustomDetail;

            $isactive = 0;
            if($request->status == "true"){
                $isactive = 1;
            }

            $switchingCustomDetail->custom_id = $request->customId;
            $switchingCustomDetail->isactive = $isactive;
            $switchingCustomDetail->response_code = $request->status_response;
            $switchingCustomDetail->condition = $request->condition;
            $switchingCustomDetail->value = $request->values;
            $switchingCustomDetail->period = $request->period;
            $switchingCustomDetail->reset_after = $request->reset_after;            
            $switchingCustomDetail->created_at = date('Y-m-d H:i:s');

            $switchingCustomDetail->save();

            $results = [
                'status' => 'success',
                'message' => 'Data success insert'
            ];
        }

        return response()->json($results);
    }

    public function deleteDetail(Request $request)
    {
        $switchingCustomDetail = SwitchingCustomDetail::find($request->id);
        $switchingCustomDetail->forceDelete();
    }

    public function getListSwitchingCustomDetail(Request $request)
    {
        $switchingCustom = SwitchingCustom::where('client_id', $request->clientId);
        $switchingCustom->select('id');

        $result = $switchingCustom->first();
        $switchingCustomDetailList = [];        
        $message = "Data empty.";

        if($result){
            $switchingCustomDetail = SwitchingCustomDetail::where('custom_id', $result->id);
            $results = $switchingCustomDetail->get();

            if($results){
                $switchingCustomDetailList = $results;
                $message = "Data succesfully loaded";
            }
            $response = [
                'status' => 'success',
                'message' => $message,
                'data' => $switchingCustomDetailList
            ];
        }else{
            $response = [
                'status' => 'success',
                'message' => $message,
                'data' => $switchingCustomDetailList
            ];
        }
        
        return response()->json($response);
    }

    public function getCollectionPartner(Request $request)
    {
        $switchingCustom = SwitchingCustom::where('client_id', $request->client_id);
        $switchingCustom->select('id', 'collection_partner');

        $result = $switchingCustom->first();

        $collection_partners = [];
        $customId = null;
        if($result){      
            $decodeCollections = json_decode($result->collection_partner);
            $customId = $result->id;

            $partner_ids = array_column($decodeCollections, 'partnerId');
            // Partner
            $partners = DB::table('sppob.partner');
            $partners->select('id','name');        
            $partners->whereIn('id', $partner_ids);
            $result_partners = $partners->get();
            $partner_name_dicts = [];
            foreach($result_partners as $row){
                $partner_name_dicts[$row->id] = $row->name;
            }

            // Clear variable yang sudah selesai dipakai
            unset($row);
            unset($partners);
            unset($result);
            unset($switchingCustom);


            if(isset($decodeCollections[0])){
                $partner_name = "";
                if(isset($partner_name_dicts[$decodeCollections[0]->partnerId])){
                    $partner_name = $partner_name_dicts[$decodeCollections[0]->partnerId];
                }
                $collection_partners[] = [
                    'partner'=>ucwords($partner_name),
                    'text' => 'Primary'
                ];           
            }
            unset($decodeCollections[0]);
            if(count($decodeCollections) > 0){
                $number = 1;
                foreach($decodeCollections as $row){
                    $partner_name = "";
                    if(isset($partner_name_dicts[$row->partnerId])){
                        $partner_name = $partner_name_dicts[$row->partnerId];
                    }
                    $collection_partners[] = [
                        'partner' => $partner_name,
                        'text' => 'Alternative '.$number
                    ];
                    $number++;
                }
            }
              
        }
        $response = [
            'id' => $customId,
            'data' =>$collection_partners
        ];
        return response()->json($response);
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
    
}
