@section('title', 'home')

@extends('welcome')
@section('content')

    <style>
        /* Styling the trigger button */
        .open-btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        /* Full-page popup container */
        .popup-overlay {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            /* Dimmed background */
            z-index: 1000;
            /* Stays on top */
            justify-content: center;
            align-items: center;
        }

        /* Content inside the popup */
        .popup-content {
            background: white;
            padding: 40px;
            border-radius: 8px;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        /* Close button styling */
        .close-btn {
            margin-top: 20px;
            padding: 8px 16px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        body {
            font-family: "Helvetica", Arial, sans-serif;
            margin: 40px;
            color: #333;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .invoice-title {
            font-size: 36px;
            font-weight: bold;
        }

        .company-info {
            text-align: right;
        }

        .parties {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
        }

        .party {
            width: 45%;
        }

        .party h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .totals {
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }

        .totals tr td {
            border: none;
            padding: 8px 0;
        }

        .total-row {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #000;
            padding-top: 10px !important;
        }

        .notes {
            margin-top: 40px;
            padding: 20px;
            background: #f9f9f9;
            border-left: 4px solid #000;
        }
    </style>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <a href="{{ Route('user_detail') }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Users</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <a href="{{ Route('customer') }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <a href="{{ Route('customer') }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Customers
                                </div>
                                <div class="row no-gutters align-items-center">
                                    {{ $customer }}
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <a href="{{ Route('list') }}">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Sale Item</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $saleItem }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <br>
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-10 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total</th>
                            <th scope="col">Show</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetail as $list)
                            <tr>
                                <th scope="row">{{ $list->id }}</th>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->phone }}</td>
                                <td>{{ $list->date }}</td>
                                <td>{{ $list->item_sum_total }}</td>

                                <td>







                                    <button class="open-btn" onclick="togglePopup()">
                                        Detail
                                    </button>

                                    <!-- The Popup Overlay -->
                                    <div id="fullPagePopup" class="popup-overlay">
                                        <div class="popup-content">
                                            <div class="header">
                                                <div class="invoice-title">INVOICE</div>
                                                <div class="company-info">
                                                    <div><strong>Invoice #:</strong> {{ $list->id }}</div>
                                                    <div><strong>Date:</strong> {{ $list->date }}</div>
                                                    <div><strong>Phone:</strong> {{ $list->phone }}</div>
                                                </div>
                                            </div>

                                            <div class="parties">
                                                <div class="party">
                                                    <h3>From</h3>
                                                    <strong>{{ auth()->user()->name }}</strong><br />

                                                </div>
                                                <div class="party">
                                                    <h3>To</h3>
                                                    <strong>{{ $list->name }}</strong><br />

                                                </div>
                                            </div>

                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th style="text-align: right">Quantity</th>
                                                        <th style="text-align: right">Amount</th>
                                                        <th style="text-align: right">Total</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($list->item as $detail)
                                                        <tr>
                                                            <td>{{ $detail->name }}</td>
                                                            <td style="text-align: right">{{ $detail->qty }}</td>
                                                            <td style="text-align: right">{{ $detail->amount }}</td>
                                                            <td style="text-align: right">{{ $detail->total }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                            <table class="totals">
                                                <tr>
                                                    <td>Subtotal:</td>
                                                    <td style="text-align: right">$ {{ $list->item_sum_total }}
                                                    </td>
                                                </tr>

                                                <tr class="total-row">
                                                    <td>Total:</td>
                                                    <td style="text-align: right">$ {{ $list->item_sum_total }}
                                                    </td>
                                                </tr>
                                            </table>

                                            <button class="close-btn" onclick="togglePopup()">Close Popup</button>
                                        </div>
                                    </div>



























                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>
        </div>


    </div>
    <script>
        $.ajax({
            url: '/invoice',
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $('#id').val(),

            },
            success: function(response) {
                alert($arr);
            }
        });
        $(document).ready(function() {
            $(".button1").click(function() {
                $.ajax({
                    url: "button1.txt",
                    /*more code*/
                });
            });
        });

        function togglePopup() {

            const popup = document.getElementById("fullPagePopup");
            // Switch between "flex" (to show and center) and "none" (to hide)
            if (popup.style.display === "flex") {
                popup.style.display = "none";
            } else {
                popup.style.display = "flex";
            }
        }

        // Optional: Close popup if clicking outside the content box
        window.onclick = function(event) {
            const popup = document.getElementById("fullPagePopup");
            if (event.target == popup) {
                popup.style.display = "none";
            }
        };
    </script>

@endsection
