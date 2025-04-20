<div class="main-panel">
  <div class="content-wrapper">


    <?php if ( $this->session->flashdata ( 'success' ) ) : ?>
    <div class="alert alert-success"><?= $this->session->flashdata ( 'success' ) ?></div>
    <?php endif; ?>
    <?php if ( $this->session->flashdata ( 'error' ) ) : ?>
    <div class="alert alert-danger"><?= $this->session->flashdata ( 'error' ) ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Set Ketua PKK RT <?= $rt->rt .' / RW '. $rt->rw ?> </h4>
        <?php if ( $current_ketua ) : ?>
        <div class="alert alert-info">
          Ketua PKK saat ini: <strong><?= $current_ketua->nama ?></strong>
        </div>
        <?php else : ?>
        <div class="alert alert-warning">Belum ada ketua PKK untuk RT ini</div>
        <?php endif; ?>

        <form id="formSetKetua" method="post" action="<?= site_url ( 'c_area/set_ketua_pkk/' . $rt->id_rt ) ?>">
          <div class="form-group">
            <label>Pilih Nasabah sebagai Ketua PKK</label>
            <select name="id_nasabah" class="form-control" required>
              <option value="">-- Pilih Nasabah --</option>
              <?php foreach ( $nasabah_list as $nasabah ) : ?>
              <option value="<?= $nasabah->id_nasabah ?>"
                      <?= ( $current_ketua && $current_ketua->id_nasabah == $nasabah->id_nasabah ) ? 'selected' : '' ?>>
                <?= $nasabah->nama ?> - <?= $nasabah->alamat ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="<?= site_url ( 'c_area' ) ?>" class="btn btn-secondary">Kembali</a>
        </form>
      </div>
    </div>
  </div>

  <script>
  const handleAjaxError = (xhr) => {
    let errorMsg = 'Terjadi kesalahan saat memproses permintaan';
    if (xhr.responseJSON?.status === 'error') {
      const messages = Array.isArray(xhr.responseJSON.message) ?
        xhr.responseJSON.message : [xhr.responseJSON.message || Object.values(xhr.responseJSON?.errors || {})];
      errorMsg = messages.join('<br>');
    }

    Swal.fire({
      title: 'Error!',
      html: errorMsg,
      icon: 'error'
    });
  };

  const showConfirmation = (options) => {
    return Swal.fire({
      title: options.title,
      text: options.text,
      html: options.html,
      icon: options.icon || 'question',
      showCancelButton: true,
      confirmButtonColor: options.confirmButtonColor || '#3085d6',
      cancelButtonColor: options.cancelButtonColor || '#d33',
      confirmButtonText: options.confirmButtonText || 'Ya',
      cancelButtonText: options.cancelButtonText || 'Batal'
    });
  };

  const handleResponse = (response, successCallback = () => location.reload()) => {
    Swal.fire({
      title: response.status === 'success' ? 'Berhasil!' : 'Gagal!',
      text: response.message,
      icon: response.status === 'success' ? 'success' : 'error'
    }).then(() => {
      if (response.status === 'success') {
        successCallback();
      }
    });
  };

  const handleAjaxSubmit = (url, data, options = {}) => {
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      dataType: 'json',
      beforeSend: function() {
        Swal.fire({
          title: 'Memproses',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          }
        });
      },
      success: (response) => handleResponse(response, options.successCallback),
      error: handleAjaxError
    });
  };

  // Form Handlers
  const handleFormSubmit = (e, confirmOptions) => {
    e.preventDefault();
    const form = $(e.target);

    showConfirmation(confirmOptions).then((result) => {
      if (result.isConfirmed) {
        handleAjaxSubmit(form.attr('action'), form.serialize());
      }
    });
  };

  $('#formSetKetua').on('submit', (e) => handleFormSubmit(e, {
    title: 'Konfirmasi',
    text: 'Anda yakin ingin melanjutkan?'
  }));
  </script>