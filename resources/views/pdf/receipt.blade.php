<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pemesanan #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #f472b6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #db2777;
            margin: 0 0 10px 0;
        }
        .header p {
            margin: 0;
            color: #666;
        }
        .content {
            margin-bottom: 30px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .details-table th {
            width: 40%;
            color: #666;
            font-weight: normal;
        }
        .details-table td {
            font-weight: bold;
        }
        .total-row td {
            border-top: 2px solid #333;
            font-size: 1.2em;
            color: #db2777;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
            margin-top: 50px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ei Salon</h1>
        <p>Struk Pemesanan / Booking Receipt</p>
    </div>

    <div class="content">
        <table class="details-table">
            <tr>
                <th>ID Booking</th>
                <td>#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <th>Tanggal Pemesanan Dibuat</th>
                <td>{{ $booking->created_at->locale('id')->isoFormat('D MMMM YYYY H:mm') }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $booking->user->name }}</td>
            </tr>
            <tr>
                <th>Nomor WhatsApp</th>
                <td>{{ $booking->user->phone }}</td>
            </tr>
            <tr>
                <th>Layanan</th>
                <td>{{ $booking->service->name }}</td>
            </tr>
            <tr>
                <th>Jadwal Reservasi</th>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] H:mm') }}</td>
            </tr>
            @if($booking->notes)
            <tr>
                <th>Catatan</th>
                <td>{{ $booking->notes }}</td>
            </tr>
            @endif
            <tr>
                <th>Status Pembayaran</th>
                <td>Menunggu Pembayaran (Pending)</td>
            </tr>
            <tr class="total-row">
                <th>Total Biaya</th>
                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Terima kasih telah memilih Ei Salon.</p>
        <p>Harap tunjukkan struk ini saat kedatangan, atau gunakan sebagai bukti konfirmasi via WhatsApp.</p>
    </div>
</body>
</html>
