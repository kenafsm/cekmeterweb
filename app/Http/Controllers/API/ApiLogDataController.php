<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LogData;
use App\Models\StafLapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiLogDataController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $logdata = LogData::with('pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('tanggal_cek', [$startDate, $endDate]);
            })
            ->orderBy('tanggal_cek', 'desc')
            ->get();

        return response()->json([
            'data' => $logdata->map(function ($item) {
                return [
                    'id' => (string)$item->id,
                    'staf_nip' => (string)$item->staf_nip,
                    'no_sp' => (string)$item->no_sp,
                    'nama_pelanggan' => $item->pelanggan->nama_pelanggan ?? '',
                    'alamat' => $item->pelanggan->alamat ?? '',
                    'alat_meter_id' => (string)$item->alat_meter_id,
                    'foto_meter' => $item->foto_meter,
                    'foto_url' => $item->foto_meter ? url(Storage::url($item->foto_meter)) : null,
                    'tahun_instalasi' => $item->tahun_instalasi,
                    'tahun_kadaluarsa' => $item->tahun_kadaluarsa,
                    'kondisi_meter' => $item->kondisi_meter,
                    'ket_kondisi' => $item->ket_kondisi,
                    'tanggal_cek' => $item->tanggal_cek
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'staf_nip' => 'required|exists:staflapangan,nip',
            'no_sp' => 'required|exists:pelanggans,no_sp',
            'alat_meter_id' => 'required',
            'kondisi_meter' => 'required',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tahun_instalasi' => 'required',
            'tahun_kadaluarsa' => 'required'
        ]);

        $logData = $request->except('foto_meter');

        if ($request->hasFile('foto_meter')) {
            $filePath = $request->file('foto_meter')->store('logdata', 'public');
            $logData['foto_meter'] = $filePath;
        }

        $logData['tanggal_cek'] = $request->input('tanggal_cek', now()->setTimezone('Asia/Jakarta'));

        $logdata = LogData::create($logData);
        
        $staf = StafLapangan::where('nip', $request->staf_nip)->first();
        if ($staf) {
            $staf->increment('jumlah_cek');
        }

        return response()->json([
            'message' => 'Log Data Berhasil Ditambahkan!',
            'data' => [
                'id' => (string)$logdata->id,
                'staf_nip' => (string)$logdata->staf_nip,
                'no_sp' => (string)$logdata->no_sp,
                'alat_meter_id' => (string)$logdata->alat_meter_id,
                'foto_meter' => $logdata->foto_meter,
                'foto_url' => $logdata->foto_meter ? url(Storage::url($logdata->foto_meter)) : null,
                'kondisi_meter' => (string)$logdata->kondisi_meter,
                'ket_kondisi' => (string)$logdata->ket_kondisi,
                'tahun_instalasi' => (string)$logdata->tahun_instalasi,
                'tahun_kadaluarsa' => (string)$logdata->tahun_kadaluarsa,
                'tanggal_cek' => $logdata->tanggal_cek->toDateTimeString(),
                'pelanggan' => $logdata->pelanggan ? [
                    'no_sp' => (string)$logdata->pelanggan->no_sp,
                    'nama_pelanggan' => $logdata->pelanggan->nama_pelanggan,
                    'alamat' => $logdata->pelanggan->alamat
                ] : null,
                'alatMeter' => $logdata->alatMeter ? [
                    'id' => (string)$logdata->alatMeter->id,
                    'nama_merk' => $logdata->alatMeter->nama_merk
                ] : null
            ]
        ], 201);

    }

    public function show($no_sp)
    {
        $logdata = LogData::with(['pelanggan', 'alatMeter'])
            ->where('no_sp', $no_sp)
            ->latest('tanggal_cek')
            ->first();

        if (!$logdata) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'id' => (string)$logdata->id,
            'staf_nip' => (string)$logdata->staf_nip,
            'no_sp' => (string)$logdata->no_sp,
            'alat_meter_id' => (string)$logdata->alat_meter_id,
            'foto_meter' => $logdata->foto_meter,
            'foto_url' => $logdata->foto_meter ? url(Storage::url($logdata->foto_meter)) : null,
            'kondisi_meter' => (string)$logdata->kondisi_meter,
            'ket_kondisi' => (string)$logdata->ket_kondisi,
            'tahun_instalasi' => (string)$logdata->tahun_instalasi,
            'tahun_kadaluarsa' => (string)$logdata->tahun_kadaluarsa,
            'tanggal_cek' => $logdata->tanggal_cek->toDateTimeString(),
            'pelanggan' => $logdata->pelanggan ? [
                'no_sp' => (string)$logdata->pelanggan->no_sp,
                'nama_pelanggan' => $logdata->pelanggan->nama_pelanggan,
                'alamat' => $logdata->pelanggan->alamat
            ] : null,
            'alatMeter' => $logdata->alatMeter ? [
                'id' => (string)$logdata->alatMeter->id,
                'nama_merk' => $logdata->alatMeter->nama_merk
            ] : null
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'staf_nip' => 'nullable|exists:staflapangan,nip',
            'no_sp' => 'nullable|exists:pelanggans,no_sp',
            'alat_meter_id' => 'nullable',
            'kondisi_meter' => 'nullable',
            'foto_meter' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'tahun_instalasi' => 'nullable',
            'tahun_kadaluarsa' => 'nullable'
        ]);

        $logdata = LogData::findOrFail($id);
        $logData = $request->except('foto_meter');

        if ($request->hasFile('foto_meter')) {
            if ($logdata->foto_meter) {
                Storage::delete($logdata->foto_meter);
            }
            $filePath = $request->file('foto_meter')->store('logdata', 'public');
            $logData['foto_meter'] = $filePath;
        }

        $logData['tanggal_cek'] = now()->setTimezone('Asia/Jakarta');
        $logdata->update($logData);

        return response()->json([
            'message' => 'Log Data Berhasil Diperbarui!',
            'data' => array_merge($logdata->toArray(), [
                'foto_url' => $logdata->foto_meter ? url(Storage::url($logdata->foto_meter)) : null
            ]),
        ]);
    }

    public function destroy($id)
    {
        $logdata = LogData::findOrFail($id);

        if ($logdata->foto_meter) {
            Storage::delete($logdata->foto_meter);
        }

        $logdata->delete();

        return response()->json([
            'message' => 'Log Data Berhasil Dihapus!',
        ]);
    }
}
