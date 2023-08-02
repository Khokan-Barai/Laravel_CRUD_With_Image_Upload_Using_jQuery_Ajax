<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{
    public function index(){
        return view('index');
    }

    public function fetchAll(){
        $employees = Employee::all();
        $output = '';
        $sl=0;
        if($employees->count() > 0){
            $output .=' <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Avatra</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>';
                foreach($employees as $employee){
                    $sl++;
                    $output .='<tr>
                        <td>'.$sl.'</td>
                        <td><img src="storage/images/'.$employee->avatar.'" width="50" height="50" class="rounded-circle"></td>
                        
                        <td>'.$employee->first_name.' '.$employee->last_name.'</td>
                        <td>'.$employee->email.'</td>
                        <td>
                            <a href="#" id="'.$employee->id.'" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"> <i class="bi bi-pencil-square h4"></i></a>

                            <a href="#" id="'.$employee->id.'" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                        </td>
                    ';
                }
                /*
                if don't show the image in the table, then delete this
                'public/storage'-> storage folder and run this comand 
                'php artisan storage:link'
                */
            
            $output .= '</tbody></table>';

            echo $output;
        }else{
            echo '<h1 class="text-center text-secondary my-5">No record found!</h1>';
        }
    }

    public function store(Request $request) {
        $file = $request->file('avatar');
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName); //Run in Cmd: php artisan storage:link
        // $file->move(public_path('images'), $fileName);

        $empData = ['first_name' => $request->fname, 'last_name' => $request->lname, 'email' => $request->email, 'avatar' => $fileName];

        Employee::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function edit(Request $request){
        $id = $request->id;
        $emp = Employee::find($id);
        return response()->json($emp);
    }

    public function update(Request $request){
        $fileName = '';
        $emp = Employee::find($request->emp_id);
        if($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName); 
            // $file->move(public_path('images'), $fileName);
            if($emp->avatar){
                Storage::delete('public/images/'.$emp->avatar);
            }

        }else{
            $fileName = $request->emp_avatar;
        }

        $empData = ['first_name' => $request->fname, 'last_name' => $request->lname, 'email' => $request->email, 'avatar' => $fileName];

        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function delete(Request $request){
        $id = $request->id;
        $emp = Employee::find($id);
        if(Storage::delete('public/images/'.$emp->avatar)){
            Employee::destroy($id);
        }
    }
}