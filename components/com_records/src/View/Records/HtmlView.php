<?php

namespace TSV\Component\Records\Site\View\Records;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\MVC\View\GenericDataException;

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
        
        $records = $this->get('List');
        $classes = $this->get('Classes');
        $classes_male = $this->get('ClassesMale');
        $classes_female = $this->get('ClassesFemale');
        $diszis = $this->get('Diszis');
        $years = $this->get('RecordYears');
        $agegroups = $this->get('AllAgegroups');
        $competitions = $this->get('AllCompetitions');
        $typ = $this->get('CompetitionTyp');
        //$print 		= JRequest::getVar('print');
        
        
        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            throw new GenericDataException(implode("\n", $errors), 500);
        }
        
        $this->state      = &$state;
        //$this->items      = &$items;
        $this->params     = &$params;
        //$this->pagination = &$pagination;
        
        $this->records =  &$records;
        $this->classes  =  &$classes;
        $this->classes_male  =  &$classes_male;
        $this->classes_female  =  &$classes_female;
        $this->diszis  =  &$diszis;
        $this->years  =  &$years;
        $this->agegroups =  &$agegroups;
        $this->competitions =  &$competitions;
        $this->typ = &$typ;
        
        
        $this->print = false;
        
        return parent::display($template);
    }

}?>