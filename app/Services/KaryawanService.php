<?php

// app/Services/AbsensiService.php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response as HttpResponse;

class KaryawanService
{

    public function getAllKaryawan()
    {

        $karyawan = User::where("tipe_user", "karyawan")->get();
        return $karyawan;
    }

    public function getKaryawanById(string $id)
    {
        $user = User::where("tipe_user", "karyawan")->find($id);
        if (!$user) {
            throw new ApiException(HttpResponse::HTTP_NOT_FOUND, "Tidak ada data karyawan dengan id: $id");
        }
        return $user;
    }


}