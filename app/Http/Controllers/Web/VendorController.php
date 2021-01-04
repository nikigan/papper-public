<?php

namespace Vanguard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $vendors = Vendor::query()->where('creator_id', auth()->id())->get();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('vendors.create', ['edit' => false]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'vat_number' => 'required|unique:vendors'
        ]);

        Vendor::query()->create($request->all() + [
                'creator_id' => auth()->id()
            ]);
        return redirect()->route('vendors.index')->with('success', __('Vendor created successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param Vendor $vendor
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Vendor $vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Vendor $vendor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'vat_number' => 'required|unique:vendors'
        ]);

        $vendor->update($request->all());
        return redirect()->route('vendors.index')->with('success', __('Vendor info updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', __('Vendor deleted successfully.'));
    }
}
