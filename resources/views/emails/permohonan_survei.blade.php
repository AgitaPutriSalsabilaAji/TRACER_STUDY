<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Survei Kinerja Alumni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            line-height: 1.5;
            padding: 20px;
        }

        .token-box {
            background-color: #e9f5ff;
            border: 2px dashed #007bff;
            border-radius: 8px;
            padding: 12px 20px;
            font-family: monospace, monospace;
            font-size: 1.2em;
            color: #007bff;
            text-align: center;
            user-select: all;
            max-width: 320px;
            margin: 10px auto 20px auto;
            word-break: break-word;
        }

        /* styling tombol link */
        .btn-link {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
    </style>
</head>

<body>
    <p>Yth. Bapak/Ibu,</p>

    <p>Kami dari Tim Tracer Study Politeknik Negeri Malang memohon kesediaan Bapak/Ibu untuk mengisi survei terkait
        kinerja alumni kami, saudara/i <strong>{{ $alumni->nama }}</strong>, yang saat ini bekerja di
        perusahaan/instansi Bapak/Ibu.</p>

    <p>Survei ini bertujuan untuk meningkatkan kualitas pendidikan dan menyesuaikan kurikulum dengan kebutuhan dunia kerja.</p>

    <p>Mohon luangkan waktu sejenak untuk mengisi survei tersebut melalui tautan berikut:</p>

    <p><a href="{{ $survey_link }}" target="_blank" class="btn-link">Isi Survei Sekarang</a></p>

    <p><strong>Sebelum mengisi survei, mohon masukkan token unik berikut sebagai verifikasi:</strong></p>

    <div class="token-box" title="Silakan blok dan salin token ini">{{ $token }}</div>

    <p>Token ini penting untuk menjaga keamanan dan validitas survei.</p>

    <p>Anda dapat menyalin token di atas dan memasukkannya pada halaman verifikasi survei.</p>

    <p>Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.</p>

    <p>Hormat kami,<br>Tim Tracer Study<br>Politeknik Negeri Malang</p>
</body>

</html>
