
<nav class="Navbar__Items center__nav">
    <div class="Navbar__Link">
        <a href="<?php echo url('search/') ?>" class="Navbar__Link cool-link">Home</a>
    </div>
    <?php if (currentUser()): ?>
        <div class="Navbar__Link">
            <a href="<?php echo url('contact/create') ?>" class="Navbar__Link cool-link">Create contact</a>
        </div>
    <?php else: ?>
        <div class="Navbar__Link">
            <a href="<?php echo url('account/login') ?>"class="Navbar__Link cool-link">Login</a>
        </div>
    <?php endif ?>
</nav>
