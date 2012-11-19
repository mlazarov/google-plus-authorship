<?php

/*
Plugin Name: Google Plus Authorship
Plugin URI: http://marto.lazarov.org/plugins/google-plus-auhorship
Description: Google Plus Authorship enables Your profile picture to appear in Google Search Results. Very Easy to implement. Just 3 step to process
Version: 2.0
Author: Martin Lazarov
Author URI: http://marto.lazarov.org
License: GPL2
*/

function google_plus_authorship_link ($gplusreturn) { 
	$gplus_author_name = esc_attr( get_the_author_meta( 'prefname', $user->ID ) );
	$gplus_author_display = esc_attr( get_the_author_meta( 'display_name', $user->ID ) );	
	$gplus_author_url = esc_attr( get_the_author_meta( 'gplusauthor', $user->ID ) );

	if(is_author){
		$authororme = 12;
	}
	else {
		$authororme = 23;
	}
	
	if($gplus_author_name==NULL) {
		$authorizing = $gplus_author_display;
	}
	else{
		$authorizing = $gplus_author_name;
	}
	$authorizing = "+";

	$gplusreturn .= "<a href='";
	$gplusreturn .= $gplus_author_url;
	$gplusreturn .= "' rel='";
	if(is_author){ $gplusreturn .="author";}
	else {$gplusreturn .= "me";}
	$gplusreturn .= "' title='Google Plus Profile for ";
	$gplusreturn .= $authorizing; 
	$gplusreturn .="' title='demo'>";					
	$gplusreturn .= $authorizing;
	$gplusreturn .= "</a>";

	return $gplusreturn;
} 

add_filter( 'get_the_author_link', 'google_plus_authorship_link',10,3 );
add_filter( 'the_author_posts_link', 'google_plus_authorship_link',10,3 );
add_action( 'show_user_profile', 'gplus_authorship_profile_fields' );
add_action( 'edit_user_profile', 'gplus_authorship_profile_fields' );

function gplus_authorship_profile_fields( $user ) { 
	
	global $current_user;
	get_currentuserinfo();
	$gplus_author_name = esc_attr( get_the_author_meta( 'prefname', $current_user->ID ) );
	$gplus_author_url = esc_attr( get_the_author_meta( 'gplusauthor', $current_user->ID ) );

	?>
	<h3>Google Plus profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="gplusauthor">Google Plus Profile URL</label></th>

			<td>
				<input type="text" name="gplusauthor" id="gplusauthor" value="<?php echo esc_attr( get_the_author_meta( 'gplusauthor', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Google Plus Profile URL. (with "https://plus.google.com/1234567890987654321")</span>
			</td>
		</tr>
		<tr>

			<th><label for="prefname">Preferred Name</label></th>
			<td>
				<input type="text" name="prefname" id="prefname" value="<?php echo esc_attr( get_the_author_meta( 'prefname', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter Your Preferred Name</span>
			</td>
		</tr>

	</table>
<?php }


add_action( 'profile_update', 'gplus_authorship_profile_save' );


function gplus_authorship_profile_save( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ){
		echo "You can't edit this user";
		return false;
	}
	update_usermeta( $user_id, 'gplusauthor', $_POST['gplusauthor'] );
	update_usermeta( $user_id, 'prefname', $_POST['prefname'] );

}

?>
