<?php

namespace TSV\Component\Records\Site\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Language\Text;


/**
 * @package     Joomla.Site
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 John Smith. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

/**
 * Hello World Message Model
 * @since 0.0.5
 */
class RecordModel extends ItemModel 
{
    protected $record_id = 0;
    protected $record;
    
    protected function populateState()
    {
        $app = Factory::getApplication();
        
        $pk = $app->input->getInt('record_id');
        $this->setState('records.id', $pk);

    }
    
    function initRecord()
    {
        $app = Factory::getApplication();
        $competition_id = $app->input->getLong('competition_id');
        $agegroup_id = $app->input->getLong('agegroup_id');
        $db = $this->getDbo();
        
        $sql = 'select * from #__records_competition where id = '.$competition_id;
        $db->setQuery($sql);
        $competition = $db->loadObject();
        
        $sql = 'select * from #__records_agegroup where id = '.$agegroup_id;
        $db->setQuery($sql);
        $agegroup = $db->loadObject();
        
        // Lets load the content if it doesn't already exist
            $record = new \stdClass();
            $record->id					= 0;
            $record->competition_id		= $competition_id;
            $record->agegroup_id		= $agegroup_id;
            $record->nr					= 0;
            $record->result				= null;
            $record->date				= null;
            $record->date2				= null;
            $record->location			= null;
            $record->person				= null;
            $record->agegroup_name      = $agegroup->agegroup_name;
            $record->agegroup_shorttext = $agegroup->agegroup_shorttext;
            $record->competition_name   = $competition->competition_name;
            $record->competition_text   = $competition->competition_text;
            $record->measurement        = $competition->measurement;
            $this->record				= $record;
            
            return $record;

    }
    
    function getPerson($Surname, $Firstname, $Year)
    {
        if($Surname == '')
            return null;
            
            $Surname = trim($Surname);
            $Firstname = trim($Firstname);
            
            $query = 'select * from #__records_person ';
            $query .= 'where surname = "'.$Surname.'" ';
            $query .= 'and firstname = "'.$Firstname.'" ';
            $query .= 'and year = '.$Year;
            
            //$log =&JLog::getInstance();
            //$log->addEntry((array('comment'=> $query)));
            
            
            $db = $this->getDbo();
            $db->setQuery($query);
            $person = $db->loadObjectList();
            
            if($person)
            {
                return $person;
            }
            else
            {
                $query2 = 'insert into #__records_person (surname, firstname, year) values (';
                $query2 .= '"'.$Surname.'", ';
                $query2 .= '"'.$Firstname.'", ';
                $query2 .= ''.$Year.'); ';
                
                $db->setQuery($query2);
                $db->execute();
                
                /*if($db->getErrorNum())
                {
                    echo "Fehler";
                    echo '<p>x'.$db->getErrorMsg().'x</p>';
                }*/
                
                $db->setQuery($query);
                $person = $db->loadObjectList();
                
                return $person;
            }
    }
    
    
    function insertRecordPerson($record_id, $person_id)
    {
        $db = $this->getDbo();
        
        $query = 'insert into #__records_rekord_person (record_id, person_id) values (';
        $query .= $record_id.', ';
        $query .= $person_id.') ';
     
        $db->setQuery($query);
        $db->execute();
    }
    
    
    function insert($record)
    {
        $app = Factory::getApplication();
        $user=$app->getIdentity();
        
        $db = $this->getDBO();
        
        // gibt es schon einen Rekord, dann verschieben?
        $sql = "select max(nr) as max from #__records_record where ".
            "competition_id = ".$record->competition_id.
            " and agegroup_id = ".$record->agegroup_id.
            " group by competition_id, agegroup_id ";

        $db->setQuery($sql);
        $max = $db->loadObject();
        
        $maxnr = ((int)$max->max);
        
        if($maxnr == -1)
        {
            $sql = "delete from #__records_record where ".
                "competition_id = ".$record->competition_id.
                " and agegroup_id = ".$record->agegroup_id.
                " and nr = -1; ";
            
            $db->setQuery($sql);
            $db->execute();
        }
        
        $maxnr = $maxnr + 1;

        $sql = "select id from #__records_record where ".
            "competition_id = ".$record->competition_id.
            " and agegroup_id = ".$record->agegroup_id.
            " and nr = 0";
        $db->setQuery($sql);
        $old_record = $db->loadObjectList();
        
        foreach($old_record as $o)
        {
            $sql = "update #__records_record set nr = ".$maxnr.
                " where id = ".$o->id;
        
            $db->setQuery($sql);
            $db->execute();
        }
        
        // und dann einfügen
        $sql = "insert into #__records_record (competition_id, agegroup_id, nr, maxnr, result, date, date2, location, modified, modified_by,created,author_ip,created_by) values (".
            $record->competition_id.", ".
            $record->agegroup_id.", ".
            "0, ".
            $maxnr.", ".
            "'".$record->result."',".
            "'".$record->date."',".
            "'".$record->date2."',".
            "'".$record->location."', ".
            "'".$db->getNullDate()."', ".
            "0, ".
            "'".gmdate('Y-m-d H:i:s')."', ".
            "'', ".
            $user->id.")";

        $db->setQuery($sql);
        $db->execute();
            
        $record_id = $db->insertid();    
               
        $app->enqueueMessage('inserted', 'Notice');
      
        return $record_id;
    }
    
