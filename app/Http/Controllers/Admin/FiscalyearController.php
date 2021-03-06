<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fiscalyear;

class FiscalyearController extends Controller
{
    protected $fiscalyear = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Fiscalyear $_fiscalyear)
    {
        $this->fiscalyear = $_fiscalyear;
    }
    public function index()
    {
        $details = $this->fiscalyear->orderBy('created_at', 'DESC')->get();
        return view('admin.fiscalyear.list', compact('details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fiscalyear.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $formData = $request->except(['published']);
        $formData['published'] = is_null($request->published) ? 0 : 1;

        $this->fiscalyear->create($formData);
        return redirect()->route('fiscalyear.index')->with('message', 'Fiscalyear created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail = $this->fiscalyear->findOrFail($id);
        return view('admin.fiscalyear.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $oldRecord = $this->fiscalyear->findOrFail($id);
        $formData = $request->except(['published']);

        $formData['published'] = is_null($request->published) ? 0 : 1;
        $oldRecord->update($formData);

        return redirect()->route('fiscalyear.index')->with('message', 'Fiscalyear updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->fiscalyear->findOrFail($id)->delete();

        return redirect()->route('fiscalyear.index')->with('message', 'Fiscalyear deleted successfully!');
    }
}
