<!doctype html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hóa đơn</title>

    <style type="text/css">
        * {
            font-family: "DejaVu Sans", sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .font {
            font-size: 15px;
        }

        .authority {
            width: 100%;
            text-align: center;
            float: right
        }

        .authority h5 {
            margin-top: -10px;
            color: green;
            text-align: center;
        }

        .thanks p {
            color: green;;
            font-size: 16px;
            font-weight: normal;
            margin-top: 20px;
            text-align: center;
        }
    </style>

</head>
<body>

<table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
            <h2 style="color: green; font-size: 26px;"><strong>Công ty Thắng Lợi</strong></h2>
        </td>
        <td align="right">
            <pre class="font">
               Phone: 09998886666 <br>
               Địa chỉ: Thành phố Hà Nội <br>
               Email:support@thangloi.com <br>
            </pre>
        </td>
    </tr>

</table>


<table width="100%" style="background:white; padding:2px;"></table>

<table width="100%" style="background: #F7F7F7; padding:0 5px;" class="font">
    <tr>
        <td>
            <p class="font" style="margin-left: 20px;">
                <strong>Tên:</strong> {{ $booking->customer->first_name . ' ' .  $booking->customer->last_name}} <br>
                <strong>Email:</strong> {{ $booking->customer->email }} <br>
                <strong>Số điện thoại:</strong> {{ $booking->customer->phone }} <br>
                @php
                    $address = sprintf("%s, %s, %s, %s", $booking->customer->address, $booking->customer->province, $booking->customer->city, $booking->customer->country)
                @endphp
                <strong>Địa chỉ:</strong> {{ $address }} <br>
            </p>
        </td>
        <td>
            <p class="font">
                Ngày đặt: {{ date("Y-m-d",strtotime($booking->created_at)) }} <br>
                Loại thanh toán :
                @if($booking->payment_method == PAYMENT_CASH)
                    Tiền mặt
                @elseif($booking->payment_method == PAYMENT_MOMO)
                    Momo
                @endif
            </p>
        </td>
    </tr>
</table>
<br/>
<h3>Phòng</h3>


<table width="100%">
    <thead style="background-color: green; color:#FFFFFF;">
    <tr class="font">
        <th scope="col">#</th>
        <th scope="col">Dịch vụ</th>
        <th scope="col">Số lượng</th>
        <th scope="col">Giá</th>
        <th scope="col">Tổng tiền</th>
    </tr>
    </thead>
    <tbody>
    <tr class="font">
        <td>{{ 1  }}</td>
        <td>{{ $booking->tour->name }}</td>
        <td>{{ $booking->people }}</td>
        <td>{{ number_format($booking->price) }}đ</td>
        <td>{{ number_format($booking->people * $booking->price) }}đ</td>
    </tr>
    @foreach($booking->rooms as $room)
        <tr class="font">
            <td>{{ $loop->index + 2  }}</td>
            <td>{{ $room->name }}</td>
            <td>{{ $room->pivot->number }}</td>
            <td>{{ number_format($room->pivot->price) }}đ</td>
            <td>{{ number_format($room->pivot->number * $room->pivot->price) }}đ</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>
<table width="100%" style=" padding:0 10px 0 10px;">
    <tr align="right">
        <td align="right">
            <h2><span style="color: green;">Giá:</span></h2>
        </td>
        <td align="left" width="200px">
            <h2>{{ number_format($booking->total / (100 - $booking->discount) * 100) }}₫</h2>
        </td>
    </tr>
    <tr align="right">
        <td align="right">
            <h2><span style="color: green;">Giám giá:</span></h2>
        </td>
        <td align="left">
            <h2>{{ $booking->discount }}%</h2>
        </td>
    </tr>
    <tr align="right">
        <td align="right">
            <h2><span style="color: green;">Tổng giá:</span></h2>
        </td>
        <td align="left">
            <h2>{{ number_format($booking->total) }} ₫</h2>
        </td>
    </tr>
</table>
<div class="thanks mt-3">
    <p>Cảm ơn đã đặt tour của chúng tôi..!!</p>
</div>
<div class="authority">
    <p>-----------------------------------</p>
    <h5>Hóa đơn được tạo bởi: công ty du lịch Thắng Lợi</h5>
</div>
</body>
</html>
