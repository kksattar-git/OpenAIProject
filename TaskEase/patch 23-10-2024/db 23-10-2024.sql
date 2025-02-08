INSERT INTO `departments` (`department_id`, `department_name`) VALUES (NULL, 'Task Creator');
ALTER TABLE `tasks` CHANGE `uid` `uid` INT NULL DEFAULT NULL;
ALTER TABLE `tasks` CHANGE `department_id` `department_id` INT NULL DEFAULT NULL;
ALTER TABLE `tasks` ADD `creator_type` VARCHAR(255) NULL COMMENT 'admin/creator/user' AFTER `current_assigne`;