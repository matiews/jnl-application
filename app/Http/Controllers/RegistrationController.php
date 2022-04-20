<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //

     public function showUser(){

    	 $genders=Gender::all();
    	 $roles=Role::all();
    	 $titles=Title::all();
    	 $marital_statuses=MaritalStatus::all();

    	return view('admins.create_user')->with(['genders'=>$genders, 'titles'=>$titles, 'marital_statuses'=>$marital_statuses, 'roles'=>$roles]);
    }

    public function createUser(Request $request){

    	$request->validate([

    		'firstname'=>'required',
    		'surname'=>'required',
    		'username'=>'required',
    		'password'=>'required',
            'phone'=>'required|min:11|max:11',
    		'email'=>'required|email',
    		'gender'=>'required',
    		'mStatus'=>'required',
    		'role'=>'required',
    		'address'=>'required',
    	]);


    	$create_user=array(

    		'role_id'=>$request->role,
    		'title_id'=>$request->title,
    		'marital_status_id'=>$request->mStatus,
    		'firstname'=>$request->firstname,
    		'surname'=>$request->surname,
    		'username'=>$request->username,
    		'phone'=>$request->phone,
    		'gender_id'=>$request->gender,
    		'email'=>$request->email,
    		'address'=>$request->address,
    		'active'=>1,
    		'password'=>bcrypt($request->password),

    		);

            /*if ($request->has('user_image')) {
            $originalImage = $request->file('user_image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path('uploads/thumbnails/');
            $originalPath = public_path('uploads/images/');
            $filename = time().$originalImage->getClientOriginalName();
            $thumbnailImage->save($originalPath.$filename);
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.$filename); 
            $create_user['user_image'] = $filename;
        } */
            User::create($create_user);

    		return redirect()->route('user.create')->with('success', 'User Created Successful');

    	
    }
}
