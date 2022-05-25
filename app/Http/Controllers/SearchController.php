<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\commercial;
use App\Models\CommercialImage;
use App\Models\commTypes;
use App\Models\Company;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchAgent(Request $request)
    {

        if (isset($request->name)) {
            $searched = $request->name;
            $searchBy = $request->searchBy;
            $results = [];
            if ($searchBy == 'name') {
                $results = User::where('role', '=', 1)->where('name', 'like', '%' . $searched . '%')->get();
                foreach ($results as $user) {
                    $user->company = Company::where('AgentId', $user->id)->first();
                }
            }
            if ($searchBy == 'companyName') {
                $companies = Company::where('name', 'like', '%' . $searched . '%')->get();
                foreach ($companies as $company) {
                    $user = User::findOrFail($company->AgentId);
                    $user->company = $company;
                    $results[$user->id] = $user;
                }
            }

//        if ($type == 'location'){
//
//        }
            $type = $request->type;


        } else {
            $searched = '';
            $results = User::where('role', 1)->get();
            $type = 'agents';
            dd($results);
        }
        return view('searchResults', compact('searched', 'results', 'type'));

    }

    public function searchProperties(Request $request)
    {
        $properties = Property::where('accepted', '=', 1);
        $properties = $properties->where('locationDescription', 'like', '%' . $request->location . '%')->orWhere('description', 'like', '%' . $request->location . '%');

        if ($request->type != -1) {
            $properties = $properties->where('typeId', '=', $request->type);
        }
        if ($request->category != -1) {
            $properties = $properties->where('categoryId', '=', $request->category);
        }
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $properties = $properties->where('price', '>', $request->minPrice)->where('price', '<', $request->maxPrice);

        $bedroomsNumber = -1;
        if ($request->bedroomsNumber != -1) {
            $bedroomsNumber = $request->bedroomsNumber;
            $properties = $properties->where('bedroomsNumber', '>=', $request->bedroomsNumber);
        }
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
        $searched = $request->location;
        $type = "properties";
        $categories = Category::all();
        $types = PropertyType::all();
        $category = $request->category;


        return view('Properties.index', compact('searched', 'properties', 'type', 'categories', 'minPrice', 'maxPrice', 'bedroomsNumber', 'types', 'category'));
    }

    public function searchCommercials(Request $request)
    {
        $commercials = commercial::where('accepted', '=', 1);
        $commercials = $commercials->where('location', 'like', '%' . $request->location . '%')->orWhere('description', 'like', '%' . $request->location . '%');

        if ($request->type != -1) {
            $commercials = $commercials->where('type', '=', $request->type);
        }
        if ($request->category != -1) {
            $commercials = $commercials->where('category', '=', $request->category);
        }
        $commercials = $commercials->where('price', '>', $request->minPrice)->where('price', '<', $request->maxPrice);
        $commercials = $commercials->where('floor', '>', $request->minFloor)->where('floor', '<', $request->maxFloor);


        if (isset($request->sort) && $request->sort != -1) {
            switch ($request->sort) {
                case 'priceHighToLow':
                    $commercials = $commercials->orderBy('price', 'Desc');
                    break;

                case 'updated_at':
                    $commercials = $commercials->orderBy('updated_at', 'Desc');
                    break;
                case 'priceLowToHigh':
                    $commercials = $commercials->orderBy('price');
                    break;
            }
        }

        $commercials = $commercials->get();

        foreach ($commercials as $commercial) {
            $commercial->images = CommercialImage::where('commercialId', $commercial->id)->get();
        }
        $searched = $request->location;
        $types = commTypes::all();
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;

        $minFloor = $request->minFloor;
        $maxFloor = $request->maxFloor;

        $category = $request->category;

        return view('commercial.indexCommercial', compact('searched', 'commercials', 'types', 'minPrice', 'maxPrice', 'minFloor', 'maxFloor', 'category'));

    }
}
