CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `pets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `gender` char(1) DEFAULT 'm',
  `breed` varchar(255) DEFAULT NULL,
  `image_url` text,
  `age` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  `is_adopted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
);

CREATE TABLE `donations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` double DEFAULT '0',
  `message` text,
  PRIMARY KEY (`id`)
);

CREATE TABLE `adoptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pet_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `pets` VALUES (1,'Rocky','Dog','m','Chihuhua','https://teckelsanimalsanctuaries.co.uk/wp-content/uploads/2021/12/patch.jpeg','3 years',1,0),(2,'Laly','Cat','m','Persian','https://teckelsanimalsanctuaries.co.uk/wp-content/uploads/2023/03/E226817A-83D3-4243-B5DB-E1F8D4A505CE-scaled.jpeg','2 years',1,0),(3,'Fluffy','Dog','m','Doberman','https://teckelsanimalsanctuaries.co.uk/wp-content/uploads/2022/07/IMG_1349-scaled.jpeg','1 year',1,0),(4,'Amy','Cat','m','Sfinx','https://tse4.mm.bing.net/th?id=OIP.qKgYNxT4UYyAV3PWak6aOAHaNM&pid=Api&P=0','8 months',1,0);