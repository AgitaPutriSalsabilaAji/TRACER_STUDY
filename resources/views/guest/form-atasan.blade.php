@extends('layouts.headerguest')

@section('content')
<div class="container my-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('alert'))
        <div class="alert alert-danger">{{ session('alert') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Form Survei Kepuasan Pengguna Alumni
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('submit.atasan') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_surveyor" class="form-label">Nama Suerveyor</label>
                        <input type="text" class="form-control" id="nama_surveyor" name="nama_surveyor" required>
                    </div>
                    <div class="col-md-6">
                        <label for="instansi" class="form-label">Instansi</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="mb-3 position-relative">
                    <label for="nama_alumni" class="form-label">Data Alumni</label>
                    <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" autocomplete="off" required>
                    <input type="hidden" id="alumni_id" name="alumni_id">
                    <div id="nama-error" class="text-danger mt-1" style="display: none;">Nama alumni tidak valid.</div>
                </div>

                <div id="form-survey" style="display: none;">
                    <hr>
                    <h5 class="mb-3">Penilaian Kompetensi Alumni<br><small>(1 = Sangat Kurang 😞, 4 = Sangat Baik 😃)</small></h5>

                    @php
                        $pertanyaan = [
                            'kerjasama_tim' => 'Kerjasama Tim',
                            'keahlian_di_bidang_ti' => 'Keahlian di bidang IT',
                            'pengembangan_diri' => 'Kemampuan mengembangkan diri',
                            'kepemimpinan' => 'Kemampuan kepemimpinan',
                            'kemampuan_bahasa_asing' => 'Kemampuan bahasa asing',
                            'kemampuan_komunikasi' => 'Kemampuan komunikasi',
                            'etos_kerja' => 'Etos kerja'
                        ];

                        $emojis = [
                            '1' => '😞 Sangat Kurang',
                            '2' => '😐 Kurang',
                            '3' => '🙂 Baik',
                            '4' => '😃 Sangat Baik'
                        ];
                    @endphp

                    @foreach($pertanyaan as $key => $label)
                        <div class="mb-3">
                            <label class="form-label">{{ $label }}</label>
                            <select class="form-select" name="{{ $key }}" required>
                                <option value="">Pilih nilai</option>
                                @foreach($emojis as $value => $text)
                                    <option value="{{ $value }}">{{ $value }} - {{ $text }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label">Kompetensi yang Belum Terpenuhi</label>
                        <textarea name="kompetensi_belum_terpenuhi" class="form-control" rows="3" placeholder="Opsional"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Saran untuk Kurikulum Kami</label>
                        <textarea name="saran_kurikulum" class="form-control" rows="3" placeholder="Opsional"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Kirim Survei</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script tetap --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        let validName = false;

        $('#nama_alumni').on('keyup', function () {
            const query = $(this).val();
            $('#alumni_id').val('');
            $('#form-survey').hide();
            validName = false;
            $('.list-group').remove();
            $('#nama-error').hide();

            if (query.length >= 3) {
                $.ajax({
                    url: "{{ route('autocomplete.alumni') }}",
                    type: "GET",
                    data: { q: query },
                    // Bagian success ajax diubah menjadi seperti ini:
            success: function(data) {
                if (data.length > 0) {
                    let dropdown = '<ul class="list-group position-absolute w-100" style="z-index:1000;">';
                    data.forEach(item => {
                        dropdown += `<li class="list-group-item" data-id="${item.id}">${item.text}</li>`;
                        
                    });
                    dropdown += '</ul>';
                    $('#nama_alumni').after(dropdown);

                    $('.list-group-item').on('click', function () {
                        const selectedText = $(this).text();
                        const selectedId = $(this).data('id');
                        $('#nama_alumni').val(selectedText);
                        $('#alumni_id').val(selectedId);
                        validName = true;
                        $('.list-group').remove();
                        $('#nama-error').hide();
                        $('#form-survey').slideDown();
                    });
                } else {
                    $('#nama-error').text('Alumni tidak ditemukan.').show();
                }
            },

            
                });
            }
        });
        $('form').submit(function (e) {
            if (!validName || !$('#alumni_id').val()) {
                e.preventDefault();
                $('#nama-error').text('Silakan pilih alumni dari daftar.').show();
                $('#nama_alumni').addClass('is-invalid');
            }
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#nama_alumni').length) {
                $('.list-group').remove();
            }
        });
    });
</script>
@endsection
