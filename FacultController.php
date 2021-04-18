<?php

namespace App\Http\Controllers;

use App\Models\Facult;
use Illuminate\Http\Request;

class FacultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facult = Facult::all();
        return view('backend.pages.facult.index',compact('faculty'));
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
     * @param  \App\Models\Facult  $facult
     * @return \Illuminate\Http\Response
     */
    public function show(Facult $facult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facult  $facult
     * @return \Illuminate\Http\Response
     */
    public function edit(Facult $facult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facult  $facult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facult $facult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facult  $facult
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facult $facult)
    {
        //
    }
}
