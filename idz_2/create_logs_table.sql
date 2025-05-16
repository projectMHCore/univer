-- Создание таблицы для логирования запросов

CREATE TABLE IF NOT EXISTS `request_logs_idz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_time` datetime NOT NULL,
  `browser` text NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `request_type` varchar(50) NOT NULL,
  `request_params` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
