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
class RecordController extends BaseController 
{
    protected $record_id = 0;
    protected $Item_id = 0;
    
    public function _save()
    {
        $app= Factory::getApplication();

        $record = new \stdClass();
        
        $this->record_id = $app->input->getLong('record_id');
        $record->id = $app->input->getLong('record_id');
        $record->nr = $app->input->getLong('record_nr');
        $record->result = $app->input->getString('record_result');
        $record->date = $app->input->getDate('record_date');
        $record->date2 = $app->input->getDate('record_date2');
        $record->location = $app->input->getString('record_location');
        $record->person = $app->input->getString('record_person');
        $record->competition_id = $app->input->getLong('record_competition_id');
        $record->agegroup_id = $app->input->getLong('record_agegroup_id');
        

        
        $model = $this->getModel('record');
        
        $record_id = $model->save($record);

        return $record_id;
    }
    
    public function save()
    {
        $app= Factory::getApplication();
        $this->Itemid = $app->input->get('Itemid');
  
        $record_id = $this->_save();

        $this->setRedirect('index.php?option=com_records&task=record.edit&record_id='.$record_id.'&Itemid='.$this->Itemid);
    }
    
    public function saveandback()
    {
        $app= Factory::getApplication();
        
        $this->Itemid = $app->input->get('Itemid');
        $this->_save();
        $this->setRedirect('index.php?option=com_records&view=records&Itemid='.$this->Itemid);
    }
    
    public function cancel()
    {
        $app= Factory::getApplication();
        
        $this->Itemid = $app->input->get('Itemid');

        $this->setRedirect('index.php?option=com_records&view=records&Itemid='.$this->Itemid);
    }
    
    public function addnew()
    {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();
        $model = $this->getModel('record');
        $view = $this->getView('Record', $viewFormat);
        $view->setModel($model, true);
        //echo json_encode($model->getItem());
        $view->display();
    }
    
    public function edit()
    {
        $document = Factory::getDocument();
        $viewFormat = $document->getType();
        
        $model = $this->getModel('record');
        
        $view = $this->getView('Record', $viewFormat);
        $view->setModel($model, true);
        //jexit();
        $view->display();
    }
}