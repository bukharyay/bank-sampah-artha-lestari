<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); ?>

<section class="py-0" id="wilayah">
  <div class="bg-holder"
       style="background-image:url(<?= base_url () ?>assets/landing/img/illustrations/dot.png);background-position:left;background-size:auto;margin-top:-105px;">
  </div>

  <div class="container position-relative py-5">
    <div class="row justify-content-center">
      <div class="col-12 text-center pt-8">
        <h1 class="display-5 fw-bold mb-3">Wilayah Kerja</h1>
        <p class="lead">Area layanan dan jangkauan Bank Sampah Artha Lestari
        </p>
        <div class="alert alert-success mt-4 w-md-50 mx-auto">
          <i class="icon icon-md mdi mdi-trophy-outline me-2"></i> <strong>Juara 1</strong> Lomba Bank Sampah Tingkat
          Kota
          Semarang
        </div>
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <h5 class="card-title fw-bold">Bank Sampah Artha Lestari</h5>
            <p class="card-text">
              <i class="icon icon-sm mdi mdi-map-marker text-primary me-2"></i> Jl. Meranti Tim. Dlm IV No.4,
              Padangsari, Kec.
              Banyumanik, Kota Semarang, Jawa Tengah 50263
            </p>
            <p class="card-text">
              <i class="icon icon-sm mdi mdi-clock-outline text-primary me-2"></i> Senin-Jumat: 08.00-16.00
            </p>
            <p class="card-text">
              <i class="icon icon-sm mdi mdi-phone text-primary me-2"></i> +62 8164241991
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-4 pb-8">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8">
        <div class="card shadow-sm">
          <div class="card-body p-0">
            <div id="map" class="map" style="height: 500px;"></div>
            <div id="popup" class="ol-popup">
              <a id="popup-closer" class="ol-popup-closer"></a>
              <div id="popup-content"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-12">
        <h2 class="fw-bold text-center mb-4">Wilayah Layanan Bank Sampah Artha Lestari</h2>
        <p class="text-center mb-5">Kami melayani warga di RW 02 Kelurahan Padangsari, Kecamatan Banyumanik, Kota
          Semarang dengan pembagian wilayah berdasarkan RT untuk memudahkan pengelolaan sampah</p>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <h5 class="card-title fw-bold ">Detail Wilayah Layanan</h5>
            <div class="d-flex align-items-start mb-3">
              <div class="me-4 align-self-center">
                <span class="badge bg-primary rounded-pill py-2">RW 02</span>
              </div>
              <div>
                <h6 class="fw-semibold mb-2">Kelurahan Padangsari</h6>
                <p class="small  mb-0">Kecamatan Banyumanik, Kota Semarang</p>
              </div>
            </div>

            <h6 class="fw-semibold mt-4 mb-3">RT yang Dilayani:</h6>
            <div class="row">
              <div class="col-4">
                <ul class="list-unstyled small">
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    01 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    02 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    03 RW
                    02</li>
                </ul>
              </div>

              <div class="col-4">
                <ul class="list-unstyled small">
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    04 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    05 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    06 RW
                    02</li>
                </ul>
              </div>
              <div class="col-4">
                <ul class="list-unstyled small">
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    07 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    08 RW
                    02</li>
                  <li class="mb-2"><i class="icon icon-sm mdi mdi-check-circle-outline text-success me-2 "></i> RT
                    09 RW
                    02</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body">
            <h5 class="card-title fw-bold">Layanan Kami</h5>
            <div class="feature-list">
              <div class="d-flex mb-3">
                <div class="feature-icon p-1 bg-soft-primary rounded-3 me-3 align-self-stretch align-content-center">
                  <i class="icon icon-md mdi mdi-recycle text-primary "></i>
                </div>
                <div>
                  <h6 class="fw-semibold mb-1">Pengumpulan Sampah</h6>
                  <p class="small  mb-0">Layanan penjemputan dan penampungan sampah terpilah</p>
                </div>
              </div>
              <div class="d-flex mb-3">
                <div class="feature-icon p-1 bg-soft-primary rounded-3 me-3 align-self-stretch align-content-center">
                  <i class="icon icon-md mdi mdi-cash-multiple text-primary "></i>
                </div>
                <div>
                  <h6 class="fw-semibold mb-1">Penukaran Sampah</h6>
                  <p class="small  mb-0">Nilai ekonomis untuk sampah yang dapat didaur ulang</p>
                </div>
              </div>
              <div class="d-flex">
                <div class="feature-icon p-1 bg-soft-primary rounded-3 me-3 align-self-stretch align-content-center">
                  <i class="icon icon-md mdi mdi-school text-primary "></i>
                </div>
                <div>
                  <h6 class="fw-semibold mb-1">Edukasi Lingkungan</h6>
                  <p class="small  mb-0">Program edukasi pengelolaan sampah ramah lingkungan</p>
                </div>
              </div>
            </div>

            <div class="alert alert-success mt-4 text-center">
              <i class=" icon icon-sm mdi mdi-trophy-outline me-2 align-middle "></i> <strong>Juara 1</strong> Lomba
              Bank
              Sampah
              Tingkat Kota
              Semarang
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-12">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-4">
            <h5 class="fw-bold mb-3">Dukung Program Pemerintah Kota Semarang</h5>
            <p class="mb-0">Bank Sampah Artha Lestari turut mendukung program pemerintah Kota Semarang dalam pengelolaan
              sampah rumah tangga secara berkelanjutan dan peningkatan partisipasi masyarakat dalam pengelolaan sampah.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="<?= base_url () ?>assets/js/Map/ol.map.js?<?= time (); ?>"></script>
<script>
// Popup content
function ToolTip(item) {
  var html = '';
  html += '<div class="ol-tooltip">' +
    '<img src="<?= base_url () ?>assets/icon-svg/icon-bank.svg">' +
    '<div class="info">' +
    '<div class="ol-tooltip-bank "> <a href="https://www.google.com/maps/place/' + item.Lat + ',' + item.Lon +
    '" target="_blank" class="text-wrap"> ' + item.Desc +
    ' </a> </div>' +
    '<div class="ol-tooltip-alamat text-wrap">' + item.alamat + '</div>' +
    '<div class="ol-tooltip-tanggal text-wrap">' + item.tanggal_dibuat + '</div>' +
    '</div>' +
    '</div>';
  return html;
}

var data = <?= json_encode ( $locations ); ?>;

function addPointGeom(data) {
  data.forEach(function(item) {

    var longitude = item.Lon,
      latitude = item.Lat,
      desc = item.Desc,
      alamat = item.alamat,
      tanggal_dibuat = item.tanggal_dibuat;

    var MarkerIcon = new ol.style.Icon({
      anchor: [0.5, 80],
      anchorXUnits: 'fraction',
      anchorYUnits: 'pixels',
      src: '<?= base_url () ?>assets/icon-svg/icon-location-pin.svg ',
      scale: 0.5
    });

    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')),
        type: 'Point',
        desc: ToolTip(item),
        lon: longitude,
        lat: latitude
      }),
      iconStyle = new ol.style.Style({
        image: MarkerIcon
      });
    iconFeature.setStyle(iconStyle);
    straitSource.addFeature(iconFeature);
  });
}

addPointGeom(data);
lastMarker = '';
</script>