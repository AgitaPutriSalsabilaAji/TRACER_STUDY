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
    
    public function list()
    {
        $profesis = Profesi::select('id', 'kategori', 'nama_profesi');
        
        return DataTables::of($profesis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($profesi) {
                $btn  = '<button onclick="modalAction(\''.url('/profesi/' . $profesi->id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/profesi/' . $profesi->id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/profesi/' . $profesi->id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
    
    // Additional method for grouped view
    public function index_grouped()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Profesi',
            'list' => ['Home', 'Profesi']
        ];
    
        $page = (object) [
            'title' => 'Daftar profesi dikelompokkan berdasarkan kategori'
        ];
    
        $activeMenu = 'profesi';
        
        $profesiByCategory = Profesi::all()->groupBy('kategori');
    
        return view('data.pengelolaan_profesi.index_grouped', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'profesiByCategory' => $profesiByCategory
        ]);
    }
}