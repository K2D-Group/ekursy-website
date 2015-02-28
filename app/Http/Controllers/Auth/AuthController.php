<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

	use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}



    public function socialLogin($social_provider)
    {
        switch($social_provider){
            case 'facebook':
                return \Socialize::with($social_provider)->scopes(['email'])->redirect();
            default:
                return \Socialize::with($social_provider)->redirect();
        }
    }

    public function socialLoginCallback($social_provider)
    {
        try{
            $user_data = \Socialize::with($social_provider)->user();

            switch($social_provider){
                case 'facebook':
                    if(is_null($user_data->email))
                        return redirect()->route('auth.login.social.redirect', [$social_provider]);
            }

            $oauth = \App\UserOauth::firstOrNew([
                'social_provider' => strtolower($social_provider),
                'social_id' => $user_data->id
            ]);
            $oauth->social_data = (array)$user_data;

            if(is_null($oauth->id) || is_null($oauth->user)){
                $role = \App\Role::whereName('user')->firstOrFail();
                if(!is_null($user_data->getEmail())){
                    $user = \App\User::firstOrNew(['email' => $user_data->getEmail()]);
                    $user->name = $user_data->getName();
                    $user->nickname = $user_data->getNickname();
                    $user->avatar = $user_data->getAvatar();
                    $user->save();
                }else {
                    $user = new \App\User;
                    $user->email = $user_data->getEmail();
                    $user->name = $user_data->getName();
                    $user->nickname = $user_data->getNickname();
                    $user->avatar = $user_data->getAvatar();
                    $user->save();
                }
                $user->roles()->sync([$role->id], false);
            }else{
                $user = $oauth->user;
            }
            $user->oauth()->save($oauth);

            \Auth::loginUsingId($user->id);
            return redirect('/');

        }catch(\Exception $e){
            \Log::alert($e->getMessage());
            \Debugbar::addException($e);
            dd($e);
            return redirect('/');
        }
    }


}
