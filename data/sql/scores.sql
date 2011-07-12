-- stores all scores they are reached yet
CREATE TABLE `scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned NOT NULL DEFAULT 1,
  `score` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `changed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_created_by_account` (`created_by` ASC),
  CONSTRAINT `fk_created_by_account`
    FOREIGN KEY (`created_by`)
    REFERENCES `accounts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `score_id` bigint unsigned NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `changed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_user_id_account` (`user_id` ASC),
  INDEX `fk_score_scores` (`score_id` ASC),
  CONSTRAINT `fk_user_id_account`
    FOREIGN KEY (`user_id`)
    REFERENCES `accounts` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_score_scores`
    FOREIGN KEY (`score_id`)
    REFERENCES `scores` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

