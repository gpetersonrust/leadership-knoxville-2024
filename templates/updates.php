<?php 
 
 $keys = array_keys($updates);
 $active_filter = 0;
  $first_updates = $updates[$keys[0]];
?>


<div class="update-filter-buttons-grid">
    <?php 
      foreach ($keys as $filter) {
        $active = '';
        if($active_filter == 0) {
          $active = 'active';
        }
        $active_filter++;
        echo '<button class="update-filter-button ' . $active . '" data-filter="' . $filter . '">' . $filter . '</button>';
      }
    
    ?>
</div>

<div id="update-grid" class="update-grid">
 <?php 
  foreach ($first_updates as $update) { ?>
      <a  href="<?php echo $update['permalink'] ?>" class="update-card">
        <div class="update-card__thumbnail">
             <img src="<?php echo $update['thumbnail_url'] ?>" alt="<?php echo $update['title'] ?>">
        </div>
        <h4 class="update-card__title"><?php echo $update['title'] ?></h4>
        <!-- date -->
        <h5 class="update-card__date"><?php echo $update['date'] ?></h5>
      </a>
  <?php }
  
 ?>
</div>

<script>
    let updates = <?php echo json_encode($updates) ?>;
</script>