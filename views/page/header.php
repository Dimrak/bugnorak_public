<header>
    <div class="Navbar">
        <div class="Navbar__Link Navbar__Link-brand logo img">
            <a href="<?php echo url('search')?>">
                <img src="<?php echo urlStyle('resources/images/logo_white.png')?>" alt="onerootmusic logo">
            </a> 
        </div>
        <div class="Navbar__Link Navbar__Link-toggle">
            <i class="fas fa-desktop"></i>
        </div>
       <?php include 'views/menu/navbar-center.php'?>
        <h2 style="color:red;">LOCAL</h2>
        <nav class="Navbar__Items Navbar__Items--right">
           <?php if(isAdmin()):?>
                <a href="<?= url('admin/index') ?>"class="Navbar__Link cool-link">Admin-panel</a>
                <a href="<?= url('account/logOut') ?>"class="Navbar__Link cool-link">Logout</a>
           <?php endif;?>
        </nav>
    </div>
</header>
