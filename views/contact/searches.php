<?php 
    if (isset($_POST['submit'])){
        print_r($_POST);
    }
?>

<section id="searchBoxes">

<div class="containerSearch">
    <form action="<?php echo url('contact/search2')?>" method="post" class="mainSearch">
    <label for="media">Media</label>
<select name="categories" id="SelectCat" >
   <?php foreach ($this->categories as $category):?>
       <!--Lo llamamos desde Controller class is core-->
       <option value="<?php echo $category->name?>">
          <?php echo $category->name?>
       </option>
   <?php endforeach;?>
</select>
    <label for="genre">Genre</label>
    <select name="genres" id="SelectGen"">
       <?php foreach ($this->genres as $genre):?>
           <!--Lo llamamos desde Controller class is core-->
           <option value="<?php echo $genre->name?>">
              <?php echo $genre->name?>
           </option>
       <?php endforeach;?>
    </select>
    <label for="country">Country</label>
    <select name="countries" id="SelectCoun"">
       <?php foreach ($this->countries as $country):?>
           <!--Lo llamamos desde Controller class is core-->
           <option value="<?php echo $country->country?>">
              <?php echo $country->country?>
           </option>
       <?php endforeach;?>
    </select>


        <input type="submit" name="submit" id="submitSearch">
    </form>
</div>
<!--    </form>-->
</section>
