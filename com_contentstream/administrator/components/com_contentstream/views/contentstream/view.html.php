<?php
/**
 * @package    COM_CONTENTSTREAM
 *
 * @author     NHS South, Central and West <webteam.scwcsu@nhs.net>
 * @copyright  Copyright (C) 2021 NHS South Central and West. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.scwcsu.nhs.uk
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;

defined('_JEXEC') or die;

/**
 * Contentstream view.
 *
 * @package   COM_CONTENTSTREAM
 * @since     1.0.0
 */
class ContentstreamViewContentstream extends HtmlView
{
	/**
	 * Contentstream helper
	 *
	 * @var    ContentstreamHelper
	 * @since  1.0.0
	 */
	protected $helper;

	/**
	 * The sidebar to show
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	protected $sidebar = '';

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @see     fetch()
	 * @since   1.0.0
	 */
	public function display($tpl = null)
	{
		// Show the toolbar
		$this->toolbar();

		// Show the sidebar
		$this->helper = new ContentstreamHelper;
		$this->helper->addSubmenu('contentstream');
		$this->sidebar = HTMLHelper::_('sidebar.render');

		// Display it all
		return parent::display($tpl);
	}

	/**
	 * Displays a toolbar for a specific page.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	private function toolbar()
	{
		ToolBarHelper::title(Text::_('COM_CONTENTSTREAM'), '');

		// Options button.
		if (Factory::getUser()->authorise('core.admin', 'com_contentstream'))
		{
			ToolBarHelper::preferences('com_contentstream');
		}
	}
}

