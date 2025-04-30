<!-- V_hasil_karya_edit.php -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="card-title mb-0">Edit Hasil Karya</h4>
          <a href="<?= base_url ( 'Hasil-Karya' ) ?>" class="btn btn-dark">
            <i class="mdi mdi-arrow-left align-middle"></i> Kembali
          </a>
        </div>

        <form id="formKarya" enctype="multipart/form-data">
          <input type="hidden" name="id_hasil_karya" value="<?= $karya->id_hasil_karya ?>">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group mb-4">
                <label class="form-label">Judul Karya <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control form-control-lg" placeholder="Masukkan judul karya"
                       value="<?= htmlspecialchars ( $karya->judul ) ?>" required>
                <div class="invalid-feedback judul-error"></div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Konten <span class="text-danger">*</span></label>
                <div id="editor" style="height: 300px;"></div>
                <input type="hidden" name="konten" id="konten" value="<?= htmlspecialchars ( $karya->konten ) ?>">
                <div class="invalid-feedback konten-error"></div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Pengaturan</h5>

                  <div class="form-group mb-4">
                    <label>Kategori Sampah <span class="text-danger">*</span></label>
                    <select name="id_jenis_sampah" id="id_jenis_sampah" class="form-control" required>
                      <option value="">Pilih Kategori</option>
                      <?php foreach ( $jenis_sampah as $js ) : ?>
                      <option value="<?= $js->id_jenis_sampah ?>"
                              <?= ( $js->id_jenis_sampah == $karya->id_jenis_sampah ) ? 'selected' : '' ?>>
                        <?= $js->jenis_sampah ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback kategori-error"></div>
                  </div>

                  <div class="form-group mb-4">
                    <label>Sub kategori Sampah</label>
                    <select name="id_sampah" id="id_sampah" class="form-control" disabled>
                      <option value="">Pilih Kategori terlebih dahulu</option>
                    </select>
                  </div>

                  <div class="form-group mb-4">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="mt-2" id="currentImagePreview">
                      <div class="border p-2 rounded">
                        <img src="<?= base_url ( './assets/uploads/karya/' . $karya->gambar ) ?>"
                             class="img-fluid rounded" style="max-height: 200px;">
                        <p class="mt-2 mb-0 text-muted small"><?= $karya->gambar ?></p>
                      </div>
                    </div>

                    <label class="form-label mt-3">Gambar Baru (opsional)</label>
                    <div class="custom-file">
                      <input type="file" name="gambar" class="custom-file-input" id="inputGambar">
                      <label class="custom-file-label" for="inputGambar">Pilih gambar baru (opsional)</label>
                    </div>
                    <small class="text-muted">Format: JPG/PNG (Maks. 2MB)</small>
                    <div class="invalid-feedback gambar-error"></div>
                    <div class="mt-2" id="gambarPreview"></div>
                  </div>

                  <hr class="my-4">

                  <div class="d-flex justify-content-end">
                    <button type="reset" id="reset" class="btn btn-dark me-2">
                      <i class="mdi mdi-autorenew align-middle"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-submit">
                      <i class="mdi mdi-content-save align-middle"></i> Simpan Perubahan
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
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

    // Load existing content to Quill
    quill.clipboard.dangerouslyPasteHTML(<?= json_encode ( $karya->konten ) ?>);

    // Set konten hidden value
    $('#konten').val(quill.root.innerHTML);

    // Reset button
    $('#reset').click(function() {
      quill.clipboard.dangerouslyPasteHTML(<?= json_encode ( $karya->konten ) ?>);
    });

    // Load subcategories when page loads if category is selected
    if ($('#id_jenis_sampah').val()) {
      loadSubcategories($('#id_jenis_sampah').val(), <?= $karya->id_sampah ?>);
    }

    // Category change event
    $('#id_jenis_sampah').change(function() {
      loadSubcategories($(this).val());
    });

    // Function to load subcategories
    function loadSubcategories(id_jenis_sampah, selectedId = null) {
      if (!id_jenis_sampah) {
        $('#id_sampah').html('<option value="">Pilih Kategori terlebih dahulu</option>').prop('disabled', true);
        $('#id_sampah').removeAttr('required');
        return;
      }

      $.ajax({
        url: '<?= base_url ( "Hasil-Karya/get_subkategori" ) ?>',
        type: 'POST',
        data: {
          id_jenis_sampah: id_jenis_sampah
        },
        dataType: 'json',
        success: function(response) {
          let options = '<option value="">Pilih Subkategori</option>';
          response.forEach(function(item) {
            options +=
              `<option value="${item.id_sampah}" ${(selectedId && item.id_sampah == selectedId) ? 'selected' : ''}>${item.nama_sampah}</option>`;
          });

          $('#id_sampah').html(options).prop('disabled', false);
          $('#id_sampah').prop('required', true);
        }
      });
    }

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
      $(this).next('.custom-file-label').addClass("selected").html(fileName || "Pilih gambar baru");
    });

    // AJAX Form Submission
    $('#formKarya').submit(function(e) {
      e.preventDefault();
      $('#konten').val(quill.root.innerHTML);

      const formData = new FormData(this);
      const btn = $('.btn-submit');

      btn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin align-middle"></i> Menyimpan...');

      $.ajax({
        url: '<?= base_url ( "Hasil-Karya/update/" . $karya->id_hasil_karya ) ?>',
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
            '<i class="mdi mdi-content-save align-middle"></i> Simpan Perubahan');
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