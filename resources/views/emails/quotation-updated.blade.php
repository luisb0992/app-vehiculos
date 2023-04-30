@extends('emails.layouts.main')

@section('content')
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td valign="middle" class="hero hero-2 bg_white" style="padding: 0 0;">
                <table>
                    <tr>
                        <td>
                            <div class="text" style="padding: 0 3em; text-align: center;">
                                <h2>
                                    La cotización <strong>{{ $data['quotation']['id'] }}</strong> para el vehículo
                                    <strong>{{ $data['vehicle']['chassis_number'] }}</strong> ha sido actualizada.
                                </h2>
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
                                    <strong>Cotización actualizada</strong>
                                </h2>
                                <p>
                                    <strong>Taller: </strong> {{ $data['workshop']['name'] }}
                                </p>
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
                                    <a href="{{ route('login') }}" class="btn-more">
                                        <span style="color: #ffffff;">Da click aquí</span>
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
