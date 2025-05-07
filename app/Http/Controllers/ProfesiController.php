<?php

namespace App\Http\Controllers;

use App\Models\Profesi;
use App\Models\KategoriProfesi;
use Illuminate\Http\Request;

class ProfesiController extends Controller
{
    public function index() {
        $kategori = KategoriProfesi::with('profesi')->get();
        return view('profesi.index', compact('kategori'));
    }

    public function store(Request $request) {
        Profesi::create($request->all());
        return response()->json(['message' => 'Profesi berhasil ditambahkan']);
    }

    public function update(Request $request, $id) {
        $profesi = Profesi::findOrFail($id);
        $profesi->update($request->all());
        return response()->json(['message' => 'Profesi berhasil diperbarui']);
    }

    public function destroy($id) {
        $profesi = Profesi::findOrFail($id);
        $profesi->delete();
        return response()->json(['message' => 'Profesi berhasil dihapus']);
    }

    public function edit($id) {
        return response()->json(Profesi::findOrFail($id));
    }
}

