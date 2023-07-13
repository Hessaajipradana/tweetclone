<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php helper('form') ?>
<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="col-md-6 offset-md-3 align-self-center">
        <div class="card shadow-sm">
            <div class="card-header bg-info">
                <strong>Tweet Baru</strong>
            </div>
            <div class="card-body">
                <?= form_open_multipart('/add') ?>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="username" class="form-label">Tweet</label>
                        <textarea name="content" id="tweet" class="form-control"></textarea>
                    </div>
                    <div class="col-md-8 px-5 text-center">
                        <label for="image_path" class="form-label">Tambahkan gambar</label>
                        <input type="file" class="form-control mt-2" name="image_path" id="image_path">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kategori</label>
                    <?= form_dropdown('category', $categories, '', 'class="form-select"') ?>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="Tambah Tweet">
                    <a href="<?= previous_url() ?>" class="btn btn-warning">Kembali</a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
