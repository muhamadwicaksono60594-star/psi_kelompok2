<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Diterima - Pendaftar Indent</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .judul { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="judul">SURAT BALASAN PENERIMAAN PKL / MAGANG</div>
    <p>Kepada Yth,</p>
    <p><strong>{{ $indent->nama }}</strong><br>{{ $indent->instansi }}</p>

    <p>Dengan hormat,</p>
    <p>Bersama surat ini kami menyatakan bahwa Anda <strong>DITERIMA</strong> untuk melaksanakan kegiatan PKL/magang di Radar Kediri.</p>

    <p>Periode pelaksanaan: {{ $indent->tanggal_mulai }} s.d {{ $indent->tanggal_selesai }}</p>

    <p>Demikian surat ini dibuat untuk digunakan sebagaimana mestinya.</p>

    <p style="text-align:right;">Kediri, {{ now()->format('d F Y') }}</p>
    <p style="text-align:right;">Hormat kami,<br><br><br>Manajemen Radar Kediri</p>
</body>
</html>
