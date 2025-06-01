<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use App\Models\LogData;
use App\Models\MerkMeter;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class LogDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logdata = LogData::all();
        $pelanggan = Pelanggan::all();
        $merkmeter = MerkMeter::all();
        $staff = Staff::all();
        return view('data.logdata.log-data', compact('logdata', 'pelanggan', 'merkmeter', 'staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $merkmeter = MerkMeter::all();
        $staff = Staff::all();
        return view('data.logdata.tambah-log-data', compact('pelanggan', 'merkmeter', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $this->validate($request, [
            'petugas_id' => 'required',
            'pelanggan_id' => 'required',
            'merk_meter_id' => 'required',
            'kondisi_meter' => 'required',
            'ket_kondisi' => 'nullable',
            'foto_meter' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Mengambil semua data request kecuali 'foto_meter'
        $logData = $request->except('foto_meter');

        // Jika ada file yang diunggah
        if ($request->hasFile('foto_meter')) {
            $filePath = $request->file('foto_meter')->store('logdata', 'public');
            $logData['foto_meter'] = $filePath;
        }

        // Set tanggal_cek otomatis ke waktu saat ini
        $logData['tanggal_cek'] = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta');

        // Membuat data log
        LogData::create($logData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Log Data Berhasil Ditambahkan!');

        return redirect()->route('logdata.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(LogData $logdata)
    {
        // return view('pelanggan.show', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $logdata = LogData::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $merkmeter = MerkMeter::all();
        $staff = Staff::all();
        return view('data.logdata.edit-log-data', compact('logdata', 'pelanggan', 'merkmeter', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'petugas_id' => 'required',
            'pelanggan_id' => 'required',
            'merk_meter_id' => 'required',
            'kondisi_meter' => 'required',
            'ket_kondisi' => 'nullable',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $logdata = LogData::findOrFail($id);
        $logData = $request->except('foto_meter');

        if ($request->hasFile('foto_meter')) {
            // Hapus foto lama
            if ($logdata->foto_meter && Storage::exists($logdata->foto_meter)) {
                Storage::delete($logdata->foto_meter);
            }

            // Simpan foto baru
            $filePath = $request->file('foto_meter')->store('logdata', 'public');
            $logData['foto_meter'] = $filePath;
        }

        // Update tanggal_cek otomatis ke waktu saat ini
        $logData['tanggal_cek'] = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta');

        // Update data
        $logdata->update($logData);

        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Log Data Berhasil Diperbarui!');

        return redirect()->route('logdata.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $logdata = LogData::findOrFail($id);
        $logdata->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Log Data Berhasil Dihapus!');
        return redirect(route('logdata.index'));
    }
}
