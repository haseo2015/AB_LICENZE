/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : licenze

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-04-18 07:28:09
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
  PRIMARY KEY (`id`,`NL`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ab_licenze
-- ----------------------------
INSERT INTO ab_licenze VALUES ('1', 'xHCKzW4Y', 'utentex', '1', '2', '-1');
INSERT INTO ab_licenze VALUES ('2', 'N3uGMikw', 'rrrr', '2', '2', '-1');
INSERT INTO ab_licenze VALUES ('3', 'e5u0YTmw', null, null, '2', '-1');
INSERT INTO ab_licenze VALUES ('4', 'zGQrVfrH', null, null, '2', '-1');
INSERT INTO ab_licenze VALUES ('6', 'rmiUUjus', 'utente1', '2', '2', '-1');
