<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galleries;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class ApartmentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Apartments/Index');
    }

    public function create()
    {
        $city = DB::table('tinh_thanh_pho')->get();
        return Inertia::render('Admin/Apartments/Create', [
            'city' => $city,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'website' => 'url',
            'phone' => 'numeric|required|digits:10',
            'city' => 'required',
            'state' => 'required',
            'street' => 'required',
            'zip' => 'required|numeric',
            'apartments.*.bathrooms' => 'required',
            'apartments.*.bedrooms' => 'required',
            'apartments.*.rent' => 'required',
            'apartments.*.sqft' => 'required',
            'apartments.*.unit' => 'required',
            'images' => 'mimes:jpg,bmp,png,jpeg,PNG',
        ]);

        try {
            DB::beginTransaction();
            $property = Properties::create([
                'name' => $request->input('name'),
                'website' => $request->input('website'),
                'phone_number' => $request->input('phone'),
                'city' => $request->input('city'),
                'about' => $request->input('about'),
                'state' => $request->input('state'),
                'street' => $request->input('street'),
                'zip' => $request->input('zip'),
            ]);

            $property->apartments()->createMany($request->apartments);

            if($request->hasFile('images')) {
                $files = $request->images;

                foreach ($files as $key => $file) {
                    $path = $file->store('/files/properties/', 'local');

                    $gallery = new Galleries();
                    $gallery->name = $file->getClientOriginalName();
                    $gallery->url = $path;

                    $property->galleries()->save($gallery);
                }
            }

            DB::commit();
            return redirect()->route('apartment.index')->with('notificaton', 'Tag deleted');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("message: " . $e->getMessage() . ' ---- line: ' . $e->getLine());
        }

    }
}
