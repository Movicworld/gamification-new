@extends('email_template.master')

@section('content')

    <table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
        <tbody>
            <tr>
                <td style="padding: 30px 30px 15px 30px;">
                    <h2 style="font-size: 18px; color: #6576ff; font-weight: 600; margin: 0;">Welcome Home!</h2>
                </td>
            </tr>
            <tr>
                <td style="padding: 30px 30px 20px">
                    <p style="margin-bottom: 10px;">Hi <strong>{{ $name }},</strong></p>
                    <p style="margin-bottom: 10px;">
                        We are glad to have you in the family, this means so much to us and we look forward to working with you and building the best technologies out of Africa.
                    </p>

                    <p style="margin-bottom: 10px;">Here are your login credentials:</p>
                    <p style="margin-bottom: 10px;">
                        Email: <strong>{{ $email }}</strong><br>
                        Password: <strong>{{ $password }}</strong>
                    </p>
                    <p style="margin-bottom: 20px; color:#888; font-size:12px;">
                        Please log in and change your password as soon as possible.
                    </p>

                    <p style="margin-bottom: 10px;">
                        Click the button below to log in <br><br>
                        <a href="{{ $url }}" target="_blank"
                            style="background-color:#6576ff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;font-weight:600;line-height:44px;text-align:center;text-decoration:none;text-transform: uppercase; padding: 0 30px">
                            Login Now
                        </a>
                    </p>

                    <p style="margin-top: 45px; margin-bottom: 15px;">---- <br> Regards, <br><i>Freebyz Team.</i></p>
                </td>
            </tr>
        </tbody>
    </table>

@endsection
