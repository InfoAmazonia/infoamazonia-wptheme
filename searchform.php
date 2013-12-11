<form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
    <div>
    	<input type="text" name="s" id="s" placeholder="<?php _e('Search for stories', 'ekuatorial'); ?>" value="<?php echo $_GET['s']; ?>" />
        <input type="submit" class="button" id="searchsubmit" value="<?php _e('Search', 'ekuatorial'); ?>" />
    </div>
</form>