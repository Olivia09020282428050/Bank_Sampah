<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function store(Request $request) {
    // Validasi data
    // Hitung estimasi harga berdasarkan berat * harga_kategori
    // Simpan ke database dengan status 'pending'
}

public function updateStatus(Request $request, $id) {
    // Admin mengubah status dari 'pending' ke 'proses' lalu 'selesai'
    // Jika 'selesai', tambahkan saldo ke akun User
}

}
