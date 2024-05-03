<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .holder {
            text-align: center;
            padding-top: 120px;
        }

        .holder h1 {
            font-size: 3.5em;
            color: #2d2d2d;
            text-shadow: 3px 3px 0 #e3e3e3;
            margin-top: 12px;
            margin-bottom: 10px;
        }

        .holder h1 span.tbl {
            font-size: 0.7em;
            color: #2d2d2d;
            font-weight: bold;
            text-shadow: -1px 1px 1px rgba(0, 0, 0, 0.3);
        }

        .holder h1 span {
            font-size: 1em;
            color: #3d9df8;
            font-weight: bold;
            text-shadow: -1px 1px 1px rgba(0, 0, 0, 0.3);
        }

        p {
            font-size: 18px;
            font-weight: 600;
            color: #13447E;
            font-family: 'Neuton', serif;
        }

        @media (min-width: 768px) {
            .holder {
                width: 480px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="holder">
        <img src="{{ URL::asset('assets/images/logo/logo.png')}}" style="width: 150px;" class="mb-4" />
        <h1><span class="tbl">Website is currently under maintenance.</span></h1>
        <p><span class="tbl">We'll be back shortly.</span></p>
        <div class="d-flex justify-content-center gap-2">
            <a class="btn btn-success" href="{{ route('login') }}">Login</a>
            <a class="btn btn-primary" href="{{ route('register') }}">Sign Up</a>
        </div>
    </div>
</body>
</html>
