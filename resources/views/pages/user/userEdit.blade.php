@section('title', 'User Edit')
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




    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <form class="user" method="POST" action="{{ Route('user_update') }}">

                        @csrf

                        <input type="hidden" name="id" value="{{ $user->id }}">
                        <div class="form-group">
                            <input type="text" id="user_name" value="{{ $user->name }}" name="name"
                                class="form-control form-control-user" id="exampleInputEmail" autocomplete="off"
                                placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" value="{{ $user->email }}"autocomplete="off"
                                class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                        </div>



                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input id="password-field" type="password" class="form-control" name="password"
                                    value="">
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="col-sm-6">
                                <input id="repeat-password-field" type="password" class="form-control"
                                    name="repeat-password" value="">
                                <span toggle="#repeat-password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                        </div>


                        <button class="btn btn-primary btn-user btn-block">Update User</button>


                    </form>

                    <br>

                </div>

            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
