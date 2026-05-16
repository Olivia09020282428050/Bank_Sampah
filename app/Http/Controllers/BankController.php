<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class BankController extends Controller
{
    // ================= LOGIN =================

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // Pastikan dialihkan ke dashboard
            return redirect()->intended('/dashboard');

        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // ================= REGISTER =================

    public function register(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'nasabah',
            'balance' => 0
        ]);

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Registrasi berhasil! Silakan masuk dengan akun Anda.'
            );
    }

    // ================= LOGOUT =================

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    // ================= DASHBOARD =================

    public function index()
    {
        $query = Transaksi::with('user');

        // Jika bukan admin hanya tampil miliknya
        if (Auth::user()->role != 'admin') {

            $query->where(
                'user_id',
                Auth::id()
            );

        }

        $transaksi = $query
            ->latest()
            ->get();

        // ================= GRAFIK ADMIN =================

        $grafik = Transaksi::selectRaw(
                'jenis_sampah, SUM(berat_kg) as total_berat'
            )
            ->where('status', 'selesai')
            ->groupBy('jenis_sampah')
            ->get();

        // ================= TOTAL PERPUTARAN =================
        // Menggunakan akumulasi total transaksi selesai

        $totalPerputaran = Transaksi::where(
                'status',
                'selesai'
            )
            ->sum('total_harga');

        // ================= TOTAL NASABAH =================

        $totalNasabah = User::where(
                'role',
                'nasabah'
            )
            ->count();

        // ================= TOTAL SAMPAH MASUK =================
        // Selain transaksi tarik tunai

        $sampahMasuk = Transaksi::where(
                'status',
                'selesai'
            )
            ->where(
                'jenis_sampah',
                '!=',
                'Tarik Tunai'
            )
            ->sum('berat_kg');

        return view(
            'dashboard',
            compact(
                'transaksi',
                'grafik',
                'totalPerputaran',
                'totalNasabah',
                'sampahMasuk'
            )
        );
    }

    // ================= HALAMAN KATALOG =================

    public function katalog()
    {
        return view('katalog');
    }

    // ================= SETOR SAMPAH =================

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'jenis_sampah' => 'required',
            'berat_kg' => 'required|numeric|min:0.1',
            'foto_sampah' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // ================= SIMPAN FOTO =================

        $fileName = time() . '.' .
            $request->foto_sampah->extension();

        $request->foto_sampah->move(
            public_path('uploads'),
            $fileName
        );

        // ================= LIST HARGA =================

        $harga_list = [
            'Plastik PET' => 3000,
            'Plastik HDPE' => 2500,
            'Kardus' => 1500,
            'Kertas HVS' => 2000,
            'Logam Besi' => 5000,
            'Aluminium' => 10000,
            'Minyak Jelantah' => 6000,
            'Elektronik' => 15000
        ];

        // ================= TOTAL =================

        $total = $request->berat_kg *
            ($harga_list[$request->jenis_sampah] ?? 0);

        // ================= SIMPAN TRANSAKSI =================

        Transaksi::create([
            'user_id' => Auth::id(),
            'kode_booking' => 'INV-' . strtoupper(uniqid()),
            'jenis_sampah' => $request->jenis_sampah,
            'berat_kg' => $request->berat_kg,
            'total_harga' => $total,
            'foto' => $fileName,
            'status' => 'pending'
        ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Setoran berhasil diajukan!'
            );
    }

    // ================= KONFIRMASI ADMIN =================

    public function konfirmasi($id)
    {
        $t = Transaksi::findOrFail($id);

        $user = User::find($t->user_id);

        // Tambahkan saldo hanya jika bukan tarik tunai

        if ($t->jenis_sampah != 'Tarik Tunai') {

            $user->balance += $t->total_harga;

            $user->save();

        }

        // Update status transaksi

        $t->update([
            'status' => 'selesai'
        ]);

        return back()->with(
            'success',
            'Transaksi berhasil dikonfirmasi!'
        );
    }

    // ================= TOLAK TRANSAKSI =================

    public function tolak($id)
    {
        $t = Transaksi::findOrFail($id);

        // Jika tarik tunai ditolak,
        // saldo dikembalikan

        if ($t->jenis_sampah == 'Tarik Tunai') {

            $t->user->increment(
                'balance',
                $t->total_harga
            );

        }

        // Update status

        $t->update([
            'status' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'Transaksi telah ditolak.'
        );
    }

    // ================= TARIK SALDO =================

    public function tarikSaldo(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000'
        ]);

        $user = Auth::user();

        // ================= VALIDASI SALDO =================

        if ($user->balance < $request->jumlah) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Saldo Anda tidak mencukupi untuk penarikan ini.'
                );

        }

        // ================= SIMPAN TRANSAKSI =================

        Transaksi::create([
            'user_id' => $user->id,
            'kode_booking' => 'TRK-' . strtoupper(uniqid()),
            'jenis_sampah' => 'Tarik Tunai',
            'berat_kg' => 0,
            'total_harga' => $request->jumlah,
            'status' => 'pending'
        ]);

        // ================= KURANGI SALDO =================

        $user->decrement(
            'balance',
            $request->jumlah
        );

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Permintaan penarikan saldo sedang diproses.'
            );
    }

    // ================= HAPUS TRANSAKSI =================

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Admin bisa hapus semua

        if (Auth::user()->role == 'admin') {

            $transaksi->delete();

            return back()->with(
                'success',
                'Transaksi berhasil dihapus!'
            );

        }

        // Nasabah hanya bisa hapus miliknya

        if ($transaksi->user_id == Auth::id()) {

            $transaksi->delete();

            return back()->with(
                'success',
                'Riwayat berhasil dihapus!'
            );

        }

        return back()->with(
            'error',
            'Akses ditolak!'
        );
    }

    // ================= DATA NASABAH =================

    public function nasabahIndex()
    {
        $nasabah = User::where(
                'role',
                'nasabah'
            )
            ->latest()
            ->get();

        return view(
            'nasabah_index',
            compact('nasabah')
        );
    }

    

    // ================= HAPUS NASABAH =================

    public function nasabahDestroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus transaksi user

        Transaksi::where(
            'user_id',
            $user->id
        )->delete();

        // Hapus user

        $user->delete();

        return back()->with(
            'success',
            'Nasabah berhasil dihapus!'
        );
    }

    // ================= CETAK RESI TARIK =================

    public function cetakResiTarik($id)
    {
        // Ambil transaksi tarik tunai milik user login

        $transaksi = Transaksi::where(
                'user_id',
                Auth::id()
            )
            ->where('id', $id)
            ->where('jenis_sampah', 'Tarik Tunai')
            ->firstOrFail();

        $data = [
            't' => $transaksi,
            'user' => Auth::user(),
            'tanggal' => $transaksi
                ->created_at
                ->format('d M Y H:i')
        ];

        // Generate PDF

        $pdf = Pdf::loadView(
            'resi_tarik',
            $data
        );

        return $pdf->stream(
            'Resi-Tarik-' .
            $transaksi->kode_booking .
            '.pdf'
        );
    }

    // ================= CETAK RESI PDF =================

    public function cetakResi($id)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA TRANSAKSI + USER
        |--------------------------------------------------------------------------
        */

        $t = Transaksi::with('user')
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | KEAMANAN AKSES
        |--------------------------------------------------------------------------
        | Nasabah hanya boleh melihat transaksi miliknya sendiri
        | Admin boleh melihat semua transaksi
        */

        if (
            Auth::user()->role != 'admin' &&
            $t->user_id != Auth::id()
        ) {

            abort(403, 'Akses ditolak');

        }

        /*
        |--------------------------------------------------------------------------
        | KIRIM KE VIEW PDF
        |--------------------------------------------------------------------------
        | Dibuat collection agar aman jika view menggunakan @foreach
        */

        $data = collect([$t]);

        $pdf = Pdf::loadView(
            'pdf.laporan',
            [
                'data' => $data
            ]
        );

        return $pdf->stream(
            'Resi-' .
            $t->kode_booking .
            '.pdf'
        );
    }

    // ================= CETAK LAPORAN =================

    public function cetakLaporan()
    {
        $transaksi = Transaksi::with('user')
            ->where('status', 'selesai')
            ->latest()
            ->get();

        $data = [
            'title' => 'LAPORAN BANK SAMPAH DIGITAL',
            'date' => date('d/m/Y'),
            'transaksi' => $transaksi,

            // Akumulasi total transaksi selesai
            'total_perputaran' => $transaksi->sum('total_harga')
        ];

        $pdf = Pdf::loadView(
            'laporan_pdf',
            $data
        );

        return $pdf->download(
            'laporan-bank-sampah.pdf'
        );
    }

    // ================= PDF LAPORAN ADMIN =================

    public function laporanAdminPdf()
    {
        $transaksi = Transaksi::with('user')
            ->where('status', 'selesai')
            ->latest()
            ->get();

        // Total Perputaran Akumulatif

        $totalPerputaran = $transaksi->sum('total_harga');

        $pdf = Pdf::loadView(
            'pdf.laporan',
            [
                'data' => $transaksi,
                'totalPerputaran' => $totalPerputaran
            ]
        );

        return $pdf->stream(
            'Laporan-Bank-Sampah.pdf'
        );
    }
}