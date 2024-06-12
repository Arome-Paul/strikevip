<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Balance;
use App\Models\UserDetail;
use App\Models\Socialmedia;
use App\Models\Notification;
use App\Models\Transaction;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.signup');
    }
    public function ref(int $ref): View
    {
        return view('auth.signup', [
            'ref' => $ref
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255'],
            'tel' => ['required', 'integer'],
            'referer' => ['max:5'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if(!empty(DB::table('users')->where('username', '=', $request->username)->first())){
            return Redirect::route('register')->with(['status' => 'username', 'username' => $request->username]);
        }

        if(!empty($request->referer)){

            $referer = DB::table('user_details')->where('referer_code', $request->referer)->first();
            $ref_count = DB::table('user_details')->where('referer_code', '=', $request->referer)->update([
                'referees' => $referer->referees + 1
            ]);
            // $ref_count = DB::table('user_details')->updateOrInsert(['referer_code' => $referer->$request->referer], ['referees' => $referer->referees + 1]);
            
            $ref_notification = Notification::create([
                'userid' => $referer->userid,
                'subject' => 'New User signed up on your refereral',
                'link_to' => 'referal'
            ]);

            $referer_id = $referer->userid;
        }
        else{
            $referer_id = null;
        }



        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username' => $request->username,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user_details = UserDetail::create([
            'userid' => Auth::id(),
            'referer_code' => $this->generateUniqueCode(), 
            'referred_by' => $referer_id
        ]);

        $balance = Balance::create([
            'userid' => Auth::id()
        ]);
        
        $notifications = Notification::create([
            'userid' => Auth::id(),
            'subject' => 'Registration completed go set up your profile',
            'link_to' => 'profile',
        ]);
        $socialmedia = Socialmedia::create([
            'userid' => Auth::id(),
        ]);

        event(new Registered($user_details));
        event(new Registered($balance));

        return redirect(RouteServiceProvider::HOME)->with('status', 'registered');
    }

    // generate referer code
    public function generateUniqueCode(){
        do{
            $code = random_int(10000, 99999);
        }
        while(UserDetail::where('referer_code', '=', $code)->first());

        return $code;
    }
}
