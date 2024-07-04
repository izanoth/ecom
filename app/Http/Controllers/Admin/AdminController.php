<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->put('name', $request->get('name'));
            return redirect()->route('admin.panel');
        }

        return back()->withErrors([
            'error' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->withInput();
    }

    public function create() 
    {
        return view('admin.create');
    }

    public function store(Request $request) 
    {
        try {
            $Admin = Admin::create($request->all());
            $Admin->save();
            return view('admin.create')->with([
                'message' => 'Admin created successfully!'
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function Admins()
    {

    }

    /*public function sessions()
    {
        $sessionKeys = Redis::keys('*laravel:session:*');
        $sessions = [];
        foreach ($sessionKeys as $key) {
            $sessionData = Redis::get($key);
            $sessionData = json_decode($sessionData, true);
            $sessions[] = $sessionData;
        }
        return view('admin.sessions', ['visits' => Redis::get('visits'), 'sessions' => $sessions]);
    }*/

    public function hasher(Request $request)
    {
        if ($request->get('password') === null) {
            return view('admin.hasher');
        } else {
            $password = $request->get('password');
            $hashedPassword = Hash::make($password);
            return view('admin.hasher')->with(['hash' => $hashedPassword]);
        }
    }

    public function panel()
    {
        $users = User::all();
        return view('admin.panel')->with([
            'users' => $users,
        ]);
    }
    public function telescope()
    {
        return view('admin.telescope');
    }


    public function logout()
    {
        Session::flush();
        Session::regenerate(true);
        return redirect()->route('admin.index');
    }
}