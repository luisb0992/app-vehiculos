@extends('emails.layouts.main')

@section('content')
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td valign="top" class="bg_white" style="padding: 1em 1em;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="logo" style="text-align: center;">
                            <h1>
                                <a href="{{ route('login') }}">
                                    <img src="{{ $img }}" alt="{{ config('app.name') }}" width="240">
                                </a>
                            </h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="middle" class="hero hero-2 bg_white" style="padding: 0 0;">
                <table>
                    <tr>
                        <td>
                            <div class="text" style="padding: 0 3em; text-align: center;">
                                <h2>
                                    <strong>{{ $data['title'] }}</strong>
                                </h2>
                                <p>
                                    <strong>{{ $data['body'] }}</strong>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                {{--  datos del vehiculo  --}}
                <table>
                    <tr>
                        <td>
                            <div class="text" style="padding: 0 3em; text-align: center;">
                                <h2>
                                    <strong>Datos del vehículo</strong>
                                </h2>
                                <p>
                                    <strong>Marca: </strong> {{ $data['vehicle']['brand']['name'] }}
                                </p>
                                <p>
                                    <strong>Modelo: </strong> {{ $data['vehicle']['model']['name'] }}
                                </p>
                                <p>
                                    <strong>Color: </strong> {{ $data['vehicle']['color']['name'] }}
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                {{--  link mas detalles  --}}
                <table>
                    <tr>
                        <td>
                            <div class="text" style="padding: 0 3em; text-align: center;">
                                <h2>
                                    <strong>Para más detalles</strong>
                                </h2>
                                <p>
                                    <a href="{{ route('workshop_quotes.index') }}">
                                        <strong>Da click aquí</strong>
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="bg_white">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td class="bg_white email-section">
                            <div class="heading-section" style="text-align: center; padding: 0 30px;">
                                <p>
                                    Si este correo es para ti y no lo solicitaste, por favor ignóralo.
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
