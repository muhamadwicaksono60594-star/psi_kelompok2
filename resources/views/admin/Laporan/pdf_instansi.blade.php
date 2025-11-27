<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body{font-family:sans-serif; font-size:12px;}
        h2{text-align:center;}
        table{width:100%; border-collapse:collapse;}
        th,td{border:1px solid #333; padding:6px;}
        th{background:#f0f0f0;}
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    @if(!empty($start) && !empty($end))
        <p style="text-align:center">Periode: {{ $start }} s/d {{ $end }}</p>
    @endif

    <table>
        <thead>
            <tr><th>No</th><th>Instansi</th><th>Total</th><th>Diterima</th><th>Ditolak</th></tr>
        </thead>
        <tbody>
            @foreach($rows as $k => $r)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $r['asal_instansi'] }}</td>
                    <td>{{ $r['total'] }}</td>
                    <td>{{ $r['diterima'] }}</td>
                    <td>{{ $r['ditolak'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
