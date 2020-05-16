<?php
// Remove all default WP template redirects/lookups
remove_action( 'template_redirect', 'redirect_canonical' );

// Redirect all requests to index.php so the Vue app is loaded and 404s aren't thrown
function remove_redirects() {
	add_rewrite_rule( '^/(.+)/?', 'index.php', 'top' );
}
add_action( 'init', 'remove_redirects' );

// Load scripts
function load_vue_scripts() {
	wp_enqueue_script(
		'vuejs-wordpress-theme-starter-js',
		get_stylesheet_directory_uri() . '/dist/scripts/index.js',
		array( 'jquery' ),
		filemtime( get_stylesheet_directory() . '/dist/scripts/index.js' ),
		true
	);

	wp_enqueue_style(
		'vuejs-wordpress-theme-starter-css',
		get_stylesheet_directory_uri() . '/dist/styles.css',
		null,
		filemtime( get_stylesheet_directory() . '/dist/styles.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'load_vue_scripts', 100 );

/*
 * Custom API DOC
 * - getAlarmPost
 *   @info   -> Returns info about specific alarm
 *   @params -> post-id
 *
 * - getAllFromType
 *   @info   -> Returns all posts of a specific form type
 *   @params -> type
 *
 * - getSidebarInfo
 *   @info   -> Returns all all information needed for the sidebar
 *
 * - getAllAlarmsFromYear
 *   @info   -> Returns all alarms for selected year
 *   @params -> year
 *
 * - getAllMeetings
 *   @info   -> Returns all meetings
 *
 * - getIndexInfo
 *   @info   -> Returns index info
*/

/*
 * Returns data from selected alarm id
 */

function getAlarm( $request_data ) {
    $id = (int)$request_data->get_params()['id'];
    $post = get_post($id);
    $alarmierungszeitpunkt = types_get_field_meta_value( 'alarmierungszeitpunkt', $id );
    $fahrzeuge = types_get_field_meta_value( 'fahrzeuge', $id );
    $einsatzpersonal = types_get_field_meta_value( 'einsatzpersonal', $id );
    $weitereKraefte = types_get_field_meta_value( 'weitere-kraefte', $id );
    $medienbilder = types_get_field_meta_value( 'medienbilder', $id );
    $einsatzfahrzeuge = types_get_field_meta_value( 'einsatzfahrzeuge', $id );
    $einsatzort = types_get_field_meta_value( 'einsatzort', $id );
    $alarmierungsart = types_get_field_meta_value( 'alarmierungsart', $id );
    $einsatzart = types_get_field_meta_value( 'einsatzart', $id );
    $einsatzicon = types_get_field_meta_value( 'einsatzicon', $id );

    $data = (object) array(
        'alarmierungszeitpunkt' => $alarmierungszeitpunkt,
        'fahrzeuge' => $fahrzeuge,
        'einsatzpersonal' => $einsatzpersonal,
        'weitereKraefte' => $weitereKraefte,
        'medienbilder' => $medienbilder,
        'einsatzfahrzeuge' => $einsatzfahrzeuge,
        'einsatzort' => $einsatzort,
        'alarmierungsart' => $alarmierungsart,
        'einsatzart' => $einsatzart,
        'einsatzicon' => $einsatzicon,
    );
    $data =  (object) array_merge((array) $data, (array) $post);
    return $data;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getAlarmPost/', array(
        'methods' => 'GET',
        'callback' => 'getAlarm'
    ));
});

/*
 * Returns al posts from selected post type
 */

function getAllFromType( $request_data ) {
    $args = array(
        'post_type' => $request_data->get_params()['type'],
        'posts_per_page'=>-1,
        'numberposts'=>-1
    );

    $the_query = new WP_Query( $args );

    return $the_query;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getAllFromType/', array(
        'methods' => 'GET',
        'callback' => 'getAllFromType'
    ));
});

/*
 * Returns sidebar Information
 */
