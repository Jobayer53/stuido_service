<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Laravel\Ui\Presets\React;

class ServiceController extends Controller
{
    public function admin_service_index()
    {
        $activeCount = Service::where('available', 1)->count();
        $totalServices = Service::count();
        $nextAction = ($activeCount >= ($totalServices / 2)) ? 'Deactivate' : 'Activate';
        $services = Service::all();
        return view('Backend.service', [
            'services' => $services,
            'status' => $nextAction
        ]);
    }
    public function admin_service_update(Request $request)
    {
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
        notyf()->position('x', 'right')->position('y', 'top')->success($service->name . ' Updated Successfully');
        return back();
    }
    public function toggleStatus(Request $request)
    {
        if($request->status == 'Deactivate'){
             Service::query()->update(['available' => 0]);
             notyf()->position('x', 'right')->position('y', 'top')->success('All services deactivated');
        }
        else{
            Service::query()->update(['available' => 1]);
            notyf()->position('x', 'right')->position('y', 'top')->success('All services activated');
        }



        return back();
    }

    //frontend service code
    public function serverCopyIndex()
    {
        $server_copy = Service::find(1);
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $server_copy->id)
            ->select(['id', 'slug', 'status', 'cost', 'nid_number', 'dob', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.server_copy', [
            'server_copy' => $server_copy,
            'orders' => $orders
        ]);
    }
    public function signCopyIndex()
    {
        $sign_copy = Service::find(2);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $sign_copy->id)
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_name', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.sign_copy', [
            'sign_copy' => $sign_copy,
            'orders' => $orders
        ]);
    }
    public function nidPdfIndex()
    {
        $nidPdf = Service::find(3);
        $smrt_nidPdf = Service::find(4);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $nidPdf->id)
            ->orWhere('service_id', $smrt_nidPdf->id)
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_name', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.nid_pdf', [
            'nid_pdf' => $nidPdf,
            'smrt_nidPdf' => $smrt_nidPdf,
            'orders' => $orders
        ]);
    }
    public function nidUserPassIndex()
    {
        $nidPass = Service::find(5);
        $nidform = Service::find(6);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $nidPass->id)
            ->orWhere('service_id', $nidform->id)
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'downloaded_info',  'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.nid_user_pass', [
            'nid_pass' => $nidPass,
            'nidform' => $nidform,
            'orders' => $orders
        ]);
    }
    public function biometricIndex()
    {
        $robi_airtel = Service::find(7);
        $banglalink = Service::find(8);
        $teletalk = Service::find(9);
        $grameenphone = Service::find(10);
        $available = true;
        if ($robi_airtel->available == false && $banglalink->available == false && $teletalk->available == false && $grameenphone->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [7, 8, 9, 10])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);


        // dd($orders);
        return view('frontend.pages.biometric', [
            'orders' => $orders,
            'available' => $available,
            'robi_airtel' => $robi_airtel,
            'banglalink' => $banglalink,
            'teletalk' => $teletalk,
            'grameenphone' => $grameenphone
        ]);
    }
    public function lostNidIndex()
    {
        $lost_nid = Service::find(11);

        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $lost_nid->id)
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'downloaded_info',  'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.lost_nid', [
            'lost_nid' => $lost_nid,
            'orders' => $orders
        ]);
    }
    public function passportIndex()
    {
        $ePass = Service::find(12);
        $mrp = Service::find(13);
        $server_copy = Service::find(14);
        $available = true;
        if ($ePass->available == false && $mrp->available == false && $server_copy->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [12, 13, 14])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.passport', [
            'ePass' => $ePass,
            'mrp' => $mrp,
            'server_copy' => $server_copy,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function locationIndex()
    {
        $location = Service::find(15);
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $location->id)
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.location', [
            'location' => $location,
            'orders' => $orders
        ]);
    }

    public function smsIndex()
    {
        $call_list = Service::find(16);
        $sms_gp = Service::find(17);
        $sms_banglalink = Service::find(18);
        $available = true;
        if ($call_list->available == false && $sms_gp->available == false && $sms_banglalink->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [16, 17, 18])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.sms', [
            'call_list' => $call_list,
            'sms_gp' => $sms_gp,
            'sms_banglalink' => $sms_banglalink,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function imeiIndex()
    {
        $imei = Service::find(19);
        $nid_to_number = Service::find(20);
        $num_to_imei = Service::find(21);
        $nid_to_gp = Service::find(22);
        $nid_to_banglalink = Service::find(23);
        $all = Service::find(24);
        $available = true;
        if ($imei->available == false && $nid_to_number->available == false && $num_to_imei->available == false && $nid_to_gp->available == false && $nid_to_banglalink->available == false && $all->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [19, 20, 21, 22, 23, 24])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_info', 'created_at', 'service_id'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.imei', [
            'imei' => $imei,
            'nid_to_number' => $nid_to_number,
            'num_to_imei' => $num_to_imei,
            'nid_to_gp' => $nid_to_gp,
            'nid_to_banglalink' => $nid_to_banglalink,
            'all' => $all,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function nagadIndex()
    {
        $nagad_info = Service::find(25);
        $b_personal = Service::find(26);
        $rocket_info = Service::find(27);
        $nagadP_3mnth = Service::find(28);
        $b_merchant = Service::find(29);
        $b_agent = Service::find(30);
        $available = true;
        if ($nagad_info->available == false && $b_personal->available == false && $rocket_info->available == false && $nagadP_3mnth->available == false && $b_merchant->available == false && $b_agent->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [25, 26, 27, 28, 29, 30])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.nagadBikash', [
            'nagad_info' => $nagad_info,
            'b_personal' => $b_personal,
            'rocket_info' => $rocket_info,
            'nagadP_3mnth' => $nagadP_3mnth,
            'b_merchant' => $b_merchant,
            'b_agent' => $b_agent,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function tinIndex()
    {
        $zero_return = Service::find(32);
        $tin_certificate = Service::find(33);
        $available = true;
        if ($zero_return->available == false && $tin_certificate->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [32, 33])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.tin', [
            'zero_return' => $zero_return,
            'tin_certificate' => $tin_certificate,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function landIndex()
    {
        $land = Service::find(34);
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', $land->id)
            ->select(['id', 'slug', 'status', 'cost', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.land', [
            'land' => $land,
            'orders' => $orders
        ]);
    }
    public function registerIndex()
    {
        $bc_before = Service::find(35);
        $bc_after = Service::find(36);
        $bc_death = Service::find(37);
        $lost_bc = Service::find(38);
        $available = true;
        if ($bc_before->available == false && $bc_after->available == false && $bc_death->available == false && $lost_bc->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [35, 36, 37, 38])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.register', [
            'bc_before' => $bc_before,
            'bc_after' => $bc_after,
            'bc_death' => $bc_death,
            'lost_bc' => $lost_bc,

            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function statementIndex()
    {
        $rocket = Service::find(39);
        $nagad = Service::find(40);
        $available = true;
        if ($rocket->available == false && $nagad->available == false) {
            $available = false;
        }
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [39, 40])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.statement', [
            'rocket' => $rocket,
            'nagad' => $nagad,
            'available' => $available,
            'orders' => $orders
        ]);
    }
    public function vaccineIndex()
    {
        $vaccine = Service::find(41);
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [41])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.vaccine', [
            'vaccine' => $vaccine,
            'orders' => $orders
        ]);
    }
    public function bc_changeIndex()
    {
        $bc_change = Service::find(42);
        $orders = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [42])
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'dob', 'description', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20); // limit to 10 latest orders

        // dd($orders);
        return view('frontend.pages.bc_change', [
            'bc_change' => $bc_change,
            'orders' => $orders
        ]);
    }
}
