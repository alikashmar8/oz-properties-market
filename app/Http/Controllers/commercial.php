<?php

namespace App\Http\Controllers;


use App\Mail\NewPropertyMail;
use App\Mail\PropertyAcceptedMail;
use App\Mail\PropertyCreated;
use App\Mail\PropertyUpdated;
use App\Mail\newCommercial;
use App\Mail\CommercialUpdate;
use App\Mail\CommecialAccepted;

use App\Models\Category;
use App\Models\commercial;
use App\Models\CommercialImage;
use App\Models\commTypes;
use App\Models\History;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use function GuzzleHttp\Promise\all;


class commercialController extends Controller
{
    public function index()
    {
        $commercials = commercial::where('accepted' , '=' , 1)->get();
        foreach ($commercials as $com) {
            $com->images = CommercialImage::where('commercialId', $com->id)->get();
        }
        $types = commTypes::all();
        return view('commercial.indexcommercial', compact('commercials', 'types'));
    }
    public function create()
    {
        $id = Auth::user()->id;
        $payment = Payment::where('user_id' , '=' , $id);
        $packages = null;
        $ab[] = null;
        if ($payment != null ) {
            $payment =  $payment->where('status' , '=','paid')->where('used' ,'=', 0)->get();
            /*foreach ($payment as $pay) {
                $pay->title = Packages::where('title', '=', $pay->package)->get();*/

            foreach ($payment as $pay){
                $packages = Packages::where('title', '=', $pay->package)->first() ;
                if ($packages->id > 7) {
                    $ab[] += $packages->id;
                }

            }
            if (  count($ab) <= 1) {
                return redirect('/packages')->with('message', 'Please Register in a Residential package!');

            } else {

                return view('commercial.createCommercial', compact( 'ab'));

            }
        }else{
            return redirect('/packages')->with('message', 'Please Register in a Residential  package!');
        }
        //return view('commercial.createCommercial');
    }

    public function store(Request $request)
    {
        //return redirect('/commercial')->with('message', 'Commercial Property Created Successfully!');

        $this->validate($request, [
            'lan' => 'required',
            'location' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required',
            'lang' => 'required',

        ]);
        $com = new commercial();
        $com->price = $request->price;
        $com->description = $request->description;
        $com->lang = $request->lang;
        $com->lan = $request->lan;
        $com->location = $request ->location;

        if (isset($request->showPrice)) $com->showPrice = 1; else $com->showPrice = 0;

        if ($request->floor != -1) {
            $com->floor = $request->floor;
        }

        $com->accepted = 0;
        $com->userId = Auth::user()->id;
        $com->category = $request->category;
        $com->type = $request->type;
        $com->extra3 = $request->packageId;

        $com->save();
        // Handle File Upload
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                if($image->getClientOriginalExtension() == 'mp4') {
                    // Get filename with the extension
                    $filenameWithExt = $image->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $image->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $image->storeAs('public/commercials_images', $fileNameToStore);

                    $image = new CommercialImage;
                    $image->commercialId = $com->id;
                    $image->url = $fileNameToStore;
                    $image->save();
                }else{
                    $Name = time() . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('storage/commercials_images/');
                    $img = Image::make($image->getRealPath());
                    $img->resize(650, 650, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . time() . $image->getClientOriginalName());

                    /*$user->profileImg = time().$image->getClientOriginalName();*/
                    $fileNameToStore = time() . $image->getClientOriginalName();
                    $image = new CommercialImage;
                    $image->commercialId = $com->id;
                    $image->url = $fileNameToStore;
                    $image->save();


                    $destinationPath = public_path('/storage/images');
                    //$image->move($destinationPath, $Name);

                }
            }
        }


        $history = new History;
        $history->commercialId = $com->id;
        $history->post_description = $com->description;
        $history->post_price = $com->price;
        $history->post_roomsNumber = $com->roomsNumber;
        $history->commercial_floor = $com->floor;
        $history->post_bathroomsNumber = $com->bathroomsNumber;
        $history->post_parkingNumber = $com->parkingNumber;
        $history->post_bedroomsNumber = $com->bedroomsNumber;
        $history->post_accepted = $com->accepted;
        $history->post_userId = $com->userId;
        $history->post_category = Category::findOrFail($com->category)->title;
        $history->post_type = commTypes::findOrFail($com->type)->title;
