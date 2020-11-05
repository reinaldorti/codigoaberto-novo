<?php $v->layout("_theme"); ?>


<div class="bradcam_area breadcam_bg_1 overlay">
    <h3>about</h3>
</div>

<div class="about_area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="about_thumb2">
                    <div class="img_1">
                        <img src="<?= asset("assets/img/about/1.png"); ?>" alt="">
                    </div>
                    <div class="img_2">
                        <img src="<?= asset("assets/img/about/2.png"); ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 offset-lg-1 col-md-6">
                <div class="about_info">
                    <div class="section_title mb-20px">
                        <span>About Us</span>
                        <h3>Best Burger <br>
                            in your City</h3>
                    </div>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                        alteration in some form, by injected humour, or randomised words which don't look even slightly
                        believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't
                        anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the
                        Internet tend to repeat predefined chunks as necessary, making this the first true generator on
                        the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model
                        sentence structures, to generate</p>
                    <div class="img_thumb">
                        <img src="<?= asset("assets/img/jessica-signature.png"); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="gallery_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section_title mb-70 text-center">
                    <span>Gallery Image</span>
                    <h3>Our Gallery</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="single_gallery big_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/1.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/1.png"); ?>" alt="">
    </div>

    <div class="single_gallery small_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/2.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/2.png"); ?>" alt="">
    </div>

    <div class="single_gallery small_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/3.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/3.png"); ?>" alt="">
    </div>

    <div class="single_gallery small_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/4.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/4.png"); ?>" alt="">
    </div>

    <div class="single_gallery small_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/5.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/5.png"); ?>" alt="">
    </div>

    <div class="single_gallery big_img">
        <a class="popup-image" href="<?= asset("assets/img/gallery/6.png"); ?>">
            <i class="ti-plus"></i>
        </a>
        <img src="<?= asset("assets/img/gallery/6.png"); ?>" alt="">
    </div>
</div>

<?php $v->insert("instagram"); ?>



