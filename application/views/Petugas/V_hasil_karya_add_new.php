<!-- V_hasil_karya_add.php -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Tambah Hasil Karya</h4>
          <a href="<?= base_url ( 'Hasil-Karya' ) ?>" class="btn btn-dark">
            <i class="mdi mdi-arrow-left align-middle"></i> Kembali
          </a>
        </div>

        <form id="formKarya" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group mb-4">
                <label class="form-label">Judul Karya <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan judul karya"
                       required>
                <div class="invalid-feedback judul-error"></div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Konten <span class="text-danger">*</span></label>
                <div id="editor" style="height: 300px;"></div>
                <input type="hidden" name="konten" id="konten">
                <div class="invalid-feedback konten-error"></div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Pengaturan</h5>

                  <div class="form-group mb-4">
                    <label class="form-label">Gambar Utama <span class="text-danger">*</span></label>
                    <div class="custom-file">
                      <input type="file" name="gambar" class="custom-file-input" id="inputGambar" required>
                      <label class="custom-file-label" for="inputGambar">Pilih gambar</label>
                    </div>
                    <small class="text-muted">Format: JPG/PNG (Maks. 2MB)</small>
                    <div class="invalid-feedback gambar-error"></div>
                    <div class="mt-2" id="gambarPreview"></div>
                  </div>

                  <hr class="my-4">

                  <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-dark me-2">
                      <i class="mdi mdi-autorenew align-middle"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-submit">
                      <i class="mdi mdi-content-save align-middle"></i> Simpan Karya
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Include Quill -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
    $(document).ready(function() {
      // Initialize Quill editor
      const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis konten karya Anda di sini...'
      });

      // Image preview
      $('#inputGambar').change(function() {
        const file = this.files[0];
        if (file) {
          // Check file type
          const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
          if (!validTypes.includes(file.type)) {
            $(this).val(''); // Clear the file input
            $('#gambarPreview').html(`
                <div class="alert alert-danger">
                    Format file tidak didukung. Harap unggah file JPG, PNG, GIF, atau WebP.
                </div>
            `);
            return;
          }

          // Check file size (2MB max)
          if (file.size > 2097152) {
            $(this).val(''); // Clear the file input
            $('#gambarPreview').html(`
                <div class="alert alert-danger">
                    Ukuran file terlalu besar. Maksimal 2MB.
                </div>
            `);
            return;
          }

          // Show preview if valid
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#gambarPreview').html(`
                <div class="border p-2 rounded">
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                    <p class="mt-2 mb-0 text-muted small">${file.name}</p>
                </div>
            `);
          }
          reader.readAsDataURL(file);
        }
      });

      // Custom file input label
      $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
      });

      // AJAX Form Submission
      $('#formKarya').submit(function(e) {
        e.preventDefault();
        $('#konten').val(quill.root.innerHTML);

        const formData = new FormData(this);
        const btn = $('.btn-submit');

        btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin align-middle"></i> Menyimpan...');

        $.ajax({
          url: '<?= base_url ( "Hasil-Karya/save" ) ?>',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              Swal.fire({
                title: 'Berhasil!',
                text: response.message,
                icon: 'success'
              }).then(() => {
                window.location.href = '<?= base_url ( "Hasil-Karya" ) ?>';
              });
            } else {
              // Show validation errors
              $.each(response.errors || {}, function(key, value) {
                $(`.${key}-error`).text(value).closest('.form-group').find('input, select, textarea')
                  .addClass('is-invalid');
              });

              if (response.message) {
                Swal.fire({
                  title: 'Gagal!',
                  text: response.message,
                  icon: 'error'
                });
              }
            }
          },
          error: function(xhr) {
            Swal.fire({
              title: 'Error!',
              text: 'Terjadi kesalahan saat menyimpan data',
              icon: 'error'
            });
          },
          complete: function() {
            btn.prop('disabled', false).html(
              '<i class="mdi mdi-content-save align-middle"></i> Simpan Karya');
          }
        });
      });

      // Reset validation on change
      $('input, textarea, select').on('input change', function() {
        $(this).removeClass('is-invalid');
        $(this).closest('.form-group').find('.invalid-feedback').text('');
      });
    });
    </script>
  </div>