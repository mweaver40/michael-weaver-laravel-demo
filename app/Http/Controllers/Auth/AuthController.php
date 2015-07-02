<?php

namespace Mweaver\Http\Controllers\Auth;

use Mweaver\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Mweaver\Http\Controllers\Store\CatalogController;
use Illuminate\Support\Facades\URL;


class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

use AuthenticatesAndRegistersUsers {
        postRegister as postRegisterTrait;
      
    }
public $redirectAfterLogout;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar) {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->redirectAfterLogout= URL::route('catalogPage');
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    public function postRegister(Request $request)
    {
        $this->postRegisterTrait($request);
        
        return redirect()->intended($this->redirectPath());

    }
    
    public function getLogin()
    {
        $data = CatalogController::getCatalogPageBasicInformation();
        return view('store.storeAuth', $data);
       
    }
    
    public function getRegister()
    {
        $data = CatalogController::getCatalogPageBasicInformation();
        return view('store.storeAuth', $data);   
    }
    

}
