<!DOCTYPE html>
<html>
<body>
    <h3>Halo, {{ $nama }} 👋</h3>

    @if ($status === 'diterima')
        <p>Selamat! Pendaftaran PKL Anda telah <strong style="color:green;">DITERIMA ✅</strong>.</p>
        <p>Silakan menunggu informasi selanjutnya dari pihak Radar Kediri.</p>
    @else
        <p>Mohon maaf, pendaftaran PKL Anda <strong style="color:red;">DITOLAK ❌</strong>.</p>
        <p>Silakan periksa kembali berkas Anda dan coba mendaftar kembali.</p>
    @endif

    <p>Salam hangat,<br><strong>Admin Radar Kediri</strong></p>
</body>
</html>
