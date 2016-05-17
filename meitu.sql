CREATE TABLE `users` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(10) UNIQUE NOT NULL,
	`password` varchar(20) NOT NULL,
	`avatar` varchar(255) NOT NULL,
	`token` varchar(128) NOT NULL,
	`expire` int(11),

	PRIMARY KEY (`id`)
);
