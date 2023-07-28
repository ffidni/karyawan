<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\KaryawanService;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Resources\Response;


class KaryawanController extends Controller
{
    protected $karyawanService;

    public function __construct(KaryawanService $karyawanService)
    {
        $this->karyawanService = $karyawanService;
    }
    public function index()
    {
        $karyawan = $this->karyawanService->getAllKaryawan();
        return new Response(HttpResponse::HTTP_OK, "Berhasil mendapatkan data karyawan", $karyawan);
    }

    public function show(string $id)
    {
        $karyawan = $this->karyawanService->getKaryawanById($id);
        return new Response(HttpResponse::HTTP_OK, "Berhasil mendapatkan data karyawan", $karyawan);
    }


}