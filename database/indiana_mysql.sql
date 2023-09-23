INSERT INTO `roles` (`id`, `role_name`, `permission`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'Report', '[\"20\",\"21\"]', '1', '0', '0', NULL, '2022-08-12 05:44:45', '2022-08-29 15:47:03');

INSERT INTO `admins` (`id`, `admin_name`, `nick_name`, `email`, `country_id`, `phone`, `password`, `address`, `role_id`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'Report User', 'RR', 'reportuser@indianagroup.com', '1', '9987807870', '07da12bf16696ba7488ebb48e41c0c9b', 'Address', '7', '1', '0', '0', NULL, '2022-08-12 05:45:05', '2022-11-23 07:01:34');

INSERT INTO `engineer_statuses` (`id`, `engineer_status_name`, `engineer_status_code`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'HOLD', 'HOLD', '1', '0', '0', NULL, '2022-08-18 19:21:16', '2022-08-18 19:21:16');

#Categories
INSERT INTO `categories` (`id`, `category_name`, `category_code`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'HK', 'HK', '1', '0', '0', NULL, '2022-08-12 18:24:46', '2022-08-12 18:24:46');

INSERT INTO `categories` (`id`, `category_name`, `category_code`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'GK', 'GK', '1', '0', '0', NULL, '2022-08-12 18:24:46', '2022-08-12 18:24:46');

INSERT INTO `categories` (`id`, `category_name`, `category_code`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'IK', 'IK', '1', '0', '0', NULL, '2022-08-12 18:24:46', '2022-08-12 18:24:46');

#Permissions
INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (24, 'Enquiry Remark', 'enquiry_remark', '7', '', 'Yes', '2022-06-16 07:12:23', '2022-08-19 12:13:35');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (25, 'Daily Remark', 'daily_remarks', 'parent', '', 'Yes', '2022-06-16 01:42:23', '2023-02-03 08:39:18');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (26, 'view', 'remark_view', '25', '', 'Yes', '2022-06-16 01:42:23', '2022-08-19 06:43:45');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (27, 'Edit', 'remark_edit', '25', '', 'Yes', '2022-06-16 01:42:23', '2022-06-16 01:48:57');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (28, 'status', 'remark_status', '25', '', 'Yes', '2022-06-16 01:42:23', '2022-08-19 06:43:45');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (29, 'delete', 'remark_delete', '25', '', 'Yes', '2022-06-16 01:42:23', '2022-08-19 06:43:45');

INSERT INTO `permissions` (`id`, `name`, `codename`, `parent_status`, `description`, `status`, `created_at`, `updated_at`) VALUES (30, 'add', 'remark_add', '25', '', 'Yes', '2022-06-16 01:42:23', '2022-08-19 06:43:45');


UPDATE `roles` SET `permission` = '[\"7\",\"9\",\"10\",\"11\"]' WHERE `roles`.`id` = 3 LIMIT 1;
UPDATE `roles` SET `permission` = '[\"7\",\"9\",\"10\",\"11\",\"18\",\"21\",\"24\",\"25\",\"26\",\"27\",\"30\"]' WHERE `roles`.`id` = 5 LIMIT 1;
UPDATE `roles` SET `permission` = '[\"7\",\"9\",\"10\",\"21\"]', `deleted_at` = NULL WHERE `roles`.`id` = 6 LIMIT 1;

-- added on 08-Feb-2023 by ritesh : start
UPDATE `roles` SET `permission` = '[\"7\",\"9\",\"10\"]' WHERE `roles`.`id` = 4 LIMIT 1;
-- added on 08-Feb-2023 by ritesh : end 

-- FIRED ON PRODUCTION TILL HERE on 08-Feb-2023 by RITESH

