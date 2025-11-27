<!DOCTYPE html>
<html>
    <body>
        <h3>Halo, {{ $nama }} 👋</h3>

        @if ($status === 'diterima')
            <p>Selamat! Pendaftaran <strong>Indent PKL</strong> Anda telah <strong style="color:green;">DITERIMA ✅</strong>.</p>
            <p>Kami akan menghubungi Anda untuk informasi tahap selanjutnya.</p>
        @else
            <p>Mohon maaf, pendaftaran <strong>Indent PKL</strong> Anda <strong style="color:red;">DITOLAK ❌</strong>.</p>
            <p>Silakan periksa kembali data dan dokumen Anda sebelum mengajukan ulang.</p>
        @endif

        <p>Salam,<br><strong>Admin Radar Kediri</strong></p>
    </body>
</html