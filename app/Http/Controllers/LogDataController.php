<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use App\Models\AlatMeter;
use App\Models\LogData;
use App\Models\StafLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class LogDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::all();
        $alatmeter = AlatMeter::all();
        $staflapangan = StafLapangan::all();

        // Ambil filter tanggal mulai dan tanggal akhir dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query filtering
        $logdata = LogData::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('tanggal_cek', [$startDate, $endDate]);
            })
            ->orderBy('tanggal_cek', 'desc') // Urutkan berdasarkan tanggal cek terbaru
            ->get();

        return view('data.logdata.log-data', compact('logdata', 'pelanggan', 'alatmeter', 'staflapangan', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $pelanggan = Pelanggan::all();
        $alatmeter = AlatMeter::all();
        $staflapangan = StafLapangan::all();
        return view('data.logdata.tambah-log-data', compact('pelanggan', 'alatmeter', 'staflapangan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        // Validasi data
        $this->validate($request, [
            'staf_nip' => 'required|exists:staflapangan,nip',
            'no_sp' => 'required|exists:pelanggans,no_sp',
            'alat_meter_id' => 'required',
            'kondisi_meter' => 'required',
            'tahun_instalasi' => 'required',
            'tahun_kadaluarsa' => 'required',
            'ket_kondisi' => 'nullable',
            'foto_meter' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        // Mengambil semua data request kecuali 'foto_meter'
        $logData = $request->except('foto_meter');

        // Data staf_nip berisi nip
        $logData['staf_nip'] = $request->input('staf_nip');

        // Data no_sp tetap valid
        $logData['no_sp'] = $request->input('no_sp');

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
    public function show($id)
    {
        $logdata = LogData::findOrFail($id);
        return view('data.logdata.show-log-data', compact('logdata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $logdata = LogData::findOrFail($id);
        $pelanggan = Pelanggan::all();
        $alatmeter = AlatMeter::all();
        $staflapangan = StafLapangan::all();
        return view('data.logdata.edit-log-data', compact('logdata', 'pelanggan', 'alatmeter', 'staflapangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $this->validate($request, [
            'staf_nip' => 'required|exists:staflapangan,nip',
            'no_sp' => 'required|exists:pelanggans,no_sp',
            'alat_meter_id' => 'required',
            'kondisi_meter' => 'required',
            'tahun_instalasi' => 'required',
            'tahun_kadaluarsa' => 'required',
            'ket_kondisi' => 'nullable',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $logdata = LogData::findOrFail($id);
        $logData = $request->except('foto_meter');

        // Data staf_nip berisi nip
        $logData['staf_nip'] = $request->input('staf_nip');

        // Data no_sp tetap valid
        $logData['no_sp'] = $request->input('no_sp');

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
        if (auth()->user()->role === 'staf_spi') {
            abort(403, 'Unauthorized action.');
        }
        $logdata = LogData::findOrFail($id);
        $logdata->delete();
        // Menampilkan SweetAlert
        Alert::success('Berhasil!', 'Log Data Berhasil Dihapus!');
        return redirect(route('logdata.index'));
    }
}
