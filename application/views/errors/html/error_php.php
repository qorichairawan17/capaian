<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$base_url = config_item('base_url') ?: '/capaian/';
?>
<!-- Load error styles inline in case it is loaded inside a view that doesn't have it -->
<link href="<?php echo $base_url; ?>assets/css/custom-errors.css" rel="stylesheet" type="text/css" />

<div class="inline-error-card">
	<div class="inline-error-header">
		<span class="inline-error-badge">PHP Error</span>
		<h4 class="inline-error-title">A PHP Error was encountered</h4>
	</div>
	<div class="inline-error-details">
		<p><strong>Tingkat Keparahan (Severity):</strong> <?php echo $severity; ?></p>
		<p><strong>Pesan (Message):</strong> <?php echo $message; ?></p>
		<p><strong>Nama Berkas (Filename):</strong> <?php echo $filepath; ?></p>
		<p><strong>Nomor Baris (Line Number):</strong> <?php echo $line; ?></p>
	</div>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
		<div class="inline-error-backtrace-title">Backtrace:</div>
		<?php foreach (debug_backtrace() as $error): ?>
			<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
				<div class="inline-error-backtrace-item">
					<strong>Berkas:</strong> <?php echo $error['file']; ?><br />
					<strong>Baris:</strong> <?php echo $error['line']; ?><br />
					<strong>Fungsi:</strong> <?php echo $error['function']; ?>
				</div>
			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
</div>