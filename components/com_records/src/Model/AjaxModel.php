<?php

namespace TSV\Component\Records\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;

class AjaxModel extends ListModel
{
    var $_id = 0;
    var $_competition_id = 0;
    var $_agegroup_id = 0;
    
    var $_records = null;
    
    function __construct()
    {
      
        parent::__construct();
        

        
    }
    
    function getHistoryQuery()
    {
        $db = $this->getDbo();
        $query = 'select record.id as record_id, DATE_FORMAT( record.date,"%d.%m.%Y") as date1, DATE_FORMAT( record.date2,"%d.%m.%Y") as date3, record.*, competition.*, agegroup.* from ';
        $query .= ' #__records_record as record, ';
        $query .= ' #__records_competition as competition, #__records_agegroup as agegroup ';
        $query .= ' where competition_id = competition.id ';
        $query .= ' and record.agegroup_id = agegroup.id ';
        $query .= ' and record.nr > 0 ';
        $query .= ' and record.competition_id = '.$this->_competition_id;
        $query .= ' and record.agegroup_id = '.$this->_agegroup_id;
        
        return $query;
    }
    
    // ermittelt die zur id geh�renden compitition_id und agegroup_id
    function getHistoryRecordQuery()
    {
        $db = $this->getDbo();
        $query = 'select record.id as record_id, record.competition_id, record.agegroup_id from ';
        $query .= ' #__records_record as record ';
        $query .= ' where record.id = '.$this->_id;
        $query .= ' and record.nr = 0 ';
        
        return $query;
        
    }
    
    function getRecordPerson($record_id)
    {
        $db = $this->getDBO();
        
        $query = 'select person.* from ';
        $query .= ' #__records_rekord_person as rp, ';
        $query .= ' #__records_person as person ';
        $query .= 'where rp.person_id = person.id ';
        $query .= 'and record_id = '.$record_id;
        
        $db->setQuery($query);
        $person = $db->loadObjectList();
        
        $name='';
        foreach ($person as $p)
        {
            if($name <> '')
                $name .= '<br />';
                $name .= $p->firstname.' '.$p->surname;
        }

        return $name;
    }
    
    function getHistory()
    {
        $app = Factory::getApplication();
        $user    = $app->getIdentity();
        
        $this->_id = $app->input->getString('id', NULL);
        
        if(!$this->_records)
        {
            $db = $this->getDBO();
            
            $query = $this->getHistoryRecordQuery();
            $db->setQuery($query);
            $records = $db->loadObject();
            
            $this->_competition_id = $records->competition_id;
            $this->_agegroup_id = $records->agegroup_id;
            
            $query = $this->getHistoryQuery();
            $db->setQuery($query);
            $records = $db->loadObjectList();
            
            foreach($records as $record) :
                $record->date = $record->date1;
            
                if($record->date1 <> $record->date3) :
                    $record->date = substr($record->date1,0,3).'/'.$record->date3;
                else :
                    $record->date = $record->date1;
                endif;
            
                $record->person = $this->getRecordPerson($record->record_id);
                
                if ($user->authorise('records.create', 'com_records')) :
                    $record->allowedit = 1;
                else :
                    $record->allowedit = 0;
                endif;
            endforeach;
            
            
            
            $this->_records = $records;
        }
        
        return $this->_records;
    }
    
    function getNameRecordQuery()
    {
        $app = Factory::getApplication();
        $phrase = $app->input->getString('phrase', NULL);
        
        $sql = 'SELECT distinct surname, firstname FROM #__records_person '.
            'where surname like "%'.$phrase.'%" '.
            'or firstname like "%'.$phrase.'%" '.
            'or concat(surname,", ",firstname) like "%'.$phrase.'%"'.
            'or concat(firstname," ",surname) like "%'.$phrase.'%"';
        
        return $sql;
        
    }
    
    function getAthleteName()
    {
        $db = $this->getDBO();
        
        $query = $this->getNameRecordQuery();
        $db->setQuery($query);
        
        $names = $db->loadObjectList();

        $gender = "M"; // ToDo
        $year = "2007"; // ToDo
        foreach($names as $name)
        {
//            $json[] = array('name' => utf8_encode($name->surname).', '.utf8_encode($name->firstname), 'surname' => utf8_encode($name->surname), 'firstname' => utf8_encode($name->firstname), 'gender' => utf8_encode($gender), 'year' => utf8_encode($year));
            $json[] = array('name' => $name->surname.', '.$name->firstname, 'surname' => $name->surname, 'firstname' => $name->firstname, 'gender' => $gender, 'year' => $year);
            
        }
        
        return $json;
        
    }
    
    
}

?>