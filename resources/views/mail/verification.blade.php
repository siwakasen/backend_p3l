<!DOCTYPE html>
<html>
<head>
  <title>Verify Your Email Address</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    /* Base Styles */
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    table {
        border-collapse: collapse;
    }
    table th {
        text-align: left;
    }
    /* Header Styles */
    .header {
        background-color: #f5f5f5;
        padding: 20px;
    }
    .header__logo {
        text-align: center;
    }   
    .header__logo img {
        height: 50px;
    }
    /* Body Styles */
    .body {
        padding: 20px;
        background-color: #f5f5f5;
    }
    .body__content {
        line-height: 1.5;
        padding: 20px;
        margin: 0 auto; /* Add margin for centering */
        width: 50%;
        background-color: #fff;
    }
    .body__action {
        text-align: center;
        padding: 10px 20px;
        margin: 0 auto; /* Add margin for centering */
        width: 50%;
        background-color: #fff;
    }
    /* Footer Styles */
    .footer {
        background-color: #f5f5f5;
        padding: 10px;
        text-align: center;
    }
    .footer__text {
        color: #999;
    }
  </style>
</head>
<body>
  <table width="100%">
    <tr>
      <th class="header">
        <div class="header__logo">
          <h1>Atma Kitchen</h1>
        </div>
      </th>
    </tr>
    <tr>
      <td>
        <div class="body">
          <div class="body__content">
            <p>Hi {{ $data['nama'] }},</p>
            <p>Thank you for signing up for Atma Kitchen! To verify your email address and complete your registration, please click the button below:</p>
          </div>
          <div class="body__action">
            <a href="{{ url('/api/auth/verify', $data['token']) }}" style="background-color: #4CAF50; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">Verify Your Email Address</a>
          </div>
          <div class="body__content">
            <p>If you can't click the button above, please copy and paste the following link into your web browser:</p>
            <p>{{ url('/api/auth/verify', $data['token']) }}</p>
          </div>
        </div>
      </td>
    </tr>
    <tr>
      <th class="footer">
        <div class="footer__text">
          <p>&copy; {{ date('Y') }} Atma Kitchen. All rights reserved.</p>
        </div>
      </th>
    </tr>
  </table>
</body>
</html>
