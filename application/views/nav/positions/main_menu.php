<div class="navbar-inner">
  <div class="container">
    <button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <div class="nav-collapse collapse">
      <ul class="nav">
    		<?php
				foreach ($nav->getPublishedItems() as $key => $item){
					echo navHelper::getItemNavTree('main-menu',$item, $navItem, 0, false, true);
				}
				?>
      </ul>
    </div>
  </div>
</div>