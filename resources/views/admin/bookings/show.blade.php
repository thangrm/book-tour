@extends('admin.master')
@section('style')
    <style>
        .tb-title {
            font-weight: bold;
            width: 80px;
            margin-bottom: 20px;
        }
    </style>
@endsection
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Booking</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Booking</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Booking</h4>
                        <hr>
                        <table>
                            <tr>
                                <td class="tb-title">Tour:</td>
                                <td>{{ $booking->tour->name }}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">Price:</td>
                                <td>{{ number_format($booking->price, 2) . ' $'}}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">People:</td>
                                <td>{{ $booking->people }}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">Payment:</td>
                                <td>
                                    @switch($booking->payment_method)
                                        @case(1)
                                        Cash
                                        @break
                                        @case(2)
                                        CreditCard
                                        @break
                                        @case(3)
                                        Paypal
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td class="tb-title">Status:</td>
                                <td>
                                    @switch($booking->status)
                                        @case(1)
                                        New
                                        @break
                                        @case(2)
                                        Confirmed
                                        @break
                                        @case(3)
                                        Completed
                                        @break
                                        @case(4)
                                        Cancel
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td class="tb-title">Total:</td>
                                <td>{{ number_format($booking->price * $booking->people, 2) . ' $'}}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-success m-r-5 m-t-30">Confirmed</button>
                                    <button class="btn btn-danger m-t-30">Cancel</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer</h4>
                        <hr>
                        <table>
                            <tr>
                                <td class="tb-title">Name:</td>
                                <td>{{ $booking->customer->first_name . ' ' . $booking->customer->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">Email:</td>
                                <td>{{ $booking->customer->email }}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">Phone:</td>
                                <td>{{ $booking->customer->phone }}</td>
                            </tr>
                            <tr>
                                <td class="tb-title">Address:</td>
                                <td>
                                    {{ trim(implode(", ", [
                                        $booking->customer->address,
                                         $booking->customer->province,
                                         $booking->customer->city,
                                         $booking->customer->country
                                         ]),', ')  }}
                                </td>
                            </tr>
                            <tr>
                                <td class="tb-title">Zipcode:</td>
                                <td>{{  $booking->customer->zipcode  }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection