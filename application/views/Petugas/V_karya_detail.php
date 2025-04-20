<!-- V_karya_detail.php -->
<div class="container my-5">
  <div class="row">
    <div class="col-md-8">
      <article class="blog-post">
        <h1 class="blog-post-title"><?= htmlspecialchars ( $karya->judul ) ?></h1>
        <p class="blog-post-meta">
          Diposting pada <?= date ( 'd F Y', strtotime ( $karya->tanggal_dibuat ) ) ?> oleh
          <a href="#"><?= htmlspecialchars ( $karya->author ) ?></a>
        </p>

        <img src="<?= base_url ( 'uploads/karya/' . $karya->gambar ) ?>" class="img-fluid rounded mb-4"
             alt="<?= $karya->judul ?>">

        <div class="blog-post-content">
          <?= $karya->konten ?>
        </div>
      </article>
    </div>

    <div class="col-md-4">
      <div class="card mb-4">
        <div class="card-header">
          <h5>Karya Terbaru</h5>
        </div>
        <div class="card-body">
          <?php foreach ( $recent_karya as $item ) : ?>
          <div class="mb-3">
            <a href="<?= base_url ( 'karya/detail/' . $item->id_hasil_karya ) ?>">
              <img src="<?= base_url ( 'uploads/karya/' . $item->gambar ) ?>" class="img-thumbnail mb-2"
                   style="max-height: 100px;">
              <h6><?= htmlspecialchars ( $item->judul ) ?></h6>
            </a>
            <small class="text-muted"><?= date ( 'd M Y', strtotime ( $item->tanggal_dibuat ) ) ?></small>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>