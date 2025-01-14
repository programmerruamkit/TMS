<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form id="logout_system" name="logout_system" method="post" action="/RKAPP/LOGIN/pages/check_logout.php" onsubmit="return conf_logout()">
            <div class="modal-header">
                <h3>ออกจากระบบ</h3>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" id='pid' name='pid' value="<?= $bag->P_ID; ?>">
                    <div class="row">
                        <h4>ท่านต้องการบังคับ Username : '<?= $id; ?>' ออกจากระบบ ใช่หรือไม่</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">LOGOUT</button>
                <a href="/RKAPP/LOGIN/"><button type="button" class="btn btn-default">CANCEL</button></a>
            </div>
        </form>
    </div>

</div>




