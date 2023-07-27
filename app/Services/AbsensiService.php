<?php

// app/Services/AbsensiService.php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\Absensi;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Response as HttpResponse;

class AbsensiService
{
    public function createAbsensi(array $data)
    {
        return Absensi::create($data);
    }

    public function getAllAbsensi($user_id, $date = null)
    {

        $date = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();
        if ($user_id) {
            $absensiRecords = Absensi::where("user_id", $user_id)->whereDate('tanggal', $date)->get();
            return $absensiRecords;
        }
        $absensiRecords = Absensi::whereDate('tanggal', $date)->get();
        return $absensiRecords;
    }

    public function getAbsensiById(string $id)
    {
        $absensi = Absensi::find($id);
        if (!$absensi) {
            throw new ApiException(HttpResponse::HTTP_NOT_FOUND, "Tidak ada data tugas dengan id: $id");
        }
        return $absensi;
    }

    public function updateAbsensi(string $id, array $data)
    {
        $absensi = Absensi::find($id);
        if (!$absensi) {
            throw new ApiException(HttpResponse::HTTP_NOT_FOUND, "Tidak ada data tugas dengan id: $id");
        }
        $absensi->update($data);
        return $absensi;
    }

    public function getLaporanKehadiran($user_id)
    {
        $startWeek = CarbonImmutable::now()->startOfWeek();
        $endWeek = CarbonImmutable::now()->endOfWeek();

        $startMonth = CarbonImmutable::now()->startOfMonth();
        $endMonth = CarbonImmutable::now()->endOfMonth();

        $absensiThisWeek = Absensi::whereBetween('tanggal', [$startWeek, $endWeek])->get();
        $izinCountThisWeek = $absensiThisWeek->where('status', 'Izin')->where("user_id", $user_id)->count();
        $hadirCountThisWeek = $absensiThisWeek->where('status', 'Hadir')->where("user_id", $user_id)->count();

        $absensiThisMonth = Absensi::whereBetween('tanggal', [$startMonth, $endMonth])->get();
        $izinCountThisMonth = $absensiThisMonth->where('status', 'Izin')->where("user_id", $user_id)->count();
        $hadirCountThisMonth = $absensiThisMonth->where('status', 'Hadir')->where("user_id", $user_id)->count();

        $absenData = $this->getAllAbsensi($user_id);
        return array(
            "izin_count_this_week" => $izinCountThisWeek,
            "izin_count_this_month" => $izinCountThisMonth,
            "hadir_count_this_week" => $hadirCountThisWeek,
            "hadir_count_this_month" => $hadirCountThisMonth,
            "absen_data" => $absenData,
        );




    }

    public function deleteAbsensi(string $id)
    {
        $absensi = Absensi::find($id);
        if (!$absensi) {
            throw new ApiException(HttpResponse::HTTP_NOT_FOUND, "Tidak ada data tugas dengan id: $id");
        }
        $absensi->delete();
    }
}