<?php

namespace App\Http\Controllers;

use App\Models\MasterObjek;
use App\Models\MasterUnitKerja;
use App\Models\SatuanKerja;
use Illuminate\Http\Request;
use App\Models\ObjekKegiatan;
use Illuminate\Support\Facades\Validator;

class ObjekKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masterUnitKerja = MasterUnitKerja::where('kategori', 1)->get();
        $masterObjekKegiatan = ObjekKegiatan::all();

        return view('admin.master-objek.objek-kegiatan', [
            'type_menu'         => 'objek',
            // 'title_modal'       => 'Import Data Satuan Kerja BPS',
            // 'url_modal_import'  => '/admin/master-satuan-kerja/import',
            'master_unitkerja'    => $masterUnitKerja,
            'master_objekkegiatan'  => $masterObjekKegiatan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_unitkerja'    => 'required',
            'kode_unitkerja'    => 'required',
            'kode_kegiatan'     => 'required|unique:objek_kegiatans,kode_kegiatan',
            'nama'              => 'required',
        ];

        // return $request;

        $validateData = request()->validate($rules);
        ObjekKegiatan::create($validateData);

        return redirect(route('objek-kegiatan.index'))->with('success', 'Berhasil Menambah Kegiatan Unit Kerja.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($kodekegiatan)
    {
        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $kodekegiatan)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Detail Data Satuan Kerja',
            'data'      => $objekKegiatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(ObjekKegiatan $objekKegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $id)->get();

        $rules = [
            'nama_unitkerja'    => 'required',
            'kode_unitkerja'    => 'required',
            'nama'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        ObjekKegiatan::where('kode_kegiatan', $id)
        ->update([
            'nama_unitkerja'    => $request->nama_unitkerja,
            'kode_unitkerja'    => $request->kode_unitkerja,
            'nama'              => $request->nama
        ]);

        $objekKegiatan = ObjekKegiatan::where('kode_kegiatan', $id)->get();

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Diperbarui',
            'data'      => $objekKegiatan
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ObjekKegiatan  $objekKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ObjekKegiatan::where('kode_kegiatan', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Objek Kegiatan Berhasil Dihapus!',
        ]);
    }

    public function unitkerja($id){
        $count = ObjekKegiatan::where('kode_unitkerja', $id)->count();

        return response()->json([
            'success'   => true,
            'message'   => 'Jumlah Kegiatan Unit kerja '.$id,
            'data'      => [
                'count' => $count
                ]
        ]);
    }
}