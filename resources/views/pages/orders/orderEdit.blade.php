@section('title', 'User Edit')
@extends('welcome')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">





                        <form method="POST" action="{{ Route('customer_update') }}" id="customerForm">

                            @if (session('msg'))
                                <div class="alert alert-success">
                                    <strong>Success!</strong> {{ session('msg') }}.
                                </div>
                            @endif
                            @csrf
                            <input type="hidden" name="items" id="itemsInput">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col">
                                    <input type="text" id="customer_name" value="{{ $items->name }}" autocomplete="off"
                                        placeholder="Customer Name" name="customer_name" class="form-control">

                                </div>
                                <div class="col">


                                    <input type="text" value="{{ $items->date }}" class="form-control datetimepicker"
                                        name="date" placeholder="Select Date">
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col">
                                    <input type="text" id="phone" value="{{ $items->phone }}" autocomplete="off"
                                        placeholder="Customer Phone" name="phone" class="form-control">

                                </div>

                            </div>

                            <br>

                            @foreach ($items->item as $item)
                                <div class="row">
                                    <div class="col">
                                        <input type="text" autocomplete="off" class="form-control" id="name1[]"
                                            name="name1[]" value="{{ $item->name }}" placeholder="Item Name">
                                    </div>
                                    <div class="col">
                                        <input type="text" autocomplete="off" class="form-control" id="qty1[]"
                                            name="qty1[]" value="{{ $item->qty }}" placeholder="Quantity">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" autocomplete="off"id="amount1[]"
                                            name="amount1[]" value="{{ $item->amount }}"placeholder="Amount">
                                    </div>
                                    <div class="col">
                                        <input type="text" id="total1[]" class="form-control" autocomplete="off"
                                            value="{{ $item->total }}" name="total1[]" placeholder="Total">
                                    </div>

                                </div>
                            @endforeach



                            <div class="row">
                                <div class="col">
                                    <input type="text" autocomplete="off" class="form-control" id="name"
                                        name="name" placeholder="Item Name">
                                </div>
                                <div class="col">
                                    <input type="text" autocomplete="off" class="form-control" id="qty"
                                        name="qty" placeholder="Quantity">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" autocomplete="off"id="amount" name="amount"
                                        value="{{ old('amount') }}"placeholder="Amount">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" autocomplete="off"
                                        value="{{ old('total') }}" name="total" placeholder="Total">
                                </div>
                                <div class="col">
                                    <input type="button" value="Add Item" id="btnAddItem" class="btn btn-success">
                                    {{-- <input type="submit" id="action"name="action" value="Add Item" id="btnsubmit"> --}}
                                </div>
                            </div>



                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($itemDetail as $item)
                                            <tr class="">
                                                <td>{{ $itemDetail->name }}</td>
                                                <td>{{ $itemDetail->qty }}</td>
                                                <td> {{ $itemDetail->amount }}</td>
                                                <td>{{ $itemDetail->total }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive">

                            </div>

                            <div class="row" style="float: right">
                                <div class="col">
                                    <button type="submit" name="action" value="customer" class="btn btn-primary">
                                        Submit
                                    </button>

                                    {{-- <button type="submit" id="action" value="customer"
                                        name="action"class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>

                        </form>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // customer Name Validation
        $('#customer_name').on('keypress', function(e) {
            var keyCode = e.which;
            // Allow uppercase (65-90) and lowercase (97-122)
            if (!((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 32))) {
                e.preventDefault();
            }
        });

        // item Name Validation
        $('#name').on('keypress', function(e) {
            var keyCode = e.which;
            // Allow uppercase (65-90) and lowercase (97-122)
            if (!((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 32))) {
                e.preventDefault();
            }
        });




        $('#phone').on('keypress', function(key) {
            if (key.charCode < 48 || key.charCode > 57) {
                return false;
            }
        });
        $('#qty').on('keypress', function(key) {
            if (key.charCode < 48 || key.charCode > 57) {
                return false;
            }
        });
        $('#amount').on('keypress', function(key) {
            if (key.charCode < 48 || key.charCode > 57) {
                return false;
            }
        });
        $('#total').on('keypress', function(key) {
            if (key.charCode < 48 || key.charCode > 57) {
                return false;
            }
        });
        $(document).ready(function() {

                    let items = [];

                    let dataItem = [];
                    // Select all container rows
                    let rows = document.querySelectorAll('.row');

                    rows.forEach(row => {
                        // Find inputs within this specific row
                        let name1 = row.querySelector('input[name1="name1[]"]').value;
                        let qty1 = row.querySelector('input[name1="qty1[]"]').value;
                        let amount1 = row.querySelector('input[name1="amount1[]"]').value;
                        let total1 = row.querySelector('input[name1="total1[]"]').value;

                        // Only add if at least one field is filled
                        let ok = [name1, qty1, total1, amount1]
                        for (let i = 0; i < fruits.length; i++) {

                        }
                        dataItem = ok;
                        //     if (name1 || qty1 || amount1 || total1) {
                        //         dataItem.push({
                        //             name1: name1,
                        //             qty1: qty1,
                        //             amount1: amount1,
                        //             total1: total1
                        //         });
                        //     }
                        // });

                        let isValid = {
                            customer_name: false,
                            phone: false,
                            name: false,
                            qty: false,
                            amount: false,
                            total: false
                        };


                        function validateField(fieldName, value) {
                            return $.ajax({
                                url: "{{ route('customer.validate') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    field: fieldName,
                                    value: value
                                },
                                success: function() {
                                    let input = $('[name="' + fieldName + '"]');

                                    input.removeClass('is-invalid');
                                    $('#error-' + fieldName).remove();

                                    isValid[fieldName] = true;
                                },
                                error: function(xhr) {
                                    let error = xhr.responseJSON.error;
                                    let input = $('[name="' + fieldName + '"]');

                                    input.addClass('is-invalid');
                                    $('#error-' + fieldName).remove();

                                    input.after(
                                        '<div id="error-' + fieldName +
                                        '" class="invalid-feedback">' +
                                        error +
                                        '</div>'
                                    );

                                    isValid[fieldName] = false;
                                }
                            });
                        }

                        // ✅ AUTO CALCULATE TOTAL
                        $('[name="qty"], [name="amount"]').on('keyup', function() {
                            let qty = parseFloat($('[name="qty"]').val()) || 0;
                            let amount = parseFloat($('[name="amount"]').val()) || 0;
                            $('[name="total"]').val(qty * amount);
                        });

                        // ✅ ADD ITEM
                        $('#btnAddItem').on('click', function() {

                            let name = $('[name="name"]').val();
                            let qty = $('[name="qty"]').val();
                            let amount = $('[name="amount"]').val();
                            let total = $('[name="total"]').val();

                            $.when(
                                validateField('name', name),
                                validateField('qty', qty),
                                validateField('amount', amount),
                                validateField('total', total)
                            ).done(function() {

                                if (isValid.name && isValid.qty && isValid.amount && isValid
                                    .total) {


                                    items.push({
                                        name: name,
                                        qty: qty,
                                        amount: amount,
                                        total: total
                                    });

                                    const merged = [items, dataItem]
                                    $('#itemsInput').val(JSON.stringify(merged));


                                    let row = `
                    <tr>
                        <td>${name}</td>
                        <td>${qty}</td>
                        <td>${amount}</td>
                        <td>${total}</td>
                    </tr>
                `;

                                    $('table tbody').append(row);


                                    $('[name="name"]').val('');
                                    $('[name="qty"]').val('');
                                    $('[name="amount"]').val('');
                                    $('[name="total"]').val('');


                                    isValid.name = false;
                                    isValid.qty = false;
                                    isValid.amount = false;
                                    isValid.total = false;
                                }

                            });

                        });


                        $('#customerForm').on('submit', function(e) {
                            e.preventDefault();

                            let customer_name = $('#customer_name').val();
                            let phone = $('#phone').val();

                            $.when(
                                validateField('customer_name', customer_name),
                                validateField('phone', phone)
                            ).done(function() {

                                if (isValid.customer_name && isValid.phone) {


                                    $('#itemsInput').val(JSON.stringify(items));

                                    $('#customerForm')[0].submit();
                                }

                            });
                        });

                    });
    </script>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".datetimepicker", {
                dateFormat: "d-m-Y",
                enableTime: true,
                allowInput: true,
                defaultDate: "today"
            });
        });
    </script>

@endsection
