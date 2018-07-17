
DROP TABLE IF EXISTS `tbl_section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `name_cn` varchar(50) DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_section`
--

LOCK TABLES `tbl_section` WRITE;
/*!40000 ALTER TABLE `tbl_section` DISABLE KEYS */;
INSERT INTO `tbl_section` VALUES (1,'fangqu1','1#防区','/static/img/section.png'),(3,'fangqu2','2#防区','/static/img/section.png'),(4,'fangqu3','3#防区','/static/img/section.png'),(5,'fangqu4','4#防区','/static/img/section.png'),(6,'fangqu5','5#防区','/static/img/section.png'),(7,'fangqu6','6#防区',NULL),(8,'fangqu7','7#防区',NULL),(9,'fangqu8','8#防区',NULL),(10,'fangqu9','9#防区',NULL),(11,'fangqu10','10#防区',NULL);
/*!40000 ALTER TABLE `tbl_section` ENABLE KEYS */;
UNLOCK TABLES;