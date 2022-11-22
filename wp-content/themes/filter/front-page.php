<?php
/**
 * @package WordPress
 * @subpackage Theme
 * @since 1.0.0
 */

get_header(); ?>

<?php get_sidebar(); ?>
<?
$args = array(
    'public'   => true,
    '_builtin' => false,
);

$output = 'names'; // names or objects, note names is the default
$operator = 'and'; // 'and' or 'or'

$post_types = get_post_types( $args, $output, $operator );

foreach ( $post_types  as $post_type ) {

    echo '<p>' . $post_type . '</p>';
    $groups = acf_get_field_groups(array('post_type' => $post_type));
    foreach ($groups as $group_key){
        echo '<pre>';
        $fields = acf_get_fields($group_key['key']);
        var_dump($fields);
        echo '</pre>';
    }
}



?>
--------------------------
<pre>
    <?//var_dump($groups)?>
</pre>
<?php get_footer(); ?>