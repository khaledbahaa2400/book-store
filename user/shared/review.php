<div class="box">
    <img src= <?php echo $path; ?> alt="">
    <p><?php echo $reviewMessage; ?></p>
    <div class="stars">
        <?php
            while($stars > 0):
                echo "<i class='fas fa-star'></i>";
                $stars--;
            endwhile;

            if($halfStar == true):
                echo "<i class='fas fa-star-half-alt'></i>";
            endif;
        ?>
    </div>
    <h3><?php echo $reviewer; ?></h3>
</div>