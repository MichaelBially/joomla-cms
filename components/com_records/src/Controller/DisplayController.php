<?php

namespace TSV\Component\Records\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Factory;

/**
 * @package     Joomla.Site
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 John Smith. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * HelloWorld Component Controller
 * @since  0.0.2
 */
class DisplayController extends BaseController {
    
    public function display($cachable = false, $urlparams = array()) {
        $document = Factory::getDocument();
        $viewName = $this->input->getCmd('view', 'Records');
        $viewFormat = $document->getType();

        $model = $this->getModel($viewName);
        $view = $this->getView($viewName, $viewFormat);
        $view->setModel($model, true);
        
        $view->document = $document;
        $view->display();
    }
    

}