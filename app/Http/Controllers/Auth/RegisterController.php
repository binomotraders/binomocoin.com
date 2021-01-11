<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Verify new user data and send verification code.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function userSignup(Request $request)
    {
        $data = $request->all();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        try {
            $random = str_shuffle('1234567890');
            $otpcode = substr($random, 0, 6);

            $client = new \GuzzleHttp\Client();
            if (config('app.env') == 'local') {
                $url = config('services.binomoapi.base_url_test')."/v1/user/sendotp/email";
            } else {
                $url = config('services.binomoapi.base_url_live')."/v1/user/sendotp/email";
            }
            
            $customerData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'otpcode' => $otpcode
            ];

            $response = $client->post($url, ['json' => $customerData], ['Content-Type' => 'application/json']);        
            
            if ($response->getStatusCode() == 200) {
                return redirect()->back()->with(['data'=>$data,'secretekey'=>Hash::make($otpcode),'verify'=>'1']);
            } else {
                return redirect()->back()->with('error','Invalid Email ID');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Internal Server Error! Try again after some time.');
        }        
    }

    /**
     * Create a new user instance after a email verification.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function verifySignupOtp(Request $request)
    {
        $data = $request->all();
        if (Hash::check($request->otpnumber, $request->secretekey)) {
            $uuid = Str::uuid()->toString();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'uuid' => $uuid.'-'.date("idHms"),
                'status' => 1,
            ]);
            Auth::login($user);
        }
        
        return redirect()->back()->with(['error'=>'Invalid verification code','data'=>$data,'secretekey'=>$data['secretekey'],'verify'=>'1']);
    }
}
