<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Citizen;
use App\Models\Panchayat;
use App\Models\State;
use App\Models\Village;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('citizens.index');
    }

    public function list()
    {
        return Citizen::with('village.panchayat.block.state')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::all();
        return view('citizens.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'citizen_name'   => 'required|unique:citizens,citizen_name',
            'village_id'     => 'required|exists:villages,id',
            'gender'         => 'required|in:Male,Female,Other',
            'citizen_phone'  => 'required|unique:citizens,citizen_phone|max:15',
            'citizen_email'  => 'required|email|unique:citizens,citizen_email',
        ]);

        Citizen::create([
            'citizen_name'   => $request->citizen_name,
            'village_id'     => $request->village_id,
            'gender'         => $request->gender,
            'citizen_phone'  => $request->citizen_phone,
            'citizen_email'  => $request->citizen_email,
        ]);

        return response()->json(['success' => true]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $citizen = Citizen::findOrFail($id);
        $states = State::all();
        $blocks = Block::where('state_id', $citizen->village->panchayat->block->state_id)->get();
        $panchayats = Panchayat::where('block_id', $citizen->village->panchayat->block_id)->get();
        $villages = Village::where('panchayat_id', $citizen->village->panchayat_id)->get();

        return view('citizens.edit', compact('citizen', 'states', 'blocks', 'panchayats', 'villages'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $citizen = Citizen::findOrFail($id);

        $request->validate([
            'citizen_name'   => 'required|max:100|unique:citizens,citizen_name,' . $id,
            'village_id'     => 'required|exists:villages,id',
            'gender'         => 'required|in:Male,Female,Other',
            'citizen_phone'  => 'required|max:15|unique:citizens,citizen_phone,' . $id,
            'citizen_email'  => 'required|email|max:100|unique:citizens,citizen_email,' . $id,
        ]);

        $citizen->update([
            'citizen_name'   => $request->citizen_name,
            'village_id'     => $request->village_id,
            'gender'         => $request->gender,
            'citizen_phone'  => $request->citizen_phone,
            'citizen_email'  => $request->citizen_email,
        ]);

        return response()->json(['success' => true]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $citizen = Citizen::findOrFail($id);
        $citizen->delete();

        return response()->json(['success' => true]);
    }

    public function getBlocks($state_id)
    {
        return Block::where('state_id', $state_id)->get();
    }

    public function getPanchayats($block_id)
    {
        return Panchayat::where('block_id', $block_id)->get();
    }

    public function getVillages($panchayat_id)
    {
        return Village::where('panchayat_id', $panchayat_id)->get();
    }
}
