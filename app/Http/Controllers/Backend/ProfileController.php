<?php

namespace App\Http\Controllers\Backend;

use App\User;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $id = Auth::User()->id;
        $user  = User::findOrfail($id);
        return view('backend.user.view-profile', compact('user','totalQuantity','lowStoc'));
    }

      public function edit(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        $id = Auth::User()->id;
        $editData  = User::findOrfail($id);
        return view('backend.user.edit-profile', compact('editData','totalQuantity','lowStoc'));
    }




    public function update(Request $request){
        $data = User::findOrfail(Auth::User()->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->gender = $request->gender;
        $data->address = $request->address;

            if ($request->file('image')) {
                $file = $request->file('image');
                @unlink(public_path('upload/user_images/'.$data->image));
                $fileName =date('YmdHi').$file->getClientOriginalExtension();
                $file->move(public_path('upload/user_images/'), $fileName);
                $data['image'] = $fileName;
            }
        $data->save();
        return redirect()->route('profiles.view')->with('success','Profiles updated Successfully');

    }

    public function PasswordView(){
        $lowStoc = 5;
        $totalQuantity = Product::where('status',1)->sum('quantity');

        return view('backend.user.edit-password',compact('totalQuantity','lowStoc'));
    }


    public function PasswordUpdate(Request $request){
        if(Auth::attempt(['id' =>Auth::user()->id, 'password' => $request->current_password])){
            $user = User::findOrfail(Auth::user()->id);
             $user->password = bcrypt($request->new_password);
             $user->save();
             return redirect()->route('profiles.view')->with('success','Password Changed Successfully');
        }else{
            return redirect()->back()->with('error','Sorry! your corrent password dost not match ');
        }

    }



}
