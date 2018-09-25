SET NAMES utf8;

use ramverk1Proj;

DROP TABLE IF EXISTS `ramverk1ProjComment`;
DROP TABLE IF EXISTS `ramverk1ProjTags`;
DROP TABLE IF EXISTS `ramverk1Projquestion`;
DROP TABLE IF EXISTS `ramverk1ProjUsers`;



CREATE TABLE `ramverk1ProjUsers` (
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `username` VARCHAR(20) NOT NULL,
    `mail` VARCHAR(50) NOT NULL,
    `password` VARCHAR(100) NOT NULL
);

INSERT INTO `ramverk1ProjUsers` (`username`, `mail`, `password`) VALUES
	("Admin", "admin@hotmail.com", "$2y$10$S5bulswg2KEVtTLexkfWpeQNw7pWLs10XWBy96lUtk7BYMRQ0ZLpa"),
	("watel", "kewin_256@hotmail.com", "$2y$10$S5bulswg2KEVtTLexkfWpeQNw7pWLs10XWBy96lUtk7BYMRQ0ZLpa");


SELECT * FROM ramverk1ProjUsers;


CREATE TABLE `ramverk1ProjTags` (
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `name` VARCHAR(20) NOT NULL
);

INSERT INTO `ramverk1ProjTags` (`name`) VALUES
	("skeleton"),
    ("pumpkin"),
    ("witches"),
    ("scarecrow");

SELECT * FROM ramverk1ProjTags;

CREATE TABLE `ramverk1Projquestion` (
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `title` VARCHAR(20) NOT NULL,
    `content` VARCHAR(500) NOT NULL,
    `tagsId` INT NOT NULL,
    `userId` INT NOT NULL,

    FOREIGN KEY (`userId`) REFERENCES `ramverk1ProjUsers` (`id`)
);

INSERT INTO `ramverk1Projquestion` (`title`, `content`, `tagsId`, `userId`) VALUES
	("not scary", "skeletons don't scare me but witches do", 13, 1),
	("Spooky", "Milks make the bones strong", 1, 2);


SELECT * FROM ramverk1ProjUsers;


CREATE TABLE `ramverk1ProjComment` (
	`id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `content` VARCHAR(500) NOT NULL,
    `ques_id` INT NOT NULL,
    `user_id` INT NOT NULL,

    FOREIGN KEY (`ques_id`) REFERENCES `ramverk1Projquestion` (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `ramverk1ProjUsers` (`id`)
);

INSERT INTO `ramverk1ProjComment` (`content`, `ques_id`, `user_id`) VALUES
	("They scare me lol", 1, 2);


SELECT * FROM ramverk1ProjComment;
