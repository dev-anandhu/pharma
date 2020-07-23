<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Http\Requests\Employee\EmployeeRequest;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the Employee index page or get Employee datatable
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('type',3)->has('user_department')->with('user_department')->latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('first_name', function($row){
                        return $row->first_name.' '.$row->last_name;
                    })
                    ->editColumn('status', function($row){
                        if($row->status){
                            return '<a href="javascript:void(0)" class="status btn btn-success btn-sm" data-id="'.$row->id.'">Active</a>';
                        }
                        return '<a href="javascript:void(0)" class="status btn btn-danger btn-sm" data-id="'.$row->id.'">Not active</a>';
                    })
                    ->editColumn('department', function($row){ 
                        return $row->user_department->name;
                    })
                    ->addColumn('action', function($row){
                        $url = URL('employee/add').'/'.$row->id;
                        return '<a href="'.$url.'" class="edit btn btn-info btn-sm" >Edit</a>
                                <a href="javascript:void(0)" class="delete btn btn-primary btn-sm" data-id="'.$row->id.'">Delete</a>';
                    })
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
        return view('admin.employee.list');
    }

    /**
     * delete a employee
     * @return Response
     */
    public function delete($id,Request $request){
        if ($request->ajax()) {
            $data = User::where('type','!=',1)->find($id);
            if($data){
                $data->delete();
                return response()->json(['message' =>'User deleted successfuly'], 200);
            }else{
                return response()->json(['message' =>'User not found'], 404);
            }
        }
    }

    /**
     * change a employee status
     * @return Response
     */
    public function status($id,Request $request){
        if ($request->ajax()) {
            $data = User::where('type',3)->find($id);
            if($data){
                $data->status = !$data->status;
                $data->save();
                return response()->json(['message' =>'User status changed successfuly'], 200);
            }else{
                return response()->json(['message' =>'User not found'], 404);
            }
        }
    }

    /**
     * add employee
     * @return View
     */
    public function add($id = NULL){
        if($id != NULL){
            $user = User::where('type','!=',1)->find($id); 
            if($user == null){
                return redirect()->route('employees');
            }
            $data['user'] = $user;
            $data['title'] = 'Edit ';
        }else{
            $data['user'] = new User();
            $data['title'] = 'Add ';
        }
        $data['departments'] = Department::all();
        $data['userType'] = array( "1" => 'Admin', "2" => 'Department Head' , '3' => "Employee" );
        return view('admin.employee.add')->with($data);
    }

    /**
     * employee add or update
     * @return Response
     */
    public function request(EmployeeRequest $request){
        if ($request->ajax()) {
            $data = $request->except('_token','id','password');
            if($request->id){
                if($request->password){
                    $data['password'] = Hash::make($request->password);
                }
                $user = User::find($request->id);
                if($user == null){
                    return response()->json(['message' =>'User not found'], 404);
                }
                $user->update($data);
                return response()->json(['message' =>'User updated successfuly'], 200);
            }else{
                $data['password'] = Hash::make($request->password);
                $data['created_at'] = date('Y-m-d H:i:s');
                User::insert($data);
                return response()->json(['message' =>'User created successfuly'], 200);
            }
        }
    }
}
