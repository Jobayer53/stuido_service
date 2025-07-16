<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
        public function admin_service_index(){
        $services = Service::all();
        return view('Backend.service',[
            'services' => $services
        ]);
    }
    public function admin_service_update(Request $request){
       $validator = Validator::make($request->all(), [
           'status' => 'required',
           'cost' => 'required',
       ]);

       if ($validator->fails()) {
           notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
           return back();
       }
       $service = Service::find($request->id);
       $service->available = $request->status;
       $service->cost = $request->cost;
       $service->save();
       notyf()->position('x', 'right')->position('y', 'top')->success($service->name.' Updated Successfully');
       return back();
    }

    //frontend service code
    public function serverCopyIndex(){
        $server_copy = Service::find(1);
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $server_copy->id)
            ->select(['id','slug', 'status', 'cost', 'nid_number', 'dob', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.server_copy',[
            'server_copy' => $server_copy,
            'orders' => $orders
        ]);
    }
    public function signCopyIndex(){
        $sign_copy = Service::find(2);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $sign_copy->id)
            ->select(['id','slug', 'status', 'cost','type','type_name', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.sign_copy',[
            'sign_copy' => $sign_copy,
            'orders' => $orders
        ]);
    }
    public function nidPdfIndex(){
        $nidPdf = Service::find(3);
        $smrt_nidPdf = Service::find(4);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $nidPdf->id)
            ->orWhere('service_id', $smrt_nidPdf->id)
            ->select(['id','slug', 'status', 'cost','type','type_name', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.nid_pdf',[
            'nid_pdf' => $nidPdf,
            'smrt_nidPdf' => $smrt_nidPdf,
            'orders' => $orders
        ]);
    }
    public function nidUserPassIndex(){
        $nidPass = Service::find(5);
        $nidform = Service::find(6);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $nidPass->id)
            ->orWhere('service_id', $nidform->id)
            ->select(['id','slug', 'status', 'cost','type','description', 'downloaded_file','downloaded_info',  'created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.nid_user_pass',[
       'nid_pass' => $nidPass,
            'nidform' => $nidform,
            'orders' => $orders
        ]);
    }
    public function biometricIndex(){
        $robi_airtel = Service::find(7);
        $banglalink = Service::find(8);
        $teletalk = Service::find(9);
        $grameenphone = Service::find(10);
        $available = true;
        if($robi_airtel->available == false && $banglalink->available == false && $teletalk->available == false && $grameenphone->available == false){
            $available = false;
        }
       $orders = Order::where('user_id', auth()->user()->id)
    ->whereIn('service_id', [7, 8, 9, 10])
    ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
    ->orderByDesc('created_at')
    ->take(10)
    ->get();

        // dd($orders);
        return view('frontend.pages.biometric',[
            'orders' => $orders,
            'available' => $available,
            'robi_airtel' => $robi_airtel,
            'banglalink' => $banglalink,
            'teletalk' => $teletalk,
            'grameenphone' => $grameenphone
        ]);
    }
    public function lostNidIndex(){
        $lost_nid = Service::find(11);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $lost_nid->id)
            ->select(['id','slug', 'status', 'cost','type','description', 'downloaded_file','downloaded_info',  'created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.lost_nid',[
            'lost_nid' => $lost_nid,
            'orders' => $orders
        ]);
    }
    public function passportIndex(){
        $ePass = Service::find(12);
        $mrp = Service::find(13);
        $server_copy = Service::find(14);
        $available = true;
        if($ePass->available == false && $MRP->available == false && $server_copy->available == false){
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [12, 13, 14])
            ->select(['id','slug', 'status', 'cost','type','description', 'downloaded_file','created_at'])
            ->orderByDesc('created_at')
            ->take(10) // limit to 10 latest orders
            ->get();
        // dd($orders);
        return view('frontend.pages.passport',[
            'ePass' => $ePass,
            'mrp' => $mrp,
            'server_copy' => $server_copy,
            'available' => $available,
            'orders' => $orders
        ]);
    }


}
