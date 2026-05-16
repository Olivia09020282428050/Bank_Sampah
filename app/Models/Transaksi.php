<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    // Ubah dari 'transaksi' menjadi 'transactions'
    protected $table = 'transactions'; 

    protected $fillable = ['user_id', 'kode_booking', 'jenis_sampah', 'berat_kg', 'total_harga', 'status'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}