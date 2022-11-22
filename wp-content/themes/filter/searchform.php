<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-group">
        <input type="text" name="s" class="inp_search form-control" placeholder="<?php echo "Поиск"; ?>" />
        <button type="submit" name="submit" id="searchsubmit" class="btn_search" value="">Поиск</button>
    </div>
</form>