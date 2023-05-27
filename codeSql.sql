CREATE TABLE membres (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pseudo VARCHAR(255) NOT NULL,
  pass VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  date_inscription DATE NOT NULL,
  avatar VARCHAR(255),
  theme VARCHAR(50),
  ville VARCHAR(255),
  travail VARCHAR(255),
  passions TEXT,
  date_naissance DATE
);
