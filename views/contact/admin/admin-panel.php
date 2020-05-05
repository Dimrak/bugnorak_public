<?php 
    $delete_id = '';
?>
    <div class="container">
        <?php if (isAdmin() == false):?>
            <?php $_SESSION['instruc'] = 'Test account, ' . '<strong>EDITING </strong>'. 'is not allowed.'?>           
            <div class="instructions-admin" style="margin-top: 10px">
                <?php echo $_SESSION['instruc']?>
            </div>
        <?php endif?>
        <?php
            if (isset($_SESSION['denied'])) {
                $denied = $_SESSION['denied'];
                $html = '';
                $html .= '<div class="' . 'message-admin' . '"' . $denied . '></div>';
                unset($_SESSION['denied']);
                echo $html;
            }
        ?>     
        <?php
            if (isset($_SESSION['success'])) {
                $success = $_SESSION['success'];
                $html = '';
                $html .= '<div class="' . 'message-admin' . '">'. $success .'</div>';
                unset($_SESSION['success']);
                echo $html;
            }
        ?>
        <h2 class="circles">Admin panel</h2>
        <!-- MEDIAS -->
            <h4 class="center capitals"><?php echo strtoupper('Medias')?></h4>
            <table class="table-group">
                <tbody>
                <?php foreach ($this->categories as $category):?>
                    <tr>
                        <td class="list-group-item">
                        <?php echo $category->name?>
                        </td>
                        <td class="list-group-item right">
                            <a href="<?php echo url('category/edit/') . $category->id?>" class="link">Edit</a>
                            <a class="link actionBtn modalBtnCat" data-delete="<?= $category->id; ?>"> Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <?php include 'delete-modal/deleteModalCat.php'?>
            </table>
            <div class="link">
                <a href="<?php echo url('category/create')?>" class="another">Create</a>
            </div>
        <!--GENRES-->
            <h4 class="center capitals"><?php echo strtoupper('Genres') ?></h4>
            <table class="table-group">
                <tbody>
                <?php foreach ($this->genres as $item):?>
                    <tr>
                        <td class="list-group-item">
                        <?php echo $item->name?>
                        </td>
                        <td class="list-group-item right">
                            <a href="<?php echo url('genre/edit/') . $item->id?>" class="link">Edit</a>
                            <a class="link actionBtn modalBtnGen" data-delete="<?= $item->id; ?>"> Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <?php include 'delete-modal/deleteModalGen.php'?>
            </table>
            <div class="link">
                <a href="<?php echo url('genre/create')?>" class="another">Create</a>
            </div>
            
        
        <!-- History_item -->
            <h4 class="center capitals"><?php echo strtoupper('History') ?></h4>
            <table class="table-group">
                <tbody>
                <?= dump($this->histories); ?>
                <?php foreach ($this->histories as $item):?>
                    <tr>
                        <td class="list-group-item">
                        <?= $item->title ?>
                        </td>
                        <td class="list-group-item right">
                            <a href="<?= url('history/edit/') . $item->id?>" class="link">Edit</a>
                            <a class="link actionBtn modalBtnHistory" data-delete="<?= $item->id; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
                <?php
                    $delete_id = $delete_id; 
                    include 'delete-modal/deleteModalHistory.php'
                ?>
            </table>
            <div class="link">
                <a href="<?= url('history/create')?>" class="another">Create</a>
            </div>
            
    </div>





