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
            <strong>Profil Pengguna</strong>
        </div>
        <div class="card-body">
        <?= form_open('/editProfile', 'method="post" enctype="multipart/form-data"') ?>
            <div class="mb-3 px-5 text-center">
                    <label for="profile_image" class="form-label">Foto Profil</label>
                    <div class="text-center">
                        <?= img(['src'=>'images/'.$user->profile_image, 'class'=>'img-fluid rounded']) ?>
                    </div>
                    <input type="file" class="form-control mt-2" name="profile_image" id="profile_image">
                    <div style="color: red; font-size: small;"><?= $validation->getError('profile_image') ?></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
                <div style="color: red; font-size: small;"><?= $validation->getError('email') ?></div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" value="<?= $user->username ?>">
                <div style="color: red; font-size: small;"><?= $validation->getError('username') ?></div>
            </div>
            <div class="mb-3">
                <label for="fullname" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="fullname" value="<?= $user->fullname ?>">
                <div style="color: red; font-size: small;"><?= $validation->getError('fullname') ?></div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password di sembunyikan" disabled>
                <a href="<?=base_url('/resetPassword')?>" class="btn btn-sm btn-secondary mt-3">reset password</a>
            </div>
            <div class="mb-3">
                <span id="liveAlertPlaceholder">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success mt-2" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>
                </span>
                <input type="submit" class="btn btn-primary" value="Simpan Perubahan" id="liveAlertBtn">
                <a href="<?= base_url('/profileHome') ?>" class="btn btn-warning">Kembali</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    </div>
</div>
<?= $this->endSection() ?>
