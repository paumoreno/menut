<?php

class Team extends DAO
{
    public $id;
    public $name;
    public $shortname;
    public $icon;
    public $position;
    
    public function getUrl()
    {
    	return Url::get().'team/'.Core::urlFriendly($this->shortname);
    }
}
