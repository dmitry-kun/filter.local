<?php
/*
Template Name: Карта сайта
*/

get_header(); ?>

    <ul id="toggle-view">
        <li>
            <h1>Карта сайта</h1>
            <div class="panel">
                <ul>
                    <?php $myposts = get_posts('numberposts=-1&post_type=page&offset='.$debut);
                    foreach($myposts as $post) : ?>
                    <li class="sitemap"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </li>
    </ul

<?php get_footer(); ?>