<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{

    public function index(){
        $employee = Employee::all();
        return view('customer/index', ['employees'=>$employee]);
    }


    public function create($id = 0){
        $employee = ['id'=>'', 'name'=>'','email'=>'','address'=>'','mobile'=>''];
        if(!empty($id)) {
            $employee = Employee::find($id);
        }
        return view('customer/add',['employee'=>$employee]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'=>'required|max:20|alpha',
            'email'=>'required',
            'mobile'=>'required:integer|min:10|max:10',
            'address'=>'required',
        ]);
        $id = $request->input('id');
        if(empty($id)) {
            Employee::create(request()->except(['_token']));
            return redirect('/')->withSuccess('Record added successfully');
        } else {
            Employee::where('id', $id)->update(request()->except(['_token']));
            return redirect('/')->withSuccess('Record updated successfully');
        }
        return redirect('/');
    }

    public function delete($id){
        Employee::destroy([$id]);
        return redirect('/')->withSuccess('Record Deleted successfully');
    }
}
