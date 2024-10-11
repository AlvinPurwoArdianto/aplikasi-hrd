<?php

namespace App\Http\Controllers;

use App\Models\Rekrutmen;
use Illuminate\Http\Request;

class RekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekrutmen = Rekrutmen::latest()->get();
        confirmDelete('Hapus Rekrutmen!', 'Apakah Anda Yakin?');
        return view('admin.rekrutmen.index', compact('rekrutmen'));

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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
