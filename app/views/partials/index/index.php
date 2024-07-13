<?php
$page_id = null;
$comp_model = new SharedController;
?>
<style>
    .vh-100 {
        height: 100vh;
        margin: 0;
    }

    .aw {
        text-align: center;
        color: #09914d;
        text-transform: uppercase;
    }
</style>
<section class="vh-100 d-flex align-items-center justify-content-center">

    <div class="container h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-8 col-lg-7 col-xl-6">
                <div class="aw">
                    <h2>Aplikasi Pelayanan Pasien</h2>
                    <h2> upt Puskesmas Tabak Kanilan</h2>
                </div><br>
                <img src="assets/images/aw.jpg" class="img-fluid" alt="Phone image">
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                <h3 style="text-align: center; margin-bottom:1rem;">Login Admin</h3>
                <form name="loginForm" action="<?php print_link('index/login/?csrf_token=' . Csrf::$token); ?>" class="needs-validation form page-form" method="post">
                    <div class="input-group form-group">
                        <input placeholder="Username" name="username" required="required" class="form-control" type="text" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="form-control-feedback icon-user"></i></span>
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <input placeholder="Password" required="required" v-model="user.password" name="password" class="form-control " type="password" />
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="form-control-feedback icon-key"></i></span>
                        </div>
                    </div>
                    <div class="row clearfix mt-3 mb-3">
                        <div class="col-6">
                            <label class="">
                                <input value="true" type="checkbox" name="rememberme" />
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary btn-block btn-md" type="submit">
                            <i class="load-indicator">
                                <clip-loader :loading="loading" color="#fff" size="20px"></clip-loader>
                            </i>
                            Login <i class="icon-key"></i>
                        </button>
                    </div>
                    <hr />
                </form>
            </div>
        </div>
    </div>
</section>