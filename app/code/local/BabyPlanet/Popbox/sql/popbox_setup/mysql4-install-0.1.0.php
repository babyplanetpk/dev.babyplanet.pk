<?php
  
$installer = $this;
  
$installer->startSetup();
  
$installer->run("
  
-- DROP TABLE IF EXISTS {$this->getTable('popbox')};
CREATE TABLE {$this->getTable('popbox')} (
  `popbox_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`popbox_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
    ");

$installer->run("
  
-- DROP TABLE IF EXISTS {$this->getTable('popboxUser')};
CREATE TABLE {$this->getTable('popboxUser')} (
  `popbox_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `child_name` varchar(255) NOT NULL default '',
  `child_dob` datetime NULL,
  `child_gender` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  PRIMARY KEY (`popbox_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
    ");
  
$installer->endSetup();
