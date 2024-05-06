<?php 

if (!isset($images) || !is_array($images) || empty($images)) {
    echo '<p style="
    font-size: 1.35rem;">No images found for this Event.</p>';
}
return;
?>

<div class="grid">
    <?php foreach ($images as $image) : ?>
        <div class="grid-item">
            <div class="image-container">
                <img src="<?php echo $image['url']; ?>" alt="Image">
            </div>
        </div>
    <?php endforeach; ?>
</div>
