CREATE TABLE IF NOT EXISTS `imchat_msgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(32) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;