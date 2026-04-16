@section('title', 'Item List')
@extends('welcome')
@section('content')

    <!-- Area Chart -->
    <div class="col-xl-10 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Amount</th>
                        <th scope="col">total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lists as $item)
                        <tr>
                            <th scope="row">{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->total }}</td>

                        </tr>
                    @endforeach

                </tbody>
            </table>



        </div>
    </div>
@endsection
