<!-- V_semua_karya.php -->
<div class="container my-5">
  <h1 class="mb-4">Hasil Karya Bank Sampah</h1>

  <div class="row">
    <?php foreach ( $karya as $item ) : ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <img src="<?= base_url ( 'uploads/karya/' . $item->gambar ) ?>" class="card-img-top" alt="<?= $item->judul ?>"
             style="height: 200px; object-fit: cover;">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars ( $item->judul ) ?></h5>
          <p class="card-text">
            <small class="text-muted">
              Oleh <?= htmlspecialchars ( $item->author ) ?> -
              <?= date ( 'd M Y', strtotime ( $item->tanggal_dibuat ) ) ?>
            </small>
          </p>
          <a href="<?= base_url ( 'karya/detail/' . $item->id_hasil_karya ) ?>" class="btn btn-primary">Baca
            Selengkapnya</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>