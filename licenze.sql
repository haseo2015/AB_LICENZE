/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : licenze

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-04-18 22:14:24
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ab_licenze`
-- ----------------------------
DROP TABLE IF EXISTS `ab_licenze`;
CREATE TABLE `ab_licenze` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NL` varchar(32) NOT NULL DEFAULT '' COMMENT 'Numero di Licenza',
  `NU` varchar(255) DEFAULT NULL COMMENT 'Nome Utente',
  `NA` tinyint(1) unsigned DEFAULT NULL COMMENT 'Numero Attivazioni',
  `NAMAX` int(11) unsigned DEFAULT '2' COMMENT 'Numero Attivazioni Massime',
  `attivo` tinyint(1) DEFAULT '-1',
  `data_modifica` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`NL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ab_licenze
-- ----------------------------
INSERT INTO ab_licenze VALUES ('1', 'Zr7Op9wZ', '1234', '2', '2', '1', '2016-04-18 21:51:10');
INSERT INTO ab_licenze VALUES ('2', 'WQIZ8wlq', '2345', '3', '10', '-1', '2016-04-18 22:13:41');
INSERT INTO ab_licenze VALUES ('3', 'odoONdhy', null, null, '2', '-1', null);
INSERT INTO ab_licenze VALUES ('4', 'Q9CHR6Vq', null, null, '2', '1', '2016-04-18 22:04:59');
