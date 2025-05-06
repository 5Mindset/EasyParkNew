<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }
        .otp-box {
            font-size: 24px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 12px 20px;
            display: inline-block;
            border-radius: 8px;
            margin: 16px 0;
        }
    </style>
</head>
<body>
    <p>Halo,</p>
    <p>Kode OTP kamu adalah:</p>
    <div class="otp-box">{{ $otp }}</div>
    <p>Kode ini berlaku selama 5 menit. Jangan bagikan kepada siapa pun.</p>
</body>
</html>
