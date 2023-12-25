<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class QueryController extends BaseController
{
    function __construct()
    {
        helper('authvalid');

        // !Cache dari server siaujdb
        // Table prodi (ProdiID,Nama)
        // Table tahun (tahun,TglKRSMulai,TglKRSSelesai,Nama,TglKuliahMulai,TglKuliahSelesai,ProdiID)
    }

    public function index()
    {
        // Semua Jumlah Mahasiswa yang ada di dalam database

        // TODO: Diisi dengan Tombol2 untuk ke pilihan Query
        return view('quary/index_Query');
    }

    public function JumlahCalonMahasiswaBaru()
    {
        // ?input
        // tahun akademik
        // Prodi

        // daya Tampung

        // ?Output
        // jumlah mahasiswa

        // ?jumlah calon mahasiswa
        // Pendaftar
        // Lulus Seleksi

        // ?jumlah mahasiswa Baru
        // Reguler
        // Transfer

        // ?jumlah mahasiswa Aktif
        // Reguler
        // Transfer

        // ?Total Dari setiap katagori
    }

    public function KelulusanTepatWaktu()
    {
        // ?input
        // tahun lulus
        // Prodi


        // ?Output
        // jumlah lulusan

        // ?index prestasi kumulatif
        // Min
        // Rata2
        // max
    }

    public function KepuasanPenggunaLulus()
    {
        // ?input
        // tahun Masuk
        // Prodi


        // ?Output
        // jumlah Mahasiswa yang di terima

        // ?Jumlah mahasiswa yang lulus pada tahun
        // TS

        // ?jumlah yang sampai akhir TS
        // Sigma dari jumlah yang lulus

        // ?rata2 masa studi
        // rata2 tahun

        // ?jumlah yang masi aktif
        // sisah yang belum lulus
    }
}
