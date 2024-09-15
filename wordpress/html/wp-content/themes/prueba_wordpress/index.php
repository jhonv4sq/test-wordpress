<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <header>
        <h1><?php bloginfo( 'name' ); ?></h1>
        <p><?php bloginfo( 'description' ); ?></p>
    </header>

    <div id="content">
        <?php 
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                the_title( '<h2>', '</h2>' );
                the_content();
            }
        } else {
            echo '<p>No content found</p>';
        }
        ?>
    </div>

    <footer>
        <p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?></p>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
