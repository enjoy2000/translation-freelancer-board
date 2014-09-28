INSERT INTO `papertask`.`UserGroup` (`name`) VALUES ('Freelancer');
INSERT INTO `papertask`.`UserGroup` (`name`) VALUES ('Employer');
INSERT INTO `papertask`.`UserGroup` (`name`) VALUES ('Admin');

INSERT INTO `papertask`.`ResourceGroup` (`name`) VALUES ('Translation');
INSERT INTO `papertask`.`ResourceGroup` (`name`) VALUES ('Desktop Publishing');
INSERT INTO `papertask`.`ResourceGroup` (`name`) VALUES ('Interpreting');

INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('1', 'Translator');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('1', 'Proofreader');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('2', 'Desktop Publishing');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('3', 'Simultaneous');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('3', 'Consecutive');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('3', 'Business Escort');
INSERT INTO `papertask`.`Resource` (`group_id`, `name`) VALUES ('3', 'Tourism Escort');
