CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `vendor` int(11) NOT NULL DEFAULT '4',
  `license` varchar(50) NOT NULL DEFAULT '',
  `status` varchar(150) NOT NULL DEFAULT 'neu eingetragen',
  `price` double NOT NULL DEFAULT '0',
  `url_info` varchar(255) NOT NULL,
  `url_download` varchar(255) NOT NULL DEFAULT '',
  `url_picture` varchar(255) NOT NULL DEFAULT '',
  `url_recipe` varchar(255) NOT NULL DEFAULT '',
  `shop_versions` varchar(150) NOT NULL DEFAULT '',
  `module_version` varchar(10) NOT NULL DEFAULT '',
  `mapping_src` varchar(150) NOT NULL DEFAULT '',
  `mapping_dest` varchar(150) NOT NULL DEFAULT '',
  `tags` text,
  `desc_de` text,
  `desc_en` text,
  `notice` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `module_id` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_info` (`url_info`),
  KEY `vendors` (`vendor`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

ALTER TABLE `modules` ADD CONSTRAINT `modules_vendors` FOREIGN KEY (`vendor`) REFERENCES `vendors` (`id`);