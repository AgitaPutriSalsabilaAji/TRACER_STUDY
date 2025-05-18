<?php

namespace App\Http\Controllers;

use App\Models\Profesi;
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

        return view('data.pengelolaan_profesi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => 'profesi'
        ]);
    }
    
public function list(Request $request)
{
    // if ($request->ajax()) {
    //     $data = DB::table('profesi as p')
    //         ->join('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
    //         ->select('p.id', 'p.nama_profesi', 'kp.kategori_profesi as kategori_profesi', 'p.created_at', 'p.updated_at');

    //     return DataTables::of($data)
    //         ->addColumn('aksi', function ($row) {
    //             $editBtn = '<button onclick="editForm('.$row->id.')" class="btn btn-sm btn-warning me-1">Edit</button>';
    //             $deleteBtn = '<button onclick="deleteForm('.$row->id.')" class="btn btn-sm btn-danger">Hapus</button>';
    //             return $editBtn . $deleteBtn;
    //         })
    //         ->rawColumns(['aksi'])
    //         ->make(true);
    // }
   
            $data = DB::table('profesi as p')
            ->join('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
            ->select('p.id', 'p.nama_profesi', 'kp.kategori_profesi as kategori_profesi', 'p.created_at', 'p.updated_at');

        return DataTables::of($data)->make(true);
}

    public function create_ajax()
    {
        return view('data.pengelolaan_profesi.create_ajax');
    }
 
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori' => 'required|string|max:100',
                'nama_profesi' => 'required|string|max:100|unique:profesi,nama_profesi'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            Profesi::create($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Data profesi berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
    
    public function edit_ajax(string $id)
    {
        $profesi = Profesi::find($id);
        return view('data.pengelolaan_profesi.edit_ajax', compact('profesi'));
    }
 
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori' => 'required|string|max:100',
                'nama_profesi' => 'required|string|max:100|unique:profesi,nama_profesi,'.$id.',id'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $profesi = Profesi::find($id);
            if ($profesi) {
                $profesi->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data profesi berhasil diperbarui'
                ]);
            }
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }
 
    public function confirm_ajax(string $id)
    {
        $profesi = Profesi::find($id);
        return view('data.pengelolaan_profesi.confirm_ajax', compact('profesi'));
    }
 
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $profesi = Profesi::find($id);
            if ($profesi) {
                $profesi->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data profesi berhasil dihapus'
                ]);
            }
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }
}