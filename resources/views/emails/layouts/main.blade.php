<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title>Email</title>

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    @include('emails.partials.css')
</head>

<body width="100%"
    style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
    <center style="width: 100%; background-color: #ffffff;">
        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="logo" style="text-align: center;">
                        <h1>
                            <a href="{{ route('login') }}">
                                <img src="{{ config('storage.app_image.banner') }}" alt="{{ config('app.name') }}"
                                    width="240">
                            </a>
                        </h1>
                    </td>
                </tr>
            </table>

            @yield('content')

            @include('emails.partials.footer')
        </div>
    </center>
</body>

</html>
