<div class="wrap">
    <h2>Blogworthy Popular Posts</h2>      
    <form method="post" action="options.php">
    <?php
        // This prints out all hidden setting fields
        settings_fields( 'bpp_ga_settings' );   
        do_settings_sections( 'blogworthy-popular-posts' );
        submit_button(); 
    ?>
    </form>
</div>