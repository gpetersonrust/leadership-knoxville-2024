<div> 

<!-- 
 -->

<?php 
 
// get sponsor keys
 
$sponsor_color = [
  'Flagship Program' => '#1C687F',
  'Intro' => '#AA1F2D',
//   'Scholars' => '#D34729',
  'Youth' => '#2C8B4B',
  'Encore' => '#74308c',
];
 
$programs = [
  'Flagship Program' => 52,
  'Intro' => 54,
//   'Scholars' => 56,
  'Youth' => 58,
  'Encore' => 60,
];?>



 
<div style="
overflow: scroll;
" class="sponsor-2024-grid">
  <?php foreach ($programs as $program => $program_id) { 
    $sponsor_logo = get_field('sponsor_logo', $program_id);
    $session_day_sponsors = get_field('session_day_sponsors', $program_id);
    $regular_sponsors = get_field('regular_sponsors', $program_id);
  ?>
    <div class="sponsor-title"> 
      <span style="background: <?php echo $sponsor_color[$program] ?> !important"></span>  
      <h2 style="color: <?php echo $sponsor_color[$program] ?> !important"><?php echo $program ?></h2>
      <span style="background: <?php echo $sponsor_color[$program] ?> !important"></span>  
    </div>
    <div> 
      <div style="display: flex;"> 
        <h3 class="sponsor-sub-title"> Program Sponsor </h3>
        <h3 class="sponsor-subtitle">Session Day Sponsors</h3>
      </div>
  
  </div>
    <div class="sponsor-row-item">
      <div class="sponsor-container"> 
    
      <div   class="sponsor-logo">
        <img src="<?php echo $sponsor_logo ?>" alt="<?php echo $program . " Sponsor Logo" ?>">
      </div>
      </div>
      <div class="other-logos-container"> 
      <h3 class="sponsor-subtitle mobile">Session Day Sponsors</h3>
        
      <div class="other-logos">
        <div class="sponsor_day_sponsors">
         <?php if($session_day_sponsors):?>
          <?php foreach($session_day_sponsors as $sponsor): ?>
            <div class="sponsor-day-logo">
              <img src="<?php echo $sponsor ?>"  alt="<?php echo $program . " Session Day Logo" ?>">
            </div>
          <?php endforeach; ?>

          <?php endif; ?>
        </div>
        <?php if($regular_sponsors):?>
        <div class="regular_sponsors">
      
            <?php foreach($regular_sponsors as $sponsor): ?>
              <div class="regular-sponsor-logo">
                <img src="<?php echo $sponsor ?>"  alt="<?php echo $program . " Regular Sponsor Logo" ?>">
              </div>
            <?php endforeach; ?>
       
        </div>
        <?php endif; ?> 
      </div>
      </div>
    </div>
  <?php } ?>
</div>
  
