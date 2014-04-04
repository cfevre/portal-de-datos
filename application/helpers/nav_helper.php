<?php
	class navHelper{

		public function prepareUrl($url){
			if(!filter_var($url, FILTER_VALIDATE_URL)){
				$url = site_url($url);
			}
			return $url;
		}

		public function getItemNavTree($menu, $item, $activeItem, $level, $divider = true, $forceLink = false){
			$active = $activeItem?$item->getId()==$activeItem->getId():false;
			if($item->getPage()){
				$itemUrl = site_url('page/view/'.$item->getAlias());
			}else{
				$itemUrl = navHelper::prepareUrl($item->getCustomurl());
			}

			$_li = '<li id="'.$menu.'-item-'.$item->getAlias().'" '.($active?' class="active"':'').'>';
			if((!$active && $itemUrl)||$forceLink){
				$target = $item->getTarget()?' target="'.$item->getTarget().'"':'';
				$_li .= '<a'.$target.' href="'.$itemUrl.'">'.$item->getTitle().'</a>';
			}else{
				$_li .= $item->getTitle();
			}
			$childrens = $item->getChildren();
			if($childrens->count()){
				$_li .= '<ul>';
				foreach ($childrens as $key => $subItem) {
					$_li .= navHelper::getItemNavTree($menu, $subItem, $activeItem, $level+1);
				}
				$_li .= '</ul>';
			}
			$_li .= '</li>';
			if($level == 0 && $divider){
				$_li .= '<li class="divider"></li>';
			}

			return $_li;
		}
		public function generateBreadcrumb($item, $extra_crumbs = null){
			$breadcrumbString = '';

			while ($item->getParent()) {
				$breadcrumb[] = navHelper::getBreadcrumbItem($item);
				$item = $item->getParent();
			}
			if($extra_crumbs){
				foreach ($extra_crumbs as $key => $extra_crumb) {
					$breadcrumb[] = $extra_crumb;
				}
			}

			if($item->getHomepage())
				return '';
			
			$breadcrumb[] = navHelper::getBreadcrumbItem($item);

			$breadcrumb = array_reverse($breadcrumb);

			foreach ($breadcrumb as $key => $item) {
				$breadcrumbString .= '<li '.(($key == count($breadcrumb)-1)?'class="active"':'').'>';
				$breadcrumbString .= '<span class="divider">/</span>';
				if(($key < count($breadcrumb)-1) && $item['link']){
					$breadcrumbString .= '<a href="'.$item['link'].'">'.$item['title'].'</a>';
				}else{
					$breadcrumbString .= $item['title'];
				}
				$breadcrumbString .= '</li>';
			}

			return $breadcrumbString;
		}
		public function getBreadcrumbItem($item){
			$itemUrl = $item->getPage()?site_url('page/view/'.$item->getAlias()):navHelper::prepareUrl($item->getCustomurl());
			return array('link' => $itemUrl, 'title' => $item->getTitle());
		}
	}
?>