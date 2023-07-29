<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = "absensi";
    protected $fillable = [
        "user_id",
        "tanggal",
        "telat_waktu",
        "status",
        "tipe",
    ];

    /**
     * Define a one-to-one relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected $casts = [
        'user_id' => 'integer',
    ];
}