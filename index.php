<?php
/**
 * The main template file
 *
 * This template is used to display the main content of the page, including the search form and the user table.
 *
 * @package Test_Wordpress
 */

get_header();
?>

<main id="main">
    <div id="module">
        <div class="test-wordpress__container">
            <?php 
                get_template_part( 'template-parts/form' );
                get_template_part( 'template-parts/table' );
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
