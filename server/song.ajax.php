<?php
/* vim:set tabstop=8 softtabstop=8 shiftwidth=8 noexpandtab: */
/**
 * Song Ajax
 *
 * PHP version 5
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright (c) 2001 - 2011 Ampache.org All Rights Reserved
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * @category	Ajax
 * @package	Server
 * @author	Karl Vollmer <vollmer@ampache.org>
 * @copyright	2001 - 2011 Ampache.org
 * @license	http://opensource.org/licenses/gpl-2.0 GPLv2
 * @version	PHP 5.2
 * @link	http://www.ampache.org/
 * @since	File available since Release 1.0
 */

/**
 * Sub-Ajax page, requires AJAX_INCLUDE
 */
if (!defined('AJAX_INCLUDE')) { exit; }

switch ($_REQUEST['action']) {
	case 'flip_state':
		if (!Access::check('interface','75')) {
			debug_event('DENIED',$GLOBALS['user']->username . ' attempted to change the state of a song','1');
			exit;
		}

		$song = new Song($_REQUEST['song_id']);
		$new_enabled = $song->enabled ? '0' : '1';
		$song->update_enabled($new_enabled,$song->id);
		$song->enabled = $new_enabled;
		$song->format();

		//Return the new Ajax::button
		$id = 'button_flip_state_' . $song->id;
		$button = $song->enabled ? 'disable' : 'enable';
		$results[$id] = Ajax::button('?page=song&action=flip_state&song_id=' . $song->id,$button,_(ucfirst($button)),'flip_state_' . $song->id);

	break;
	default:
		$results['rfc3514'] = '0x1';
	break;
} // switch on action;

// We always do this
echo xml_from_array($results);
?>
