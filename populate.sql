/*Locais Publicos*/

INSERT INTO local_publico VALUES (38.234783,-7.543872,'LIDL');
INSERT INTO local_publico VALUES (38.283765,-9.248372,'Pingo Doce');
INSERT INTO local_publico VALUES (39.991734,-8.283723,'Continente');
INSERT INTO local_publico VALUES (38.438713,-8.123456,'Auchan');
INSERT INTO local_publico VALUES (38.127382,-9.283782,'Minipreco');
INSERT INTO local_publico VALUES (38.234782,-7.174222,'Jumbo');
INSERT INTO local_publico VALUES (41.298323,-8.237823,'Aldi');
INSERT INTO local_publico VALUES (38.019287,-7.328113,'Mercadona');
INSERT INTO local_publico VALUES (39.346731,-8.219823,'Intermarche');
INSERT INTO local_publico VALUES (38.473823,-9.299992,'Amanhecer');

/*Itens*/

INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 1','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 2','Beja',38.283765,-9.248372);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 3','Braga',38.473823,-9.299992);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 4','Santarem',41.298323,-8.237823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 5','Beja',38.283765,-9.248372);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 6','Vila Real',38.127382,-9.283782);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 1','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 1','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 9','Porto',39.346731,-8.219823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 10','Faro',38.234782,-7.174222);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 11','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 12','Aveiro',38.234783,-7.543872);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 13','Vila Real',38.127382,-9.283782);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 14','Faro',38.234782,-7.174222);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 9','Porto',39.346731,-8.219823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 16','Braga',38.473823,-9.299992);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 17','Santarem',41.298323,-8.237823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao duplicado 2','Beja',38.283765,-9.248372);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 19','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 20','Vila Real',38.127382,-9.283782);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 21','Lisboa',39.991734,-8.283723);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 22','Santarem',41.298323,-8.237823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 23','Porto',39.346731,-8.219823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 24','Beja',38.283765,-9.248372);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 25','Porto',39.346731,-8.219823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 26','Santarem',41.298323,-8.237823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 27','Porto',39.346731,-8.219823);
INSERT INTO item (descricao, localizacao, latitude, longitude) VALUES ('Descricao do item 28','Santarem',41.298323,-8.237823);

/*Anomalias*/

INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((1,1),(5,5))','url-imagem1','Portugues','2019-1-23 01:11:00','Descricao da anomalia 1', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((2,2),(5,5))','url-imagem2','Ingles','2019-2-22 02:52:11','Descricao da anomalia 2', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((3,3),(8,5))','url-imagem3','Espanhol','2017-3-21 03:34:24','Descricao da anomalia 3', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((4,5),(9,9))','url-imagem4','Frances','2018-4-20 04:15:35','Descricao da anomalia 4', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((5,4),(10,10))','url-imagem5','Italiano','2019-5-19 05:50:36','Descricao da anomalia 5', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((6,7),(11,9))','url-imagem6','Portugues','2019-6-18 06:50:47','Descricao da anomalia 6', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((7,6),(10,15))','url-imagem7','Italiano','2019-7-17 07:50:27','Descricao da anomalia 7', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((8,8),(15,15))','url-imagem8','Ingles','2019-8-16 08:32:36','Descricao da anomalia 8', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((9,9),(15,15))','url-imagem9','Portugues','2018-9-15 09:12:37','Descricao da anomalia 9', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((10,11),(12,13))','url-imagem10','Espanhol','2017-10-14 10:00:23','Descricao da anomalia 10', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((11,10),(13,16))','url-imagem11','Portugues','2019-11-13 11:06:29','Descricao da anomalia 11', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((12,12),(17,20))','url-imagem12','Espanhol','2018-12-12 12:28:52','Descricao da anomalia 12', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((13,13),(16,21))','url-imagem13','Ingles','2019-1-11 13:44:54','Descricao da anomalia 13', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((14,14),(15,15))','url-imagem14','Italiano','2019-2-10 14:55:43','Descricao da anomalia 14', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((15,15),(16,18))','url-imagem15','Italiano','2019-3-9 15:33:16','Descricao da anomalia 15', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((16,11),(17,13))','url-imagem16','Frances','2018-4-8 16:25:15','Descricao da anomalia 16', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((17,10),(19,15))','url-imagem17','Espanhol','2017-5-7 17:12:18','Descricao da anomalia 17', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((18,19),(25,25))','url-imagem18','Ingles','2019-6-6 18:16:18','Descricao da anomalia 18', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((19,12),(25,21))','url-imagem19','Portugues','2019-7-5 19:59:23','Descricao da anomalia 19', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((20,21),(25,26))','url-imagem20','Espanhol','2019-8-4 20:59:38','Descricao da anomalia 20', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((21,22),(26,27))','url-imagem21','Ingles','2019-4-4 20:56:58','Descricao da anomalia 21', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((22,22),(28,27))','url-imagem22','Ingles','2019-7-4 19:56:58','Descricao da anomalia 22', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((23,22),(26,27))','url-imagem23','Ingles','2019-4-5 18:56:58','Descricao da anomalia 23', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((24,29),(30,36))','url-imagem24','Italiano','2019-2-25 14:55:43','Descricao da anomalia 24', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((25,29),(32,36))','url-imagem25','Italiano','2019-5-4 21:52:45','Descricao da anomalia 25', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((26,30),(36,37))','url-imagem26','Espanhol','2019-9-25 17:12:18','Descricao da anomalia 26', false);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((27,13),(30,21))','url-imagem27','Ingles','2019-3-11 14:34:54','Descricao da anomalia 27', true);
INSERT INTO anomalia (zona, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES ('((28,15),(34,23))','url-imagem28','Ingles','2019-1-14 23:42:34','Descricao da anomalia 28', true);

/*Anomalias de traducao*/

INSERT INTO anomalia_traducao VALUES (2,'((6,6),(9,9))','Portugues');
INSERT INTO anomalia_traducao VALUES (4,'((10,10),(13,14))','Ingles');
INSERT INTO anomalia_traducao VALUES (6,'((12,12),(15,17))','Ingles');
INSERT INTO anomalia_traducao VALUES (8,'((3,3),(6,6))','Frances');
INSERT INTO anomalia_traducao VALUES (10,'((2,2),(6,5))','Ingles');
INSERT INTO anomalia_traducao VALUES (12,'((20,20),(23,23))','Ingles');
INSERT INTO anomalia_traducao VALUES (14,'((0,0),(4,5))','Ingles');
INSERT INTO anomalia_traducao VALUES (16,'((7,7),(9,9))','Ingles');
INSERT INTO anomalia_traducao VALUES (18,'((26,27),(30,35))','Italiano');
INSERT INTO anomalia_traducao VALUES (20,'((3,0),(9,10))','Ingles');
INSERT INTO anomalia_traducao VALUES (21,'((3,3),(8,11))','Espanhol');
INSERT INTO anomalia_traducao VALUES (24,'((3,5),(9,11))','Espanhol');
INSERT INTO anomalia_traducao VALUES (25,'((6,5),(9,11))','Ingles');
INSERT INTO anomalia_traducao VALUES (26,'((0,0),(7,10))','Ingles');

/*Duplicados*/

INSERT INTO duplicado VALUES (1,7);
INSERT INTO duplicado VALUES (1,8);
INSERT INTO duplicado VALUES (2,18);
INSERT INTO duplicado VALUES (9,15);

/*Utilizadores*/

INSERT INTO utilizador VALUES ('josefino@gmail.com','password');
INSERT INTO utilizador VALUES ('tavares@sapo.pt','stuartmill');
INSERT INTO utilizador VALUES ('carlos@hotmail.com','qwerty');
INSERT INTO utilizador VALUES ('joao@gmail.com','abcdef');
INSERT INTO utilizador VALUES ('carlos2@sapo.pt','12345');
INSERT INTO utilizador VALUES ('nunes@gmail.com','qwqwqwqw');
INSERT INTO utilizador VALUES ('vera@gmail.com','asdfgh');
INSERT INTO utilizador VALUES ('miguel@hotmail.com','12345');
INSERT INTO utilizador VALUES ('matos@sapo.pt','passss');
INSERT INTO utilizador VALUES ('filipe@gmail.com','farinheira');
INSERT INTO utilizador VALUES ('joao2@gmail.com','password');
INSERT INTO utilizador VALUES ('joao3@hotmail.com','808080');
INSERT INTO utilizador VALUES ('carlos3@hotmail.com','cozido');
INSERT INTO utilizador VALUES ('tvi@gmail.com','760200300');
INSERT INTO utilizador VALUES ('josejose@hotmail.com','zezezeze');
INSERT INTO utilizador VALUES ('burnol@gmail.com','qwerty');
INSERT INTO utilizador VALUES ('costa@gov.pt','portugal');
INSERT INTO utilizador VALUES ('socrates@gov.com','12345');
INSERT INTO utilizador VALUES ('cozido@gmail.com','batatas');
INSERT INTO utilizador VALUES ('robalo@hotmail.com','azeite');

/*Utilizadores Qualificados*/

INSERT INTO utilizador_qualificado VALUES ('josefino@gmail.com');
INSERT INTO utilizador_qualificado VALUES ('carlos@hotmail.com');
INSERT INTO utilizador_qualificado VALUES ('carlos2@sapo.pt');
INSERT INTO utilizador_qualificado VALUES ('vera@gmail.com');
INSERT INTO utilizador_qualificado VALUES ('matos@sapo.pt');
INSERT INTO utilizador_qualificado VALUES ('joao2@gmail.com');
INSERT INTO utilizador_qualificado VALUES ('carlos3@hotmail.com');
INSERT INTO utilizador_qualificado VALUES ('josejose@hotmail.com');
INSERT INTO utilizador_qualificado VALUES ('costa@gov.pt');
INSERT INTO utilizador_qualificado VALUES ('cozido@gmail.com');

/*Utilizadores Regulares*/

INSERT INTO utilizador_regular VALUES ('tavares@sapo.pt');
INSERT INTO utilizador_regular VALUES ('joao@gmail.com');
INSERT INTO utilizador_regular VALUES ('nunes@gmail.com');
INSERT INTO utilizador_regular VALUES ('miguel@hotmail.com');
INSERT INTO utilizador_regular VALUES ('filipe@gmail.com');
INSERT INTO utilizador_regular VALUES ('joao3@hotmail.com');
INSERT INTO utilizador_regular VALUES ('tvi@gmail.com');
INSERT INTO utilizador_regular VALUES ('burnol@gmail.com');
INSERT INTO utilizador_regular VALUES ('socrates@gov.com');
INSERT INTO utilizador_regular VALUES ('robalo@hotmail.com');

/*Incidencias*/

INSERT INTO incidencia VALUES (1,1,'josefino@gmail.com');
INSERT INTO incidencia VALUES (2,2,'tavares@sapo.pt');
INSERT INTO incidencia VALUES (3,3,'carlos@hotmail.com');
INSERT INTO incidencia VALUES (4,4,'carlos@hotmail.com');
INSERT INTO incidencia VALUES (5,5,'carlos2@sapo.pt');
INSERT INTO incidencia VALUES (6,6,'vera@gmail.com');
INSERT INTO incidencia VALUES (7,7,'nunes@gmail.com');
INSERT INTO incidencia VALUES (8,8,'tvi@gmail.com');
INSERT INTO incidencia VALUES (9,9,'vera@gmail.com');
INSERT INTO incidencia VALUES (10,10,'filipe@gmail.com');
INSERT INTO incidencia VALUES (11,11,'carlos3@hotmail.com');
INSERT INTO incidencia VALUES (12,12,'josejose@hotmail.com');
INSERT INTO incidencia VALUES (13,13,'josejose@hotmail.com');
INSERT INTO incidencia VALUES (14,14,'burnol@gmail.com');
INSERT INTO incidencia VALUES (15,15,'costa@gov.pt');
INSERT INTO incidencia VALUES (16,16,'costa@gov.pt');
INSERT INTO incidencia VALUES (17,17,'robalo@hotmail.com');
INSERT INTO incidencia VALUES (18,18,'josejose@hotmail.com');
INSERT INTO incidencia VALUES (19,19,'burnol@gmail.com');
INSERT INTO incidencia VALUES (20,20,'costa@gov.pt');
INSERT INTO incidencia VALUES (21,21,'tavares@sapo.pt');
INSERT INTO incidencia VALUES (22,22,'tavares@sapo.pt');
INSERT INTO incidencia VALUES (23,23,'tavares@sapo.pt');
INSERT INTO incidencia VALUES (24,24,'tvi@gmail.com');
INSERT INTO incidencia VALUES (25,25,'burnol@gmail.com');
INSERT INTO incidencia VALUES (26,26,'tavares@sapo.pt');
INSERT INTO incidencia VALUES (27,27,'josefino@gmail.com');
INSERT INTO incidencia VALUES (28,28,'josefino@gmail.com');

/*Propostas de Correcao*/

INSERT INTO proposta_de_correcao VALUES ('josefino@gmail.com',1,'2019-9-23 08:41:00','Texto1 do josefino');
INSERT INTO proposta_de_correcao VALUES ('cozido@gmail.com',1,'2019-8-24 10:24:00','Texto1 do cozido');
INSERT INTO proposta_de_correcao VALUES ('josefino@gmail.com',2,'2019-9-29 20:16:50','Texto2 do josefino');
INSERT INTO proposta_de_correcao VALUES ('costa@gov.pt',1,'2019-5-11 01:11:00','Texto1 do costa');
INSERT INTO proposta_de_correcao VALUES ('costa@gov.pt',2,'2019-5-20 14:54:23','Texto2 do costa');
INSERT INTO proposta_de_correcao VALUES ('josefino@gmail.com',3,'2019-10-13 12:31:37','Texto3 do josefino');
INSERT INTO proposta_de_correcao VALUES ('josejose@hotmail.com',1,'2019-3-21 10:24:43','Texto1 do josejose');
INSERT INTO proposta_de_correcao VALUES ('matos@sapo.pt',1,'2019-2-20 15:31:59','Texto1 do matos');
INSERT INTO proposta_de_correcao VALUES ('carlos@hotmail.com',1,'2019-7-19 02:22:22','Texto1 do carlos');
INSERT INTO proposta_de_correcao VALUES ('joao2@gmail.com',1,'2019-3-13 13:13:31','Texto1 do joao2');
INSERT INTO proposta_de_correcao VALUES ('vera@gmail.com',1,'2019-7-13 13:53:21','Texto1 da vera');
INSERT INTO proposta_de_correcao VALUES ('carlos2@sapo.pt',1,'2019-8-13 23:13:31','Texto1 do carlos2');

/*Correcoes*/

INSERT INTO correcao VALUES ('josefino@gmail.com',1,1);
INSERT INTO correcao VALUES ('cozido@gmail.com',1,1);
INSERT INTO correcao VALUES ('josefino@gmail.com',2,4);
INSERT INTO correcao VALUES ('costa@gov.pt',1,16);
INSERT INTO correcao VALUES ('costa@gov.pt',2,17);
INSERT INTO correcao VALUES ('josefino@gmail.com',3,15);
INSERT INTO correcao VALUES ('josejose@hotmail.com',1,2);
INSERT INTO correcao VALUES ('matos@sapo.pt',1,13);
INSERT INTO correcao VALUES ('carlos@hotmail.com',1,4);
INSERT INTO correcao VALUES ('joao2@gmail.com',1,1);
INSERT INTO correcao VALUES ('vera@gmail.com',1,6);
INSERT INTO correcao VALUES ('carlos2@sapo.pt',1,5);
