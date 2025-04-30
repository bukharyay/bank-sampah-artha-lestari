<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium <a
         href="https://www.Codelight.co/" target="_blank">Codelight.co</a></span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2025. All rights
      reserved.</span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->


<script>
  $('[data-toggle="tooltip"]').tooltip({
    boundary: 'window'
  });
  // Fungsi untuk memuat notifikasi
  function loadNotifications() {
    $.ajax({
      url: '<?= site_url ( "Get-Notifikasi" ) ?>',
      type: 'GET',
      dataType: 'json',

      success: function (response) {
        if (response.success) {
          // Update counter notifikasi
          $('#notificationCount').text(response.unread_count);
          if (response.unread_count > 0) {
            $('#notificationCount').show();
          } else {
            $('#notificationCount').hide();
          }

          // Update daftar notifikasi
          let notificationsHtml = '';
          if (response.notifikasi.length > 0) {
            response.notifikasi.forEach(function (notif) {
              let iconClass = '';
              let textClass = '';
              switch (notif.tipe) {
                case 'warning':
                  iconClass = 'mdi mdi-alert';
                  textClass = 'text-warning';
                  break;
                case 'success':
                  iconClass = 'mdi mdi-check-circle';
                  textClass = 'text-success';
                  break;
                case 'danger':
                  iconClass = 'mdi mdi-alert-circle';
                  textClass = 'text-danger';
                  break;
                default:
                  iconClass = 'mdi mdi-information';
                  textClass = 'text-primary';
              }

              notificationsHtml += `
                            <a class="dropdown-item preview-item py-3 notification-item ${notif.dibaca == 1 ? '' : 'unread'}" 
                               data-id="${notif.id_notifikasi}" href="#">
                                <div class="preview-thumbnail">
                                    <i class="${iconClass} m-auto ${textClass}"></i>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal text-dark mb-1">${notif.judul}</h6>
                                    <p class="fw-light small-text mb-0">${notif.pesan}</p>
                                    <p class="fw-light small-text mb-0 text-muted">
                                        ${formatTime(notif.created_at)}
                                    </p>
                                </div>
                            </a>
                        `;
            });
          } else {
            notificationsHtml = `
                        <div class="dropdown-item py-3 text-center">
                            <p class="text-muted">Tidak ada notifikasi</p>
                        </div>
                    `;
          }

          $('#notificationList').html(notificationsHtml);
        }
      }
    });
  }

  // Format waktu notifikasi
  function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSecond = Math.floor((now - date) / (1000));
    const diffInMinute = Math.floor((now - date) / (1000 * 60));
    const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));

    if (diffInHours < 1) {
      if (diffInMinute < 1) {
        return `Baru saja ${diffInSecond} detik yang lalu`;
      } else {
        return `Baru saja ${diffInMinute} menit yang lalu`;
      }
    } else if (diffInHours < 24) {
      return `${diffInHours} jam yang lalu`;
    } else {
      return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
      });
    }
  }

  // Tandai notifikasi sebagai dibaca saat diklik
  $(document).on('click', '.notification-item', function (e) {
    e.preventDefault();
    const notifId = $(this).data('id');

    $.ajax({
      url: `<?= site_url ( "Read-Notifikasi" ) ?>/${notifId}`,
      type: 'POST',
      dataType: 'json',
      success: function () {
        loadNotifications();
      }
    });
  });

  // Tandai semua notifikasi sebagai dibaca
  $('#markAllAsRead').click(function (e) {
    e.preventDefault();

    $.ajax({
      url: '<?= site_url ( "Read-All-Notifikasi" ) ?>',
      type: 'POST',
      dataType: 'json',
      success: function () {
        loadNotifications();
      }
    });
  });

  // Muat notifikasi pertama kali
  $(document).ready(function () {
    loadNotifications();

    // Perbarui notifikasi setiap 1 menit
    setInterval(loadNotifications, 60000);
  });
</script>

<!-- End custom js for this page-->
</body>

</html>