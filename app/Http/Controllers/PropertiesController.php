<?php

namespace App\Http\Controllers;

use App\Mail\Inspect;
use App\Mail\NewPropertyMail;
use App\Mail\PropertyAcceptedMail;
use App\Mail\PropertyCreated;
use App\Mail\PropertyUpdated;
use App\Models\Category;
use App\Models\commercial;
use App\Models\History;
use App\Models\InspectionTime;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest() || (!Auth::guest() && Auth::user()->role != 0)) {
            $categories = Category::all();
            $types = PropertyType::all();
            $properties = Property::where('accepted', '=', 1)->orderBy('updated_at')->take(6)->get();
            /*$properties = Property::all();where('accepted', '=', 1);*/
            /*
            $properties->images = PropertyImage::all()->where('propertyId' , $properties->id)->take(1);
            */
            foreach ($properties as $property) {
                $property->images = PropertyImage::all()->where('propertyId', $property->id)->take(1);
            }


            return view('welcome')->with('properties', $properties)->with('categories', $categories)->with('types', $types);

        } else {
            if (!Auth::guest()) {
                if (Auth::user()->role == 0) {
                    $allProperties = Property::all();
                    $allCommercials = commercial::all();
                    $allUsers = User::all();
                    $allPayments = Payment::where('status', '!=', 'pending')->get();
                    $allEarnings = $allPayments->where('created_at', '>=', new DateTime('today'));
                    $notAcceptedProperties = Property::where('accepted', '=', 0)->get();
                    $recentUsers = User::where('created_at', '>=', new DateTime('today'))->get();
                    $notAcceptedCommercials = commercial::where('accepted', '=', 0)->get();

                    return view("welcome", compact('notAcceptedProperties', 'recentUsers', 'notAcceptedCommercials', 'allProperties', 'allCommercials', 'allUsers', 'allPayments', 'allEarnings'));
                }
            }
        }
        return view('welcome');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $property = Property::findOrFail($request['id']);
        $property->accepted = 1;
        $property->contactInfo = $request['contactInfo'];
        $property->save();

        $history = new History;
        $history->propertyId = $property->id;
        $history->post_description = $property->description;
        $history->post_price = $property->price;
        $history->post_roomsNumber = $property->roomsNumber;
        $history->post_bathroomsNumber = $property->bathroomsNumber;
        $history->post_parkingNumber = $property->parkingNumber;
        $history->post_bedroomsNumber = $property->bedroomsNumber;
        $history->post_accepted = $property->accepted;
        $history->post_userId = $property->userId;
        $history->post_category = Category::findOrFail($property->categoryId)->title;
        $history->post_type = PropertyType::findOrFail($property->typeId)->title;
        $history->post_locationDescription = $property->locationDescription;
        $history->post_contactInfo = $property->contactInfo;
        $history->post_longitude = $property->longitude;
        $history->post_latitude = $property->latitude;
        $history->isCreated = 0;
        $history->isUpdated = 1;
        $history->isDeleted = 0;
        $history->save();

        $user = User::findOrFail($property->userId);
        Mail::to($user->email)->send(new PropertyAcceptedMail());
        return redirect('/acceptProperties')->with('message', 'Property Accepted');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $payment = Payment::where('user_id', '=', $id);
        $packages = null;
        $aa[] = null;
        if ($payment != null) {
            $payment = $payment->where('status', '=', 'paid')->where('used', '=', 0)->get();
            /*foreach ($payment as $pay) {
                $pay->title = Packages::where('title', '=', $pay->package)->get();*/

            foreach ($payment as $pay) {
                $packages = Packages::where('title', '=', $pay->package)->first();
                if ($packages->id < 6) {
                    $aa[] += $packages->id;
                } elseif ($packages->id > 5 && $packages->id < 8) {
                    $aa[] += $packages->id;
                }

            }
            if (count($aa) == 1) {
                return redirect('/packages')->with('message', 'Please Register in a Residential package!');;

            } else {


                return view('Properties.create', compact('aa'));

            }
        } else {
            return redirect('/packages')->with('message', 'Please Register in a Residential  package!');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request);
        $this->validate($request, [
            'latitude' => 'required',
            'locationDescription' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required',
            'longitude' => 'required',

        ]);
        $property = new Property();
        $property->price = $request->price;
        $property->description = $request->description;
        $property->longitude = $request->longitude;
        $property->latitude = $request->latitude;
        $property->locationDescription = $request->locationDescription;

        if (isset($request->showPrice)) $property->showPrice = $request->showPrice; else $property->showPrice = 0;

        if ($request->bedroomsNumber != -1) {
            $property->bedroomsNumber = $request->bedroomsNumber;
        }
        if ($request->bathroomsNumber != -1) {
            $property->bathroomsNumber = $request->bathroomsNumber;
        }
        if ($request->parkingNumber != -1) {
            $property->parkingNumber = $request->parkingNumber;
        }
        $property->accepted = 0;
        $property->userId = Auth::user()->id;
        $property->categoryId = $request->category;
        $property->packageId = $request->packageId;
        $property->typeId = $request->type;

        $property->save();
        // Handle File Upload
        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                if ($image->getClientOriginalExtension() == 'mp4') {
                    // Get filename with the extension
                    $filenameWithExt = $image->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $image->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $image->storeAs('public/properties_images', $fileNameToStore);

                    $image = new PropertyImage;
                    $image->propertyId = $property->id;
                    $image->url = $fileNameToStore;
                    $image->save();

                } else {
                    $Name = time() . '.' . $image->getClientOriginalExtension();

                    $destinationPath = public_path('storage/properties_images/');
                    $img = Image::make($image->getRealPath());
                    $img->resize(650, 650, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath . '/' . time() . $image->getClientOriginalName());

                    /*$user->profileImg = time().$image->getClientOriginalName();*/
                    $fileNameToStore = time() . $image->getClientOriginalName();
                    $image = new PropertyImage;
                    $image->propertyId = $property->id;
                    $image->url = $fileNameToStore;
                    $image->save();


                    $destinationPath = public_path('/storage/images');
                    //$image->move($destinationPath, $Name);
                }


            }
        }

        $history = new History;
        $history->propertyId = $property->id;
        $history->post_description = $property->description;
        $history->post_price = $property->price;
        $history->post_roomsNumber = $property->roomsNumber;
        $history->post_bathroomsNumber = $property->bathroomsNumber;
        $history->post_parkingNumber = $property->parkingNumber;
        $history->post_bedroomsNumber = $property->bedroomsNumber;
        $history->post_accepted = $property->accepted;
        $history->post_userId = $property->userId;
        $history->post_category = Category::findOrFail($property->categoryId)->title;
        $history->post_type = PropertyType::findOrFail($property->typeId)->title;
        $history->post_locationDescription = $property->locationDescription;
        $history->post_contactInfo = $property->contactInfo;
        $history->post_longitude = $property->longitude;
        $history->post_latitude = $property->latitude;
        $history->isCreated = 1;
        $history->isUpdated = 0;
        $history->isDeleted = 0;
        $history->save();


        $package = Packages::findOrFail($request->packageId);
        $payment = Payment::all()->where('user_id', '=', Auth::user()->id)->where('package', '=', $package->title)->where('used', '=', 0)->first();
        $payment->used = 1;
        $payment->save();


        $mail = Auth::user()->email;
        Mail::to('ozpropertymarket@gmail.com')->send(new NewPropertyMail());
        Mail::to($mail)->send(new PropertyCreated());

        return redirect('/properties/myProperties')->with('message', 'Property Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);
        $property->agent = User::findOrFail($property->userId);


        $property->images = PropertyImage::where('propertyId', $property->id)->get();
        $inspectionTime = InspectionTime::where('propertyId', $property->id)->get();

        return view("Properties.show")->with('user', $property)->with('inspectionTime', $inspectionTime);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Property::findOrFail($id);
        return view('properties.edit', compact('user'));
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
//        dd($request);
        $this->validate($request, [
            'description' => 'required',
            'price' => 'required',
        ]);
        $property = Property::findOrFail($id);
        $property->price = $request->price;
        $property->description = $request->description;
        if (isset($request->showPrice)) $property->showPrice = $request->showPrice; else $property->showPrice = 0;

        if ($request->bedroomsNumber != -1) {
            $property->bedroomsNumber = $request->bedroomsNumber;
        }
        if ($request->bathroomsNumber != -1) {
            $property->bathroomsNumber = $request->bathroomsNumber;
        }
        if ($request->parkingNumber != -1) {
            $property->parkingNumber = $request->parkingNumber;
        }
        $property->accepted = 0;
        $property->categoryId = $request->category;
        $property->typeId = $request->type;
        $property->contactInfo = null;

        $property->save();
        // Handle File Upload
        if (isset($request->images)) {
            if (count($request->images) > 0) {
                $this->deleteImages($id);
                foreach ($request->images as $image) {
                    if ($image->getClientOriginalExtension() == 'mp4') {
                        // Get filename with the extension
                        $filenameWithExt = $image->getClientOriginalName();
                        // Get just filename
                        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        // Get just ext
                        $extension = $image->getClientOriginalExtension();
                        // Filename to store
                        $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                        // Upload Image
                        $path = $image->storeAs('public/properties_images', $fileNameToStore);

                        $image = new PropertyImage;
                        $image->propertyId = $property->id;
                        $image->url = $fileNameToStore;
                        $image->save();
                    } else {
                        $Name = time() . '.' . $image->getClientOriginalExtension();

                        $destinationPath = public_path('storage/properties_images/');

                        $img = Image::make($image->getRealPath());
                        $img->resize(650, 650, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . '/' . time() . $image->getClientOriginalName());

                        /*$user->profileImg = time().$image->getClientOriginalName();*/
                        $fileNameToStore = time() . $image->getClientOriginalName();
                        $image = new PropertyImage;
                        $image->propertyId = $property->id;
                        $image->url = $fileNameToStore;
                        $image->save();


                        $destinationPath = public_path('/storage/images');
                        //$image->move($destinationPath, $Name);
                    }
                }
            }
        }

        $history = new History;
        $history->propertyId = $property->id;
        $history->post_description = $property->description;
        $history->post_price = $property->price;
        $history->post_roomsNumber = $property->roomsNumber;
        $history->post_bathroomsNumber = $property->bathroomsNumber;
        $history->post_parkingNumber = $property->parkingNumber;
        $history->post_bedroomsNumber = $property->bedroomsNumber;
        $history->post_accepted = $property->accepted;
        $history->post_userId = $property->userId;
        $history->post_category = Category::findOrFail($property->categoryId)->title;
        $history->post_type = PropertyType::findOrFail($property->typeId)->title;
        $history->post_locationDescription = $property->locationDescription;
        $history->post_contactInfo = $property->contactInfo;
        $history->post_longitude = $property->longitude;
        $history->post_latitude = $property->latitude;
        $history->isCreated = 0;
        $history->isUpdated = 1;
        $history->isDeleted = 0;
        $history->save();
        Mail::to('ozpropertymarket@gmail.com')->send(new PropertyUpdated());
        return redirect('/properties/' . $property->id)->with('message', 'Property Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->delete($id);
        if (Auth::user()->role == 0) {
            return redirect('/acceptProperties')->with('message', 'Property Deleted!');
        } else {
            return redirect('properties/myProperties')->with('message', 'Property Deleted!');
        }
    }

    public function delete($id)
    {
        $property = Property::findOrFail($id);

        $history = new History;
        $history->propertyId = $property->id;
        $history->post_description = $property->description;
        $history->post_price = $property->price;
        $history->post_roomsNumber = $property->roomsNumber;
        $history->post_bathroomsNumber = $property->bathroomsNumber;
        $history->post_parkingNumber = $property->parkingNumber;
        $history->post_bedroomsNumber = $property->bedroomsNumber;
        $history->post_accepted = $property->accepted;
        $history->post_userId = $property->userId;
        $history->post_category = Category::findOrFail($property->categoryId)->title;
        $history->post_type = PropertyType::findOrFail($property->typeId)->title;
        $history->post_locationDescription = $property->locationDescription;
        $history->post_contactInfo = $property->contactInfo;
        $history->post_longitude = $property->longitude;
        $history->post_latitude = $property->latitude;
        $history->isCreated = 0;
        $history->isUpdated = 0;
        $history->isDeleted = 1;
        $history->save();

        $this->deleteImages($property->id);

        $property->delete();
    }

    public function deleteImages($id)
    {
        $imags = PropertyImage::where('propertyId', '=', $id);
        $images = $imags->get();
        foreach ($images as $image) {
            $path = public_path() . '\storage\properties_images\\' . $image->url;
            if (file_exists($path)) {
                Storage::delete('public/properties_image/' . $image->url);
                //$path = public_path() . '\storage\properties_images\\' . $image->url;
                unlink($path);
            }
        }
        $imags->delete();
    }

    public function buyIndex(Request $request)
    {

        //$category = Category::where('title', '=', 'Buy')->first();
        //$properties = Property::where('categoryId', $category->id)->where('accepted', '=', 1);
        $properties = Property::whereIn('categoryId', [1])->where('accepted', '=', 1)->where('packageId', '>', 0);
        if (isset($request->sort) && $request->sort != -1) {
            switch ($request->sort) {
                case 'priceHighToLow':
                    $properties = $properties->orderBy('price', 'Desc');
                    break;

                case 'updated_at':
                    $properties = $properties->orderBy('updated_at', 'Desc');
                    break;
                case 'priceLowToHigh':
                    $properties = $properties->orderBy('price');
                    break;
            }
        }
        $properties = $properties->get();
        foreach ($properties as $property) {
            $property->images = PropertyImage::where('propertyId', $property->id)->get();
        }
        $categories = Category::all();
        $types = PropertyType::all();


        return view("Properties.index", compact('properties', 'categories', 'types'));
    }

    public function rentIndex(Request $request)
    {
//        $category = Category::where('title', '=', 'Rent')->orWhere('title', '=', 'Share')->get();
        $properties = Property::whereIn('categoryId', [2, 3])->where('accepted', '=', 1)->where('packageId', '>', 0);
        if (isset($request->sort) && $request->sort != -1) {
            switch ($request->sort) {
                case 'priceHighToLow':
                    $properties = $properties->orderBy('price', 'Desc');
                    break;

                case 'updated_at':
                    $properties = $properties->orderBy('updated_at', 'Desc');
                    break;
                case 'priceLowToHigh':
                    $properties = $properties->orderBy('price');
                    break;
            }
        }
        $properties = $properties->get();
        foreach ($properties as $property) {
            $property->images = PropertyImage::where('propertyId', $property->id)->get();
        }
        $categories = Category::all();
        $types = PropertyType::all();


        return view("Properties.index", compact('properties', 'categories', 'types'));
    }

    public function viewNotAcceptedProperties()
    {
        if (Auth::user()->role == 0) {
            $notAcceptedProperties = Property::where('accepted', '=', 0)->get();
            foreach ($notAcceptedProperties as $property) {
                $property->images = PropertyImage::where('propertyId', $property->id)->get();
                $property->agent = User::find($property->userId);
            }
            return view("AdminPages.acceptProperties", compact('notAcceptedProperties'));
        }
    }

    public function allAcceptedProperties()
    {
        $properties = Property::where('accepted', '=', 1)->get();
        foreach ($properties as $property) {
            $property->images = PropertyImage::where('propertyId', $property->id)->get();
            $property->agent = User::find($property->userId);
        }
        return view('AdminPages.allProperties', compact('properties'));
    }

    public function myProperties()
    {

        $properties = Property::where('userId', '=', Auth::id())->get();
        foreach ($properties as $property) {
            $property->images = PropertyImage::where('propertyId', $property->id)->get();
        }
        return view("Properties.myProperties", compact('properties'));
    }

    public function showProperty(Request $request)
    {
        $property = Property::findOrFail($request->id);
        $property->accepted = 1;
        $property->save();
        return redirect('/properties/' . $property->id);
    }

    public function hideProperty(Request $request)
    {
        $property = Property::findOrFail($request->id);
        $property->accepted = 0;
        $property->save();
        return redirect('/properties/' . $property->id);
    }

    public function package($id, $amount)
    {
        $pack = Packages::findOrFail($id);
        $pack->amount = $amount;
        return view('Packages.order', compact('pack'));
    }


    public function upgradePackage(Request $request)
    {

        $newPackage = Packages::findOrFail($request->newPackageId);
        if ($request->oldPackage != 0) {
            $oldPackage = Packages::findOrFail($request->oldPackage);
        }
        $property = Property::findOrFail($request->propertyId);


        $oldPayment = Payment::where('user_id', '=', $property->userId);
        $oldPayment = $oldPayment->where('used', '=', 1);
        $oldPayment = $oldPayment->where('status', '=', 'paid');
        $oldPayment = $oldPayment->where('package', 'like', '%' . $oldPackage->title . '%');
        $oldPayment = $oldPayment->first();


        $newPayments = Payment::where('user_id', '=', $property->userId);
        $newPayments = $newPayments->where('used', '=', 0);
        $newPayments = $newPayments->where('status', '=', 'paid');
        $newPayments = $newPayments->where('package', '=', $newPackage->title);
        $newPayments = $newPayments->first();

        if ($request->oldPackage == 0) {
            $newPayments->used = 1;
            $newPayments->save();
            $property->packageId = $newPackage->id;
            if ($newPackage->id == 6 || $newPackage->id == 7) {
                $property->categoryId = 2;
            } else {
                $property->categoryId = 1;
            }
            $property->save();
            return redirect('/properties/' . $property->id);
        } else {
            if ($newPayments != null && $oldPayment != null) {
                $oldPayment->used = 0;
                $oldPayment->save();
                $newPayments->used = 1;
                $newPayments->save();
                $property->packageId = $newPackage->id;
                if ($newPackage->id == 6 || $newPackage->id == 7) {
                    $property->categoryId = 2;
                } else {
                    $property->categoryId = 1;
                }
                $property->save();
                return redirect('/properties/' . $property->id);
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
        $property = Property::findOrFail($id);

        $property->images = PropertyImage::where('propertyId', $property->id)->get();
        $pdf = PDF::loadView('pdf.brochure', compact('property'));

        return $pdf->download('brochure.pdf');
    }

    public function setInspection(Request $request)
    {


        $inspect = new InspectionTime;
        $inspect->propertyId = $request->id;
        $inspect->date = $request->date;
        $inspect->startTime = $request->startTime;
        $inspect->endTime = $request->endTime;
        $inspect->save();

        return redirect('/properties/' . $request->id);


    }

    public function deleteInspection($id)
    {
        $ins = InspectionTime::findOrFail($id);
        $property = Property::findOrFail($ins->propertyId);
        $ins->delete();
        return redirect('/properties/' . $property->id)->with('message', 'Inspection time deleted successfully!');
    }

    public function Inspect($id)
    {
        $ins = InspectionTime::findOrFail($id);
        $property = Property::findOrFail($ins->propertyId);
        $user = User::findOrFail($property->userId);

        $data = array(
            'propertyId' => $property->id,
            'address' => $property->locationDescription,
            'phone' => Auth::user()->phoneNumber,

            'userId' => Auth::user()->id,
            'userName' => Auth::user()->name,
            'userEmail' => Auth::user()->email,
            'date' => $ins->date,
            'time' => $ins->startTime,

        );
        Mail::to($user->email)->send(new Inspect($data));
        return redirect('/properties/' . $property->id)->with('message', 'Inspection request sent to the owner successfully! ');;
    }

    public function soldProperty(Request $request)
    {
        $property = \App\Models\Property::findOrFail($request->propertyId);
        $property->sold = 1;
        $property->save();

        $sold = new \App\Models\SoldProperty();
        $sold->propertyId = $request->propertyId;
        $sold->type = 1;
        $sold->extra = "";
        $sold->save();
        return redirect('/properties/' . $property->id)->with('message', 'Property marked as SOLD successfully');


    }

    public function apiGetAllProperties()
    {
        $properties = Property::all();
        foreach ($properties as $property) {
            $property->images = PropertyImage::where('propertyId', $property->id)->get();
        }
        return $properties;
    }

    public function apiStore(Request $request)
    {

        $property = new Property();
        $property->price = $request->price;
        $property->description = $request->description;
        $property->longitude = $request->longitude;
        $property->latitude = $request->latitude;
        $property->locationDescription = $request->locationDescription;

        if (isset($request->showPrice)) $property->showPrice = $request->showPrice; else $property->showPrice = 0;

        $property->bedroomsNumber = $request->roomsNumber;
        $property->accepted = 0;
        $property->userId = $request->creatorId;
        $property->categoryId = $request->categoryId;
        $property->typeId = $request->listingTypeId;
        $property->contactInfo = $request->contactInfo;
        $property->save();
        // Handle File Upload
        if ($request->hasFile('images')) {

            $Name = time() . '.' . $request->image->getClientOriginalExtension();

            $destinationPath = public_path('storage/properties_images/');
            $img = Image::make($request->image->getRealPath());
            $img->resize(650, 650, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . time() . $request->image->getClientOriginalName());

            $fileNameToStore = time() . $request->image->getClientOriginalName();
            $image = new PropertyImage;
            $image->propertyId = $property->id;
            $image->url = $fileNameToStore;
            $image->save();
        }

        return response()->json([
            $property
        ], 202);
    }

}
