<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CountryCode;
use App\Models\History;
use App\Models\PropertyImage;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use http\Env\Response;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;

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
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $var = ltrim($data['phoneNumber'], '0');
        $data['phoneNumber'] = $var;

        if ($data['role'] == 1) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:190'],
                'bio' => ['nullable', 'string', 'max:190'],
                'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
//            'phoneNumber' => ['required', 'string', 'max:25','unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phoneNumber' => ['unique:users', 'phone:phoneNumberCode'],
                'phoneNumberCode' => 'required_with:phoneNumber',
                'profileImg' => 'max:500000',
                'licenseNumber' => ['required', 'unique:companies']
            ]);
        } else {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:190'],
                'bio' => ['nullable', 'string', 'max:190'],
                'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'phoneNumber' => ['unique:users', 'phone:phoneNumberCode'],
                'phoneNumberCode' => 'required_with:phoneNumber',
                'profileImg' => 'max:500000',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $country = CountryCode::where('iso', '=', $data['phoneNumberCode'])->get();
        $code = $country[0]->phonecode;
        $fileNameToStore = 'profileImage.png';
        $bio = NULL;
        if (isset($data['profileImg'])) {
            $image = $data['profileImg'];
            // Get filename with the extension
            $filenameWithExt = $image->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $image->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $image->storeAs('public/user_profile_images', $fileNameToStore);
        }

        if (isset($data['bio'])) {
            $bio = $data['bio'];
        }
        $user = User::create([
            'name' => $data['name'],
            'bio' => $bio,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phoneNumber' => ltrim($data['phoneNumber'], '0'),
            'phoneNumberCode' => $code,
            'profileImg' => $fileNameToStore,
            'role' => $data['role'],

        ]);
        if ($data['role'] == 1) {
            $company = new Company;
            $company->name = $data['comp_name'];
            $company->licenseNumber = $data['licenseNumber'];
            $company->AgentId = $user->id;
            $company->save();
        }

        $history = new History;
        $history->userId = $user->id;
        $history->user_name = $user->name;
        $history->user_email = $user->email;
        $history->user_role = $user->role;
        $history->user_phoneNumber = $user->phoneNumber;
        $history->user_phoneNumberCode = $user->phoneNumberCode;
        $history->user_bio = $user->bio;
        $history->isCreated = 1;
        $history->isUpdated = 0;
        $history->isDeleted = 0;
        $history->save();

        return $user;
    }
}
