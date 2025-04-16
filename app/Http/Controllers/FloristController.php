<?php

namespace App\Http\Controllers;

use App\Models\Florist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FloristController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Florist Test';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Florist $florist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Florist $florist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Florist $florist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Florist $florist)
    {
        //
    }
}
