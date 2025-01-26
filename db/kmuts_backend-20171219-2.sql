/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.15-log : Database - kmuts_backend
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kmuts_backend` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `kmuts_backend`;

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_title_unique` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_user_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`user_id`,`role_id`) values (1,1),(2,8),(3,8),(4,8),(11,8);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_roles` varchar(32) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `code_roles` (`code_roles`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`code_roles`,`name`,`display_name`,`description`,`created_at`,`updated_at`) values (1,'1','admin','Administrator','Only one and only admin','2017-11-07 19:54:18','2017-11-07 19:54:18'),(2,'2','main_docter','Dokter Utama','For monitoring all process and docter privilage','2017-11-07 19:54:18','2017-11-07 19:54:18'),(3,'3','docter','Dokter','Dokter Privileges',NULL,NULL),(4,'4','surgeon','Ahli Bedah','Surgeon Privileges',NULL,NULL),(5,'5','visus','Visus Man','Visus Man Privileges',NULL,NULL),(6,'6','operator','Operator Klinik','Operator Privileges',NULL,NULL),(7,'7','laborant','Laboran','Laboran Privileges',NULL,NULL),(8,'8','patient','Pasien','Patient Privileges',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code_user` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `code_user` (`code_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`code_user`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'ADM-5A0D4M5IFN500','admin1@local.local','$2y$10$U0Kh5gt6b6VbJeT1PCjRVuDsZdRRl976/L0pDlUxdty/9euWk6DTm','DfmKzoeZTDrDz2Hg8i7ayzq1SAEOm43Ac0NR6LJjd8FVAC8hs5O6jq0e4e1f','2017-11-07 19:54:18','2017-11-07 19:54:18'),(2,'USR-5A0B4850F35D4','muhammad.agya7@gmail.com','$2y$10$HCUREqflBo7TBqgpmwIu1eBmM9LDfW8IBhWq7O6p0z1tcTxvgiLua',NULL,'2017-11-14 19:47:43','2017-11-14 19:47:43'),(3,'USR-5A0F2583EFB15','asd@asd.asda','$2y$10$nh8Wn1sEp3WuxeMGpIeSLuRJ/QDDG05ooQVhwzq2qwIIIZpwmiBxK',NULL,'2017-11-17 18:08:08','2017-11-17 18:08:08'),(4,'USR-5A17880B3FE3F','asd@asd.asd','$2y$10$7HVm9yLjdfB/5dQv9fIB8uD1avha2q5b5E6FGf0zDMafLtFci2Cru',NULL,'2017-11-24 02:46:44','2017-11-24 02:46:44'),(6,'USR-5A17880B3FE3G','zxc@cvb.ee','$2y$10$U0Kh5gt6b6VbJeT1PCjRVuDsZdRRl976/L0pDlUxdty/9euWk6DTm',NULL,NULL,NULL),(8,'USR-5A0F2583EFB14','yui@fdgh.uk','$2y$10$nh8Wn1sEp3WuxeMGpIeSLuRJ/QDDG05ooQVhwzq2qwIIIZpwmiBxK',NULL,'2017-11-17 18:08:08','2017-11-17 18:08:08'),(10,'USR-5A17880B3FE35','asd@asd.asdax','$2y$10$7HVm9yLjdfB/5dQv9fIB8uD1avha2q5b5E6FGf0zDMafLtFci2Cru',NULL,'2017-11-24 02:46:44','2017-11-24 02:46:44'),(11,'USR-5A17898477832','wer@asd.sad','$2y$10$FNl/A35Z1zQ899AoTFQYBO.CnRghAmLssni4XX.aBB/FpmxM3elUK',NULL,'2017-11-24 02:52:58','2017-11-24 02:52:58');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
