<?php
/**
 *  
 * @package    YoloTheme
 * @version    1.0.0
 * @created    3/3/2016
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
*/

global $yolo_bestruct_options;
$prefix                     = 'yolo_';
$maintenance_social_profile = array();
$maintenance_social_profile = $yolo_bestruct_options['maintenance_social_profile'];

$twitter = '';
if ( isset( $yolo_bestruct_options['twitter_url'] ) ) {
	$twitter = $yolo_bestruct_options['twitter_url'];
}

$facebook = '';
if ( isset( $yolo_bestruct_options['facebook_url'] ) ) {
	$facebook = $yolo_bestruct_options['facebook_url'];
}

$dribbble = '';
if ( isset( $yolo_bestruct_options['dribbble_url'] ) ) {
	$dribbble = $yolo_bestruct_options['dribbble_url'];
}

$vimeo = '';
if ( isset( $yolo_bestruct_options['vimeo_url'] ) ) {
	$vimeo = $yolo_bestruct_options['vimeo_url'];
}

$tumblr = '';
if ( isset( $yolo_bestruct_options['tumblr_url'] ) ) {
	$tumblr = $yolo_bestruct_options['tumblr_url'];
}

$skype = $yolo_bestruct_options['skype_username'];
if ( isset( $yolo_bestruct_options['skype_username'] ) ) {
	$skype = $yolo_bestruct_options['skype_username'];
}

$linkedin = '';
if ( isset( $yolo_bestruct_options['linkedin_url'] ) ) {
	$linkedin = $yolo_bestruct_options['linkedin_url'];
}

$googleplus = '';
if ( isset( $yolo_bestruct_options['googleplus_url'] ) ) {
	$googleplus = $yolo_bestruct_options['googleplus_url'];
}

$flickr = '';
if ( isset( $yolo_bestruct_options['flickr_url'] ) ) {
	$flickr = $yolo_bestruct_options['flickr_url'];
}

$youtube = '';
if ( isset( $yolo_bestruct_options['youtube_url'] ) ) {
	$youtube = $yolo_bestruct_options['youtube_url'];
}

$pinterest = '';
if ( isset( $yolo_bestruct_options['pinterest_url'] ) ) {
	$pinterest = $yolo_bestruct_options['pinterest_url'];
}

$foursquare = $yolo_bestruct_options['foursquare_url'];
if ( isset( $yolo_bestruct_options['foursquare_url'] ) ) {
	$foursquare = $yolo_bestruct_options['foursquare_url'];
}

$instagram = '';
if ( isset( $yolo_bestruct_options['instagram_url'] ) ) {
	$instagram = $yolo_bestruct_options['instagram_url'];
}

$github = '';
if ( isset( $yolo_bestruct_options['github_url'] ) ) {
	$github = $yolo_bestruct_options['github_url'];
}

$xing = $yolo_bestruct_options['xing_url'];
if ( isset( $yolo_bestruct_options['xing_url'] ) ) {
	$xing = $yolo_bestruct_options['xing_url'];
}

$rss = '';
if ( isset( $yolo_bestruct_options['rss_url'] ) ) {
	$rss = $yolo_bestruct_options['rss_url'];
}

$behance = '';
if ( isset( $yolo_bestruct_options['behance_url'] ) ) {
	$behance = $yolo_bestruct_options['behance_url'];
}

$soundcloud = '';
if ( isset( $yolo_bestruct_options['soundcloud_url'] ) ) {
	$soundcloud = $yolo_bestruct_options['soundcloud_url'];
}

$deviantart = '';
if ( isset( $yolo_bestruct_options['deviantart_url'] ) ) {
	$deviantart = $yolo_bestruct_options['deviantart_url'];
}

$yelp = "";
if ( isset( $yolo_bestruct_options['yelp_url'] ) ) {
	$yelp = $yolo_bestruct_options['yelp_url'];
}

$email = "";
if ( isset( $yolo_bestruct_options['email_address'] ) ) {
	$email = $yolo_bestruct_options['email_address'];
}

$social_icons = '';

