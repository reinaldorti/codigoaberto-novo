<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <?php $photo = (!empty(user()->photo) ? image(user()->photo) : asset("assets/images/no_avatar.jpg", CONF_VIEW['ADMIN'])); ?>
        <img src="<?= $photo; ?>" style="width: 35px; height: 35px;" class="img-circle elevation-2" title="<?= user()->first_name; ?>">
    </div>
    <div class="info">
        <a href="<?= url("admin/users/user/" . user()->id . ""); ?>" class="d-block">
            <?= user()->fullName(); ?>
        </a>
    </div>
</div>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        $nav = function ($icon, $href, $title) use ($app) {
            $active = (explode("/", $app)[0] == explode("/", $href)[0] ? "active" : null);
            $url = url("/admin/{$href}");

            return"
                <li class='nav-item has-treeview menu-open'>
                    <ul class='nav nav-treeview'>
                        <li class='nav-item'>
                            <a href='{$url}' class='nav-link {$active}'><i class='nav-icon fas fa-{$icon}'></i><p>{$title}</p></a>
                        </li>                   
                    </ul>
                </li>
            ";
        };

        echo $nav("tachometer-alt", "dash", "Dashboard");
        echo $nav("users", "users/home", "Usuários");
        echo $nav("images", "slides/home", "Destaque");
        echo $nav("edit", "posts/home", "Posts");

        echo"
            <li class='nav-item has-treeview menu-open'>
                <ul class='nav nav-treeview'>
                    <li class='nav-item'>
                        <a href='" . url() . "' target='_blank' class='nav-link'>
                            <i class='nav-icon fas fa-reply'></i><p>Ver Site</p>
                        </a>
                    </li>                   
                </ul>
            </li>
        ";
        ?>
    </ul>
</nav>