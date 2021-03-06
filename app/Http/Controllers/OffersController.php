<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Http\Requests\Offer\UpdateRequest;
use App\Models\Offer;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Traits\OfferTrait;

class OffersController extends Controller
{
    use OfferTrait;

    public function index()
    {
        // return Offer::select('name', 'price', 'details')->get();
        // $offers = Offer::select('name', 'price', 'photo')->get();
        // dd($offers);

        // $offers = Offer::all();
        $offers = Offer::select(
            'id',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details',
            'price'
        )->get();
        // return $offers;
        // dd($offers);
        return view('offers.index', ['offers' => $offers]);
    }

    public function store(OfferRequest $request)
    {

        // dd($request->image);
        // $offer = Offer::create([
        //     'name' => 'test-name',
        //     'price' => 'test-price',
        //     'details' => 'test-details'
        // ]);

        // if($offer){
        //     return 'offer is created successfully';
        // }

        // return 'failed to store offer';

        /**
         *   validate data before store in the database
         * */
        // $data = $request->all();
        // $rules = $this->validationRules();
        // $messages = $this->validationMessages();

        // $validator = Validator::make(
        //     $data,
        //     $rules,
        //     $messages
        // );

        // if ($validator->fails()) {
        //     // dd($validator);
        //     // return $validator->errors();
        //     // return redirect('offers/create')->withErrors($validator);
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        /*******************************
         * save photo
         */
        $path = 'images/offers';
        $file_name = $this->saveImage($request->image, $path);
        // dd($file_name);
        // if ($image) {
        //     return 'moved';
        // }
        // return 'false';
        /*******************************
         * store data in database after validation
         */
        $offer = Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
            'price' => $request->price,
            'image' => $file_name,
        ]);

        // dd($offer);
        return view('offers.create', ['successAdded' => __('create-offer.success-offer')]);
    }

    // create form view
    public function create()
    {
        return view('offers.create');
    }

    // edit offer view
    public function edit($id)
    {
        // return $id;
        //$offer = Offer::findOrFail($id); //return Not Found if it was not found
        // dd($offer);
        // return $offer;
        $offer = Offer::find($id);
        if (!$offer) {
            return redirect()->back();
        }
        return view('offers.edit', ['offer' => $offer]);
    }

    // update offer view
    public function update(UpdateRequest $request, $id)
    {
        // dd($id);
        // $data = $request->validated();
        // dd($data);
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());
        // dd($request->all());
        // dd($offer);
        // $offer->name_ar = $request->name_ar;
        // $offer->name_en = $request->name_en;
        // $offer->details_ar = $request->details_ar;
        // $offer->details_en = $request->details_en;
        // $offer->price = $request->price;
        // $offer->save();
        // return $offer;
        //return redirect()->route('offers.index', ['updateMessage'=> __('index-offers.offer-updateSuccessfully')]);
        // return redirect()->route('offers.index')->with('updateMessage', __('index-offers.offer-updateSuccessfully'));
        return redirect()->back()->with('updateMessage', __('index-offers.offer-updateSuccessfully'));
    }

    public function destroy($id)
    {
        // return $id;
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return redirect()->route('offers.index')->with(['DeleteMessage' => __('index-offers.offer-deleteSuccessfully')]);
    }
    // protected function validationRules()
    // {
    //     return [
    //         'name' => 'required|unique:offers|max:255',
    //         'price' => 'required|max:255|min:1',
    //         'details' => 'required|min:10',
    //     ];
    // }

    // protected function validationMessages()
    // {
    //     return [
    //         'name.required' => __('messages.name.required'),
    //         'name.unique' => __('messages.name.unique'),
    //         'price.required' => __('messages.price.required'),
    //         'details.required' => __('messages.details.required'),
    //     ];
    // }

}
