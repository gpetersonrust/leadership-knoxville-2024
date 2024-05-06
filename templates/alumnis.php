 <div class="leadership-alumni">
    <?php
    
    $i = 0;
    foreach ( $starting_posts as $year => $items) {

        
        echo '<h2 class="leadership-alumni__year">' . $year . '</h2>';
        echo '<div class="leadership-alumni__row">';
        echo '<div class="leadership-alumni__column">';
        // reset counter
        $i = 0;
        
        foreach ($items as $item) {
            $deceased = $item['deceased'] ? 'deceased' : '';
            $deceased_prefix = $item['deceased'] ? '† ' : '';
            if ($i % 9 == 0 && $i != 0) {
                echo '</div><div class="leadership-alumni__column">';
            }
            
            echo '<li class="leadership-alumni__item">';
            echo "<span class='leadership-alumni__title $deceased '>" . $item['title'] . " $deceased_prefix" . '</span>';
            echo '<span class="leadership-alumni__year hide "> (' . $item['year'] . ')</span>';
            echo '</li>';
            
            $i++;
        }
        
        echo '</div>';
        echo '</div>';
    } 
    ?>
    
   </div>
 