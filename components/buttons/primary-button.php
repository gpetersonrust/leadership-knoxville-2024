<?php
if($link){ ?>
    <a  <?php if($id) echo "id=$id"?> href="<?php echo $link; ?>" class="btn btn-base <?php echo $class; ?>" <?php echo $target; ?> <?php echo $rel; ?>><?php echo $text; ?></a>

<?php } else { ?>

    <button <?php if($id) echo "id=$id"?> class="btn btn-base <?php echo $class; ?>" <?php echo $target; ?> <?php echo $rel; ?>><?php echo $text; ?></button>
<?php } ?>