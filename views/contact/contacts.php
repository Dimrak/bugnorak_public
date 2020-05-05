
    <h2 class="center changing">inprogress</h2>
    <section id="inprogress">
        <?php include 'searches.php'?>
    <h2 class="circles">Contacts</h2>
   <section id="contacts">
      <table class="portada">
         <tr>
            <th>Media</th>
            <th>MediaName</th>
            <th>Genre</th>
            <th>Country</th>
            <th>Email</th>
            <th>Actions</th>
         </tr>
      <?php foreach ($this->contacts as $contact): ?>
      <tr>
          <?php foreach ($this->categories as $category):?>
                <?php if ($category->id == $contact->media):?>
              <td class="media"><?php echo ucfirst($category->name)?></td>
          <?php endif; ?>
          <?php endforeach;?>
          <td class="mediaName"><?php echo ucfirst($contact->mediaName)?></td>
            <?php foreach ($this->genres as $genre):?>
             <?php if ($genre->id == $contact->genre):?>
                  <td class="genre"><?php echo ucfirst($genre->name)?></td>
               <?php endif;?>
          <?php endforeach;?>
         <td class="countryTd"><?php echo ucfirst($contact->country)?></td>
          <td class="mediaTd"><?php echo ucfirst($contact->email)?></td>
          <td>
              <a class="actionBtn" href="<?php echo url('contact/show/' . $contact->id)?>">Show</a>
              <a class="actionBtn" href="<?php echo url('contact/edit/' . $contact->id)?>">Edit</a>

              <a class="actionBtn modalBtn">Delete</a>
          </td>
      </tr>
      <?php endforeach; ?>
      </table>

            <?php include 'admin/deleteModal.php';?>
        </section>
    </section>

