<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreHewanRequest;
use App\Http\Requests\UpdateHewanRequest;
use App\Models\Genre;

class HewanController extends Controller
{
    /**
     * Display all hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hewans = Hewan::with('genre')->latest()->paginate(10);
        return view('hewan.index', compact('hewans'));
    }

    /**
     * Show form for creating hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        $hewan = new Hewan();
        return view('hewan.create', compact('genres', 'hewan'));
    }

    /**
     * Store a newly created hewan
     *
     * @param Hewan $hewan
     * @param StoreHewanRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Hewan $hewan, StoreHewanRequest $request)
    {
        //For demo purposes only. When creating hewan or inviting a hewan
        // you should create a generated random password and email it to the hewan

        $data = $request->validated();

        if($request->file('objek')){
            $file= $request->file('objek');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('img'), $filename);
            $data['objek']= $filename;
        }

        $hewan->create($data);

        return redirect()->route('hewan.index')
            ->withSuccess(__('Hewan berhasil ditambahkan.'));
    }

    /**
     * Show hewan data
     *
     * @param Hewan $hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Hewan $hewan)
    {
        return view('hewan.show', [
            'hewan' => $hewan
        ]);
    }

    /**
     * Edit hewan data
     *
     * @param Hewan $hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Hewan $hewan)
    {
        return view('hewan.edit', [
            'hewan' => $hewan,
            'genres' => Genre::latest()->get()
        ]);
    }

    /**
     * Update hewan data
     *
     * @param Hewan $hewan
     * @param UpdateHewanRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Hewan $hewan, UpdateHewanRequest $request)
    {
        $data = $request->validated();

        if($request->file('objek')){
            $file= $request->file('objek');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('img'), $filename);
            $data['objek']= $filename;
        }

        $hewan->update($data);


        return redirect()->route('hewan.index')
            ->withSuccess(__('Hewan berhasil diubah.'));
    }

    /**
     * Delete hewan data
     *
     * @param Hewan $hewan
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hewan $hewan)
    {
        $hewan->delete();

        return redirect()->route('hewan.index')
            ->withSuccess(__('Hewan berhasil dihapus.'));
    }
}
