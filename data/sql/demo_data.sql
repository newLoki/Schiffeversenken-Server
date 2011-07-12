-- Admin user (can not logged in, because he have no email)
INSERT INTO `accounts` (`id`, `name`, `email`, `password`, `created_at`)
  VALUES (1, 'Admin', NULL, NULL, NOW());

-- First scores
INSERT INTO `scores` (`id`, `created_by`, `score`, `created_at`, `changed_at`)
  VALUES (1, 1, 0, NOW(), NOW());
INSERT INTO `scores` (`id`, `created_by`, `score`, `created_at`, `changed_at`)
  VALUES (2, 1, 1337, NOW(), NOW());

-- First user scores
INSERT INTO `user_scores` (`user_id`, `score_id`, `created_at`,`changed_at`)
  VALUES (1, 1, NOW(), NOW());
INSERT INTO `user_scores` (`user_id`, `score_id`, `created_at`,`changed_at`)
  VALUES (1, 2, NOW(), NOW());