    function update($record)
    {
        $app = Factory::getApplication();
        $db = $this->getDBO();
        
        $app->enqueueMessage('update'.$this->getState('records.id'), 'Notice');
        
        $sql = "update #__records_record set".
            " result = '".$record->result."', ".
            "date = '".$record->date."', ".
            "date2 = '".$record->date2."', ".
            "location = '".$record->location."' ".
            "where id = ".$record->id;
        
        $db->setQuery($sql);
        $db->execute();
        dump($sql);
    }
    
    function save($record)
    {
        $app = Factory::getApplication();
        $db = $this->getDBO();
        
        $record_id = $record->id;
        
        if($record_id == 0)
            $record_id = $this->insert($record);
        else
            $this->update($record);
        
        $query = 'delete from #__records_rekord_person where record_id = '.$record_id;
        $db->setQuery($query);
        $db->execute();
            
        $person = explode(';', $record->person);
            
        foreach($person as $p) 
        {
            if($p != '')
            {
                $name = explode(',', $p);
                $nachname = $name[0];
                $vorname = $name[1];
                $pers = $this->getPerson($nachname, $vorname, 0);
                
                $this->insertRecordPerson($record_id, $pers[0]->id);
            }
        }

        return $record_id;
    }
    
    function getRecordId() : int
    {
        
        return (int) $this->getState('records.id');
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
                $name .= '; ';
                $name .= $p->surname.', '.$p->firstname;
        }
        
        return $name;
    }
    
    /**
     * Returns a message for display
     * @param integer $pk Primary key of the "message item", currently unused
     * @return object Message object
     */
    public function getItem($pk= null): object 
    {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState('records.id');
        
        if($pk == 0)
        {
            $record = $this->initRecord();
        }
        
        else 
        {
        
        try
        {
            $db = $this->getDbo();
            $query = $db->getQuery(true)
            ->select(
                $this->getState(
                    'item.select', 'record.id as record_id, record.*, competition.*, agegroup.* '
                    )
                );
            $query->from($db->quoteName('#__records_record', 'record'))
            ->where('record.id = ' . (int)$pk)
            ->join('inner', '#__records_competition as competition on record.competition_id = competition.id')
            ->join('inner', '#__records_agegroup as agegroup on record.agegroup_id = agegroup.id');
         
            $db->setQuery($query);
            
            $record = $db->loadObject();
            
            $record->person = $this->getRecordPerson((int)$pk);
//dump($record);           
            if (empty($record))
            {
                throw new \Exception(Text::_('COM_MYWALKS_ERROR_WALK_NOT_FOUND'), 404);
            }
        }
        catch (\Exception $e)
        {
            if ($e->getCode() == 404)
            {
                // Need to go through the error handler to allow Redirect to work.
                throw new \Exception($e->getMessage(), 404);
            }
            else
            {
                $this->setError($e);
                $this->_item[$pk] = false;
            }
        }
        }
        
        return $record;
    }
    
}?>