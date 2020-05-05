    <section id="searchBoxes" style="background-image: <?php echo 'url(/resources/images/lempa.png)' ?>">
        <div>
            <span class="searchText">Which contact are you looking for?</span>
        </div>
        <?php echo $this->form?>
    </section>
    <?php if (isAdmin() == false):?>
        <?php $_SESSION['instruc'] = 'Test account, ' . '<strong>EDITING </strong>'. 'is not allowed.'?>
        <div class="instructions" style="margin-top: 10px"><?php echo $_SESSION['instruc']?></div>
    <?php endif?>
    <?php
        if (isset($_SESSION['denied']))
        {
            $denied = $_SESSION['denied'];
            $html = '';
            $html .= '<div class="' . 'message' . '"' . $denied . '</div>';
            unset($_SESSION['denied']);
            echo $html;
        }
    ?>
    <span class="message-copy">
        COPIED
    </span>
    <div class="search-wrapper">
    </div>

    <div id="load_data"></div>
    <ul id="demo" class="pagination"></ul>
    <?php include 'admin/deleteModalContact.php'?>

    <!-- <ul id="demo" class="pagination"></ul> -->





