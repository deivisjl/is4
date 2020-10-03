<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notas del curso</title>
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
    <table class="table-custom">
        <tbody>
            <tr>
                <td><strong>Plan:</strong> {{ $curso->plan}}</td>
                <td><strong>Carrera: </strong>{{ $curso->carrera }}</td>
            </tr>
            <tr>
                <td><strong>Grado: </strong>{{ $curso->grado }}, sección {{ $curso->seccion }}</td>
                <td><strong>Curso: </strong>{{ $curso->nombre }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alumno</th>
                <th>Primer bimestre</th>
                <th>Segundo bimestre</th>
                <th>Tercer bimestre</th>
                <th>Cuarto bimestre</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos['alumno'] as $index => $item)
                <tr class="text-center">
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $item['nombre'] }}</td>
                    <td>
                        @if(isset($item['bimestre_1']))
                            {{ $item['bimestre_1'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if(isset($item['bimestre_2']))
                            {{ $item['bimestre_2'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if(isset($item['bimestre_3']))
                            {{ $item['bimestre_3'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if(isset($item['bimestre_4']))
                            {{ $item['bimestre_4'] }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{ $item['total'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>