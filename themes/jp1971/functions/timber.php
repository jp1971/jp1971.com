<?php 

add_filter( 'timber_context', 'jp1971_add_to_timber_context' );
function jp1971_add_to_timber_context( $data ){

	// Get Tweets
	$data['tweets'] = getTweets( 3, 'JamesonProctor', array( 'include_rts' => true ) );

	// Get Github activity
	$feed = fetch_feed( 'http://github.com/jp1971.atom' ); 
	$html = '';
	$i = 0;
	foreach ( $feed->get_items() as $item ) {
		if ($i == 3) {
			break;
		}
		$content = $item->data['child']['http://www.w3.org/2005/Atom']['content'][0]['data'];
		$html .= '<div class="github-activity-item">' . $content . '</div>';
		$i++;
	}
	$data['github'] = $html;

	$data = apply_filters('jp1971_timber_context' , $data);

    return $data;
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */