<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title></title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                {{ $name }}<br><br>
                {{ $phone }}<br><br>
                {{ $email }}<br><br>
                Unidad de interes: {{ $unit }}<br><br>
                @if(!empty($model))
                Modelo de interes: {{ $model }}<br><br>
                @endif
                {{ $msg }}<br><br>
            </td>
        </tr>
    </table>
</body>
</html>