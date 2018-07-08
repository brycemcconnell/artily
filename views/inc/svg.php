<?php 

class Factory {
	public function arrow_down($color = "#000") {
		return '<?xml version="1.0" ?><svg enable-background="new 0 0 24 24" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><polyline fill="none" points="21,8.5 12,17.5 3,8.5 " stroke="'.$color.'" stroke-miterlimit="10" stroke-width="2"/></svg>';
	}
}

$SVG = new Factory();