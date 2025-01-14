<?php if($title_page != "SQL"){ ?>
<div class="modal fade" id="logoutModal">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_display">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">คุณต้องการออกจากระบบ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">หากต้องการออกจากระบบ ก็กด Logout ได้เลย!!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form name="logout" method="POST" action="<?= $oop->sql ?>">
                    <input type="hidden" name="select_type" value="Logout">
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>