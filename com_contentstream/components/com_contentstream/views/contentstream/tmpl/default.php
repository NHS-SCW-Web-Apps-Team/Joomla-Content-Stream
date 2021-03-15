<?php
/**
 * @package    COM_CONTENTSTREAM
 *
 * @author     NHS South, Central and West <webteam.scwcsu@nhs.net>
 * @copyright  Copyright (C) 2021 NHS South Central and West. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.scwcsu.nhs.uk
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;

defined('_JEXEC') or die;

HTMLHelper::_('script', 'com_contentstream/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_contentstream/style.css', array('version' => 'auto', 'relative' => true));

$layout = new FileLayout('contentstream.page');
$data = array();
$data['text'] = 'Hello Joomla!';
echo $layout->render($data);

