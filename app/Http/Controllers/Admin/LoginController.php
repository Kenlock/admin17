<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Admin;
class LoginController extends Controller
{
    public function getIndex()
    {
    	return view('admin.login.index');
    }

    public function postIndex(Request $request)
    {
    	$this->validate($request,['email'=>'required','password'=>'required']);

    	$attempt = \Auth::attempt(['email'=>$request->email,'password'=>$request->password,'status'=>'active']);
    	if($attempt==true)
    	{
    		return redirect(Admin::urlBackend('dashboard'));
    	}else{
    		return redirect()->back()->with('info','Your account not found');
    	}
    }

    public function getForgotPassword()
    {
        return view('admin.login.forgot');
    }

    public function postForgotPassword(Request $request)
    {
        $this->validate($request,['email'=>'required|email']);

        $model=User::whereEmail($request->email)->first();
        if(empty($model->id))
        {
            return redirect()->back()->with('info','Email not found!');
        }

        \Mail::to($model->email)
            ->send(new \App\Mail\Admin\ForgotMail($model));

        $model->update(['status'=>'un_active']);

        return redirect()->back()->with('info',"Silahkan cek email anda untuk merubah password");
    }

    public function validateToken($token)
    {
        $email=\Crypt::decryptString($token);
        $model = User::whereEmail($email)->firstOrFail();
        if($model->status=='active')
        {
            abort(404);
        }
        return $model;
    }

    public function getNewPassword($token)
    {
        $model = $this->validateToken($token);
        return view('admin.login.new_password',['model'=>$model]);
    }

    public function postNewPassword(Request $request,$token)
    {
        $this->validate($request,['password'=>'required|min:5','verify_password'=>'same:password']);

        $model = $this->validateToken($token);

        $model->update([
            'password'=>\Hash::make($request->password),
            'status'=>'active'
        ]);

        return redirect('login')->with('success','Password berhasil di perbaharui silahkan login kembali');

    }

    public function getLogout()
    {
        $auth = auth()->user()->role->id;
        // \Cache::forget('admin_menu_array'.$auth);
        \Auth::logout();
        return redirect('login');
    }
}
