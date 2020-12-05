<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function view(){

        $data['allData'] = User::all();
        return view('backend.user.view-user',$data);
    }

    public function add(){
       return view('backend.user.add-user');
    }

    public function store(Request $request){

        $data = new User();
        $data->usertype = $request->usertype;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password =bcrypt($request->password);
        $data->save();

        return redirect()->route('users.view')->with('success','Data Inserted Successfully');

    }


     public function edit($id){
            $data = User::findOrfail($id);
           return view('backend.user.edit-user',compact('data'));

    }


    public function update(Request $request, $id ){
        $data = User::findOrfail($id);
        $data->usertype = $request->usertype;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->save();

        return redirect()->route('users.view')->with('success','Data updated Successfully');

    }

    public function delete($id){

        $data = User::findOrfail($id);
        if(file_exists('upload/user_images/' . $data->image) AND ! empty($data->image)){
            unlink('upload/user_images/' . $data->image);
        }
        $data->delete();
       return redirect()->route('users.view')->with('success','Data Deleted Successfully');
    }






}
