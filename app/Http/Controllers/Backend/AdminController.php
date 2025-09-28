<?php

namespace App\Http\Controllers\Backend;

use PDO;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $todays_amount = Order::whereDate('created_at', date('Y-m-d'))->where('status', '!=', 'cancelled')->sum('cost');
        $todays_totalOrder = Order::whereDate('created_at', date('Y-m-d'))->count();
        $todays_totalRecharge = Payment::whereDate('created_at', date('Y-m-d'))->sum('amount');
        $yesterdays_amount = Order::whereDate('created_at', date('Y-m-d', strtotime("-1 day")))->sum('cost');
        $yesterday_totalRecharge = Payment::whereDate('created_at', date('Y-m-d', strtotime("-1 day")))->sum('amount');
        $yesterday_totalOrder = Order::whereDate('created_at', date('Y-m-d', strtotime("-1 day")))->count();
        $yesterday = DB::table('orders')
            ->selectRaw("
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'canceled' THEN 1 ELSE 0 END) as canceled,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
        ")
            ->whereDate('created_at', date('Y-m-d', strtotime("-1 day")))
            ->first();

        if ($yesterdays_amount > 0) {
            $percentage_change = (($todays_amount - $yesterdays_amount) / $yesterdays_amount) * 100;
        } else {
            $percentage_change = $todays_amount > 0 ? 100 : 0;
        }
        $status = $percentage_change > 0 ? 'increase' : ($percentage_change < 0 ? 'decrease' : 'no change');
        $pending = Order::whereDate('created_at', date('Y-m-d'))->where('status', 'pending')->count();
        $cancelled = Order::whereDate('created_at', date('Y-m-d'))->where('status', 'cancelled')->count();
        $completed = Order::whereDate('created_at', date('Y-m-d'))->where('status', 'completed')->count();
        $topCustomers = User::withCount(['orders' => function ($query) {
            $query->whereDate('created_at', date('Y-m-d'));
        }])
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_count')
            ->take(4)
            ->get();
        $topCustomerYesterday = User::withCount(['orders' => function ($query) {
            $query->whereDate('created_at', date('Y-m-d', strtotime("-1 day")));
        }])
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_count')
            ->take(4)
            ->get();
        $topService = Service::withCount(['orders' => function ($query) {
            $query->whereDate('created_at', date('Y-m-d'));
        }])
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_count')
            ->take(4)
            ->get();
        $topServiceYesterday = Service::withCount(['orders' => function ($query) {
            $query->whereDate('created_at', date('Y-m-d', strtotime("-1 day")));
        }])
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_count')
            ->take(4)
            ->get();
        $serverCopy = Order::whereDate('created_at', date('Y-m-d'))->where('service_id', 47)->count();
        $signToNid = Order::whereDate('created_at', date('Y-m-d'))->where('service_id', 48)->count();
        $autoBC = Order::whereDate('created_at', date('Y-m-d'))->where('service_id', 49)->count();
        $tin = Order::whereDate('created_at', date('Y-m-d'))->where('service_id', 50)->count();
        $autoNid = Order::whereDate('created_at', date('Y-m-d'))->where('service_id', 51)->count();
        $apiTotal = $serverCopy + $signToNid + $autoBC + $tin + $autoNid;

        // dd($status. ' ' . $percentage_change);
        return view('Backend.index', [
            'todays_amount'            => $todays_amount,
            'todays_totalOrder'        => $todays_totalOrder,
            'percentage'               => $percentage_change,
            'status'                   => $status,
            'pending'                  => $pending,
            'cancelled'                => $cancelled,
            'completed'                => $completed,
            'topCustomers'             => $topCustomers,
            'topService'               => $topService,
            'todays_totalRecharge'     => $todays_totalRecharge,
            'yesterday_totalRecharge'  => $yesterday_totalRecharge,
            'yesterday_totalOrder'     => $yesterday_totalOrder,
            'yesterdays_amount'        => $yesterdays_amount,
            'yesterday'                => $yesterday,
            'topCustomerYesterday'     => $topCustomerYesterday,
            'topServiceYesterday'      => $topServiceYesterday,
            'serverCopy'               => $serverCopy,
            'signToNid'                => $signToNid,
            'autoBC'                   => $autoBC,
            'tin'                      => $tin,
            'autoNid'                  => $autoNid,
            'apiTotal'                 => $apiTotal
        ]);
    }
    public function admin_login()
    {
        return view('Backend.auth.login');
    }
    public function admin_login_check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            notyf()->position('x', 'right')->position('y', 'top')->success('Login Successfully');
            return redirect()->route('admin_index');
        }
        notyf()->position('x', 'right')->position('y', 'top')->error('Invalid Email or Password');
        return back();
    }
    public function admin_logout(Request $request)
    {
        Auth::guard('admin')->logout();
        notyf()->position('x', 'right')->position('y', 'top')->success('Logout Successfully');
        return redirect()->route('admin_login');
    }
    public function admin_register()
    {
        $admin = Admin::find(1);
        if ($admin) {
            return  redirect()->route('admin_login');
        }
        return view('Backend.auth.register');
    }
    public function admin_register_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('Account Created Successfully');
        return redirect()->route('admin_login');
    }
    public function admin_profile()
    {
        return view('Backend.profile');
    }
    public function admin_profile_update(request $request)
    {
        $user = auth()->guard('admin')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|required_with:old_password|string',

        ]);

        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return redirect()->back();
        }
        if ($request->old_password) {
            if (!Hash::check($request->old_password, $user->password)) {
                notyf()->position('x', 'right')->position('y', 'top')->error('The old password is incorrect.');
                return redirect()->back();
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('Profile Updated Successfully');
        return redirect()->back();
    }
    public function admin_user_index()
    {
        $activeCount = User::where('terminate', 1)->count();
        $totalUser = User::count();
        $nextAction = ($activeCount >= ($totalUser / 2)) ? 'Terminate' : 'Activate';
        $users = User::paginate(40);
        $total = User::count();
        return view('Backend.user', [
            'users' => $users,
            'total' => $total,
            'status' => $nextAction
        ]);
    }
    public function user_details($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $last_recharge = Payment::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $total_recharge = Payment::where('user_id', $user->id)->sum('amount');

        return view('Backend.user_details', [
            'user' => $user,
            'last_recharge' => $last_recharge,
            'total_recharge' => $total_recharge,

        ]);
    }
    public function user_terminate($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $user->terminate == 0 ? $user->terminate = 1 : $user->terminate = 0;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('User Terminate Successfully');
        return redirect()->back();
    }
    public function toggleStatus(Request $request)
    {

        if ($request->status == 'Terminate') {
            User::query()->update(['terminate' => 0]);
            notyf()->position('x', 'right')->position('y', 'top')->success('All Users Deactivated');
        } else {
            User::query()->update(['terminate' => 1]);
            notyf()->position('x', 'right')->position('y', 'top')->success('All Users activated');
        }
        return back();
    }
    public function payment()
    {
        $payments = Payment::orderBy('id', 'desc')->paginate(50);
        $total = Payment::sum('amount');
        $remaining = User::sum('amount');
        return view('Backend.payment', [
            'payments' => $payments,
            'total' => $total,
            'remaining' => $remaining
        ]);
    }
}
