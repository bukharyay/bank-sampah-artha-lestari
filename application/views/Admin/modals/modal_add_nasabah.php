<div class="modal fade" id="userAdd" tabindex="-1" aria-labelledby="userAddLabel" style="display: none;"
     aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="userAddLabel"> Tambah Nasabah <i
             class=" mdi mdi-account-plus text-primary align-middle"></i></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="forms-sample" id="addUsers" action="<?= base_url ( 'Add-Users' ) ?>" method="POST">
          <div class="row justify-content-center align-items-start w-auto mx-auto">
            <div class="col-6 col-sm-12 col-md-10 col-lg-6 ">
              <input type="text" name="role" value="nasabah" hidden>

              <div class="form-group <?= form_error ( 'username' ) ? 'has-danger' : '' ?>  ">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="<?= set_value ( 'username' ); ?>" placeholder="Username" required>
                <?= form_error ( 'username', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'email' ) ? 'has-danger' : '' ?>">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value ( 'email' ); ?>"
                       placeholder="Email" required>
                <?= form_error ( 'email', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'password' ) ? 'has-danger' : '' ?>">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value=""
                       placeholder="Password" autocomplete="on" required>
                <!-- <input type="checkbox" id="showPassword"> Show Password -->
                <?= form_error ( 'password', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'password_confirmation' ) ? 'has-danger' : '' ?>">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control " id="password_confirmation" name="password_confirmation"
                       value="" placeholder="Confirm Password" autocomplete="on" required>
                <!-- <input type="checkbox" id="showPassword_confirmation"> Show Password -->
                <?= form_error ( 'password_confirmation', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

            </div>
            <div class="col-6 col-sm-12 col-md-10 col-lg-6 ">

              <div class="form-group <?= form_error ( 'id_rt' ) ? 'has-danger' : '' ?>">
                <label for="id_rt">RW / RT</label>
                <select class="form-control form-select" id="id_rt" name="id_rt">
                  <option value="">Pilih RT/RW</option>
                  <?php foreach ( $rt_list as $rt ) : ?>
                  <option value="<?= $rt->id_rt ?>" <?= set_value ( 'id_rt' ) == $rt->id_rt ? 'selected' : '' ?>>
                    <?= "RW {$rt->rw} / RT {$rt->rt}" ?>
                  </option>
                  <?php endforeach; ?>
                </select>
                <?= form_error ( 'id_rt', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'nama' ) ? 'has-danger' : '' ?>">
                <label for="nama">Nama Lengkap : </label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value ( 'nama' ); ?>"
                       placeholder="Nama Lengkap">
                <?= form_error ( 'nama', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'no_telfon' ) ? 'has-danger' : '' ?>">
                <label for="no_telfon">No Telfon <small>(optional)</small></label>
                <input type="number" class="form-control" id="no_telfon" name="no_telfon"
                       value="<?= set_value ( 'no_telfon' ) ?>" placeholder="No Telfon">
                <?= form_error ( 'no_telfon', '<label class="error mt-2 text-danger">', '</label>' ); ?>
              </div>

              <div class="form-group <?= form_error ( 'alamat' ) ?? 'has-danger' ?>">
                <label for="alamat">Alamat <small>(optional)</small></label>
                <textarea class="form-control h-50" rows="5" name="alamat"
                          id="alamat"><?= set_value ( 'username' ); ?></textarea>
              </div>

            </div>
          </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary"><i class=" mdi mdi-account-plus align-middle"></i> Tambah
        </button>
      </div>
      </form>
    </div>
  </div>
</div>