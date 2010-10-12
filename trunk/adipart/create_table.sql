DROP TABLE IF EXISTS `REQUESTS`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `REQUESTS` (
  `id` int(6) NOT NULL auto_increment,
  `username` char(20)  default NULL,
  `req_time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `status` set('generated','expired','pending') default NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;
