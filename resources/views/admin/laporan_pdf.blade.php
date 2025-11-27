<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendaftar</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h3>Laporan Data Pendaftar</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Asal Instansi</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d['nama'] }}</td>
                    <td>{{ $d['asal'] }}</td>
                    <td>{{ $d['jenis'] }}</td>
                    <td>{{ $d['status'] }}</td>
                    <td>{{ $d['tanggal'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
