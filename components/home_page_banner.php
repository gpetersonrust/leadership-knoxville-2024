<div class="hero-banner">
    <div class="lower-background-image" style="background-image: url(<?php echo $thumbnail_url ?>);"></div>
    <div class="white-background"></div>
    <div class="content">
        <h1 data-mobile-trim="5"><?php echo $title ?></h1>
        <?php if ($subtitle): ?>
            <h2 data-mobile-trim="5"><?php echo $subtitle ?></h2>
        <?php endif; ?>
        <p data-mobile-trim="8">
            <?php echo $description ?>
        </p>
        <?php if ($cta): ?>
            <?php echo $cta; // This line appears to be a variable or some other PHP code. ?>
        <?php endif; ?>
        <?php if ($button): ?>
            <a href="<?php echo $button_link ?>"><?php echo $button ?></a>
        <?php endif; ?>
    </div>
</div>
