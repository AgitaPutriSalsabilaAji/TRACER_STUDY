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
        $query = DB::table('profesi as p')
            ->join('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
            ->select('p.id', 'p.nama_profesi', 'kp.kategori_profesi');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                 if (strtolower($row->kategori_profesi) == 'belum bekerja') {
                    return '<span class="text-muted">Data ini tidak boleh diubah atau dihapus.</span>';
                }
                $editBtn = '<button onclick="editProfesi(\'/profesi/update/' . $row->id . '\', \'' . e($row->kategori_profesi) . '\', \'' . e($row->nama_profesi) . '\')" class="btn btn-sm btn-warning me-1"><i class="fa fa-edit"></i> Edit</button>';
                $deleteBtn = '<button onclick="deleteProfesi(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus</button>';
                return $editBtn . $deleteBtn;
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value'] != '') {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('p.nama_profesi', 'like', "%{$search}%")
                            ->orWhere('kp.kategori_profesi', 'like', "%{$search}%");
                    });
                }
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

        return redirect()->back()->with('success', 'Profesi berhasil ditambahkan. ');
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

    public function storeKategori(Request $request)
    {
        $request->validate([
            'kategori_profesi' => 'required|unique:kategori_profesi,kategori_profesi'
        ]);

        KategoriProfesi::create([
            'kategori_profesi' => $request->kategori_profesi
        ]);

        return response()->json(['success' => true]);
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'kategori_profesi' => 'required|unique:kategori_profesi,kategori_profesi,' . $id . ',id'
        ]);

        KategoriProfesi::where('id', $id)->update([
            'kategori_profesi' => $request->kategori_profesi
        ]);

        return response()->json(['success' => true]);
    }

    public function deleteKategori($id)
    {
        KategoriProfesi::destroy($id);
        return response()->json(['success' => true]);
    }
}
