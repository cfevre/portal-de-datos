<form method="GET" action="<?php echo site_url('buscar'); ?>" class="navbar-search pull-left visible-phone form-search">
    <input type="text" value="<?php echo htmlentities($search_string); ?>" class="search-query" name="q" id="q_responsive" placeholder="buscar">
</form>
<form method="GET" action="<?php echo site_url('buscar'); ?>" class="navbar-form pull-right hidden-phone">
	<input type="text" value="<?php echo htmlentities($search_string); ?>" class="span2" name="q" id="q" placeholder="¿qué estás buscando?">
	<input class="btn buscar" type="submit" value="Submit">
</form>