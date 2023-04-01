<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function show_login(Request $request){
        return view("client.login");
    }
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);
		// dd("ss");
		if(Auth::guard('client')->attempt(['email' => $request->email, 'password' => $request->password])){	
	
			
			// dd("Ss");
            return redirect(session('url.intended') ?? route('client.home'));

			// return redirect()->intended(route("client.home")); 
		}
		else{ 
			//dd(4);
			
			return redirect("/client/login")->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Incorrect email address or password',
            ]); 
		}
		
		return true;
    }
    public function ClientLogout(Request $request)
    {
		 Auth::guard('client')->logout();
      
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route("client.show_login");

     }
}
