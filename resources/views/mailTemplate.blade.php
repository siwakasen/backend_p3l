<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Link Verifikasi untuk reset password</h1>
        <h3>Halo {{$details['name']}},</h3>
        <p>Anda telah mengajukan perubahan password pada akun Anda</p>
        <p>Untuk memverifikasi tindakan anda, silahkan mengakses link berikut agar dapat melakukan reset password</p>
        <p>{{$details['url']}}</p>
        <p><b>Apabila anda tidak merasa melakukan pengajuan berikut, mohon mengabaikan email ini</b></p>
    </div>
</body>
</html>
