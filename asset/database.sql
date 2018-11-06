-- Create syntax for TABLE 'oauth_access_token'
CREATE TABLE `oauth_access_token` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `session_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime DEFAULT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_access_token_scope'
CREATE TABLE `oauth_access_token_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `access_token_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token_id` (`access_token_id`,`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_auth_code'
CREATE TABLE `oauth_auth_code` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `session_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime DEFAULT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_auth_code_scope'
CREATE TABLE `oauth_auth_code_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `auth_code_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `auth_code_id` (`auth_code_id`,`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_client'
CREATE TABLE `oauth_client` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `secret` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_client_endpoint'
CREATE TABLE `oauth_client_endpoint` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `client_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_client_grant'
CREATE TABLE `oauth_client_grant` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `client_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_client_scope'
CREATE TABLE `oauth_client_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `client_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`,`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_grant'
CREATE TABLE `oauth_grant` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `type` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_grant_scope'
CREATE TABLE `oauth_grant_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `grant_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grant_id` (`grant_id`,`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_refresh_token'
CREATE TABLE `oauth_refresh_token` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `access_token_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime DEFAULT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `access_token` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_scope'
CREATE TABLE `oauth_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `code` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_session'
CREATE TABLE `oauth_session` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `client_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `client_redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Create syntax for TABLE 'oauth_session_scope'
CREATE TABLE `oauth_session_scope` (
  `id` INT(10) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT,
  `session_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` INT(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_by` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified_on` INT(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`,`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;