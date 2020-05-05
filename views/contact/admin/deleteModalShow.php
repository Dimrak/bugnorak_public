<div class="container">
   <!-- The Modal -->
    <script>
        console.log('hello deleteModalShow.php');
    </script>
   <div id="myModalShow" class="modal myModal">
      <!-- Modal content -->
      <div class="modal-content">
         <p>Are you sure you want to delete?</p>
<!--          --><?php //echo url('contact/delete') .  $this->contact->getId()?>
         <form method="post" action="<?php echo url('contact/delete/') . $this->contact->getId()?>">
            <input type="submit" name="yes" value="yes">
            <input type="submit" name="no" value="no">
         </form>
         <span class="close">&times;</span>
      </div>
   </div>
   <script src="<?php echo urlStyle('resources/js/modal.js')?>"></script>
</div>