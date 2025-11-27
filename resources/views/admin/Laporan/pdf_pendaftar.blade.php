<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body{font-family: sans-serif; font-size:12px;}
        h2{text-align:center;}
        table{width:100%; border-collapse:collapse;}
        th,td{border:1px solid #333; padding:6px; text-align:left;}
        th{background:#f0f0f0;}
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    @if(!empty($start) && !empty($end))
        <p style="text-align:center;">Periode: {{ $start }} s/d {{ $end }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th><th>Nama</th><th>Instansi</th><th>Jurusan</th><th>Jenis</th><th>Status</th><th>Tgl Daftar</th><th>Tgl Mulai</th><th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $k => $r)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $r->nama }}</td>
                    <td>{{ $r->asal_instansi }}</td>
                    <td>{{ $r->jurusan }}</td>
                    <td>{{ $r->jenis }}</td>
                    <td>{{ $r->status }}</td>
                    <td>{{ $r->tanggal_daftar }}</td>
                    <td>{{ $r->tanggal_mulai }}</td>
                    <td>{{ $r->tanggal_selesai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
