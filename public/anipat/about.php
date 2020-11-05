<?php $v->layout("_theme"); ?>

<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcam_text text-center">
                    <h3>Sobre</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pet_care_area">
    <div class="container">
        <?php if (empty($about)): ?>
            <div class="alert alert-info text-center">
                <i class='fa fa-warning'></i>Oops! Não existe texto cadastrados no momento!
            </div>
        <?php else: ?>
            <div class="row align-items-center">
                <?php foreach ($about as $row): ?>
                    <div class="col-lg-12 col-md-12">
                        <div class="pet_info">
                            <div class="section_title">
                                <h3>
                                    <span><?= $row->title; ?></span>
                                </h3>
                                <p><?= $row->content, 500; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
