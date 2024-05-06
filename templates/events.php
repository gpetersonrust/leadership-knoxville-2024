 <div class="events-list">
    <div class="event-grid featured">
        <?php foreach ($featured_events as $event) : ?>
            <a href="<?php echo $event['permalink'] ?>"  class="leadership_knoxville_event featured-event">
                <div class="event-card">
                <div class="event-card__thumbnail">
                    <img class="event-thumbnail" src="<?php echo esc_url($event['post_thumbnail_url']); ?>" alt="Event Thumbnail" />
                    </div>
                   
                      <div class="event-card__content">
                      <h3 class="event-title"><?php echo esc_html($event['title']); ?></h3>
                 </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="event-grid regular">
        <?php foreach ($regular_events as $event) : ?>
        <a href="<?php echo $event['permalink'] ?>"  class="leadership_knoxville_event regular-event">
                <div class="event-card">
                    <div class="event-card__thumbnail">
                    <img class="event-thumbnail" src="<?php echo esc_url($event['post_thumbnail_url']); ?>" alt="Event Thumbnail" />
                    </div>
                   
                      <div class="event-card__content">
                      <h3 class="event-title"><?php echo esc_html($event['title']); ?></h3>
                      </div>
                
                   
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>