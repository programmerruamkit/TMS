<?php $page_title = "Logout";
require_once '../../application.php'; ?>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/RKAPP/">RuamKit Application</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="/RKAPP/">Home</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <form class="" id="logout_system" name="logout_system" method="post" action="/RKAPP/LOGIN/pages/check_logout.php" onsubmit="return conf_logout()">
            <div class="panel panel-default w3-border-red">
                <div class="panel-heading text-center"><h4>LOGOUT</h4></div>
                <div class="panel-body w3-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-12"><button type="submit" class="w3-btn w3-red col-lg-12"><h4>ออกจากระบบ</h4></button></div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <p>@RKAPP</p>
                </div>
            </div>
        </form>
    </div>
</body>