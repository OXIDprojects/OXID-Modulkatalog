CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `vendor` int(11) NOT NULL,
  `license` varchar(50) NOT NULL DEFAULT '',
  `price` float DEFAULT NULL,
  `url_info` varchar(255) NOT NULL,
  `url_download` varchar(255) NOT NULL,
  `url_picture` varchar(255) NOT NULL,
  `url_recipe` varchar(255) NOT NULL,
  `shop_versions` varchar(150) NOT NULL DEFAULT '',
  `module_version` varchar(10) NOT NULL DEFAULT '',
  `mapping_src` varchar(150) NOT NULL,
  `mapping_dest` varchar(150) NOT NULL,
  `tags` text NOT NULL,
  `desc_de` text NOT NULL,
  `desc_en` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vendors` (`vendor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

ALTER TABLE `modules`
  ADD CONSTRAINT `modules_vendors` FOREIGN KEY (`vendor`) REFERENCES `vendors` (`id`);