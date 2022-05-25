<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CountryCode;
use App\Models\History;
use App\Models\Payment;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all()->except(Auth::user()->id);
        return view('AdminPages.users', compact('users'));
    }

    public function agentsIndex()
    {
        $users = User::where('role', '=', 1)->get();
        return view('AdminPages.users', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 1) {
            $user->company = Company::where('AgentId', $user->id)->first();
        }
        $membership = Payment::where('user_id', '=', $id)->get();

        return view('Users.show', compact('user', 'membership'));
    }

    public function registerAgent()
    {
        return view('auth.registerAgent');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->profileImg != 'profileImage.png') {
            Storage::delete('public/user_profile_images/' . $user->profileImg);
        }
        $properties = Property::where('userId', '=', $user->id)->get();
        foreach ($properties as $property) {
            app('\App\Http\Controllers\PropertiesController')->delete($property->id);
        }
        if ($user->role == 1) {
            $company = Company::where('agentId', '=', $user->id);
            $company->delete();
        }

        $history = new History;
        $history->userId = $user->id;
        $history->user_name = $user->name;
        $history->user_email = $user->email;
        $history->user_role = $user->role;
        $history->user_phoneNumber = $user->phoneNumber;
        $history->user_phoneNumberCode = $user->phoneNumberCode;
        $history->user_bio = $user->bio;
        $history->isCreated = 0;
        $history->isUpdated = 0;
        $history->isDeleted = 1;
        $history->save();

        $user->delete();

        if (Auth::user()->role == 0) {
            return redirect('/users')->with('message', 'User Deleted !');;
        } else {
            return redirect('/');
        }
    }


    public function edit(Request $request)
    {
        return view('Users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $var = ltrim($request['phoneNumber'], '0');
        $request['phoneNumber'] = $var;
        $country = CountryCode::where('iso', '=', $request['phoneNumberCode'])->get();
        $code = $country[0]->phonecode;

        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'bio' => ['nullable', 'string', 'max:190'],
        ]);

        if ($request->email != Auth::user()->email) {
            $validatedData = $request->validate([
                'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            ]);
            $user->email = $request->email;
        }

        if ($request->phoneNumber != Auth::user()->phoneNumber || $code != Auth::user()->phoneNumberCode) {
            $validatedData = $request->validate([
                'phoneNumber' => ['unique:users', 'phone:phoneNumberCode'],
                'phoneNumberCode' => 'required_with:phoneNumber',
            ]);
        }


//        dd($request);
        $user->phoneNumber = $request['phoneNumber'];
        $user->phoneNumberCode = $code;
        $user->name = $request->name;
        $user->bio = $request->bio;

        if ($request['profileImg'] != null) {
            if ($user->profileImg != 'profileImage.png') {
                Storage::delete('public/storage/user_profile_images/' . $user->profileImg);
            }
            $image = $request['profileImg'];
            /*
            // Get filename with the extension
            $filenameWithExt = $image->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $image->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $user->profileImg = $fileNameToStore;
            $path = $image->storeAs('public/user_profile_images', $fileNameToStore);
        */
            $request['profileImg'] = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('storage/user_profile_images');
            $img = Image::make($image->getRealPath());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . time() . $image->getClientOriginalName());

            $user->profileImg = time() . $image->getClientOriginalName();

            $destinationPath = public_path('/storage/images');
            $image->move($destinationPath, $request['profileImg']);

        } else {
            $user->profileImg = 'profileImage.png';
        }


        if ($request->email != Auth::user()->email) {
            $user->email_verified_at = null;
        }

        $history = new History;
        $history->userId = $user->id;
        $history->user_name = $user->name;
        $history->user_email = $user->email;
        $history->user_role = $user->role;
        $history->user_phoneNumber = $user->phoneNumber;
        $history->user_phoneNumberCode = $user->phoneNumberCode;
        $history->user_bio = $user->bio;
        $history->isCreated = 0;
        $history->isUpdated = 1;
        $history->isDeleted = 0;
        $history->save();

        $user->save();
        return redirect('users/' . $user->id)->with('message', 'Profile Updated !');
    }

    public function apiGetById($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            $user
        ], 200);
    }

    public function apiEdit($id, Request $request)
    {
        $user = User::findOrFail($id);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->phoneNumber = $request->phoneNumber;

        $user->save();

        return response()->json([
            $user
        ], 200);
    }

}
