<div class="wrap">
    <h2>Blogworthy Popular Posts</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('blogworthy_popular_posts-group'); ?>
        <?php @do_settings_fields('blogworthy_popular_posts-group'); ?>

        <?php do_settings_sections('blogworthy_popular_posts'); ?>

        <?php @submit_button(); ?>
    </form>
</div>