<?php

namespace TSV\Component\Records\Site\View\Record;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 John Smith. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * View for the user identity validation form
 */
class HtmlView extends BaseHtmlView {
    

    /**
     * Display the view
     *
     * @param   string  $template  The name of the layout file to parse.
     * @return  void
     */
    public function display($template = null) {
        
        $app    = Factory::getApplication();
        $params = $app->getParams();
        
        // Get some data from the models
        $state      = $this->get('State');
        //$items      = $this->get('Items');
        //$pagination = $this->get('Pagination');
        
        // Flag indicates to not add limitstart=0 to URL
        //$pagination->hideEmptyLimitstart = true;
        
        $this->record = $this->get('Item');
        
        parent::display($template);
    }

}?>