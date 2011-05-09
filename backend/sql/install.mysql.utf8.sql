DROP TABLE IF EXISTS `#__ask`;

CREATE TABLE `#__ask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `submitted` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `userid_creator` int(11) NOT NULL,
  `userid_modifier` int(11) DEFAULT NULL,
  `question` int(11) NOT NULL,
  `votes_possitive` int(11) NOT NULL,
  `votes_negative` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `impressions` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(3) NOT NULL,
  `chosen` int(11) NOT NULL,
  `name` text,
  `ip` text,
  `email` text,
  `catid` int(11) NOT NULL DEFAULT '0',
  `users_voted` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__ask` (
`id` ,
`title` ,
`text` ,
`submitted` ,
`modified` ,
`userid_creator` ,
`userid_modifier` ,
`question` ,
`votes_possitive` ,
`votes_negative` ,
`parent` ,
`impressions` ,
`published` ,
`chosen` ,
`name`,
`ip`,
`email`,
`catid`
)
VALUES (
'1', 'Sample Question', 'Sample Question Text', '2011-03-01 20:56:09', NULL , '0', NULL , '1', '0', '0', '0', '0', '1', '0', 'Alexandros', '127.0.0.1', 'example@example.com', '0'
), (
'2', 'Sample Answer', 'Sample Answer Text', '2011-03-01 20:56:55', NULL , '0', NULL , '0', '0', '0', '1', '0', '1', '0', 'Alexandros', '127.0.0.1', 'example@examle.com', '0'
);
