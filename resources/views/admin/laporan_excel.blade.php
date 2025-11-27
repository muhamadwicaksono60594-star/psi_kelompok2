<table border="1" cellspacing="0" cellpadding="5">
    <thead style="background-color: #dbeafe;">
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
