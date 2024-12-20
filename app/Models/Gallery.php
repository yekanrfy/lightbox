<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan dalam database.
     * Secara default, Laravel akan menganggap nama tabel adalah bentuk plural dari nama model.
     * Dalam kasus ini, nama tabel sudah sesuai dengan konvensi.
     */
    protected $table = 'galleries';

    /**
     * Kolom-kolom yang dapat diisi secara massal (mass assignable).
     * Pastikan kolom-kolom ini sesuai dengan yang didefinisikan di migration.
     */
    protected $fillable = [
        'title',
        'description',
        'picture',
    ];

    /**
     * Menentukan apakah model menggunakan kolom timestamps (created_at dan updated_at).
     * Defaultnya adalah true, dan sesuai dengan struktur tabel di migration.
     */
    public $timestamps = true;

    /**
     * Relasi dengan model lain (opsional).
     * Tambahkan relasi jika diperlukan, misalnya relasi dengan User.
     */
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
