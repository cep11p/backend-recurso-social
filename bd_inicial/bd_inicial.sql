-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: recursosocial
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB-1:10.4.17+maria~focal

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_data`
--

DROP TABLE IF EXISTS `audit_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` blob DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_audit_data_entry_id` (`entry_id`),
  CONSTRAINT `fk_audit_data_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `audit_entry` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18861 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_data`
--

LOCK TABLES `audit_data` WRITE;
/*!40000 ALTER TABLE `audit_data` DISABLE KEYS */;
INSERT INTO `audit_data` VALUES (18857,9225,'audit/request','x�uUَ�8��O3	f_�~`1	�$���,��p%H	0R�]��@*���|}��r��%�~%�aODΘd���%`�C]O���¢���0���{L�Fn_hLG��\"����꾣�(P��e\'����a�:�˻��� ���{y���R>p�!��WT��0ѫ���/��������w#O&w�EW�l���|�����b6C\'�	��tOح�oo	�x�17k�4�n�����7�˼oI��:/�%+�La��l�\r�´�\nUE�������-\r��%-D\n�\r;Rn_:�^9�ƻ[�pf~�+�P�I+^�]D��bsn&��kxwF}S�L��sɜw���|c���M���}���x�9銧f�sE�ee?�w�M���?m]w�ֹ�	n�����F斻e���p��\n\\�0]-�\r\0_Հ�����45÷������@w\\E��F {�\"C��d7\0��*�x��0Ô�ݟ�D�xC����,��+������tF�+n��n���dNٲ)�EIV�kn����U4�L�<W�C��#k:���Ԣ�$�犪[��\0���ja�(�T��\0�5M���Г�UF��-\\\0���Gl\\Y��^e����\r!SQ�8��:rHp{+�^�\'�N����_i�d�>\\��w��c�A�˳ߦ�;��2L�3��\"����JҵC?O�K\'*	���.���y�6��fN�L�^�͞��<C��G޳_L\0�i̑y����m3��xq�K�c�������y`3��X���I������o�6��(��R>E�/{��Y\Zn`�#�\n[ҁi(��isYWS����|�݁Cס�tc{J���ɰ�~���p��3��d�l	ӷ��Jķ�Ò���s��g�ۍ�Z\'�>���t���','2020-12-23 14:19:16'),(18858,9225,'audit/db','x���O�H���+Vy$Jwg;���)MNڗJ�������l�D���om�7����C���]�g�;��	<����z������{�������D��s�\n�7}?���]�F�t2��0��w���Q\\�LZd+�׏=b��/`\'�z�8�]>]$I�F����d�r$�GXIJ	�Ǡ�\0�����w�{����\\���/0J�VFq��a�T\\V6�M��֨�hxz���Ϸpy.ҼȂ8-fi�����e��p137&3ih�Y\\���7��U�qz�Ȓ���,��$x^��|�dG�N�(�����]�������R�p�p4WvT��0(���\Z��]�\'�g<3�|��e8O�g�,�qX-uXty�&ٲd}��I�+��T���~x1t�5@���:��AeM�h:ǈ�5�Sl���\r�����k�ӌ̷�1P�+E�ߊ���_��5Z��\Zm�AB�h�7%M����x:��D���Is�@~�X�?B~f�3�b����\"*���	\n������j8E5��pn�ty���OG��?���x��g����t�ܙ�Z�B� �v�\n	R(U����SLwD��bU\ZjV�ɪ��;���r�hJ����{��}���5r��5-�c���6sm5w\ZqL9�m�HL(�Z��{�V�)i���N��0��8�	���0�uGQ����rH\\�Dv��:�R�T��7*�\0;��}���P�(p�>I\\�\0��uH�m�\\ \0��F��V��G�����/G^�m���O_��֎�;�O\0����F\r;*�6[���8�*����CW��_��:<\n�KR��q��\rwB�j���9wT!���*������cW�!�vǬ4�6zCI�F���a�ݹ[���y�\"��ʦ�v:�.y�P7���RL�-��mu|�fo3�j��׳����X1���b-�f��v����fl7U^�\r��E��8@U�,���(u�hQX�e�;���l�UT��P���}Ps���&itrJ{����N,I�+�����2��N��k��I��A����d��l�w��MQ��cE�#����b���yݔ2�9J�p��c������yxx���P','2020-12-23 14:19:16'),(18859,9225,'audit/log','x��W[o�H~ϯ����3����M�JE�\n�}��{�x�m:�WAQ��ې�zX-����s���\\���L���,�*����L<G+^_d�rљ}�~C��ct=�}��Ї��g��\"��Jr��;�H`���!�G��l��{��~�ƱLB!~JoJA���P��$.��*m),��	V޹�=�)M�ar��L�*��t�\'\n�$QA��@�&���i��\n\n���,\r\"�Z��~�Ld�v��n���ծHa��]fn{�*��}����4�������GP\\�,�2J�E��b�����_��WZ%�\n�\\����{�g����>ձ,�,��Q�r\'����#CW3���O��Ĥ�Cmv֋2tJq�M\'�^�m��\\��4\0����f��h�&e^Mn�J�W��KA�I�LZH���ʣl�T�����vh�5@! [�L�*4���u��-�7����^�u�a��Td̳[�,b1�.��h�!�G���v�F���YP��i�+��Z��Y��U����J���U蟣�W���j�I��^���xT���&�E��\'f����-M���+Q�pNq�)w�U�!�T=Ktn u��F�+}�:\0����﷌k�mɢ?\r6��y�n��2��2���Ա0���\'�#Ʉ��� �M�N��;Jn�?�����5���N��H��q�?b�v<^����N�1v�]�2b7�y�k��G+hڧ��pf�C�M�JF��̡TV���c�ڃ�[�1mLg6��K�-�@G��d�9�8m\'PcI\r����VZ��t��f2���U�����Gƻz��9I�sB MMT8߆M�m�ΑT``^��	����P�bu�]م�����0i����a�����K�(X6�ƏXũ�@�}�P��e����B��~�%�?5��*//�\04�\0�','2020-12-23 14:19:16'),(18860,9225,'audit/profiling','x��Y]O�H}�W��H�ηg����*MV�/�c�mbS�YU���c�7ê1���HH<_��{�;v�3�k�K�37�4[v���I�Kʻ���N�M���kA�TXp�5%\Zڕ�����;��g��\Z��I�C���ѽI������4ILX�i��2�2��Ҽ�e&\\dy:��0f��]\'��<5T�-6o��v�ܧ��,��St���yb?��l_faK�<ƈ�T1����c��KiI8�>�;��eC�\\�][�(��Cg�����G��j0@���Շ���}@�`���$E��nZ����σ$��/S����A))d���\nP϶�\n� �:0yJx%&o��\Z@����=�����Y\'��:�h�a��\'�]�̍�L�hR�3�r���u�ܤ�<����᝙O�+�g9:�,��ct>t��l�O�/l0��8\Z\rK姃^�,�E=��u}t�m��C��hh�y2<{a�U��r�C��e�����YSn)���}���\"@v��DSNZ���coE�ٷм�&����puye�	�ņ����R�ꗢ)��(�i��x3G����U4��&$}>�/.���rT�.��4K���if`ͼ��Mq�F�J���0���u2���A��m83A���?B���s��b����2D�k���5Ǌ�y���0.��Jo3x�G=��}���Uw��T���*M+���Jc�s��_+�R���{������J�+��^�`\Z�9w6�	\"���`�a�(�D��g��7�\rex�R2��\"N��QbK2�uK^�Jm���p��U����Nu)h(��\Z�%اZ��	΃��Ė��i�����\"R;�J���A<{\"�-#���p�����m����v���=��\'�k�FM�T�}���38��\0���ɇ��hN�����=�j��(缢S?o��V�m������*A�݁nji��+�\r�qu;�Vz�	���� ���h�ܒL��R�J$��zc��7��V9�?��ei֢�aRǝ6h�LUR�C��Ԕ��]��\\	�^��-3�y��m\'�K\nprQ�:0�6��~ጹ�hYx�d�.�Y[^�#T8��y����4w��.�p��+&�JNi�s���	0��\"�/�4Zd��i�>���s\"��V�y��{��<Q��SF��iOS*^�8\";�h-����֩4v��X8v:(U�����_u��','2020-12-23 14:19:16');
/*!40000 ALTER TABLE `audit_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_entry`
--

DROP TABLE IF EXISTS `audit_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `duration` float DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `request_method` varchar(16) DEFAULT NULL,
  `ajax` int(1) NOT NULL DEFAULT 0,
  `route` varchar(255) DEFAULT NULL,
  `memory_max` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_route` (`route`)
) ENGINE=InnoDB AUTO_INCREMENT=9226 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_entry`
--

LOCK TABLES `audit_entry` WRITE;
/*!40000 ALTER TABLE `audit_entry` DISABLE KEYS */;
INSERT INTO `audit_entry` VALUES (9225,'2020-12-23 14:19:15',0,1.09204,NULL,'CLI',0,'audit/cleanup',7621008);
/*!40000 ALTER TABLE `audit_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_error`
--

DROP TABLE IF EXISTS `audit_error`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `message` text NOT NULL,
  `code` int(11) DEFAULT 0,
  `file` varchar(512) DEFAULT NULL,
  `line` int(11) DEFAULT NULL,
  `trace` blob DEFAULT NULL,
  `hash` varchar(32) DEFAULT NULL,
  `emailed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_audit_error_entry_id` (`entry_id`),
  KEY `idx_file` (`file`(180)),
  KEY `idx_emailed` (`emailed`),
  CONSTRAINT `fk_audit_error_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `audit_entry` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_error`
--

LOCK TABLES `audit_error` WRITE;
/*!40000 ALTER TABLE `audit_error` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_error` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_javascript`
--

DROP TABLE IF EXISTS `audit_javascript`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_javascript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `origin` varchar(512) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_audit_javascript_entry_id` (`entry_id`),
  CONSTRAINT `fk_audit_javascript_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `audit_entry` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_javascript`
--

LOCK TABLES `audit_javascript` WRITE;
/*!40000 ALTER TABLE `audit_javascript` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_javascript` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_mail`
--

DROP TABLE IF EXISTS `audit_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `successful` int(11) NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `cc` varchar(255) DEFAULT NULL,
  `bcc` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `text` blob DEFAULT NULL,
  `html` blob DEFAULT NULL,
  `data` longblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_audit_mail_entry_id` (`entry_id`),
  CONSTRAINT `fk_audit_mail_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `audit_entry` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_mail`
--

LOCK TABLES `audit_mail` WRITE;
/*!40000 ALTER TABLE `audit_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_audit_trail_entry_id` (`entry_id`),
  KEY `idx_audit_user_id` (`user_id`),
  KEY `idx_audit_trail_field` (`model`,`model_id`,`field`),
  KEY `idx_audit_trail_action` (`action`),
  CONSTRAINT `fk_audit_trail_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `audit_entry` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trail`
--

LOCK TABLES `audit_trail` WRITE;
/*!40000 ALTER TABLE `audit_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_trail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aula`
--

DROP TABLE IF EXISTS `aula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aula` (
  `recursoid` int(11) NOT NULL,
  `alumnoid` int(11) NOT NULL,
  PRIMARY KEY (`recursoid`,`alumnoid`),
  CONSTRAINT `fk_aula_recursoid` FOREIGN KEY (`recursoid`) REFERENCES `recurso` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aula`
--

LOCK TABLES `aula` WRITE;
/*!40000 ALTER TABLE `aula` DISABLE KEYS */;
/*!40000 ALTER TABLE `aula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('1_ver','2',1608731960),('3_ver','2',1608731968),('usuario','2',1608732824);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('1_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('1_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('1_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('1_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('2_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('2_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('2_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('2_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('3_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('3_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('3_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('3_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('4_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('4_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('4_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('4_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('5_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('5_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('5_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('5_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('6_acreditar',2,'Permite acreditar prestaciones de su programa',NULL,NULL,1608730687,NULL),('6_baja',2,'Permite dar de baja prestaciones de su programa',NULL,NULL,1608730687,NULL),('6_crear',2,'Permite crear una prestaciones de su programa',NULL,NULL,1608730687,NULL),('6_ver',2,'Permite ver prestaciones de su programa',NULL,NULL,1608730687,NULL),('admin',1,'Controla todo el sistema',NULL,NULL,1608216298,1608560794),('soporte',1,'Realiza operaciones de soporte',NULL,NULL,1608216343,1608560667),('usuario',1,'Puede efectuar funcionalidades administrativas',NULL,NULL,1608216429,1608726657);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1552672687),('m190724_153500_deleteProgramaHasTipoRecurso',1607700037),('m190730_144525_add_localidadid_to_recurso_social',1607700037),('m200411_221328_tipo_responsable',1607700037),('m200413_171649_responsable_entrega',1607700037),('m200413_181257_modulo_alimenticio',1607700037),('m200414_020356_programa_has_tipo_recurso',1607700037),('m200420_185346_fk_reponsable_to_tipo_responsable',1607700037),('m200421_071947_fix_table_responsable',1607700037),('m200421_230417_add_fecha_entrega_to_recurso',1607700037),('m200429_165019_programaColor',1607700037),('m201223_123304_permisos',1608730687);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa`
--

DROP TABLE IF EXISTS `programa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `color` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa`
--

LOCK TABLES `programa` WRITE;
/*!40000 ALTER TABLE `programa` DISABLE KEYS */;
INSERT INTO `programa` VALUES (1,'Subsidio',NULL,'#FF6B37'),(2,'Río Negro Presente',NULL,'#ABDF7D'),(3,'Emprender',NULL,'#FFC837'),(4,'Micro Emprendimiento',NULL,'#FFF637'),(5,'Hábitat',NULL,'#4AF9C1'),(6,'Modulo Alimenticio',NULL,'#7DDEFF');
/*!40000 ALTER TABLE `programa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa_has_tipo_recurso`
--

DROP TABLE IF EXISTS `programa_has_tipo_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa_has_tipo_recurso` (
  `tipo_recursoid` int(11) NOT NULL,
  `programaid` int(11) NOT NULL,
  PRIMARY KEY (`tipo_recursoid`,`programaid`),
  KEY `fk_tipo_recurso_has_programa_programa1_idx` (`programaid`),
  KEY `fk_tipo_recurso_has_programa_tipo_recurso1_idx` (`tipo_recursoid`),
  CONSTRAINT `fk_tipo_recurso_has_programa_programa1` FOREIGN KEY (`programaid`) REFERENCES `programa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipo_recurso_has_programa_tipo_recurso1` FOREIGN KEY (`tipo_recursoid`) REFERENCES `tipo_recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa_has_tipo_recurso`
--

LOCK TABLES `programa_has_tipo_recurso` WRITE;
/*!40000 ALTER TABLE `programa_has_tipo_recurso` DISABLE KEYS */;
INSERT INTO `programa_has_tipo_recurso` VALUES (1,1),(1,2),(2,2),(2,3),(2,4),(3,1),(3,2),(3,5),(4,6);
/*!40000 ALTER TABLE `programa_has_tipo_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso`
--

DROP TABLE IF EXISTS `recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicial` date NOT NULL,
  `fecha_alta` date NOT NULL,
  `monto` double NOT NULL,
  `observacion` text DEFAULT NULL COMMENT '\n',
  `proposito` text DEFAULT NULL,
  `programaid` int(11) NOT NULL,
  `tipo_recursoid` int(11) NOT NULL,
  `personaid` int(11) NOT NULL COMMENT 'Este atributo hace referencia a una persona del sistema Registral',
  `fecha_baja` date DEFAULT NULL,
  `fecha_acreditacion` date DEFAULT NULL,
  `descripcion_baja` text DEFAULT NULL,
  `localidadid` int(11) DEFAULT NULL COMMENT 'Este atributo hace referencia al sistema Lugar (interoperabilidad)',
  `responsable_entregaid` int(11) DEFAULT NULL,
  `cant_modulo` int(11) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL COMMENT 'Este atributo nos indica la fecha de entrega de la prestacion',
  PRIMARY KEY (`id`),
  KEY `fk_recurso_programa1_idx` (`programaid`),
  KEY `fk_recurso_tipo_recurso1_idx` (`tipo_recursoid`),
  CONSTRAINT `fk_recurso_programa1` FOREIGN KEY (`programaid`) REFERENCES `programa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_recurso_tipo_recurso1` FOREIGN KEY (`tipo_recursoid`) REFERENCES `tipo_recurso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsable_entrega`
--

DROP TABLE IF EXISTS `responsable_entrega`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responsable_entrega` (
  `tipo_responsableid` int(11) NOT NULL COMMENT 'esto nos permite tener multiples tipos de responsables. ej municipio, delegacion, comision de fomente,etc',
  `recursoid` int(11) NOT NULL AUTO_INCREMENT,
  `responsable_entregaid` int(11) DEFAULT NULL,
  PRIMARY KEY (`recursoid`),
  KEY `fk_tipo_responsableid` (`tipo_responsableid`),
  CONSTRAINT `fk_recurso` FOREIGN KEY (`recursoid`) REFERENCES `recurso` (`id`),
  CONSTRAINT `fk_tipo_responsableid` FOREIGN KEY (`tipo_responsableid`) REFERENCES `tipo_responsable` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsable_entrega`
--

LOCK TABLES `responsable_entrega` WRITE;
/*!40000 ALTER TABLE `responsable_entrega` DISABLE KEYS */;
/*!40000 ALTER TABLE `responsable_entrega` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_account`
--

LOCK TABLES `social_account` WRITE;
/*!40000 ALTER TABLE `social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_recurso`
--

DROP TABLE IF EXISTS `tipo_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_recurso`
--

LOCK TABLES `tipo_recurso` WRITE;
/*!40000 ALTER TABLE `tipo_recurso` DISABLE KEYS */;
INSERT INTO `tipo_recurso` VALUES (1,'Alimentación'),(2,'Empleo/Formación Laboral'),(3,'Mejora Habitacional'),(4,'Emergencia');
/*!40000 ALTER TABLE `tipo_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_responsable`
--

DROP TABLE IF EXISTS `tipo_responsable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_responsable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_responsable`
--

LOCK TABLES `tipo_responsable` WRITE;
/*!40000 ALTER TABLE `tipo_responsable` DISABLE KEYS */;
INSERT INTO `tipo_responsable` VALUES (1,'municipio'),(2,'delegacion'),(3,'comision de fomento');
/*!40000 ALTER TABLE `tipo_responsable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT 0,
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'admin','admin@correo.com','$2y$10$MnF9LJCnya.NrXIQBN4YGuRIdIuGtOSsGqqZTpby9RnFp7Chb4qEm','maXx0ibz2Br9UEfP06TVcltr0uOiWl4B',1556894840,NULL,NULL,'172.18.0.2',1556894840,1607700159,0,1608214173);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-23 14:20:22
