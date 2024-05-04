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

    @media only screen and (max-width: 600px) {
        .body__content, .body__action {
            width: 90%;
        }
    }
  </style>
</head>
<body>
  <table width="100%">
    <tr>
      <td>
        <div class="body">
          <div class="body__content">
            <p>Hi {{ $data['nama'] }},</p>
            <p>Terima Kasih sudah melakukan pendaftaran di Atma Kitchen. Berikut adalah kode verifikasi Anda:</p>
            <div class="body__action">
              <div style="background-color: #4CAF50; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;">
                <h3>
                  {{ $data['digit'] }}
                </h3>
              </div>
            </div>
            <p>Jika Anda tidak merasa melakukan pendaftaran, abaikan email ini. Dan jika kode verifikasi tidak bekerja, silahkan melakukan pengiriman ulang kode verifikasi.</p>
          </div>
        </div>
      </td>
    </tr>
  </table>
</body>
</html>
