@section('title', 'User List')
@extends('welcome')
@section('content')

    <style>
        .field-icon {
            float: right;
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }

        .container {
            padding-top: 50px;
            margin: auto;
        }

        #nameError {
            display: none;
            font-size: 0.8em;
        }

        #nameError.visible {
            display: block;
        }

        input.invalid {
            border-color: red;
        }
    </style>
    <!-- Page Heading -->



    <!-- Content Row -->


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <form class="user" id="customerForm" method="POST" action="{{ Route('user_add') }}">

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

                        <div class="form-group">
                            <input type="text" id="name" value="{{ old('name') }}" name="name"
                                class="form-control form-control-user" autocomplete="off" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" value="{{ old('email') }}" name="email"
                                autocomplete="off" class="form-control form-control-user" placeholder="Email Address">
                        </div>



                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input id="password-field" id="password" value="{{ old('password') }}" type="password"
                                    class="form-control form-control-user" name="password" value="">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="col-sm-6">
                                <input id="repeat-password-field" type="password" class="form-control form-control-user"
                                    name="repeat_password" value="">
                                <span toggle="#repeat-password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>


                        <button class="btn btn-primary btn-user btn-block">Add User</button>


                    </form>

                    <br>

                </div>

            </div>

        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userDetail as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            <form class="user" method="POST" action="{{ Route('user_edit') }}">

                                @csrf

                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-primary">
                                    Edit</button>

                            </form>

                            <button class="btn btn-danger" value="{{ $item->id }}" id="deleteUser"
                                onClick='doAction("Delete", "Delete will permanently remove the record. Are you sure?");'>Delete</button>
                            {{-- 
                            <form class="user" method="POST" action="{{ Route('user_delete') }}">

                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-danger">
                                    Delete</button> --}}

                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





    <script>
        function doAction(action, message) {

            const myElement = document.getElementById("deleteUser");
            const value = myElement.value;

            if (confirm(message)) {



                $.ajax({
                    type: "POST",
                    url: '/user_delete',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": value
                    },
                });



            } else {

                console.log(action + ' is cancelled');
            }
        };


        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $('#user_name').on('keypress', function(e) {
            var keyCode = e.which;

            if (!((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 32))) {
                e.preventDefault();
            }
        });
    </script>

@endsection
