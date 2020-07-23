<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Report;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->type == 1){
            $data['department'] = Department::count();
            $data['employees'] = User::where('type',3)->where('status',1)->count();
            $data['new_employees'] = User::where('type',3)->where('status',0)->count();
            $data['reports'] = 0;
            return view('admin.home')->with($data);
        }else if($user->type == 2){
            $data['user'] = User::where('id',$user->id)->has('user_department')->with('user_department')->first(); 
            $data['count'] = User::where('type',3)->where('department',$user->department)->count();
            $data['verificationReports'] = Report::where('department_id',$user->department)->where('status',0)->count();
            return view('department.index')->with($data);
        }else{ 
            $data['user'] = User::where('id',$user->id)->has('user_department')->with('user_department')->first(); 
            $now = Carbon::now();
            $start =  $now->startOfWeek()->addDay(0)->format('Y-m-d');
            $end =  $now->startOfWeek()->addDay(6)->format('Y-m-d');
            $data['week'] = $start .' to '.$end;
            $data['count'] = Report::where('user_id',$user->id)->whereBetween('created_at',[ $start .' 00:00:00', $end.' 23:59:59' ])->count();
            
            return view('user.index')->with($data);
        }
    }
}
