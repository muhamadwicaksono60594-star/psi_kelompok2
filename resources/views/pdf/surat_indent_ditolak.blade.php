<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Penolakan - Pendaftar Indent</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .judul { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="judul">SURAT BALASAN PENOLAKAN PKL / MAGANG</div>
    <p>Kepada Yth,</p>
    <p><strong>{{ $indent->nama }}</strong><br>{{ $indent->instansi }}</p>

    <p>Dengan hormat,</p>
    <p>Berdasarkan hasil seleksi, kami menyatakan bahwa pengajuan PKL/magang Anda <strong>TIDAK DAPAT DITERIMA</strong>.</p>

    @if($indent->alasan_penolakan)
        <p>Alasan: {{ $indent->alasan_penolakan->alasan }}</p>
    @endif

    <p>Demikian surat ini kami sampaikan, terima kasih atas perhatian Anda.</p>

    <p style="text-align:right;">Kediri, {{ now()->format('d F Y') }}</p>
    <p style="text-align:right;">Hormat kami,<br><br><br>Manajemen Radar Kediri</p>
</body>
</html>
