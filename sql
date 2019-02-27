CREATE TABLE `urls` (
  `id` int(11) NOT NULL,
  `small` varchar(128) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `urls`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;