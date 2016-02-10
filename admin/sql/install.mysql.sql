CREATE TABLE IF NOT EXISTS `#__jvcounter` 
( 
	`time` int unsigned NOT NULL,
	`visits` mediumint unsigned NOT NULL DEFAULT '0',
	`guests` mediumint unsigned NOT NULL DEFAULT '0',
	`members` mediumint unsigned NOT NULL DEFAULT '0',
	`bots` mediumint unsigned NOT NULL DEFAULT '0',
	UNIQUE KEY (`time`) 
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 
