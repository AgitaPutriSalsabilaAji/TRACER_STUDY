<?php

namespace App\Http\Controllers;

use App\Models\Profesi;
use App\Models\KategoriProfesi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfesiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Profesi',
            'list' => ['Home', 'Profesi']
        ];

        $page = (object) [
            'title' => 'Daftar profesi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'profesi';
        $kategoriList = KategoriProfesi::all();

        return view('data.pengelolaan_profesi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => 'profesi',
            'kategoriList' => $kategoriList

        ]);
    }
    public function list(Request $request)
    {
       
            $data = DB::table('profesi as p')
                ->join('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
                ->select('p.id', 'p.nama_profesi', 'kp.kategori_profesi')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn() // untuk DT_RowIndex
                ->addColumn('aksi', function ($row) {
                    $editBtn = '<button onclick="editProfesi(' . $row->id . ')" class="btn btn-sm btn-warning me-1">Edit</button>';
                    $deleteBtn = '<button onclick="deleteProfesi(' . $row->id . ')" class="btn btn-sm btn-danger">Hapus</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);     
    }

    
    public function store(Request $request)
    {
        $request->validate([
        'kategori_profesi_id' => 'required|exists:kategori_profesi,id',
        'profesi' => 'required|unique:profesi,nama_profesi'
        ]);

        Profesi::create([
            'kategori_profesi_id' => $request->kategori_profesi_id,
            'nama_profesi' => $request->profesi
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan. ');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_profesi_id' => 'required|exists:kategori_profesi,id',
            'profesi' => 'required|unique:profesi,nama_profesi,' . $id
        ]);

        Profesi::where('id', $id)->update([
            'kategori_profesi_id' => $request->kategori_profesi_id,
            'nama_profesi' => $request->profesi
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Profesi::destroy($id);
        return response()->json(['success' => true]);
    }
}
