CREATE TABLE `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pseudo` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` date NOT NULL
);
