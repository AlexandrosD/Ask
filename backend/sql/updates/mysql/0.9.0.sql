ALTER TABLE `#__ask` ADD `ip` text;
ALTER TABLE `#__ask` ADD `email` text;
ALTER TABLE `#__ask` ADD `catid` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `#__ask` ADD `users_voted` text;
ALTER TABLE `#__ask` ADD `tags` text;