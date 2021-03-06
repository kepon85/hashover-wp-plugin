<?php

/**
 * Copyright (C) 2017 Jacob Barkdull
 * This program is part of HashOver.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * @package HashOver
 * @version next
 *
 * Plugin Name: HashOver
 * Plugin URI: http://tildehash.com/?page=hashover
 * Description: Adds the HashOver comment system to each post.
 * Author: Jacob Barkdull
 * Version: next
 * Author URI: http://tildehash.com/?page=author
 */


// Registers the HashOver script
function register_hashover ()
{
	// HashOver script location
	$script = '/hashover/hashover.js';

	// Check if the comments are open
	if (is_single () === true and comments_open () === true) {
		// If so, register the HashOver script
		wp_register_script ('hashover', $script, array (), 'next', true);
	}
}

// Enqueues the HashOver script
function enqueue_hashover ()
{
	// Check if the comments are open
	if (is_single () === true and comments_open () === true) {
		// If so, enqueue the HashOver script
		wp_enqueue_script ('hashover');
	}
}

// Returns URL to the HashOver HTML elements file
function hashover_elements_url ()
{
	// Check if the comments are open
	if (is_single () === true and comments_open () === true) {
		// Return HashOver HTML elements file path
		return plugin_dir_path (__FILE__) . 'initial-html.php';
	}
}

// Returns a HashOver count link JavaScript tag
function hashover_count_link ()
{
	// Check if the comments are open
	if (comments_open (get_the_ID ()) === true) {
		// Get the post URL
		$post_url = urlencode (get_permalink ());

		// Construct the link count URL parameter
		$script_url = '/hashover/api/count-link.php?url=' . $post_url;

		// Return the JavaScript tag
		return '<script type="text/javascript" src="' . $script_url . '"></script>';
	}
}

// Hook HashOver script register and enqueuer to front-end
add_action ('wp_enqueue_scripts', 'register_hashover');
add_action ('wp_enqueue_scripts', 'enqueue_hashover');

// Replace default comments with HashOver HTML elements
add_filter ('comments_template', 'hashover_elements_url');
