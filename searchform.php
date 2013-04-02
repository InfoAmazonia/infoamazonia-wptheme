<form role="search" method="get" id="searchform">
    <div>
    	<input type="text" name="s" id="s" placeholder="<?php echo infoamazonia_search_placeholder(); ?>" value="<?php echo $_GET['s']; ?>" />
        <input type="submit" class="button" id="searchsubmit" value="<?php _e('Search', 'infoamazonia'); ?>" />
    </div>
</form>