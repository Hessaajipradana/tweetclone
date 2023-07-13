<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php 
helper('form');
$validation = \Config\Services::validation();
?>
<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
    <div class="card shadow-sm">
        <div class="card-header text-light bg-dark">
            <strong>Form Registrasi</strong>
        </div>
        <div class="card-body">
            <?= form_open('/add_user') ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= set_value('email') ?>" id="email" placeholder="email@example.com">
                <div style="color: red; font-size: small;"> <?=$validation->getError('email')?> </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" class="form-control" name="username" 
                    value="<?= set_value('username') ?>" id="username" placeholder="username">
                <div style="color: red; font-size: small;"> <?=$validation->getError('username')?> </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                <div style="color: red; font-size: small;"> <?=$validation->getError('password')?> </div>
            </div>
            <div class="mb-3">
                <label for="confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="confirmation" id="confirmation" placeholder="password">
                <div style="color: red; font-size: small;"> <?=$validation->getError('confirmation')?> </div>
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="fullname" 
                    value="<?= set_value('fullname') ?>" id="fullname" placeholder="Nama Lengkap">
                <div style="color: red; font-size: small;"> <?=$validation->getError('fullname')?> </div>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Daftar User">
            </div>
            <?= form_close() ?>
        </div>
    </div>
    </div>
</div>
<?= $this->endSection() ?>