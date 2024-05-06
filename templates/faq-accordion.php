
<div class="leadership-accordion-grid">
    <?php if (have_rows('faq')) :
          $index = 0;
        //   count the number of rows
        $row_count = count(get_field('faq'));
        //  divide the number of rows by 2 and round up to get the number of rows in the first column
        $per_row = ceil($row_count / 2);
         $tracker = 0;
        ?>
        <?php while (have_rows('faq')) : the_row(); 
            $index++;
            $tracker++;

            if($index == 1) {
                echo '<div class="leadership-accordion-column">';
            }
        ?>
            <div class="leadership-accordion">
                <input type="checkbox" id="<?php echo "faq-$tracker" ?>" />
                <label for="<?php echo "faq-$tracker" ?>">  <span style="font-weight:600; letter-spacing: .75px;"> <?php the_sub_field('faq_question'); ?> </span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M6 9l6 6 6-6" />
</svg>
</label>
                <div class="leadership-accordion-content">
                    <?php the_sub_field('faq_content'); ?>
                </div>
            </div>
            <?php if($index == $per_row) {
                echo '</div>';
                 $index = 0;
            } ?>

        <?php endwhile; ?>
    <?php endif; ?>
  
</div>