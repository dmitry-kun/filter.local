<div class="sidebar">
    <?php if ( is_active_sidebar('sidebar') ) :
        dynamic_sidebar('sidebar');
    else :
        echo 'Сайдбар пустой';
    endif; ?>
</div>