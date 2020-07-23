<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Http\Requests\Report\AddReportRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
     /**
     * Show report adding page
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $now = Carbon::now();
        $start =  $now->startOfWeek()->addDay(0)->format('Y-m-d');
        $end =  $now->startOfWeek()->addDay(6)->format('Y-m-d');
        $data['week'] = $start .' to '.$end;
        $data['count'] = Report::where('user_id',auth()->user()->id)->whereBetween('created_at',[ $start .' 00:00:00', $end.' 23:59:59' ])->count();
        return view('user.report-add')->with($data);
    }

    public function add(AddReportRequest $request){

        if($request->ajax()){ 

            $now = Carbon::now();
            $start =  $now->startOfWeek()->addDay(0)->format('Y-m-d');
            $end =  $now->startOfWeek()->addDay(6)->format('Y-m-d');
            if(Report::where('user_id',auth()->user()->id)->whereBetween('created_at',[ $start .' 00:00:00', $end.' 23:59:59' ])->count() > 0){
                return response()->json(['message' =>'weekly report already submited.'], 400);
            }

            $extension = $request->file('file')->getClientOriginalExtension(); 
            $file_name = auth()->user()->first_name.strtotime(now()); 
            $path = 'public/files/'.$file_name; 

            if(Storage::put($path,  File::get($request->file('file')))){
                $report = new Report();
                $report->file = $file_name.'.'.$extension; 
                $report->description = $request->description; 
                $report->user_id = auth()->user()->id;
                $report->department_id = auth()->user()->department;
                $report->save();
                return response()->json(['message' =>'Report submited successfuly'], 200);
            }else{
                return response()->json(['message' =>'Something went wrong'], 400);
            }
        }

    }

    /**
     * Show report list to employee
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function list(Request $request){
        if ($request->ajax()) {
            $data = Report::where('user_id',auth()->user()->id)->latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('first_name', function($row){
                        return $row->first_name.' '.$row->last_name;
                    })->editColumn('status', function($row){
                        if($row->status){
                            return 'Verified';
                        }
                        return 'Not Verified';
                    })->editColumn('created_at', function($row){
                        return date('Y-m-d H:i:s', strtotime($row->created_at) );
                    })->addColumn('week', function($row){ 
                        $now = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
                        $start =  $now->startOfWeek()->addDay(0)->format('Y-m-d');
                        $end =  $now->startOfWeek()->addDay(6)->format('Y-m-d');
                        return $start .' to '.$end;
                    })->make(true);
        }
        return view('user.report-list');
    }

}
