<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\GuideBooking;
use App\gudregisters;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
Use Illuminate\Support\Carbon;

use App\Http\Requests\GuideBookingRequest;

class GuideBookingController extends Controller
{

    public function index2($id){
        $guide = gudregisters::find($id);
        $gudbooking=GuideBooking::paginate(15);


        return view('tourist.booking_form.guide_booking',compact('guide'));
    }
    

    /**
     * 
     *
     * @param  array  $data
     * @return \App\User
     */
    
    public function create(GuideBookingRequest $request)
    {
      
        $this -> validate($request,[
            'start_date' => 'required|date|after_or_equal:tomorrow',
            'end_date' => 'required|date|after_or_equal:start_date',
            'district' =>'required',
            'nop' =>'min:1|max:20|numeric',
            'note' =>'max:255', 
        ]);  

        $booking =new GuideBooking;
        $booking->tourist_id = Auth::user()->id;
        $booking->guide_id = $request->guide_id;
        $booking->start_date = $request->start_date;
        $booking->end_date = $request->end_date;
        $booking->district = $request->district;
        $booking->nop = $request->nop;
        $booking->note =$request->note;
        $booking->book_flag =0;
        $booking->finiesd_flag =0;

        $booking->save();

        $num = $request->guide_id;
        $num2 = Auth::user()->id;
       
        return redirect()->route('status_guide', [$num,$num2]);
       
        
    }

    public function show($id)
    {
        //
    }
    

    public function edit($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       

        $gudbooking=GuideBooking::find($id);
        $gudbooking ->book_flag = $request->input('book_flag');
        
        $gudbooking ->finiesd_flag = $request->input('finished_flag');
        $gudbooking->save();
        
        return back();
    }

}
