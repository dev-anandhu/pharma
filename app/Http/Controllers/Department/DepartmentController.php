<?php

namespace App\Http\Controllers\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Http\Requests\Department\AddDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Show the department index page or get department datatable
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return '<a href="javascript:void(0)" class="delete btn btn-primary btn-sm" data-id="'.$row->id.'">Delete</a>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.department.list');
    }

    /**
     * Show the department name and user name
     *
     * @return Datable response
     */
    public function heads(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('type',2)->has('user_department')->with('user_department')->latest()->get();
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
        return view('admin.department.head-list');
    }

    /**
     * delete from departments table
     * @return Response
     */
    public function delete($id,Request $request){
        if ($request->ajax()) {
            $data = Department::find($id);
            if($data){
                $data->delete();
                return response()->json(['message' =>'Department deleted successfuly'], 200);
            }else{
                return response()->json(['message' =>'Department not found'], 404);
            }
        }
    }

    /**
     * add department
     * @return Response
     */
    public function add(AddDepartmentRequest $request){
        if ($request->ajax()) {
            $data = Department::insert($request->except('_token'));
            return response()->json(['message' =>'Department created successfuly'], 200);
        }
    }
}
