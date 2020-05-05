    <h2 class="circles"><u>Login</u></h2>
    <!-- <section id="login">
        <?php echo $this->form;?>
    </section> -->
    <section class="container-simple-form">
        <?php echo $this->form;?>
    </section>
    <?php
   if (isset($_SESSION['denied'])){
      $denied = $_SESSION['denied'];
      $html = '';
      $html .= '<div class="' . 'message' . '"' . $denied . '</div>';
      unset($_SESSION['denied']);
      echo $html;
   }
   ?>
    <!--Incorrect login-->
   <?php if (isset($_SESSION['disable'])):?>
       <div class="incorrect" style="background-color: rgba(255,94,45,0.53);">
           <strong><?php echo $_SESSION['disable']?></strong>
          <?php session_unset();?>
       </div>
   <?php else:?>
    <?php endif?>
    <?php if (isset($_SESSION['warning'])):?>
        <div class="incorrect">
            <?php echo $_SESSION['warning']?>
            <?php session_unset();?>
        </div>
    <?php else:?>
    <?php endif?>

    <?php if (isset($_SESSION['incorrect'])):?>
    <div class="incorrect">
        <?php echo $_SESSION['incorrect']?>
        <?php session_unset();?>
    </div>
    <?php else:?>
    <?php endif?>

    <?php if (isset($_SESSION['user_no_db'])):?>
    <div class="incorrect" style="background-color: rgba(255,94,45,0.53);">
        <?php echo $_SESSION['user_no_db']?>
        <?php session_unset();?>
    </div>
    <?php else:?>
    <?php endif?>
