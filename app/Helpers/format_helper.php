<?php

if (!function_exists('format_tanggal_indonesia')) {
    function format_tanggal_indonesia($tanggal)
    {
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $tanggal_angka = date('d', strtotime($tanggal));
        $bulan_angka = (int)date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        return $tanggal_angka . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
    }
}

if (!function_exists('format_tanggal_singkat')) {
    function format_tanggal_singkat($tanggal)
    {
        $bulan = [
            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        $tanggal_angka = date('d', strtotime($tanggal));
        $bulan_angka = (int)date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));

        return $tanggal_angka . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
    }
}
