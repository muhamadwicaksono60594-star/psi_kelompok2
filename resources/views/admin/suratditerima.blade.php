<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Magang</title>
<style>
    @page {
        size: A4;
        margin: 2cm;
    }

    @media print {
        body {
            margin: 0;
        }
        .ttd-container {
            page-break-inside: avoid;
        }
    }

    body {
        font-family: 'Times New Roman', Times, serif;
        margin: 20px;
        line-height: 1.4;
        font-size: 12.5px;
    }

    .kop {
        text-align: center;
        margin-bottom: 15px;
    }

    .kop h2 {
        margin: 0;
        font-size: 16pt;
    }

    .kop p {
        margin: 2px 0;
        font-size: 11pt;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
        font-size: 11.5pt;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 5px;
        text-align: left;
    }

    ol {
        margin-left: 18px;
        padding-left: 10px;
    }

    ol li {
        margin-bottom: 4px;
    }

    .ttd-container {
        margin-top: 20px;
        text-align: right;
        font-size: 11pt;
        line-height: 1.3;
        page-break-inside: avoid;
    }

    .ttd-container img {
        margin: 5px 0;
        width: 90px;
        height: auto;
    }
</style>


</head>
<body>

<div class="kop">
<table style="width: 100%; border: none; border-collapse: collapse;">
    <tr>
        <td style="width: 18%; border: none;">
            <img src="{{ public_path('images/rk2.png') }}" alt="Logo" style="width: 90px;">
        </td>
        <td style="text-align: center; border: none;">
            <strong style="font-size: 32px;">RADAR KEDIRI INSTITUTE</strong><br>
            <hr style="width: 100%; border: 1px solid black; margin: 4px auto;">
            Jl. Raya Gampeng 45, Gampengrejo Kabupaten Kediri. Telp : 0354-681320. <br>
            Email : radarkediri.institute@gmail.com
        </td>
    </tr>
</table>
</div>



<p><strong>No.</strong>{{ $nomorSurat ?? '-' }}</p>
<p><strong>Hal</strong> : Balasan Permohonan Magang/PKL</p>

<p>
    Kepada:<br>
    Yth. {{$pendaftar->penandatangan}} {{ $pendaftar->asal_instansi }}
</p>

<p>Assalamu’alaikum wr,wb</p>

<p>
    Sehubungan dengan surat permohonan PKL/Magang nomor kami menyampaikan bahwa kami bersedia menerima {{ $pendaftar->user->role == 'siswa_smk' ? 'Siswa' : 'Mahasiswa' }} berikut:
</p>
<p>
    Kami sangat menghargai minat dan kepercayaan yang telah diberikan kepada institusi kami, dan kami harap kerja sama dapat terjalin di waktu yang akan datang.
</p>


@if($pendaftar->status == 'Diterima')
<table>
    <thead>
        <tr>
            <th>NIM/NIS</th>
            <th>NAMA</th>
            <th>Prodi/Jurusan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $pendaftar->nim_nis }}</td>
            <td>{{ $pendaftar->nama_lengkap }}</td>
            <td>{{ $pendaftar->jurusan }}</td>
        </tr>
    </tbody>
</table>

<p>
    Untuk magang/PKL di Jawa Pos Radar Kediri dari tanggal 
    {{ \Carbon\Carbon::parse($pendaftar->tanggal_mulai)->format('d M Y') }} s/d 
    {{ \Carbon\Carbon::parse($pendaftar->tanggal_selesai)->format('d M Y') }}.
    Adapun syarat yang harus dipenuhi adalah sebagai berikut:
</p>

<ol>
    <li>Mengikuti tugas magang dengan sungguh-sungguh</li>
    <li>Bersedia ditugaskan di seluruh wilayah edar Jawa Pos Radar Kediri</li>
    <li>Mempunyai peralatan dan kendaraan sendiri</li>
    <li>Menyelesaikan administrasi</li>
    <li>Mematuhi Peraturan Perusahaan yang berlaku</li>
    <li>Mempunyai atau bersedia membayar asuransi BPJS Ketenagakerjaan (diutamakan)</li>
</ol>
@endif

<p>
    Demikian surat ini agar dapat digunakan sebagaimana mestinya.
</p>
<p>Wassalamu’alaikum wr,wb</p>

<div class="ttd-container">
    <div class="ttd-container">
        @php
            \Carbon\Carbon::setLocale('id');
        @endphp
        <p>Kediri, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Penanggung Jawab Magang</p>
        <img src="data:image/png;base64,{{ $qrCodeBase64 }}" alt="QR Code" width="100">
        <p><strong>Jauhar Johanis</strong></p>
    </div>
</div>
</body>
</html>
