<?php

namespace App\Http\Controllers\Backend;

use PDO;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('Backend.index');
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
        if($admin){
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
    public function admin_user_index(){
        $users = User::paginate(40);
        $total = User::count();
        return view('Backend.user',[
            'users' => $users,
            'total' => $total
        ]);
    }
}
