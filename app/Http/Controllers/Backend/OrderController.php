<?php

namespace App\Http\Controllers\Backend;

use PDO;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Helpers\ServiceFieldMap;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {

        $serviceGroups = [
            'biometric' => [7, 8, 9, 10],
            'passport' => [12, 13, 14],
            'sms' => [16, 17, 18],
            'imei' => [19, 20, 21, 22, 23, 24],
            'nagad' => [25, 26, 27, 28, 29, 30],
            'register' => [35, 36, 37, 38],
            'statement' => [39, 40],
        ];

        $stats = [];

        foreach ($serviceGroups as $key => $ids) {
            $idsString = implode(',', $ids);
            $stats[$key] = DB::selectOne("SELECT COUNT(*) AS total, SUM(CASE WHEN status IN ('completed', 'cancelled') THEN 1 ELSE 0 END) AS completed,  SUM(CASE WHEN notified = 0 THEN 1 ELSE 0 END) AS new FROM orders WHERE service_id IN ($idsString)AND DATE(created_at) = CURDATE() ");
        }

        // Optional: For unused service IDs
        $usedIds = collect($serviceGroups)->flatten()->toArray();
        $otherServices = Service::whereNotIn('id', $usedIds)
            ->withCount([
                'orders as total' => fn($q) => $q->whereDate('created_at', today()),
                'orders as completed' => fn($q) => $q->whereIn('status', ['completed', 'cancelled'])->whereDate('created_at', today()),
                'orders as new' => fn($q) => $q->where('notified', 0)->whereDate('created_at', today()),
            ])
            ->get();

        return view('Backend.order', [
            'biometric' => $stats['biometric'],
            'passport' => $stats['passport'],
            'sms' => $stats['sms'],
            'imei' => $stats['imei'],
            'nagad' => $stats['nagad'],
            'register' => $stats['register'],
            'statement' => $stats['statement'],
            'otherServices' => $otherServices,
        ]);
    }
    public function show($id)
    {
        if ($id == 11) {
            return $this->lostNidShow();
        }
        $service = Service::findOrFail($id);

        $defaultFields = ['id', 'slug', 'status', 'cost', 'created_at',  'service_id', 'downloaded_info'];
        $extraFields = array_keys(ServiceFieldMap::fields()[$service->id] ?? []);

        $selectFields = array_merge($defaultFields, $extraFields);

        $orders = $service->orders()
            ->select($selectFields)
            ->orderByDesc('created_at')
            ->paginate(20);
        if ($service->orders()->where('notified', 0)->count() > 0) {
            $service->orders()->update(['notified' => 1]);
        }
        // $service->orders()->update(['notified' => 1]);
        return view('Backend.order_details', [
            'service' => $service,
            'orders' => $orders
        ]);
    }
    public function admin_status_update(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->status;
        $order->save();
        if ($order->status == 'cancelled') {
            $user = $order->user;
            $user->amount = $user->amount + $order->cost;
            $user->save();
            if ($order->downloaded_file) {
                $file_path = public_path('upload/' . $order->downloaded_file);
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }

        notyf()->position('x', 'right')->position('y', 'top')->success('Order Status Updated');
        return back();
    }
    public function admin_file(Request $request)
    {

        $order = Order::find($request->order_id);
        if ($request->data) {
            $order->downloaded_info = $request->data;
            $order->save();
            notyf()->position('x', 'right')->position('y', 'top')->success('Uploaded Successfully');
        } else {
            $extension = $request->file('downloaded_file')->getClientOriginalExtension();
            $name = 'order_' . $order->slug . '.' . $extension;
            if ($order->downloaded_file == null) {
                $request->file('downloaded_file')->move(public_path('upload'), $name);
                $order->downloaded_file = $name;
                $order->save();
                notyf()->position('x', 'right')->position('y', 'top')->success('File Uploaded Successfully');
            } else {
                $path = public_path('upload/' . $order->downloaded_file);
                if (file_exists($path)) {
                    unlink($path);
                }
                $request->file('downloaded_file')->move(public_path('upload'), $name);
                $order->downloaded_file = $name;
                $order->save();

                notyf()->position('x', 'right')->position('y', 'top')->success('File Overwrited Successfully');
            }
        }

        return back();
    }

    public function biometric_show()
    {
        $robi_airtel = Service::find(7);
        $banglalink = Service::find(8);
        $teletalk = Service::find(9);
        $grameenphone = Service::find(10);
        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [7, 8, 9, 10]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        dd($orders);
        return view('Backend.pages.biometric_details', [
            'robi_airtel' => $robi_airtel,
            'banglalink' => $banglalink,
            'teletalk' => $teletalk,
            'grameenphone' => $grameenphone,
            'orders' => $orders
        ]);
    }

    public function passport_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [12, 13, 14]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.passport_details', [

            'orders' => $orders
        ]);
    }
    public function lostNidShow()
    {
        $lost_nid = Service::find(11);
        $orders = Order::where('user_id', auth()->user()->id)
            ->where('service_id', 11)
            ->select(['id', 'slug', 'status', 'cost', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);
        return view('Backend.pages.lost_nid_details', [
            'lost_nid' => $lost_nid,
            'orders' => $orders
        ]);
    }
    public function sms_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [16, 17, 18]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.sms_details', [

            'orders' => $orders
        ]);
    }
    public function imei_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [19, 20, 21, 22, 23, 24]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_info', 'created_at', 'service_id'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.imei_details', [

            'orders' => $orders
        ]);
    }
    public function nagad_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [25, 26, 27, 28, 29, 30]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_info', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.nagadBikash_details', [

            'orders' => $orders
        ]);
    }
    public function register_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [35, 36, 37, 38]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'description', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.register_details', [

            'orders' => $orders
        ]);
    }
    public function statement_show()
    {

        $query = Order::where('user_id', auth()->user()->id)
            ->whereIn('service_id', [39, 40]);

        $checkQuery = clone $query;

        if ($checkQuery->where('notified', 0)->count() > 0) {
            $query->update(['notified' => 1]);
        }

        $orders = $query
            ->select(['id', 'slug', 'status', 'cost', 'type', 'type_number', 'downloaded_file', 'created_at'])
            ->orderByDesc('created_at')
            ->paginate(20);

        // dd($orders);
        return view('Backend.pages.statement_details', [

            'orders' => $orders
        ]);
    }
    public function showOrderBySlug(Request $request)
    {

        $order = Order::where('slug', $request->slug)->get()->first();
        if(!$order){
            notyf()->position('x', 'right')->position('y', 'top')->error('Order Not Found');
            return back();
        }
        // Define grouped service IDs

        $biometric = [7, 8, 9, 10];
        $passport = [12, 13, 14];
        $sms = [16, 17, 18];
        $imei = [19, 20, 21, 22, 23, 24];
        $nagad = [25, 26, 27, 28, 29, 30];
        $register = [35, 36, 37, 38];
        $statement = [39, 40];


        // Redirect logic based on group
        if (in_array($order->service_id, $biometric)) {
            return $this->biometric_show();
        } elseif (in_array($order->service_id, $passport)) {
            return $this->passport_show();
        } elseif (in_array($order->service_id, $sms)) {
            return $this->sms_show();
        } elseif (in_array($order->service_id, $imei)) {
            return $this->imei_show();
        } elseif (in_array($order->service_id, $nagad)) {
            return $this->nagad_show();
        } elseif (in_array($order->service_id, $register)) {
            return $this->register_show();
        } elseif (in_array($order->service_id, $statement)) {
            return $this->statement_show();
        } else {
            return redirect()->route('admin_order_details', $order->id);
        }
    }
}
