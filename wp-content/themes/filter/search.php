<?php
/**
 * @package WordPress
 * @subpackage Theme
 * @since 1.0.0
 */

get_header(); ?>

    <div class="container-fluid">
        <div class="container">
            <div class="content-search">
                <div class="row">
                    <div class="content-search-title col-12"><?php echo 'Результат поиска: ' . '<span>' . get_search_query() . '</span>'; ?></div>
                    <div class="content-search-result col-12">
                        <?php
                        if (have_posts()) :
                            while (have_posts()) : the_post(); ?>
                                <div id="posts">
                                    <p><a href="<?php the_permalink() ?>"><?php the_title() ?></a></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else :
                            echo "Извините по Вашему результату ничего не найдено";
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer() ?>