function getSidebarInfo() {
    $latestAlarmArgs = array(
        'posts_per_page' => 1,
        'order'=> 'DESC',
        'post_type' => 'einsatz'
    );

    $latestAlarm = get_posts( $latestAlarmArgs );
    $alarmierungszeitpunkt = (object) array('alarmTime' => types_get_field_meta_value( 'alarmierungszeitpunkt', $latestAlarm[0]->ID ));
    $latestAlarm =  (object) array('latestAlarm' => array_merge((array) $latestAlarm[0],(array) $alarmierungszeitpunkt));

    $nextThreeMeetingsArgs = array(
        'posts_per_page' => 3,
        'order'=> 'ASC',
        'post_type' => 'termin',
        'meta_key' => 'wpcf-zeitpunkt ',
        'orderby' => 'meta_value_num', );

    $nextThreeMeetingsPosts = get_posts( $nextThreeMeetingsArgs );
    $nextThreeMeetings = array();
    foreach ($nextThreeMeetingsPosts as $meeting) {
        $zeitpunkt = (object) array('date' => types_get_field_meta_value( 'zeitpunkt', $meeting->ID ));
        $data = (object) array_merge((array) ($meeting), (array) $zeitpunkt);
        $nextThreeMeetings[] = $data;
    }
    $nextThreeMeetings = (object) array('nextThreeMeetings' => $nextThreeMeetings);

    $sideBarPostArgs = array( 'posts_per_page' => -1,
        'numberposts'=>-1,
        'order'=> 'ASC',
        'orderby' => 'title',
        'post_type' =>  'SideBar' );

    $sideBarPosts = get_posts( $sideBarPostArgs );
    $sideBar = array();
    foreach ($sideBarPosts as $post) {
        $goto = types_get_field_meta_value( 'goto', $post->ID );
        $sideimg = types_get_field_meta_value( 'sideimg', $post->ID );
        $sideimgalt = types_get_field_meta_value( 'sideimgalt', $post->ID );
        $data = (object) array(
            'goto' => $goto,
            'sideimg' => $sideimg,
            'sideimgalt' => $sideimgalt,
        );
        $data = (object) array_merge((array) ($post), (array) $zeitpunkt);
        $sideBar[] = $data;
    }

    $returnData = (object) array_merge((array) ($sideBar), (array) $nextThreeMeetings);
    $returnData = (object) array_merge((array) $returnData, (array) $latestAlarm);

    return $returnData;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getSidebarInfo/', array(
        'methods' => 'GET',
        'callback' => 'getSidebarInfo'
    ));
});

/*
 * Returns all alarms from selected year
 */

function getAllAlarmsFromYear( $request_data ) {
    $alarmsArgs = array(
        'posts_per_page' => -1,
        'numberposts'=>-1,
        'post_type' => 'einsatz',
        'order' => 'DESC'
    );

    $alarmsPosts = get_posts( $alarmsArgs );
    $alarmsPost = [];
    $test = 0;
    foreach ($alarmsPosts as $post) {
        $alarmierungszeitpunkt = types_get_field_meta_value( 'alarmierungszeitpunkt', $post->ID );
        if(date("Y",$alarmierungszeitpunkt['timestamp']) == $request_data['year']){
            $einsatzicon = types_get_field_meta_value( 'einsatzicon', $post->ID );
            $data = (object) array(
                'alarmierungszeitpunkt' => $alarmierungszeitpunkt,
                'einsatzicon' => $einsatzicon,
            );
            $data = (object) array_merge((array) ($post), (array) $data);
            $test++;
            array_push($alarmsPost, $data);
        }

    }
    return $alarmsPost;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getAllAlarmsFromYear/', array(
        'methods' => 'GET',
        'callback' => 'getAllAlarmsFromYear'
    ));
});

/*
 * Returns all meetings
 */

function getAllMeetings() {
    $meetingsArgs = array(
        'posts_per_page' => -1,
        'numberposts'=>-1,
        'order'=> 'ASC',
        'post_type' => 'termin',
        'meta_key' => 'wpcf-zeitpunkt ',
        'orderby' => 'meta_value_num' );

    $meetingsPosts = get_posts( $meetingsArgs );
    $meetings = array();
    foreach ($meetingsPosts as $meeting) {
        $zeitpunkt = types_get_field_meta_value( 'zeitpunkt', $meeting->ID );
        $time = types_get_field_meta_value( 'uhrzeit', $meeting->ID );
        $hasLink = types_get_field_meta_value( 'berichtlinkcheck', $meeting->ID );
        $link = types_get_field_meta_value( 'berichtlink', $meeting->ID );
        $data = (object) array(
            'zeitpunkt' => $zeitpunkt,
            'time' => $time,
            'hasLink' => $hasLink,
            'link' => $link,
        );
        $data = (object) array_merge((array) ($meeting), (array) $data);
        $meetings[] = $data;
    }
    return $meetings;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getAllMeetings/', array(
        'methods' => 'GET',
        'callback' => 'getAllMeetings'
    ));
});

/*
 * Returns index Info
 */

function getIndexInfo() {
    $indexArgs = array(
        'posts_per_page' => -1,
        'numberposts'=>-1,
        'order'=> 'DESC',
        'post_type' =>  array( 'post', 'page'));

    $indexPosts = get_posts( $indexArgs );
    $posts = array();
    foreach ($indexPosts as $post) {
        $visibleonstart = types_get_field_meta_value( 'visibleonstart', $post->ID );
        $startBild = types_get_field_meta_value( 'start-bild', $post->ID );
        $data = (object) array(
            'visibleonstart' => $visibleonstart,
            'startBild' => $startBild,
        );
        $data = (object) array_merge((array) ($post), (array) $data);
        if($visibleonstart){
            $posts[] = $data;
        }
    }
    return $posts;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'types/v1', '/getIndexInfo/', array(
        'methods' => 'GET',
        'callback' => 'getIndexInfo'
    ));
});
