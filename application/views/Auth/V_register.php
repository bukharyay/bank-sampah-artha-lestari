<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-12 col-sm-12 col-md-10 col-lg-6 mx-auto">
          <div class="card text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
              <!-- <img src="../../../../images/logo.svg" alt="logo"> -->
            </div>
            <h4>Daftar Nasabah</h4>
            <?= validation_errors ( '<div class="error text-danger">', '</div>' ); ?>

            <!-- <h6 class="fw-light">Signing up is easy. It only takes a few steps</h6> -->
            <h6 class="fw-light">bergabung dengan kami. ciptakan lingkungan bersih</h6>
            <form class="pt-3" method="POST" action="<?= base_url ( 'Auth-Register' ); ?>">
              <div class="row justify-content-center w-auto mx-auto">
                <div class="col-12 col-sm-12 col-md-10 col-lg-6">
                  <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-user text-dark"></i>
                        </span>
                      </div>
                      <input type="text"
                             class="form-control form-control-lg border-left-0  <?= form_error ( 'username' ) ? 'is-invalid' : ''; ?>"
                             id="username" name="username" value="<?= set_value ( 'username' ) ?>"
                             placeholder="Username" required>
                      <div class="invalid-feedback">
                        <?= form_error ( 'username' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-email text-dark"></i>
                        </span>
                      </div>
                      <input type="email"
                             class="form-control form-control-lg border-left-0 <?= form_error ( 'email' ) ? 'is-invalid' : ''; ?>"
                             id="email" name="email" value="<?= set_value ( 'email' ) ?>" placeholder="Email">
                      <div class="invalid-feedback">
                        <?= form_error ( 'email' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-lock text-dark"></i>
                        </span>
                      </div>
                      <input type="password"
                             class="form-control form-control-lg border-left-0  <?= form_error ( 'password' ) ? 'is-invalid' : ''; ?>"
                             id="password" name="password" placeholder="Password" required>
                      <div class="invalid-feedback">
                        <?= form_error ( 'password' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-lock text-dark"></i>
                        </span>
                      </div>
                      <input type="password"
                             class="form-control form-control-lg border-left-0  <?= form_error ( 'password_confirmation' ) ? 'is-invalid' : ''; ?>"
                             id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password"
                             required>
                      <div class="invalid-feedback">
                        <?= form_error ( 'password_confirmation' ); ?>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-12 col-sm-12 col-md-10 col-lg-6">
                  <div class="form-group">
                    <label for="id_rt">RW / RT</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-map-alt text-dark"></i>
                        </span>
                      </div>
                      <select class="form-control form-control-lg" id="id_rt" name="id_rt" required>
                        <option value="">Pilih RT/RW</option>
                        <?php foreach ( $rt_list as $rt ) : ?>
                        <option value="<?= $rt->id_rt ?>" <?= set_value ( 'id_rt' ) ? 'selected' : '' ?>>
                          <?= "RW {$rt->rw} / RT {$rt->rt}" ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                      <div class="invalid-feedback">
                        <?= form_error ( 'id_rt' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-id-badge text-dark"></i>
                        </span>
                      </div>
                      <input type="text"
                             class="form-control form-control-lg border-left-0  <?= form_error ( 'nama' ) ? 'is-invalid' : ''; ?>"
                             id="nama" name="nama" value="<?= set_value ( 'nama' ) ?>" placeholder="Nama Lengkap"
                             required>
                      <div class="invalid-feedback">
                        <?= form_error ( 'nama' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>No Telfon <small>(Optional)</small> </label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-mobile text-dark"></i>
                        </span>
                      </div>
                      <input type="number"
                             class="form-control form-control-lg border-left-0  <?= form_error ( 'no_telfon' ) ? 'is-invalid' : ''; ?>"
                             id="no_telfon" name="no_telfon" value="<?= set_value ( 'no_telfon' ) ?>"
                             placeholder="No Telfon">
                      <div class="invalid-feedback">
                        <?= form_error ( 'no_telfon' ); ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Alamat Tinggal<small>(Optional)</small> </label>
                    <div class="input-group">
                      <div class="input-group-prepend bg-transparent">
                        <span class="input-group-text bg-transparent border-right-0">
                          <i class="ti-home text-dark"></i>
                        </span>
                      </div>
                      <textarea class="form-control form-control-lg border-left-0  <?= form_error ( 'alamat' ) ? 'is-invalid' : ''; ?>"
                                name="alamat" id="alamat" cols="30" rows="10"
                                placeholder="Alamat Tinggal"><?= set_value ( 'alamat' ) ?></textarea>
                      <div class="invalid-feedback">
                        <?= form_error ( 'alamat' ); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mt-3 d-flex flex-wrap justify-content-center">
                  <button type="button"
                          class="btn btn-block btn-dark btn-lg auth-form-btn fw-bolder fs-6 mx-auto my-2 order-2 order-md-1"
                          onclick="location.href='<?= base_url ( 'Auth-Login' ); ?>'">Kembali <i
                       class="icon-logout align-middle m-0 p-1 fw-bolder fs-6"></i></button>
                  <button type="submit"
                          class="btn btn-block btn-primary btn-lg auth-form-btn fw-bolder fs-6 mx-auto my-2 order-1 order-md-2"
                          disabled>Buat
                    Akun <i class="icon-login align-middle m-0 p-1 fw-bolder fs-6"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->