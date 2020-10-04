<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pago de colegiatura</title>
    <style>
        .table-custom{
            width: 100%;
        }
        .table{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
        .table-bordered {
            border: 1px solid #000;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #000;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #000;
        }
        .table {
            border-spacing: 0;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div>
        <table class="table-custom" style="margin-bottom:15px;">
            <tbody>
                <tr>
                    <th>Comprobante de pago No. {{ $pago->id }}</th>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="margin-bottom: 1px; border: 1px solid #000; border-radius:5px; padding: 10px 10px;">
        <table class="table-custom">
            <tbody>
                <tr>
                    <td>Alumno: {{ $inscrito->alumno->persona->primer_nombre }} {{ $inscrito->alumno->persona->segundo_nombre }} {{ $inscrito->alumno->persona->tercer_nombre }} {{ $inscrito->alumno->persona->primer_apellido }} {{ $inscrito->alumno->persona->segundo_apellido }}</td>
                    <td>Fecha: {{ $fecha }}</td>
                </tr>
                <tr>
                    <td>Ciclo Escolar: {{ $pago->ciclo_escolar->nombre }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="height:180px; margin-top: 15px; margin-bottom: 1px; border: 1px solid #000; border-radius:5px;  padding: 10px 10px;">
        <table class="table-custom" >
            <tbody >
                <tr>
                    <td>
                        DESCRIPCION: Colegiatura correspondiente al mes de: {{ $pago->mes->nombre }}
                    </td>
                    <td>Monto: Q. {{ $pago->monto }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table-custom" style="margin-top:35px;">
            <tbody>
                <tr style="text-align:center">
                    <td>______________________________________</td>
                </tr>
                <tr style="text-align: center">
                    <td>Firma y sello</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>