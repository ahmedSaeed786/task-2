<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\customer;
use App\Models\order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class userController extends Controller
{


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back();
    }
    public function index()
    {

        $user = User::count('id');
        $customer = customer::count('id');
        $orderDetail = customer::withSum('item', 'total')->orderBy('id', 'desc')->with('item')->get();
        $total = order::sum('total');
        $saleItem = order::count('id');
        $userDetail = User::orderBy('id', 'desc')->get();

        // return $user;
        return view('pages.dashboard', compact('user', 'total', 'customer', 'saleItem', 'userDetail', 'orderDetail'));
    }
    public function validateField(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique::users,email',
            'password' => 'min:6|required_with:repeat_password|same:repeat_password',
            'repeat_password' => 'required',

        ];

        $field = $request->field;

        if (!isset($rules[$field])) {
            return response()->json(['success' => true]);
        }

        $validator = Validator::make(
            [$field => $request->value],
            [$field => $rules[$field]]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first($field)
            ], 422);
        }

        return response()->json(['success' => true]);
    }
    public function UserDetail()
    {
        $userDetail = User::orderBy('id', 'desc')->get();
        return view('pages.user.user', compact('userDetail'));
    }
    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'min:6|required_with:repeat_password|same:repeat_password',
        ]);


        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),

        ]);
        return back()->with('msg', 'User Add Successfully!');
    }

    public function destroy(Request $request)
    {

        // return $request->all();
        user::where('id', $request->id)->delete();

        return back();
    }
    public function show(Request $request)
    {

        // return $request->all();
        $user = user::where('id', $request->id)->first();

        return view('pages.user.userEdit', compact('user'));
    }
    public function update(Request $request)
    {

        // return $request->all();
        if ($request->password != null) {
            # code...

            $user = user::where('id', $request->id)->update(
                [
                    "name" => $request->name,
                    "email" => $request->email,
                    "password" => Hash::make($request->password),

                ]
            );
        } else {
            $user = user::where('id', $request->id)->update(
                [
                    "name" => $request->name,
                    "email" => $request->email,


                ]
            );
        }
        return Redirect('user_detail')->with('msg', 'User Updated Successfully!');
    }
    public function logout()
    {


        Auth::logout();
        return Redirect('login');
    }
    //
}
