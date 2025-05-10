<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Survei</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+" crossorigin="anonymous">
    <style>
        .form-icon {
            width: 30px;
        }
        .form-label {
            width: 200px;
            vertical-align: middle;
        }
        td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h4 class="text-white bg-primary p-2">Lengkapi Data</h4>

    {{ Form::open() }}
    <table class="table table-borderless">
        <tr>
            <td class="form-icon"><i class="fa fa-phone"></i></td>
            <td class="form-label">No Telp</td>
            <td>{!! Form::text('no_telp', null, ['class' => 'form-control', 'placeholder' => '08xxxxxxxx']) !!}</td>
        </tr>
        <tr>
            <td class="form-icon"><i class="fa fa-envelope"></i></td>
            <td class="form-label">Email</td>
            <td>{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email@example.com']) !!}</td>
        </tr>
        <tr>
            <td class="form-icon"><i class="fa fa-calendar"></i></td>
            <td class="form-label">Tanggal pertama kerja</td>
            <td>{!! Form::date('tanggal_kerja', null, ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Jenis Instansi</td>
            <td>{!! Form::text('jenis_instansi', null, ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Nama Instansi</td>
            <td>{!! Form::text('nama_instansi', null, ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Skala</td>
            <td>{!! Form::select('skala', ['Nasional' => 'Nasional', 'Internasional' => 'Internasional'], 'Nasional', ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Lokasi Instansi</td>
            <td>{!! Form::text('lokasi_instansi', null, ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Kategori Profesi</td>
            <td>{!! Form::select('kategori_profesi', ['Infokom' => 'Infokom', 'Non-Infokom' => 'Non-Infokom'], 'Infokom', ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td></td>
            <td class="form-label">Profesi</td>
            <td>{!! Form::text('profesi', 'Mahasiswa', ['class' => 'form-control']) !!}</td>
        </tr>
    </table>

    <div class="text-right">
        {!! Form::submit('Next', ['class' => 'btn btn-primary']) !!}
    </div>
    {{ Form::close() }}
</div>

<!-- FontAwesome (for icons) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
