<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto" id="toast-title">Notification</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body" id="toast-body">
      This is a toast message.
    </div>
  </div>
</div>

<script src="<?= base_url () ?>assets/vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url () ?>assets/js/off-canvas.js"></script>
<script src="<?= base_url () ?>assets/js/hoverable-collapse.js"></script>
<!-- <script src="<?= base_url () ?>assets/js/template.js"></script> -->
<script src="<?= base_url () ?>assets/js/settings.js"></script>
<script src="<?= base_url () ?>assets/js/todolist.js"></script>
<script src="<?= base_url () ?>assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
<script src="<?= base_url () ?>assets/js/Auth/toast.js"></script> <!-- Pastikan untuk memuat toast.js -->

<script>
  $(document).ready(function () {
    // Cache commonly used elements
    const $form = $('form');
    const $submitButton = $('button[type="submit"]');
    const formAction = $form.attr('action') || '';
    const isRegisterForm = formAction.includes('Auth-Register');
    const isLoginForm = formAction.includes('Auth-Login');

    // Debounce function
    function debounce(func, wait, immediate = false) {
      let timeout;
      return function () {
        const context = this;
        const args = arguments;
        const later = function () {
          timeout = null;
          if (!immediate) func.apply(context, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (immediate && !timeout) func.apply(context, args);
      };
    }

    // Initialize validation based on form type
    if (isRegisterForm) {
      initRegisterValidation();
    } else if (isLoginForm) {
      initLoginValidation();
    }

    function initRegisterValidation() {
      // Field validation with debounce
      setupValidation('#username', 500);
      setupValidation('#email', 500, validateEmailFormat);
      setupValidation('#nama', 500);
      setupValidation('#alamat', 500);
      setupValidation('#no_telfon', 500, validatePhoneFormat);
      setupValidation('#id_rt');

      // Password field validation (frontend only)
      $('#password, #password_confirmation').on('input', debounce(function () {
        validatePassword();
      }, 300));
    }

    function initLoginValidation() {
      setupValidation('#username', 500);
      setupValidation('#password', 500);
    }

    function setupValidation(selector, delay, formatValidator = null) {
      $(selector).on('input', debounce(function () {
        const $field = $(this);
        const fieldName = $field.attr('id');
        const value = $field.val();

        if (formatValidator && !formatValidator(value)) {
          updateSubmitButtonState();
          return;
        }

        validateField(fieldName, {
          field: fieldName,
          value: value,
          form_type: isRegisterForm ? 'register' : 'login'
        });
      }, delay));
    }

    function validateEmailFormat(value) {
      if (value && !isValidEmail(value)) {
        showFieldError($('#email'), 'Format email tidak valid');
        return false;
      }
      return true;
    }

    function validatePhoneFormat(value) {
      if (value && !isValidPhone(value)) {
        showFieldError($('#no_telfon'), 'Format nomor telepon tidak valid (10-13 angka)');
        return false;
      }
      return true;
    }

    function validatePassword() {
      if (!isRegisterForm) return;

      const $password = $('#password');
      const $confirm = $('#password_confirmation');
      const $passwordFeedback = $password.next('.invalid-feedback');
      const $confirmFeedback = $confirm.next('.invalid-feedback');
      const password = $password.val();
      const confirm = $confirm.val();

      // Reset states
      resetFieldState($password);
      resetFieldState($confirm);

      // Validate password
      if (password) {
        if (password.length < 6) {
          showFieldError($password, 'Password minimal 6 karakter');
        } else if (!hasMinimumStrength(password)) {
          showFieldError($password, 'Password harus mengandung huruf dan angka');
        } else {
          showFieldSuccess($password);
          $passwordFeedback.html(
            '<span class="text-success"><i class="mdi mdi-check-circle-outline align-middle"></i> Valid</span>')
            .show();
        }
      }

      // Validate confirmation
      if (password && confirm) {
        if (password !== confirm) {
          showFieldError($confirm, 'Password tidak cocok');
        } else {
          showFieldSuccess($confirm);
          $confirmFeedback.html(
            '<span class="text-success"><i class="mdi mdi-check-circle-outline align-middle"></i> Valid</span>')
            .show();
        }
      }

      updateSubmitButtonState();
    }

    function validateField(fieldName, data) {
      const $field = $('#' + fieldName);
      const $feedback = $field.next('.invalid-feedback');

      // Skip validation for password fields in frontend
      if (isRegisterForm && (fieldName === 'password' || fieldName === 'password_confirmation')) {
        return;
      }

      // Skip validation if field is empty and not required
      if (!data.value && !$field.prop('required')) {
        resetFieldState($field);
        updateSubmitButtonState();
        return;
      }

      // For select boxes, check if a value is selected
      if (fieldName === 'id_rt' && data.value === '') {
        showFieldError($field, 'RT/RW harus dipilih');
        updateSubmitButtonState();
        return;
      }

      // Show loading indicator
      $field.addClass('is-validating');
      $feedback.html(
        '<span class="text-dark"><i class="mdi mdi-loading mdi-spin align-middle"></i> Memvalidasi...</span>')
        .show();

      // AJAX validation
      $.ajax({
        url: '<?= base_url () ?>Auth-Validate',
        type: 'POST',
        data: data,
        dataType: 'json',
        beforeSend: function () {
          $submitButton.prop('disabled', true);
        },
        success: function (response) {
          $field.removeClass('is-validating');

          if (response.error) {
            showFieldError($field, response.error);
          } else {
            showFieldSuccess($field);
            $feedback.html(
              '<span class="text-success"><i class="mdi mdi-check-circle-outline align-middle"></i> Valid</span>'
            ).show();
            setTimeout(() => $feedback.hide(), 2000);
          }
        },
        error: function (xhr) {
          $field.removeClass('is-validating');
        },
        complete: updateSubmitButtonState
      });
    }

    function resetFieldState($field) {
      $field.removeClass('is-invalid is-valid is-validating');
      $field.next('.invalid-feedback').hide();
    }

    function showFieldError($field, message) {
      $field.removeClass('is-valid is-validating')
        .addClass('is-invalid');
      $field.next('.invalid-feedback')
        .html(`<i class="mdi mdi-alert-circle-outline text-danger align-middle"></i> ${message}`)
        .show();
    }

    function showFieldSuccess($field) {
      $field.removeClass('is-invalid is-validating')
        .addClass('is-valid');
    }

    function updateSubmitButtonState() {
      if (!isRegisterForm && !isLoginForm) return;

      const hasErrors = $form.find('.is-invalid').length > 0;
      let allRequiredFilled = true;

      $form.find('[required]').each(function () {
        const $field = $(this);
        if ($field.is('select')) {
          if ($field.val() === null || $field.val() === '') {
            allRequiredFilled = false;
            return false; // break loop
          }
        } else if ($field.val().trim() === '') {
          allRequiredFilled = false;
          return false; // break loop
        }
      });

      $submitButton.prop('disabled', hasErrors || !allRequiredFilled);
    }

    // Client-side validation helpers
    function isValidEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isValidPhone(phone) {
      return /^[0-9]{10,13}$/.test(phone);
    }

    function hasMinimumStrength(password) {
      return /[A-Za-z]/.test(password) && /[0-9]/.test(password);
    }

    // Form submission handler
    $form.on('submit', function (e) {
      // Validate all fields one more time before submit
      if (isRegisterForm) {
        validatePassword(); // Validate password again before submit

        // Validate other fields
        const fieldsToValidate = ['username', 'email', 'nama', 'id_rt', 'alamat', 'no_telfon'];
        fieldsToValidate.forEach(field => {
          validateField(field, {
            field: field,
            value: $('#' + field).val(),
            form_type: 'register'
          });
        });
      } else if (isLoginForm) {
        validateField('username', {
          field: 'username',
          value: $('#username').val(),
          form_type: 'login'
        });
        validateField('password', {
          field: 'password',
          value: $('#password').val(),
          form_type: 'login'
        });
      }

      const $invalidFields = $form.find('.is-invalid');

      if ($invalidFields.length > 0) {
        $invalidFields.first().trigger('focus');
        showDangerToast('Harap perbaiki kesalahan pada form sebelum mengirim.');
      } else {
        // Set tombol ke state loading
        $submitButton.prop('disabled', true)
          .html('<i class="mdi mdi-loading mdi-spin align-middle"></i> Memproses...');
      }

    });

    function resetSubmitButton() {
      $submitButton.prop('disabled', false)
        .html('Submit');
    }


    // Initial button state
    updateSubmitButtonState();
  });
</script>

<script>
  // Show toast on page load based on session flashdata
  <?php if ( $this->session->flashdata ( 'message' ) ) : ?>
    showSuccessToast('<?= $this->session->flashdata ( 'message' ); ?>');
  <?php endif; ?>
  <?php if ( $this->session->flashdata ( 'error' ) ) : ?>
    showDangerToast('<?= $this->session->flashdata ( 'error' ); ?>');
  <?php endif; ?>
  <?php if ( $this->session->flashdata ( 'warning' ) ) : ?>
    showWarningToast('<?= $this->session->flashdata ( 'warning' ); ?>');
  <?php endif; ?>
</script>
</body>

</html>