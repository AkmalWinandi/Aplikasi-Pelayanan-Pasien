<?php
if (user_login_status() == true && basename($_SERVER['PHP_SELF']) != 'index/index.php') {
    // Tampilkan navbar hanya jika pengguna sudah login dan bukan di halaman index.php
?>
    <div id="topbar" class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">

            </a>
            <?php
            if (user_login_status() == true) {
            ?>
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                </button>
                <button type="button" id="sidebarCollapse" class="btn btn-dark">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse navbar-responsive-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                <span class="avatar-icon"><i class="icon-user"></i></span>
                                <span><?php echo ucwords(USER_NAME); ?> !</span>
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?php print_link('account') ?>"><i class="icon-user"></i> My Account</a>
                                <a class="dropdown-item" href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="icon-logout"></i> Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php
    if (user_login_status() == true) {
    ?>
        <nav id="sidebar" class="navbar-dark bg-dark">
            <ul class="nav navbar-nav w-100 flex-column align-self-start">
                <li class="menu-profile text-center nav-item">
                    <h5 class="user-name">Hallo
                        <?php echo ucwords(USER_NAME); ?> &#128525;
                    </h5>
                </li>
            </ul>
            <?php Html::render_menu(Menu::$navbarsideleft, "nav navbar-nav w-100 flex-column align-self-start", "accordion"); ?><br>
            <a class="align-self-start accordion text-light " style="margin-left:8px; text-decoration:none; " href="<?php print_link('index/logout?csrf_token=' . Csrf::$token) ?>"><i class="icon-logout"></i> Logout</a>

        </nav>
<?php
    }
}
?>