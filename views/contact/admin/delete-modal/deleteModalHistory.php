<div class="container-modal__delete" id="container-modal__delete-history">
    <!-- The Modal -->
    <div id="myModalHistory" class="modal myModal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="read-better">Are you sure you want to delete?</p>
            <form method="post" action="<?php echo url('history/delete/') ?>" id="delete-history-form" class="">
                <div class="modal__delete">
                    <input class="form-confirm" type="submit" name="yes" value="<?= CONFIRM_YES; ?>">
                    <input class="form-confirm" type="submit" name="no" value="<?= CONFIRM_NO; ?>">
                </div>
            </form>
            
        </div>
    </div>
</div>