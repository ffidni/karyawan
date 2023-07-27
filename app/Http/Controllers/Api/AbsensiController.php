<?php


// app/Http/Controllers/Api/AbsensiController.php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Response;
use App\Services\AbsensiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    protected $absensiService;

    public function __construct(AbsensiService $absensiService)
    {
        $this->absensiService = $absensiService;
    }

    public function index(Request $request)
    {
        $user_id = $request->query("user_id");
        $date = $request->query("date");
        $absensiList = $this->absensiService->getAllAbsensi($user_id, $date);
        return new Response(HttpResponse::HTTP_OK, 'Berhasil mendapatkan semua data karyawan', $absensiList);
    }

    public function getLaporanKehadiran($user_id)
    {
        $laporan = $this->absensiService->getLaporanKehadiran($user_id);
        return new Response(HttpResponse::HTTP_OK, 'Berhasil mendapatkan laporan kehadiran', $laporan);

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,hadir,izin',
            'tipe' => 'required|in:Masuk,Keluar,masuk,keluar',
        ]);
        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages'], null);
        }

        $absensi = $this->absensiService->createAbsensi($data);

        return new Response(HttpResponse::HTTP_CREATED, 'Berhasil mengabsen karyawan', $absensi);
    }

    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric|exists:absensi,id',
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages'], null);
        }

        $absensi = $this->absensiService->getAbsensiById($id);

        return new Response(HttpResponse::HTTP_OK, 'Berhasil mendapatkan data absensi', $absensi);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,hadir,izin',
            'tipe' => 'required|in:Masuk,Keluar,masuk,keluar',
        ]);

        if ($validator->fails()) {
            $validatorData = validatorErrorHandler($validator);
            throw new ApiException(HttpResponse::HTTP_BAD_REQUEST, $validatorData['messages'], null);
        }

        $absensi = $this->absensiService->updateAbsensi($id, $data);

        return new Response(HttpResponse::HTTP_OK, 'Berhasil merubah data absen', $absensi);
    }

    public function destroy(string $id)
    {
        $this->absensiService->deleteAbsensi($id);

        return new Response(HttpResponse::HTTP_OK, 'Berhasil menghapus data absen', null);
    }
}