<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //

    public function __construct()
    {
    }
    public function index()
    {

        if (Auth::check()) {
            if (Auth::user()->role_id != 1)
                return abort(403);
        }

        $users_type = DB::table('user_types')->select('user_types_id as id', 'user_types_name as name')->get();
        $admins = User::where('role_id', 1)->get();
        $data_entry = User::where('role_id', 13)->get();
        $vendors = User::where('role_id', 3)->get();
        return view('dashboard.users.index')->with([
            'users_type' => $users_type,
            'admins' => $admins,
            'data_entry' => $data_entry,

            'vendors' => $vendors
        ]);
    }
    public function index_user(Request $request)
    {

        $users_type = DB::table('user_types')->where('user_types_id', $request->type)->select('user_types_id as id', 'user_types_name as name')->get();
        $admins = User::where('role_id', $request->type)->get();
        $jobs = Job::get();
        return view('dashboard.users.users')->with([
            'users_type' => $users_type,
            'admins' => $admins,
            'jobs' => $jobs,
        ]);
    }

    public function edit(User $user)
    {
        $jobs = Job::get();
        return view('dashboard.users.edit')->with(['user' => $user,  'jobs' => $jobs,]);
    }

    public function update_user(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            // 'first_name' => ['required', 'string'],
            // 'last_name' => ['required', 'string'],
            'email' => ['required', 'unique:users,email,' . Auth::id()],
            //'password' => ['required', 'string', 'min:8'],
            //'confirm_password' => ['same:password'],
            'phone' => ['required', 'numeric'],
            'avatar' => ['nullable', 'image'],

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        $id = Auth::id();
        $user = User::where('id', $id)->first();
        $user->update([
            'name' => $request->name,
            // 'first_name' => $request->first_name,
            // 'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => ($request->has('avatar')) ? $request->avatar : env('APP_URL') . '/profile.png',
        ]);
        //dd($user);
        return back()->with('success', '  success!! ');
    }

    public function update_user2(Request $request)
    {
        $rules = [
            'name' => ['required', 'string'],
            // 'first_name' => ['required', 'string'],
            // 'last_name' => ['required', 'string'],
            'email' => ['nullable', 'unique:users,email,' . $request->id],
            // 'password' => ['required', 'string', 'min:8'],
            //'confirm_password' => ['same:password'],
            'phone' => ['required', 'numeric', 'unique:users,phone,' . $request->id],

            'avatar' => ['nullable', 'image'],
            // 'last_name' => ['required', 'string'],

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        // $id = Auth::id();
        $user = User::where('id', $request->id)->first();
        $user->update([
            'name' => $request->name,
            // 'first_name' => $request->first_name,
            // 'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'avatar' => ($request->has('avatar')) ? $request->avatar : env('APP_URL') . '/profile.png',
        ]);
        if ($user->role_id == 4) {
            $user->jobs()->sync($request->job);
            // foreach ($request->job as $key => $value) {
            //     $user->jobs()->attach($value);
            //     $user->save();
            // }
        }
        //dd($user);
        return back()->with('success', '  success!! ');
    }
    public function index1()
    {

        if (Auth::check()) {
            if (Auth::user()->role_id != 1)
                return abort(403);
        }
        $users_type = DB::table('user_types')->whereIn('user_types_id', [1, 13, 2])->select('user_types_id as id', 'user_types_name as name')->get();
        $admins = User::where('role_id', 2)->get();
        $data_entry = User::where('role_id', 13)->get();
        return view('dashboard.clients')->with([
            'users_type' => $users_type,
            'admins' => $admins,
            'data_entry' => $data_entry
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        if (Auth::check()) {
            if (Auth::user()->role_id != 1)
                return abort(403);
        }
        // dd($request->all());
        //validate request
        //rules

        $rules = [
            'name' => ['required', 'string'],
            'avatar' => ['nullable', 'image'],
            // 'last_name' => ['required', 'string'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:password'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'role' => ['required'],
        ];

        //messages


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //end of validating request



        $user = User::create([
            'name' => $request->name,
            'avatar' => ($request->has('avatar')) ? $request->avatar : env('APP_URL') . '/profile.png',
            // 'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => $request->role,
            'default_address_id' => 1,

        ]);

        if ($request->role == 4) {
            $user->jobs()->sync($request->job);
            // foreach ($request->job as $key => $value) {
            //     $user->jobs()->attach($value);
            //     $user->save();
            // }
        }

        // $user->name = $user->id . $user->name;
        // $user->save();

        return redirect()->back()->with('success', 'Success');
    }
    public function update(User $user, Request $request)
    {
        //  if (Auth::check()) {
        //     if (Auth::user()->role_id != 1)
        //         return abort(403);
        // }

        // $validator = Validator::make($request->all(), [
        //     'role' => [
        //         'required',
        //         Rule::in(['1', '2', '13']),
        //     ],
        // ]);
        // if ($validator->fails())
        //     return back()->with('error', 'نمط المستخدم المختار غير صالح');
        //dd($request->all());
        $user = User::where('id', $request->id)->first();
        $user->update([
            'is_active' => $request->val
        ]);
        //dd($user);
        return back()->with('success', 'تم تعديل المستخدم بنجاح');
    }

    //////////


    public function index1_POS()
    {

        if (Auth::check()) {
            if (Auth::user()->role_id != 1)
                return abort(403);
        }
        $users_type = DB::table('user_types')->whereIn('user_types_id', [1, 13, 2])->select('user_types_id as id', 'user_types_name as name')->get();
        $admins = User::where('role_id', 2)->get();
        $data_entry = User::where('role_id', 13)->get();
        return view('dashboard.clients')->with([
            'users_type' => $users_type,
            'admins' => $admins,
            'data_entry' => $data_entry
        ]);
    }

    public function store_POS(Request $request)
    {
        //  if (Auth::check()) {
        //     if (Auth::user()->role_id != 1)
        //         return abort(403);
        // }
        // dd($request->all());
        //validate request
        //rules

        $rules = [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:password'],
            'phone' => ['required', 'numeric'],
            'role' => ['required'],
        ];

        //messages
        $messages = [
            'first_name.required' => 'required',
            'last_name.required' => 'required',
            'email.required' => 'required',
            'password.required' => 'required',
            'phone.required' => 'required',
            'phone.numeric' => 'رقم الهاتف غير صالح',
            'address.required' => 'required',
            'confirm_password.same' => 'No password match',
            'image.image' => 'يمكن رفع صور فقط ',
            'email.unique' => 'email must be unique',
            'password.min' => 'password must be more than 8 letters',
            'role.*' => '   required ',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //end of validating request



        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => $request->role

        ]);

        $user->name = $user->id . $user->first_name;
        $user->save();

        return redirect()->back()->with('success', 'Success');
    }
    public function update_POS(User $user, Request $request)
    {
        //  if (Auth::check()) {
        //     if (Auth::user()->role_id != 1)
        //         return abort(403);
        // }

        // $validator = Validator::make($request->all(), [
        //     'role' => [
        //         'required',
        //         Rule::in(['1', '2', '13']),
        //     ],
        // ]);
        // if ($validator->fails())
        //     return back()->with('error', 'نمط المستخدم المختار غير صالح');
        //dd($request->all());
        $user = User::where('id', $request->id)->first();
        $user->update([
            'status' => $request->val
        ]);
        //dd($user);
        return back()->with('success', 'Success');
    }
    public function update2_POS(User $user, Request $request)
    {
        //  if (Auth::check()) {
        //     if (Auth::user()->role_id != 1)
        //         return abort(403);
        // }

        $validator = Validator::make($request->all(), [
            'role' => [
                'required',
                Rule::in(['1', '2', '13']),
            ],
        ]);
        if ($validator->fails())
            return redirect()->back()->with('error', 'نمط المستخدم المختار غير صالح');
        //dd($request->all());
        $user->update([
            'role_id' => $request->role
        ]);
        //dd($user);
        return redirect()->back()->with('success', 'تم تعديل المستخدم بنجاح');
    }
}
