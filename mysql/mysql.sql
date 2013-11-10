DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
	`comment_id` int(16) NOT NULL AUTO_INCREMENT,
	`datetime` bigint(64) NOT NULL,
	`approved` enum('y','n') NOT NULL DEFAULT 'y',
	`user_id` int(64) NOT NULL DEFAULT '0',
	`name` varchar(64) NOT NULL,
	`email` varchar(64) NOT NULL,
	`comment` longtext NOT NULL,
	PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36;

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
	`image_id` int(11) NOT NULL AUTO_INCREMENT,
	`comment_id` int(16) NOT NULL,
	`name` varchar(30) NOT NULL,
	`type` varchar(30) NOT NULL,
	`size` int(11) NOT NULL,
	`content` longblob NOT NULL,
	`full` blob NOT NULL,PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=143 ;


DROP TABLE IF EXISTS `perameters`;
CREATE TABLE IF NOT EXISTS `perameters` (
	`key` varchar(32) NOT NULL,
	`value` varchar(320) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