//        $history->post_category = $com->category;
//        $history->post_type = $com->type;
        $history->post_locationDescription = $com->location;
        $history->post_contactInfo = $com->extra1;
        $history->post_longitude = $com->lang;
        $history->post_latitude = $com->lan;
        $history->isCreated = 1;
        $history->isUpdated = 0;
        $history->isDeleted = 0;
        $history->save();


        $package = Packages::findOrFail($request->packageId) ;
        $payment = Payment::all()->where( 'user_id' , '=',  Auth::user()->id)->where('package','=', $package->title)->first();
        $payment->used = 1;
        $payment->save();


        $mail = Auth::user()->email;
        Mail::to('ozpropertymarket@gmail.com')->send(new NewCommercial());
        Mail::to($mail)->send(new PropertyCreated());

        return redirect('/myCommercial')->with('message', 'Commercial Property Created Successfully!' );
    }

    public function show($id)
    {
        $com = commercial::findOrFail($id);
        $com->agent = User::findOrFail($com->userId);


        $com->images = CommercialImage::where('commercialId', $com->id)->get();

        return view("commercial.showCommercial")->with('com', $com);
    }

    public function myCommercial()
    {
        $coms = commercial::where('userId', '=', Auth::id())->get();
        foreach ($coms as $com) {
            $com->images = CommercialImage::where('commercialId', $com->id)->get();
        }
        //return view("commercial.myCommercial", compact('$coms'));
        return view("commercial.myCommercial")->with('coms', $coms);
    }
    public function edit($id)
    {
        $com = commercial::findOrFail($id);
        return view('commercial.editCommercial', compact('com'));
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $com = commercial::findOrFail($id);
        $com->price = $request->price;
        $com->description = $request->description;
        if (isset($request->showPrice)) $com->showPrice = 1; else $com->showPrice = 0;

        $com->floor = $request->floor;

        $com->accepted = 0;
        $com->category = $request->category;
        $com->type = $request->type;
        $com->extra1 = null;

        $com->save();
        // Handle File Upload

        if (isset($request->images)) {
            if (count($request->images) > 0) {
                $this->deleteImages($id);
                foreach ($request->images as $image) {
                    if($image->getClientOriginalExtension() == 'mp4') {
                        // Get filename with the extension
                        $filenameWithExt = $image->getClientOriginalName();
                        // Get just filename
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                        $extension = $image->getClientOriginalExtension();
                        // Filename to store
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        // Upload Image
                        $path = $image->storeAs('public/commercials_images', $fileNameToStore);

                        $image = new CommercialImage();
                        $image->commercialId = $com->id;
                        $image->url = $fileNameToStore;
                        $image->save();
                    }else{
                        $Name = time() . '.' . $image->getClientOriginalExtension();

                        $destinationPath = public_path('storage/commercials_images/');
                        $img = Image::make($image->getRealPath());
                        $img->resize(650, 650, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . time() . $image->getClientOriginalName());

                        /*$user->profileImg = time().$image->getClientOriginalName();*/
                        $fileNameToStore = time() . $image->getClientOriginalName();
                        $image = new CommercialImage();
                        $image->commercialId = $com->id;
                        $image->url = $fileNameToStore;
                        $image->save();


                        $destinationPath = public_path('/storage/images');
                        //$image->move($destinationPath, $Name);

                    }
                }
            }
        }


        $history = new History;
        $history->commercialId = $com->id;
        $history->post_description = $com->description;
        $history->post_price = $com->price;
        $history->post_roomsNumber = $com->roomsNumber;
        $history->commercial_floor = $com->floor;
        $history->post_bathroomsNumber = $com->bathroomsNumber;
        $history->post_parkingNumber = $com->parkingNumber;
        $history->post_bedroomsNumber = $com->bedroomsNumber;
        $history->post_accepted = $com->accepted;
        $history->post_userId = $com->userId;
        $history->post_category = Category::findOrFail($com->category)->title;
        $history->post_type = commTypes::findOrFail($com->type)->title;
//        $history->post_category =
//        $history->post_type = ;
        $history->post_locationDescription = $com->location;
        $history->post_contactInfo = $com->extra1;
        $history->post_longitude = $com->lang;
        $history->post_latitude = $com->lan;
        $history->isCreated = 0;
        $history->isUpdated = 1;
        $history->isDeleted = 0;
        $history->save();

        Mail::to('ozpropertymarket@gmail.com')->send(new CommercialUpdate());
        return redirect('/commercial/' . $com->id)->with('message', 'Commercial Property Updated!');
    }

    public function viewNotAccepted(){
        if (Auth::user()->role == 0) {
            $notAccepted  = commercial::where('accepted', '=', 0)->get();
            foreach ($notAccepted as $com) {
                $com->images = CommercialImage::where('commercialId', $com->id)->get();
                $com->agent = User::find($com->userId);
            }
            return view("AdminPages.acceptCommercials", compact('notAccepted'));
        }
    }
    public function accept(Request $request)
    {
//        dd($request['id']);
        $com = commercial::findOrFail($request['id']);
        $com->accepted = 1;
        $com->extra1 = $request['extra1'];
        $com->save();

        $history = new History;
        $history->commercialId = $com->id;
        $history->post_description = $com->description;
        $history->post_price = $com->price;
        $history->post_roomsNumber = $com->roomsNumber;
        $history->commercial_floor = $com->floor;
        $history->post_bathroomsNumber = $com->bathroomsNumber;
        $history->post_parkingNumber = $com->parkingNumber;
        $history->post_bedroomsNumber = $com->bedroomsNumber;
        $history->post_accepted = $com->accepted;
        $history->post_userId = $com->userId;
        $history->post_category = Category::findOrFail($com->category)->title;
        $history->post_type = commTypes::findOrFail($com->type)->title;
//        $history->post_category = $com->category;
//        $history->post_type = $com->type;
        $history->post_locationDescription = $com->location;
        $history->post_contactInfo = $com->extra1;
        $history->post_longitude = $com->lang;
        $history->post_latitude = $com->lan;
        $history->isCreated = 0;
        $history->isUpdated = 1;
        $history->isDeleted = 0;
        $history->save();

        $user = User::findOrFail($com->userId);
        Mail::to($user->email)->send(new CommecialAccepted());
        return redirect('/acceptCommercials')->with('message', 'Property Accepted');
    }

    public function destroy($id)
    {


        $com = commercial::findOrFail($id);
        $i = $com->accepted;
        $this->deleteImages($com->id);

        $history = new History;
        $history->commercialId = $com->id;
        $history->post_description = $com->description;
        $history->post_price = $com->price;
        $history->post_roomsNumber = $com->roomsNumber;
        $history->commercial_floor = $com->floor;
        $history->post_bathroomsNumber = $com->bathroomsNumber;
        $history->post_parkingNumber = $com->parkingNumber;
        $history->post_bedroomsNumber = $com->bedroomsNumber;
        $history->post_accepted = $com->accepted;
        $history->post_userId = $com->userId;
        $history->post_category = Category::findOrFail($com->category)->title;
        $history->post_type = commTypes::findOrFail($com->type)->title;
//        $history->post_category = $com->category;
//        $history->post_type = $com->type;
        $history->post_locationDescription = $com->location;
        $history->post_contactInfo = $com->extra1;
        $history->post_longitude = $com->lang;
        $history->post_latitude = $com->lan;
        $history->isCreated = 0;
        $history->isUpdated = 0;
        $history->isDeleted = 1;
        $history->save();


        $com->delete();
        if (Auth::user()->role == 0) {
            if ($i == 0)
                return redirect('/acceptCommercials')->with('message', 'Property Deleted!');
            else
                return redirect('/allCommercials')->with('message', 'Property Deleted!');
        } else {
            return redirect('/myCommercial')->with('message', 'Property Deleted!');
        }
    }
    public function allCommercials(){
        $coms = commercial::where('accepted', '=', 1)->get();
        foreach ($coms as $com) {
            $com->images =  CommercialImage::where('commercialId', $com->id)->get();
            $com->agent = User::find($com->userId);
        }
        return view('AdminPages.allCommercials', compact('coms'));
    }

    public function deleteImages($id)
    {
        $imags = CommercialImage::where('commercialId', '=', $id);
        $images = $imags->get();
        foreach ($images as $image) {

            $path = public_path() . '\storage\commercials_images\\' . $image->url;
            if(  file_exists($path)) {
                unlink($path);
                Storage::delete('public/commercials_images/' . $image->url);
            }
        }
        $imags->delete();
    }

    public function showCommercial(Request $request)
    {
        $com = commercial::findOrFail($request->id);
        $com->accepted = 1;
        $com->save();
        return redirect('/commercial/' . $com->id);
    }

    public function hideCommercial(Request $request)
    {
        $com = commercial::findOrFail($request->id);
        $com->accepted = 0;
        $com->save();
        return redirect('/commercial/' . $com->id);
    }


    public function upgradePackageCom(Request $request)
    {
        $newPackage = Packages::findOrFail($request->newPackageId);
        if ($request->oldPackage != 0) {
            $oldPackage = Packages::findOrFail($request->oldPackage);
        }
        $property = commercial::findOrFail($request->propertyId);

        $oldPayment = Payment::where('user_id' , '=' , $property->userId);
        $oldPayment = $oldPayment->where('used' , '='  , 1);
        $oldPayment = $oldPayment->where('status' , '=' , 'paid');
        $oldPayment = $oldPayment->where('package', '=' , $oldPackage->title );
        $oldPayment = $oldPayment->first();

        $newPayments = Payment::where('user_id' , '=' , $property->userId);
        $newPayments = $newPayments->where('used' , '=' , 0);
        $newPayments = $newPayments->where('status' , '=' , 'paid');
        $newPayments = $newPayments->where('package', '=' , $newPackage->title);
        $newPayments = $newPayments->first();


        if ($request->oldPackage == 0){
            $newPayments->used = 1 ;
            $newPayments->save();
            $property->extra3 = $newPackage->id;
            if ($newPackage->id > 10 && $newPackage->id < 14) {
                $property->category = 2;
            } else {
                $property->category = 1;
            }
            $property->save();
            return redirect('/commercial/'.$property->id ) ;
        }else {
            if ($newPayments != null && $oldPayment != null) {
                $oldPayment->used = 0;
                $oldPayment->save();
                $newPayments->used = 1;
                $newPayments->save();
                $property->extra3 = $newPackage->id;
                if ($newPackage->id > 10 && $newPackage->id < 14) {
                    $property->category = 2;
                } else {
                    $property->category = 1;
                }
                $property->save();
                return redirect('/commercial/' . $property->id);
            } else {
                $difference = $newPackage->price - $oldPackage->price;
                if ($difference > 0) {
                    return redirect('/order/' . $newPackage->id . '/' . $difference)->with('message', 'Please pay the rest for the new package, then link it to this listing.');
                } else {
                    return redirect('/order/' . $newPackage->id . '/' . $newPackage->price)->with('message', 'Please register in this package first, then link it to this listing.');

                }
            }
        }




    }

    public function brochure($id)
    {
        $property = commercial::findOrFail($id);

        $property->images = CommercialImage::where('commercialId', $property->id)->get();
        $pdf = PDF::loadView('pdf.comBrochure' , compact('property'));

        return $pdf->download('brochure.pdf');
    }



}
