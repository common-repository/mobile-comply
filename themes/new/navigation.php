<div id ="select_a_page">
<p>Select a page:</p>
</div>
<div id ="navigation">
<?php
	$menu = wp_get_nav_menu_items("Main menu");
	if ($menu)
	{
		if(isset($_GET["menu_id"])) $menu_id = $_GET["menu_id"];
		else $menu_id = 0;
		$has_child_items = array();
		foreach ((array)$menu as $menu_item)
		{
			if ($menu_item->menu_item_parent != 0)
				$has_child_items[$menu_item->menu_item_parent] = 1;
		}
		foreach ((array)$menu as $menu_item)
		{
			if ($menu_item->menu_item_parent == $menu_id)
			{
				echo '<div class="menu_item">
					  <div class="menu_item_title">
					  <a href ="';
				if ($has_child_items[$menu_item->db_id] == 1)
				{
					echo home_url('/') . '?menu_id='.$menu_item->db_id;
				}
				else
				{
					echo $menu_item->url;
				}
				echo '">'.$menu_item->title.'</a></div>
				<div class="menu_arrow">
				<a href ="';
				if ($has_child_items[$menu_item->db_id] == 1)
				{
					echo home_url('/') . '?menu_id='.$menu_item->db_id;
				}
				else
				{
					echo $menu_item->url;
				}
				echo '">&gt;</a></div></div>';
			}
		}
	}
?>
</div>