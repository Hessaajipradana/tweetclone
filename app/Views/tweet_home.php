<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<div class="row" style="margin: 30px 0px;">

<!-- Awal tambahan bagian notifikasi -->
<?php
    $sess = session();
    $addstatus = $sess->get('addtweet');
    if($addstatus == 'success'){
        echo '<div class="alert alert-success" role="alert">
                Tweet baru berhasil diposting
            </div>';
    }

    $editstatus = $sess->get('edittweet');
    if($editstatus == 'success'){
        echo '<div class="alert alert-success" role="alert">
            Tweet berhasil diedit / diperbaharui.
            </div>';
    }
    if($editstatus == 'error'){
        echo '<div class="alert alert-danger" role="alert">
            Kesalahan pengeditan / pembaruan tweet.
            </div>';
    }

    $delstatus = $sess->get('deltweet');
    if($delstatus == 'success'){
        echo '<div class="alert alert-warning" role="alert">
            Tweet berhasil dihapus.
            </div>';
    }
    if($delstatus == 'error'){
        echo '<div class="alert alert-danger" role="alert">
            Kesalahan penghapusan tweet.
            </div>';
    }
    ?>
    <!-- Akhir tambahan bagian notifikasi -->

    <div class="col-md-4">
        <div class="card mb-3 shadow-sm" >
            <div class="row g-0">
                <div class="col-md-4 ps-3 py-4">
                    <div class="text-center"  style="overflow: hidden;" >
                        <?= img(['src'=>'images/'.$profile->profile_image, 'class'=>'img-fluid']) ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <p>
                        <strong class="card-title"><?=$profile->fullname?></strong>
                        <small class="text-muted">@<?=$profile->username?></small>
                        
                        </p>
                        <p class="card-text">
                        <a href="<?=base_url('/profileHome')?>" class="btn btn-primary btn-sm mb-1" style="padding: 0.25rem 0.5rem; font-size: 0.7rem;">Profil</a>
                            <a class="btn btn-info btn-sm mb-1" 
                                    style="padding: 0.25rem 0.5rem; font-size: 0.7rem;" 
                                    href="<?=base_url('/add')?>">Tweet Baru</a>
                            <a class="btn btn-danger btn-sm mb-1" 
                                    style="padding: 0.25rem 0.5rem; font-size: 0.7rem;" 
                                    href="<?=base_url('/logout')?>">Logout</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="list-group shadow-sm">
            <div class="list-group-item list-group-item-action active" aria-current="true">
                <strong>Kategori Tweet</strong>
            </div>
            <?php foreach($categories as $key => $val): ?>
            <a href="<?=base_url('/category//'.$key)?>" 
                class="list-group-item list-group-item-action">
                <?=$val?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="col-md-8">
        <h2><?= $judul ?></h2>
        <?php foreach ($tweets as $tweet) { ?>
                    
                        <div class="row" style="border-top: 1px solid #eee; padding-top: 10px; margin-bottom: 10px;">
                            <div class="col-sm-2">
                                <?= img(['src'=>'images/'.$tweet->profile_image, 'class'=>'img-thumbnail', 'style' => 'max-width: 80px; max-height: 80px;']) ?>
                            </div>
                            <div class="col-sm-10">
                                <h4><?=$tweet->fullname?> <small>@<?=$tweet->username?></small></h4>
                                <div class="mb-3">
                                    <?=$tweet->content?>
                                </div>
                                <div class="mb-3">
                                    <?= img(['src'=>'uploads/'.$tweet->image_path, 'class'=>'img-fluid']) ?>
                                </div>
                                <div class="container-fluid">
                                    <span>
                                    <a href="<?=base_url('/category//'.$tweet->category)?>">#<?=$tweet->category?></a>
                                    <small><?= $tweet->getCreatedAt() ?></small>
                                    </span>
                                    <?php 
                                    $sess = session();
                                    $curUser = $sess->get('currentuser');
                                    if($curUser['userid'] == $tweet->user_id): 
                                    ?>
                                    <span>
                                        <a href="<?=base_url('/edit//'.$tweet->id)?>" class="btn btn-sm btn-warning">E</a>
                                        <a href="<?=base_url('/delete//'.$tweet->id)?>" class="btn btn-sm btn-danger">D</a>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>