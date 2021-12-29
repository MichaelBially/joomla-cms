


CREATE TABLE `#__records_agegroup` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `agegroup_name` varchar(30) NOT NULL,
 `agegroup_shorttext` varchar(5) NOT NULL,
 `beginning` int(11) NOT NULL,
 `ending` int(11) NOT NULL,
 `agegroup_sortkz` int(11) NOT NULL,
 `gender` varchar(1) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

CREATE TABLE `#__records_competition` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `typ_id` int(11) NOT NULL,
 `stadion` varchar(1) NOT NULL COMMENT 'Halle oder Freiluft',
 `competition_name` varchar(30) NOT NULL,
 `competition_description` varchar(100) NOT NULL,
 `competition_text` varchar(50) NOT NULL,
 `competition_shorttext` varchar(30) NOT NULL,
 `measurement` varchar(10) NOT NULL,
 `competition_sortkz` int(11) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=820 DEFAULT CHARSET=utf8;

CREATE TABLE `#__records_competitiontype` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `type_name` varchar(30) NOT NULL,
 `type_shorttext` varchar(5) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `#__records_person` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `surname` varchar(30) NOT NULL,
 `firstname` varchar(30) NOT NULL,
 `year` int(11) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8;


CREATE TABLE `#__records_record` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `competition_id` int(11) NOT NULL,
 `agegroup_id` int(11) NOT NULL,
 `nr` int(11) NOT NULL,
 `maxnr` int(11) NOT NULL,
 `result` varchar(10) NOT NULL,
 `date` date NOT NULL,
 `date2` date NOT NULL,
 `location` varchar(30) NOT NULL,
 `modified` datetime NOT NULL,
 `modified_by` int(11) NOT NULL,
 `created` datetime NOT NULL,
 `author_ip` varchar(15) NOT NULL,
 `created_by` int(11) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4783 DEFAULT CHARSET=utf8;

CREATE TABLE `#__records_rekord_person` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `record_id` int(11) NOT NULL,
 `person_id` int(11) NOT NULL,
 UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7552 DEFAULT CHARSET=utf8;


