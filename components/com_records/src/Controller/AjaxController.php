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
class AjaxController extends BaseController {

    
    public function history()
    {
        $model = $this->getModel('ajax');
        echo json_encode($model->getHistory());
        jexit();
    }
 
    public function getAthleteName()
    {
        $model = $this->getModel('ajax');
//dump($model->getAthleteName());        
        echo json_encode($model->getAthleteName());
        jexit();
    }
}