<!-- Tambahkan Bootstrap CSS di <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      Form Tracer Alumni
    </div>
    <div class="card-body">
      <form action="{{ route('submit.alumni') }}" method="POST">
        @csrf
        <div class="row g-4">
          <!-- Kolom Kiri -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Nama/NIM</label>
              <input type="text" class="form-control" name="nama">
            </div>
            <div class="mb-3">
              <label class="form-label">Program Studi</label>
              <select class="form-select" name="prodi">
                <option value="">-- Pilih Program Studi --</option>
                <option value="D-IV Sistem Informasi Bisnis">D-IV Sistem Informasi Bisnis</option>
                <option value="D-IV Teknik Informatika">D-IV Teknik Informatika</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Tahun Lulus</label>
              <select class="form-select" name="tahun">
                <option value="2025">2025</option>
              </select>
            </div>
            <div class="mb-3">
  <label class="form-label">No. HP</label>
  <input type="text" class="form-control" name="no_hp" required pattern="^[0-9]+$">
  <div class="invalid-feedback">
    Harus diisi dengan angka saja.
  </div>
</div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Pertama Kerja</label>
              <input type="date" class="form-control" name="tgl_pertama_kerja">
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Mulai di Instansi Saat Ini</label>
              <input type="date" class="form-control" name="tgl_instansi">
            </div>
          </div>

          <!-- Kolom Kanan -->
          <div class="col-md-6">
            <div class="mb-3">
            <label for="jenis_instansi" class="form-label">Jenis Instansi</label>
            <select class="form-select" name="jenis_instansi" id="jenis_instansi" required>
              <option value="" disabled selected>-- Pilih Jenis Instansi --</option>
              <option value="1">Pendidikan Tinggi</option>
              <option value="2">Instansi Pemerintah</option>
              <option value="3">Perusahaan Swasta</option>
              <option value="4">BUMN</option>
            </select>
          </div>
            <div class="mb-3">
              <label class="form-label">Nama Instansi</label>
              <input type="text" class="form-control" name="nama_instansi">
            </div>
            <div class="mb-3">
              <label class="form-label">Skala Instansi</label>
              <select class="form-select" name="skala_instansi" id="skala_instansi" required>
                <option value="" disabled selected>-- Pilih Skala Instansi --</option>
                <option value="Multinasional/Internasional">Multinasional/Internasional</option>
                <option value="Nasional">Nasional</option>
                <option value="Wirausaha">Wirausaha</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Lokasi Instansi</label>
              <input type="text" class="form-control" name="lokasi_instansi">
            </div>
        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <select class="form-select" name="kategori" id="kategori" required>
            <option value="" disabled selected>-- Pilih Kategori --</option>
            <option value="Bidang Infokom">Bidang Infokom</option>
            <option value="Bidang Non Infokom">Bidang Non Infokom</option>
            <option value="Belum Bekerja">Belum Bekerja</option>
          </select>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Profesi</label>
            <select class="form-select" id="kategori" name="kategori" required onchange="handleKategoriChange(this)">
              <option value="" disabled selected>-- Pilih Profesi --</option>
                <optgroup label="Bidang Infokom">
                  <option value="Developer/Programmer/Software Engineer">Developer/Programmer/Software Engineer</option>
                  <option value="IT Support/IT Administrator">IT Support/IT Administrator</option>
                  <option value="Infrastructure Engineer">Infrastructure Engineer</option>
                  <option value="Digital Marketing Specialist">Digital Marketing Specialist</option>
                  <option value="Graphic Designer/Multimedia Designer">Graphic Designer/Multimedia Designer</option>
                  <option value="Business Analyst">Business Analyst</option>
                  <option value="QA Engineer/Tester">QA Engineer/Tester</option>
                  <option value="IT Enterpreneur">IT Enterpreneur</option>
                  <option value="Trainer/Guru/Dosen (IT)">Trainer/Guru/Dosen (IT)</option>
                  <option value="Mahasiswa (IT)">Mahasiswa (IT)</option>
                  <option value="Lainnya (IT)">Lainnya</option>
                </optgroup>
                <optgroup label="Bidang Non-Infokom">
                  <option value="Procurement & Operational Team">Procurement & Operational Team</option>
                  <option value="Wirausahawan (Non IT)">Wirausahawan (Non IT)</option>
                  <option value="Trainer/Guru/Dosen (Non IT)">Trainer/Guru/Dosen (Non IT)</option>
                  <option value="Mahasiswa (Non IT)">Mahasiswa (Non IT)</option>
                  <option value="Lainnya (Non IT)">Lainnya Non IT</option>
                   <option value="Belum Bekerja">Belum Bekerja</option>
                </optgroup>
              </select>
            </div>

            <!-- Input tambahan untuk "Lainnya" -->
            <div class="mb-3 d-none" id="inputLainnyaWrapper">
              <label for="kategori_lainnya" class="form-label">Isi Kategori Profesi Lainnya</label>
              <input type="text" class="form-control" id="kategori_lainnya" name="kategori_lainnya" placeholder="Masukkan kategori lainnya...">
            </div>

            <script>
              function handleKategoriChange(select) {
                const lainnyaValues = ['Lainnya (IT)', 'Lainnya (Non IT)'];
                const inputWrapper = document.getElementById('inputLainnyaWrapper');

                if (lainnyaValues.includes(select.value)) {
                  inputWrapper.classList.remove('d-none');
                } else {
                  inputWrapper.classList.add('d-none');
                  document.getElementById('kategori_lainnya').value = ''; // kosongkan input jika bukan "lainnya"
                }
              }
            </script>
        <div class="text-end mt-3">
          <button type="submit" class="btn btn-primary">Submit</button>

        </div>
      </form>
    </div>
  </div>
</div>
