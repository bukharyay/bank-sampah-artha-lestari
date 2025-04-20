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

	<script src="<?= base_url() ?>assets/vendors/js/vendor.bundle.base.js"></script>
	<script src="<?= base_url() ?>assets/js/off-canvas.js"></script>
	<script src="<?= base_url() ?>assets/js/hoverable-collapse.js"></script>
	<script src="<?= base_url() ?>assets/js/template.js"></script>
	<script src="<?= base_url() ?>assets/js/settings.js"></script>
	<script src="<?= base_url() ?>assets/js/todolist.js"></script>
	<script src="<?= base_url() ?>assets/vendors/jquery-toast-plugin/jquery.toast.min.js"></script>
	<script src="<?= base_url() ?>assets/js/Auth/toast.js"></script>

	<script>
		<?php if ($this->session->flashdata('message')) : ?>
			showSuccessToast('<?= $this->session->flashdata('message'); ?>');
		<?php endif; ?>
		<?php if ($this->session->flashdata('error')) : ?>
			showDangerToast('<?= $this->session->flashdata('error'); ?>');
		<?php endif; ?>
		<?php if ($this->session->flashdata('warning')) : ?>
			showWarningToast('<?= $this->session->flashdata('warning'); ?>');
		<?php endif; ?>
	</script>
	</body>

	</html>
