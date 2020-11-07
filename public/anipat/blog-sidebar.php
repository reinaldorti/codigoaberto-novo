<div class="col-lg-4">
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget search_widget">
            <form action="<?= url("blog/buscar"); ?>">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input type="text" name="s" class="form-control" placeholder="Pesquisar">
                        <div class="input-group-append">
                            <button class="btn" type="button"><i class="ti-search"></i></button>
                        </div>
                    </div>
                </div>
                <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">
                    Pesquisar
                </button>
            </form>
        </aside>

<!--        <aside class="single_sidebar_widget newsletter_widget">-->
<!--            <h4 class="widget_title">Newsletter</h4>-->
<!--            <form class="ajax_off" target="_blank" action="" id="_form_334_">-->
<!--                <input type="hidden" name="u" value="334" />-->
<!--                <input type="hidden" name="f" value="334" />-->
<!--                <input type="hidden" name="s" />-->
<!--                <input type="hidden" name="c" value="0" />-->
<!--                <input type="hidden" name="m" value="0" />-->
<!--                <input type="hidden" name="act" value="sub" />-->
<!--                <input type="hidden" name="v" value="2" />-->
<!--                <div class="form-group">-->
<!--                    <input type="email" class="form-control" placeholder='Melhor e-mail' required>-->
<!--                </div>-->
<!--                <button id="_form_334_submit" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn" type="submit">-->
<!--                    QUERO RECEBER-->
<!--                </button>-->
<!--            </form>-->
<!--        </aside>-->

        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">Categorias</h4>
            <ul class="list cat-list">
                <li>
                    <a href="#" class="d-flex">
                        <p>Resaurant food</p>
                        <p>(37)</p>
                    </a>
                </li>
            </ul>
        </aside>

        <aside class="single_sidebar_widget popular_post_widget">
            <h3 class="widget_title">Posts Mais visto</h3>
            <?php if (empty($views)): ?>
                <div class="login_form_callback">
                    <div class="message info">
                        <i class="fa fa-info"></i>
                        Oops! Não existe artigos cadastrados no momento!
                    </div>
                </div>
            <?php
            else:
                foreach ($views as $view):
                    $cover = (!empty($view->cover) ? image($view->cover, 80) : asset("assets/img/no_image.jpg", CONF_VIEW['THEME']));
                    $link = url("/blog/{$view->uri}");
                    ?>
                    <div class="media post_item">
                        <a href="<?= $link; ?>" title="<?= $view->title; ?>">
                            <img src="<?= $cover; ?>" title="<?= $view->title; ?>" width="120" height="80" alt="<?= $view->title; ?>">
                        </a>
                        
                        <div class="media-body">
                            <a href="<?= $link; ?>" title="<?= $view->title; ?>">
                                <h3><?= str_limit_words($view->title, 60); ?></h3>
                            </a>
                            <p><?= date("d/m/Y", strtotime($view->created_at)); ?></p>
                        </div>
                    </div>
                <?php
                endforeach;
            endif;
            ?>
        </aside>

        <aside class="single_sidebar_widget tag_cloud_widget">
            <h4 class="widget_title">Tags</h4>

            <ul class="list">
                <?php if (empty($tags)): ?>
                    <div class="login_form_callback">
                        <div class="message info">
                            <i class="fa fa-info"></i>
                            Oops! Não existe tags cadastrados no momento!
                        </div>
                    </div>
                <?php
                else:
                    foreach ($tags as $tag):
                        if ($tag->tag):
                            foreach (explode(",", $tag->tag) AS $tags):
                                $tag = ltrim(rtrim($tags));
                                ?>
                                <li>
                                    <a href="<?= url("/blog/tag/" . str_slug($tag) . " "); ?>"><?= $tag; ?></a>
                                </li>
                            <?php
                            endforeach;
                        endif;
                    endforeach;
                endif;
                ?>
            </ul>
        </aside>
    </div>
</div>