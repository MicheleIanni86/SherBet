<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prediction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Calendar;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        // recupero tutto il calendario
        $calendar = Calendar::all();
        // prendo array con valori unici delle giornate
        $days = [];

        foreach ($calendar as $day) {
            $days[] = $day->round;
        }

        $days_array = array_unique($days); 
        $first_day = Calendar::where('round', '=', 1)->get();
        return view('admin.prediction', compact('calendar', 'days_array', 'first_day'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function show(Prediction $prediction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function edit(Prediction $prediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediction $prediction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediction $prediction)
    {
        //
    }

    public function filter(Request $request) {
     
        $calendar = Calendar::all()->toArray();
        $filter = $request->input('filter', '');
       
        $filtered_calendar = array_filter($calendar, function ($single_day) use ($filter) {
            return $filter == $single_day['round'];
        });
      
        return response()->json($filtered_calendar);
    }
}
