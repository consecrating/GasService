<?php
/*
Plugin Name: Instagram Feed by Username
Description: Displays Instagram posts from a public profile using a shortcode.
Version: 1.1
Author: Your Name
*/

function ifbu_display_instagram_feed($atts) {
    $atts = shortcode_atts(array(
        'username' => '',
        'embed1' => '',
        'embed2' => '',
    ), $atts);

    if (empty($atts['username'])) {
        return "<p>Please provide a username.</p>";
    }

    $html = '<div class="instagram-feed-wrapper">';
    $html .= '<p class="instagram-follow-link">Follow <a href="https://instagram.com/' . esc_attr($atts['username']) . '" target="_blank">@' . esc_html($atts['username']) . '</a> on Instagram</p>';

    // Embed posts vertically
    if (!empty($atts['embed1'])) {
        $html .= '<div class="instagram-post"><iframe src="' . esc_url($atts['embed1']) . 'embed" width="320" height="440" frameborder="0" scrolling="no" allowtransparency="true"></iframe></div>';
    }

    if (!empty($atts['embed2'])) {
        $html .= '<div class="instagram-post"><iframe src="' . esc_url($atts['embed2']) . 'embed" width="320" height="440" frameborder="0" scrolling="no" allowtransparency="true"></iframe></div>';
    }

    $html .= '</div>';

    // Inline styles (can also be enqueued separately if needed)
    $html .= '<style>
        .instagram-feed-wrapper {
            max-width: 350px;
            margin: 0 auto;
            text-align: center;
        }
        .instagram-follow-link {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .instagram-post {
            margin-bottom: 20px;
        }
    </style>';

    return $html;
}

add_shortcode('instagram_feed', 'ifbu_display_instagram_feed');
