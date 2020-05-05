<div class="container-modal__delete center-location" id="container-modal__delete-contact">
    <!-- The Modal -->
    <div id="myModalContact" class="modal myModal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p class="read-better">Are you sure you want to delete?</p>
            <form method="post" action="<?php echo url('contact/delete/') ?>" id="delete-contact-form" class="">
                <div class="modal__delete">
                    <input class="form-confirm" type="submit" name="yes" value="<?= CONFIRM_YES; ?>">
                    <input class="form-confirm" type="submit" name="no" value="<?= CONFIRM_NO; ?>">
                </div>
            </form>
        </div>
    </div>
</div>