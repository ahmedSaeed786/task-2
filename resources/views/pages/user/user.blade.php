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
                            <form class="user" method="POST" action="{{ Route('user_delete') }}">

                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-danger">
                                    Delete</button>

                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        $(document).ready(function() {



            let isValid = {

                name: false,
                email: false,
                password: false,
                repeat_password: false
            };


            function validateField(fieldName, value) {
                return $.ajax({
                    url: "{{ route('user.validate') }}",
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
                            '<div id="error-' + fieldName + '" class="invalid-feedback">' +
                            error +
                            '</div>'
                        );

                        isValid[fieldName] = false;
                    }
                });
            }


            $('#customerForm').on('submit', function(e) {
                e.preventDefault();

                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();

                $.when(
                    validateField('name', name),
                    validateField('password', password),
                    validateField('email', email)
                ).done(function() {

                    if (isValid.name && isValid.email && isValid.pass) {



                        $('#customerForm')[0].submit();
                    }

                });
            });

        });
    </script>


    <script>
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
