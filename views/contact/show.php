
<h2 class="circles">Contact information</h2>
<section class="container-complex-form">
  <p class="input input-complex input-complex-margin"><span class="show-label">Name: </span><?php echo ucfirst($this->contact->name)?></p>
  <p class="input input-complex input-complex-margin">
    <span class="show-label">Email: <i class="far fa-copy"></i></span>
    <input readonly="readonly" class="email-copy" value="<?php echo $this->contact->email; ?>">
  </p>
  <p class="input input-complex input-complex-margin"><span class="show-label">Country: </span><?php echo ucfirst($this->contact->country); ?></span>
  <p class="input input-complex input-complex-margin"><span class="show-label">Media: </span><?php echo $this->contact->media; ?></p>
  <p class="input input-complex input-complex-margin"><span class="show-label">Media-Name: </span><?php echo $this->contact->mediaName; ?></p>
  <p class="input input-complex input-complex-margin"><span class="show-label">Genre: </span><?php echo $this->contact->genre; ?></p>
  <div class="show-boxes input">
    <span class="show-label" style="display: block;" >Website</span>
    <p class="input input-complex input-complex-margin custom-bar" style="overflow: auto;">
      <a class="custom-link" target="_blank" href="<?= $this->contact->website?>"><?php echo $this->contact->website?></a>
    </p>
  </div>
  <div >
    <p class="input input-complex input-complex-margin show-boxes-extra-space">
    <span class="show-label">Address : <i class="far fa-copy"></i></span>
    
    <input class="email-copy" style="max-width: 40em; max-width: 100ch;" value="<?= chunk_split($this->contact->address, 30) ?>">
  </p>
  </div>
  <p class="input input-complex input-complex-margin smaller-space"><span class="show-label">Response: </span>
    <?= ($this->contact->response === '1') ? CONFIRM_YES : CONFIRM_NO ?>
  </p> 
  <p class="input input-complex input-complex-margin smaller-space"><span class="show-label">Only physical?: </span>
    <?= ($this->contact->physical === '1') ? CONFIRM_YES : CONFIRM_NO ?>
  </p>
  <p class="input input-complex input-complex-margin smaller-space"><span class="show-label">Meet: </span>
    <?= ($this->contact->meet === '1') ? CONFIRM_YES : CONFIRM_NO ?>
  </p>
  <div class="show-boxes input">
    <span class="show-label">Notes</span>
    <p class="input input-complex input-complex-margin show-boxes-extra-space"><?= $this->contact->notes ?></p>
  </div>
    <span class="message-copy">
          COPIED
    </span>
</section>
<section id="showTextBtns">
  <div class="center">
  <a id="editBtn" class="actionBtn  grid-item-show-extra firstOrder" href=" <?php echo url('contact/edit/') . $this->contact->id?>">Edit</a>
  <a class="actionBtn modalBtn grid-item-show-extra delete-hover">Delete</a>
  </div>
  <?php include 'admin/deleteModalShow.php';?>
</section>

