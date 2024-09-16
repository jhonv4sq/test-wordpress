<?php
/**
 * The main template file
 *
 * @package Prueba_Wordpress
 */

get_header();
?>

<main id="main">
    <div id="module">
        <div class="prueba-wordpress__container">
            <?php 
                get_template_part( 'template-parts/form' );
                get_template_part( 'template-parts/table' );
            ?>
        </div>
    </div>
</main>

<?php
get_footer();

