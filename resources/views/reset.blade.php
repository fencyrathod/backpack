<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .error {
            color: red;
        }
        label{
            font-weight: 400;
        }
    </style>


</head>

<body>
    <br><br><br><br>


    <div class="container shadow p-3 mb-5 bg-body rounded mt-3" style=" width: 33pc;">
        <div class="text-center">

            <h1 style="font-family: auto;">Reset Password</h1>
        </div>
        
            @if (Session::has('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('msg')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
            @elseif (Session::has('msg1'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{Session::get('msg1')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>    
             @endif
    
       
        @if(count($errors) > 0 )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <form method="post" action="/reset_password">
            @csrf
         
            <label>Email</label>
            <input type="text" class="form-control" name="email" placeholder="Enter The Email"
                value="<?php if(isset($_GET["q"]))
                    {  echo $_GET["q"];}?>" readonly>

            <label>Password</label>
            <input type="password" class="form-control" name="pass" placeholder="Enter The Password"
                value="{{ old('pass') }}">
           
            <label>Confirm Password</label>
            <input type="password" class="form-control" name="conf_pass" placeholder="Enter The Confirm Password"
                    value="{{ old('conf_pass') }}">

            <div class="text-center mt-3">
                <button class="btn btn-success">Change Password</button>
            </div>
        </form>
    </div>   

    
</body>

</html>
