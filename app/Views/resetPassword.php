<!-- request_reset_password.php -->
<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php helper('form'); ?>

<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
        <div class="card shadow-sm">
            <div class="card-header text-light bg-dark">
                <strong>Reset Password</strong>
            </div>
            <div class="card-body">
                <?= form_open('/resetPassword', 'method="post"') ?>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="<?= $user->password ?>">
                </div>
                <div class="mb-3">
                    <span id="liveAlertPlaceholder">
                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success mt-2" role="alert">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                    </span>
                    <button type="submit" class="btn btn-primary">reset</button>
                    <a href="<?= base_url('/') ?>" class="btn btn-warning">Kembali ke Halaman Login</a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
