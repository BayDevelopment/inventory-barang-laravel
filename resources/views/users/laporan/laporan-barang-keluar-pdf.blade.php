<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .line {
            border-bottom: 2px solid #000;
            margin: 10px 0 15px;
        }

        .info {
            margin-bottom: 10px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #e9ecef;
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }

        td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .ttd {
            width: 30%;
            float: right;
            text-align: center;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>

    <!-- HEADER / KOP -->
    <div class="header">
        <h2>LAPORAN BARANG KELUAR</h2>
        <p>PT Contoh Inventory</p>
        <p>Jl. Contoh Alamat No. 123</p>
    </div>

    <div class="line"></div>

    <!-- INFO -->
    <div class="info">
        <strong>Tanggal Cetak:</strong> {{ date('d-m-Y') }}
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="30%">Nama Barang</th>
                <th width="25%">Supplier</th>
                <th class="text-center" width="15%">Jumlah</th>
                <th class="text-center" width="15%">Tanggal Keluar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->barangById->nama_barang ?? '-' }}</td>
                    <td>{{ $item->supplierById->nama_supplier ?? '-' }}</td>
                    <td class="text-center">{{ $item->jumlah_keluar }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d, F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- FOOTER / TTD -->
    <div class="footer">
        <div class="ttd">
            <p>{{ date('d F Y') }}</p>
            <br><br><br>
            <p><strong>Mengetahui</strong></p>
        </div>
        <div class="clear"></div>
    </div>

</body>

</html>
