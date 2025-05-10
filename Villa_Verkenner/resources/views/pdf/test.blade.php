<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }

        h1 {
            color: #4682B4;
        }
    </style>
</head>

<body>
    <h1>{{ $title }}</h1>
    <p>{{ $content }}</p>
    <p>Generated at: {{ date('Y-m-d H:i:s') }}</p>
</body>

</html>