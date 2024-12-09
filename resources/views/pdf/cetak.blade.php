<!DOCTYPE html>
<html>
<head>
    <title>Rekap Pensiun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Sesuaikan ukuran font */
            margin: 0;
            padding: 0;
        }
        .header, .footer {
            position: fixed;
            width: 100%;
            text-align: center;
            left: 0;
        }
        .header {
            top: 0;
            height: 120px;
            background-color: #ffffff;
            border-bottom: 1px solid #000;
            padding: 10px 0;
        }
        .header img {
            height: 100px; /* Sesuaikan ukuran gambar */
            margin-right: 1px; /* Tambahkan margin jika perlu */
            float: left;
        }
        .footer {
            bottom: 0;
            height: 50px;
            background-color: #f2f2f2;
            border-top: 1px solid #000;
            padding: 10px 0;
        }
        .content {
            margin: 170px 20px; /* Sesuaikan margin atas dan bawah sesuai tinggi header dan footer */
        }
        .content h4{
            position: absolute;
            margin-top: 40px; /* Sesuaikan posisi vertikal */
            right: 10px; /* Sesuaikan posisi horizontal */
            text-align: center; /* Pusatkan teks di dalam posisi yang diatur */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Memusatkan tabel */
        }
        th, td {
            padding: 4px;
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@php
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    
    $monthName = isset($months[$month]) ? $months[$month] : 'Januari sampai Desember';
@endphp

    <div class="header">
        <img src="{{ public_path('images/favicon.png') }}" alt="Logo">
        <h2>PEMERINTAH KABUPATEN KEPULAUAN MERANTI DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL <br>
        Jalan Dorak Komplek Perkantoran Terpadu Selatpanjang - 28753<br>SELATPANJANG</h2>
    </div>
    <div class="content">
            <h3 style="text-align: center;">Rekap Laporan Tahunan Pindah Alamat Bulan {{ $monthName }} Tahun {{ $year }}</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>NO. KK</th>
                        <th>NIK</th>
                        <th>Alamat Asal</th>
                        <th>Alamat Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->no_kk }}</td>
                            <td>{{ $row->nik }}</td>
                            <td>Kabupaten {{ $row->kabupaten_asal }},
                        Kecamatan {{ $row->kecamatan_asal->name }},
                        Desa/Kelurahan {{ $row->desa_asal->name }},
                        {{ $row->alamat_asal }}</td>
                            <td>Kabupaten {{ $row->kabupaten_tujuan }},
                        Kecamatan {{ $row->kecamatan_tujuan->name }},
                        Desa/Kelurahan {{ $row->desa_tujuan->name }},
                        {{ $row->alamat_tujuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </body>
</html>
