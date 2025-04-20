<?php
$message = $this->session->flashdata('success') ?:
	$this->session->flashdata('error') ?:
	$this->session->flashdata('warning') ?:
	$this->session->flashdata('info');

$type = $this->session->flashdata('success') ? 'success' : ($this->session->flashdata('error') ? 'danger' : ($this->session->flashdata('warning') ? 'warning' : ($this->session->flashdata('info') ? 'info' : '')));

if ($message) : ?>
	<div class="alert alert-<?= $type; ?> alert-dismissible fade show" role="alert">
		<?= $message; ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif; ?>
