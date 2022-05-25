<?php

namespace App\Http\Controllers;
use App\Models\commercial;
use App\Models\CommercialImage;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class commercialController extends Controller
{

    public function index()
    {
        $coms = commercial::all();
        return view('commercial.indexcommercial')->with('coms' , $coms);
    }
    public function create()
    {


        //return view('commercial.createCommercial');
    }
    public function destroy($id)
    {
        $this->delete($id);
        if (Auth::user()->role == 0) {
            return redirect('/acceptCommercials')->with('message', 'Property Deleted!');
        } else {
            return redirect('/myCommercial')->with('message', 'Property Deleted!');
        }
    }


    public function store(Request $request)
    {
        return redirect('/commercial')->with('message', 'Commercial Property Created Successfully!');

       /* $this->validate($request, [
            'lat' => 'required',
            'location' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required',
            'long' => 'required',

        ]);*/
        $com = new commercial();
        $com->price = $request->price;
        $com->description = $request->description;
        $com->lang = $request->long;
        $com->lan = $request->lat;
        $com->location = $request ->location;

        if (isset($request->showPrice)) $com->showPrice = $request->showPrice; else $com->showPrice = 0;

        if ($request->floor != -1) {
            $com->floor = $request->floor;
        }

        $com->accepted = 0;
        $com->userId = Auth::user()->id;
        $com->category = $request->category;
        $com->type = $request->type;

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
                    $image = new CommercialImage;
                    $image->commercialId = $com->id;
                    $image->url = $fileNameToStore;
                    $image->save();


                    $destinationPath = public_path('/storage/images');
                    //$image->move($destinationPath, $Name);

                }
            }
        }

        $package = Packages::findOrFail($request->packageId)->first();
        $payment = Payment::all()->where( 'user_id' , '=',  Auth::user()->id)->where('package','=', $package->title)->first();
        $payment->used = 1;
        $payment->save();

        //$mail = Auth::user()->email;
        //Mail::to('ozpropertymarket@gmail.com')->send(new NewPropertyMail());
        //Mail::to($mail)->send(new PropertyCreated());

        return redirect('/commercial')->with('message', 'Commercial Property Created Successfully!');
    }




    public function upgradePackageCom(Request $request)
    {
        $newPackage = Packages::findOrFail($request->newPackageId);
        $oldPackage = Packages::findOrFail($request->oldPackage);
        $property = Property::findOrFail($request->propertyId);

        $oldPayment = Payment::where('user_id' , '=' , $property->userId);
        $oldPayment = $oldPayment->where('used' , '='  , 1);
        $oldPayment = $oldPayment->where('status' , '=' , 'paid');
        //$oldPayment = $oldPayment->where('package', 'like' , '%'.$oldPackage->title .'%');
        $oldPayment = $oldPayment->first();

        $newPayments = Payment::where('user_id' , '=' , $property->userId);
        $newPayments = $newPayments->where('used' , '=' , 0);
        $newPayments = $newPayments->where('status' , '=' , 'paid');
        $newPayments = $newPayments->where('package', '=' , $newPackage->title);
        $newPayments = $newPayments->first();



        if ($newPayments != null && $oldPayment != null  ){
            $oldPayment->used = 0;
            $oldPayment->save();
            $newPayments->used = 1 ;
            $newPayments->save();
            $property->packageId = $newPackage->id;
            $property->save();
            return redirect('/commercial/'.$property->id ) ;
        }
        else{
            return redirect('/pricing ' );
        }




    }

}
