<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opozdun;
use Illuminate\Http\Request;

class OpozdunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOpozdun(Request $request)
    {
        $answers = $request->all();

        $opozdun = new Opozdun([
            'user_id' => $answers['user_id'],
            'opozdun_type_id' => $answers['opozdun_type_id'],
            'answer' => $answers['answer'],
        ]);
        $opozdun->save();

        return response()->json($opozdun, 200);
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
    public function show(Opozdun $opozdun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opozdun $opozdun)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opozdun $opozdun)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opozdun $opozdun)
    {
        //
    }
}
