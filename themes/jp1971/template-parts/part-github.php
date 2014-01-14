<h4><i class="fa fa-github-square"></i>Github</h4>
<?php $feed = fetch_feed( 'http://github.com/jp1971.atom' ) ; ?>
<?php
	$html = '';
	$i = 0;
	foreach ($feed->get_items() as $item) {
		if ($i == 3) {
			break;
		}
		$content = $item->data['child']['http://www.w3.org/2005/Atom']['content'][0]['data'];
		$html .= '<div class="github-activity-item">'.$content.'</div>';
		$i++;
	}
	echo $html;
?>