if ( ($maintenance_social_profile == array()) || (empty( $maintenance_social_profile )) ) {
	if ( $twitter ) {
		$social_icons .= '<li><a href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html('Follow us on Twitter','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $facebook ) {
		$social_icons .= '<li><a href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html('Follow us on Facebook','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $dribbble ) {
		$social_icons .= '<li><a href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html('Follow us on Dribbble','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $youtube ) {
		$social_icons .= '<li><a href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html('Follow us on Youtube','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $vimeo ) {
		$social_icons .= '<li><a href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html('Follow us on Square','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $tumblr ) {
		$social_icons .= '<li><a href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html('Follow us on Tumblr','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $skype ) {
		$social_icons .= '<li><a href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html('Follow us on Skype','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $linkedin ) {
		$social_icons .= '<li><a href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html('Follow us on Linkedin','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $googleplus ) {
		$social_icons .= '<li><a href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html('Follow us on Googleplus','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $flickr ) {
		$social_icons .= '<li><a href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html('Follow us on Flickr','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $pinterest ) {
		$social_icons .= '<li><a href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html('Follow us on Pinterest','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $foursquare ) {
		$social_icons .= '<li><a href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html('Follow us on Foursquare','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $instagram ) {
		$social_icons .= '<li><a href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html('Follow us on Instagram','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $github ) {
		$social_icons .= '<li><a href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html('Follow us on Github','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $xing ) {
		$social_icons .= '<li><a href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html('Follow us on Xing','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $behance ) {
		$social_icons .= '<li><a href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html('Follow us on Behance','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $deviantart ) {
		$social_icons .= '<li><a href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html('Follow us on Deviantart','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $soundcloud ) {
		$social_icons .= '<li><a href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html('Follow us on Soundcloud','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $yelp ) {
		$social_icons .= '<li><a href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i></a>'. esc_html('Follow us on Yelp','yolo-bestruct') .'</li>' . "\n";
	}
	if ( $rss ) {
		$social_icons .= '<li><a href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html('Follow us on Rss','yolo-bestruct') .'</a></li>' . "\n";
	}
	if ( $email ) {
		$social_icons .= '<li><a href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html('Send messages','yolo-bestruct') .'</a></li>' . "\n";
	}
} else {
	if (empty($twitter)) { $twitter = '#'; }
	if (empty($facebook)) { $facebook = '#'; }
	if (empty($dribbble)) { $dribbble = '#'; }
	if (empty($youtube)) { $youtube = '#'; }
	if (empty($vimeo)) { $vimeo = '#'; }
	if (empty($tumblr)) { $tumblr = '#'; }
	if (empty($skype)) { $skype = '#'; }
	if (empty($linkedin)) { $linkedin = '#'; }
	if (empty($googleplus)) { $googleplus = '#'; }
	if (empty($flickr)) { $flickr = '#'; }
	if (empty($pinterest)) { $pinterest = '#'; }
	if (empty($foursquare)) { $foursquare = '#'; }
	if (empty($instagram)) { $instagram = '#'; }
	if (empty($github)) { $github = '#'; }
	if (empty($xing)) { $xing = '#'; }
	if (empty($behance)) { $behance = '#'; }
	if (empty($deviantart)) { $deviantart = '#'; }
	if (empty($soundcloud)) { $soundcloud = '#'; }
	if (empty($yelp)) { $yelp = '#'; }
	if (empty($rss)) { $rss = '#'; }
	if (empty($email)) { $email = '#'; }

	foreach ( $maintenance_social_profile as $id ) {
		if ( ( $id == 'twitter' ) && $twitter ) {
			$social_icons .= '<li><a href="' . esc_url( $twitter ) . '" target="_blank"><i class="fa fa-twitter"></i>'. esc_html('Follow us on Twitter','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'facebook' ) && $facebook ) {
			$social_icons .= '<li><a href="' . esc_url( $facebook ) . '" target="_blank"><i class="fa fa-facebook"></i>'. esc_html('Follow us on Facebook','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'dribbble' ) && $dribbble ) {
			$social_icons .= '<li><a href="' . esc_url( $dribbble ) . '" target="_blank"><i class="fa fa-dribbble"></i>'. esc_html('Follow us on Dribbble','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'youtube' ) && $youtube ) {
			$social_icons .= '<li><a href="' . esc_url( $youtube ) . '" target="_blank"><i class="fa fa-youtube"></i>'. esc_html('Follow us on Youtube','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'vimeo' ) && $vimeo ) {
			$social_icons .= '<li><a href="' . esc_url( $vimeo ) . '" target="_blank"><i class="fa fa-vimeo-square"></i>'. esc_html('Follow us on Vimeo','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'tumblr' ) && $tumblr ) {
			$social_icons .= '<li><a href="' . esc_url( $tumblr ) . '" target="_blank"><i class="fa fa-tumblr"></i>'. esc_html('Follow us on Tumblr','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'skype' ) && $skype ) {
			$social_icons .= '<li><a href="skype:' . esc_attr( $skype ) . '" target="_blank"><i class="fa fa-skype"></i>'. esc_html('Follow us on Skype','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'linkedin' ) && $linkedin ) {
			$social_icons .= '<li><a href="' . esc_url( $linkedin ) . '" target="_blank"><i class="fa fa-linkedin"></i>'. esc_html('Follow us on Linkedin','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'googleplus' ) && $googleplus ) {
			$social_icons .= '<li><a href="' . esc_url( $googleplus ) . '" target="_blank"><i class="fa fa-google-plus"></i>'. esc_html('Follow us on Googleplus','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'flickr' ) && $flickr ) {
			$social_icons .= '<li><a href="' . esc_url( $flickr ) . '" target="_blank"><i class="fa fa-flickr"></i>'. esc_html('Follow us on Flickr','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'pinterest' ) && $pinterest ) {
			$social_icons .= '<li><a href="' . esc_url( $pinterest ) . '" target="_blank"><i class="fa fa-pinterest"></i>'. esc_html('Follow us on Pinterest','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'foursquare' ) && $foursquare ) {
			$social_icons .= '<li><a href="' . esc_url( $foursquare ) . '" target="_blank"><i class="fa fa-foursquare"></i>'. esc_html('Follow us on Foursquare','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'instagram' ) && $instagram ) {
			$social_icons .= '<li><a href="' . esc_url( $instagram ) . '" target="_blank"><i class="fa fa-instagram"></i>'. esc_html('Follow us on Instagram','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'github' ) && $github ) {
			$social_icons .= '<li><a href="' . esc_url( $github ) . '" target="_blank"><i class="fa fa-github"></i>'. esc_html('Follow us on Github','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'xing' ) && $xing ) {
			$social_icons .= '<li><a href="' . esc_url( $xing ) . '" target="_blank"><i class="fa fa-xing"></i>'. esc_html('Follow us on Xing','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'behance' ) && $behance ) {
			$social_icons .= '<li><a href="' . esc_url( $behance ) . '" target="_blank"><i class="fa fa-behance"></i>'. esc_html('Follow us on Behance','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'deviantart' ) && $deviantart ) {
			$social_icons .= '<li><a href="' . esc_url( $deviantart ) . '" target="_blank"><i class="fa fa-deviantart"></i>'. esc_html('Follow us on Deviantart','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'soundcloud' ) && $soundcloud ) {
			$social_icons .= '<li><a href="' . esc_url( $soundcloud ) . '" target="_blank"><i class="fa fa-soundcloud"></i>'. esc_html('Follow us on Soundcloud','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'yelp' ) && $yelp ) {
			$social_icons .= '<li><a href="' . esc_url( $yelp ) . '" target="_blank"><i class="fa fa-yelp"></i>'. esc_html('Follow us on Yelp','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'rss' ) && $rss ) {
			$social_icons .= '<li><a href="' . esc_url( $rss ) . '" target="_blank"><i class="fa fa-rss"></i>'. esc_html('Follow us on Rss','yolo-bestruct') .'</a></li>' . "\n";
		}
		if ( ( $id == 'email' ) && $email ) {
			$social_icons .= '<li><a href="mailto:' . esc_attr( $email ) . '" target="_blank"><i class="fa fa-vk"></i>'. esc_html('Send messages','yolo-bestruct') .'</a></li>' . "\n";
		}
	}
}
if (empty($social_icons)) {
	return;
}
?>
<ul class="maintenance-social-profile-wrapper">
	<?php echo wp_kses_post( $social_icons ); ?>
</ul>