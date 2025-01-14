<?php $page_title = "Login";
require_once '../application.php'; ?>

<body>
<?php require_once '../nav_bar_menu.php'; ?>

    <div class="container">
        <center><h2>หน้าจอเข้าสู่ระบบ</h2></center>
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form class="" id="login_system" name="login_system" method="post" action="/RKAPP/LOGIN/pages/check_login.php">
                    <div class="modal-header">
                        <center><h4>LOGIN</h4></center>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group w3-margin-bottom"><span class="input-group-addon">USERNAME</span>
                                        <input class='form-control w3-hover-border-black' type="text" id='idlogin' name='idlogin' maxlength="20" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="input-group"><span class="input-group-addon">PASSWORD</span>
                                        <input class='form-control w3-hover-border-black' type="password" id='passlogin' name='passlogin' maxlength="20" required>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
