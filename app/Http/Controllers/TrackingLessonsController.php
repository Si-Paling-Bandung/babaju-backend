<?php

namespace App\Http\Controllers;

use App\Models\TrackingLessons;
use Illuminate\Http\Request;
use DataTables;

class TrackingLessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TrackingLessons::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.tracking.tracking');
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
     * @param  \App\Models\TrackingLessons  $trackingLessons
     * @return \Illuminate\Http\Response
     */
    public function show(TrackingLessons $trackingLessons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrackingLessons  $trackingLessons
     * @return \Illuminate\Http\Response
     */
    public function edit(TrackingLessons $trackingLessons)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrackingLessons  $trackingLessons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrackingLessons $trackingLessons)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrackingLessons  $trackingLessons
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrackingLessons $trackingLessons)
    {
        //
    }
}
