/*Locais Publicos*/

insert into local_publico values (38.234783,-7.543872,'LIDL');
insert into local_publico values (38.283765,-9.248372,'Pingo Doce');
insert into local_publico values (39.991734,-8.283723,'Continente');
insert into local_publico values (38.438713,-8.123456,'Auchan');
insert into local_publico values (38.127382,-9.283782,'Minipreco');
insert into local_publico values (38.234782,-7.174222,'Jumbo');
insert into local_publico values (41.298323,-8.237823,'Aldi');
insert into local_publico values (38.019287,-7.328113,'Mercadona');
insert into local_publico values (39.346731,-8.219823,'Intermarche');
insert into local_publico values (38.473823,-9.299992,'Amanhecer');

/*Itens*/

insert into item values (1,'Descricao duplicado 1','Lisboa',39.991734,-8.283723);
insert into item values (2,'Descricao duplicado 2','Beja',38.283765,-9.248372);
insert into item values (3,'Descricao do item 3','Braga',38.473823,-9.299992);
insert into item values (4,'Descricao do item 4','Santarem',41.298323,-8.237823);
insert into item values (5,'Descricao do item 5','Beja',38.283765,-9.248372);
insert into item values (6,'Descricao do item 6','Vila Real',38.127382,-9.283782);
insert into item values (7,'Descricao duplicado 1','Lisboa',39.991734,-8.283723);
insert into item values (8,'Descricao duplicado 1','Lisboa',39.991734,-8.283723);
insert into item values (9,'Descricao duplicado 9','Porto',39.346731,-8.219823);
insert into item values (10,'Descricao do item 10','Faro',38.234782,-7.174222);
insert into item values (11,'Descricao do item 11','Lisboa',39.991734,-8.283723);
insert into item values (12,'Descricao do item 12','Aveiro',38.234783,-7.543872);
insert into item values (13,'Descricao do item 13','Vila Real',38.127382,-9.283782);
insert into item values (14,'Descricao do item 14','Faro',38.234782,-7.174222);
insert into item values (15,'Descricao duplicado 9','Porto',39.346731,-8.219823);
insert into item values (16,'Descricao do item 16','Braga',38.473823,-9.299992);
insert into item values (17,'Descricao do item 17','Santarem',41.298323,-8.237823);
insert into item values (18,'Descricao duplicado 2','Beja',38.283765,-9.248372);
insert into item values (19,'Descricao do item 19','Lisboa',39.991734,-8.283723);
insert into item values (20,'Descricao do item 20','Vila Real',38.127382,-9.283782);
insert into item values (21,'Descricao do item 21','Lisboa',39.991734,-8.283723);
insert into item values (22,'Descricao do item 22','Santarem',41.298323,-8.237823);
insert into item values (23,'Descricao do item 23','Porto',39.346731,-8.219823);

/*Anomalias*/

insert into anomalia values (1,'((1,1),(5,5))','url-imagem1','Portugues','2019-1-23 01:11:00','Descricao da anomalia 1', true);
insert into anomalia values (2,'((2,2),(5,5))','url-imagem2','Ingles','2019-2-22 02:52:11','Descricao da anomalia 2', false);
insert into anomalia values (3,'((3,3),(8,5))','url-imagem3','Espanhol','2017-3-21 03:34:24','Descricao da anomalia 3', true);
insert into anomalia values (4,'((4,5),(9,9))','url-imagem4','Frances','2018-4-20 04:15:35','Descricao da anomalia 4', false);
insert into anomalia values (5,'((5,4),(10,10))','url-imagem5','Italiano','2019-5-19 05:50:36','Descricao da anomalia 5', true);
insert into anomalia values (6,'((6,7),(11,9))','url-imagem6','Portugues','2019-6-18 06:50:47','Descricao da anomalia 6', false);
insert into anomalia values (7,'((7,6),(10,15))','url-imagem7','Italiano','2019-7-17 07:50:27','Descricao da anomalia 7', true);
insert into anomalia values (8,'((8,8),(15,15))','url-imagem8','Ingles','2019-8-16 08:32:36','Descricao da anomalia 8', false);
insert into anomalia values (9,'((9,9),(15,15))','url-imagem9','Portugues','2018-9-15 09:12:37','Descricao da anomalia 9', true);
insert into anomalia values (10,'((10,11),(12,13))','url-imagem10','Espanhol','2017-10-14 10:00:23','Descricao da anomalia 10', false);
insert into anomalia values (11,'((11,10),(13,16))','url-imagem11','Portugues','2019-11-13 11:06:29','Descricao da anomalia 11', true);
insert into anomalia values (12,'((12,12),(17,20))','url-imagem12','Espanhol','2018-12-12 12:28:52','Descricao da anomalia 12', false);
insert into anomalia values (13,'((13,13),(16,21))','url-imagem13','Ingles','2019-1-11 13:44:54','Descricao da anomalia 13', true);
insert into anomalia values (14,'((14,14),(15,15))','url-imagem14','Italiano','2019-2-10 14:55:43','Descricao da anomalia 14', false);
insert into anomalia values (15,'((15,15),(16,18))','url-imagem15','Italiano','2019-3-9 15:33:16','Descricao da anomalia 15', true);
insert into anomalia values (16,'((16,11),(17,13))','url-imagem16','Frances','2018-4-8 16:25:15','Descricao da anomalia 16', false);
insert into anomalia values (17,'((17,10),(19,15))','url-imagem17','Espanhol','2017-5-7 17:12:18','Descricao da anomalia 17', true);
insert into anomalia values (18,'((18,19),(25,25))','url-imagem18','Ingles','2019-6-6 18:16:18','Descricao da anomalia 18', false);
insert into anomalia values (19,'((19,12),(25,21))','url-imagem19','Portugues','2019-7-5 19:59:23','Descricao da anomalia 19', true);
insert into anomalia values (20,'((20,21),(25,26))','url-imagem20','Espanhol','2019-8-4 20:59:38','Descricao da anomalia 20', false);
insert into anomalia values (21,'((21,22),(26,27))','url-imagem21','Ingles','2019-4-4 20:56:58','Descricao da anomalia 21', false);
insert into anomalia values (22,'((22,22),(28,27))','url-imagem22','Ingles','2019-7-4 19:56:58','Descricao da anomalia 22', true);
insert into anomalia values (23,'((23,22),(26,27))','url-imagem23','Ingles','2019-4-5 18:56:58','Descricao da anomalia 23', true);

/*Anomalias de traducao*/

insert into anomalia_traducao values (2,'((6,6),(9,9))','Portugues');
insert into anomalia_traducao values (4,'((10,10),(13,14))','Ingles');
insert into anomalia_traducao values (6,'((12,12),(15,17))','Ingles');
insert into anomalia_traducao values (8,'((3,3),(6,6))','Frances');
insert into anomalia_traducao values (10,'((2,2),(6,5))','Ingles');
insert into anomalia_traducao values (12,'((20,20),(23,23))','Ingles');
insert into anomalia_traducao values (14,'((0,0),(4,5))','Ingles');
insert into anomalia_traducao values (16,'((7,7),(9,9))','Ingles');
insert into anomalia_traducao values (18,'((26,27),(30,35))','Italiano');
insert into anomalia_traducao values (20,'((3,0),(9,10))','Ingles');
insert into anomalia_traducao values (21,'((3,3),(8,11))','Espanhol');

/*Duplicados*/

insert into duplicado values (1,7);
insert into duplicado values (1,8);
insert into duplicado values (2,18);
insert into duplicado values (9,15);

/*Utilizadores*/

insert into utilizador values ('josefino@gmail.com','password');
insert into utilizador values ('tavares@sapo.pt','stuartmill');
insert into utilizador values ('carlos@hotmail.com','qwerty');
insert into utilizador values ('joao@gmail.com','abcdef');
insert into utilizador values ('carlos2@sapo.pt','12345');
insert into utilizador values ('nunes@gmail.com','qwqwqwqw');
insert into utilizador values ('vera@gmail.com','asdfgh');
insert into utilizador values ('miguel@hotmail.com','12345');
insert into utilizador values ('matos@sapo.pt','passss');
insert into utilizador values ('filipe@gmail.com','farinheira');
insert into utilizador values ('joao2@gmail.com','password');
insert into utilizador values ('joao3@hotmail.com','808080');
insert into utilizador values ('carlos3@hotmail.com','cozido');
insert into utilizador values ('tvi@gmail.com','760200300');
insert into utilizador values ('josejose@hotmail.com','zezezeze');
insert into utilizador values ('burnol@gmail.com','qwerty');
insert into utilizador values ('costa@gov.pt','portugal');
insert into utilizador values ('socrates@gov.com','12345');
insert into utilizador values ('cozido@gmail.com','batatas');
insert into utilizador values ('robalo@hotmail.com','azeite');

/*Utilizadores Qualificados*/

insert into utilizador_qualificado values ('josefino@gmail.com');
insert into utilizador_qualificado values ('carlos@hotmail.com');
insert into utilizador_qualificado values ('carlos2@sapo.pt');
insert into utilizador_qualificado values ('vera@gmail.com');
insert into utilizador_qualificado values ('matos@sapo.pt');
insert into utilizador_qualificado values ('joao2@gmail.com');
insert into utilizador_qualificado values ('carlos3@hotmail.com');
insert into utilizador_qualificado values ('josejose@hotmail.com');
insert into utilizador_qualificado values ('costa@gov.pt');
insert into utilizador_qualificado values ('cozido@gmail.com');

/*Utilizadores Regulares*/

insert into utilizador_regular values ('tavares@sapo.pt');
insert into utilizador_regular values ('joao@gmail.com');
insert into utilizador_regular values ('nunes@gmail.com');
insert into utilizador_regular values ('miguel@hotmail.com');
insert into utilizador_regular values ('filipe@gmail.com');
insert into utilizador_regular values ('joao3@hotmail.com');
insert into utilizador_regular values ('tvi@gmail.com');
insert into utilizador_regular values ('burnol@gmail.com');
insert into utilizador_regular values ('socrates@gov.com');
insert into utilizador_regular values ('robalo@hotmail.com');

/*Incidencias*/

insert into incidencia values (1,1,'josefino@gmail.com');
insert into incidencia values (2,2,'tavares@sapo.pt');
insert into incidencia values (3,3,'carlos@hotmail.com');
insert into incidencia values (4,4,'carlos@hotmail.com');
insert into incidencia values (5,5,'carlos2@sapo.pt');
insert into incidencia values (6,6,'vera@gmail.com');
insert into incidencia values (7,7,'nunes@gmail.com');
insert into incidencia values (8,8,'tvi@gmail.com');
insert into incidencia values (9,9,'vera@gmail.com');
insert into incidencia values (10,10,'filipe@gmail.com');
insert into incidencia values (11,11,'carlos3@hotmail.com');
insert into incidencia values (12,12,'josejose@hotmail.com');
insert into incidencia values (13,13,'josejose@hotmail.com');
insert into incidencia values (14,14,'burnol@gmail.com');
insert into incidencia values (15,15,'costa@gov.pt');
insert into incidencia values (16,16,'costa@gov.pt');
insert into incidencia values (17,17,'robalo@hotmail.com');
insert into incidencia values (18,18,'josejose@hotmail.com');
insert into incidencia values (19,19,'burnol@gmail.com');
insert into incidencia values (20,20,'costa@gov.pt');
insert into incidencia values (21,21,'tavares@sapo.pt');
insert into incidencia values (22,22,'tavares@sapo.pt');
insert into incidencia values (23,23,'tavares@sapo.pt');

/*Propostas de Correcao*/

insert into proposta_de_correcao values ('josefino@gmail.com',1,'2019-9-23 08:41:00','Texto1 do josefino');
insert into proposta_de_correcao values ('cozido@gmail.com',1,'2019-8-24 10:24:00','Texto1 do cozido');
insert into proposta_de_correcao values ('josefino@gmail.com',2,'2019-9-29 20:16:50','Texto2 do josefino');
insert into proposta_de_correcao values ('costa@gov.pt',1,'2019-5-11 01:11:00','Texto1 do costa');
insert into proposta_de_correcao values ('costa@gov.pt',2,'2019-5-20 14:54:23','Texto2 do costa');
insert into proposta_de_correcao values ('josefino@gmail.com',3,'2019-10-13 12:31:37','Texto3 do josefino');
insert into proposta_de_correcao values ('josejose@hotmail.com',1,'2019-3-21 10:24:43','Texto1 do josejose');
insert into proposta_de_correcao values ('matos@sapo.pt',1,'2019-2-20 15:31:59','Texto1 do matos');
insert into proposta_de_correcao values ('carlos@hotmail.com',1,'2019-7-19 02:22:22','Texto1 do carlos');
insert into proposta_de_correcao values ('joao2@gmail.com',1,'2019-3-13 13:13:31','Texto1 do joao2');

/*Correcoes*/

insert into correcao values ('josefino@gmail.com',1,1);
insert into correcao values ('cozido@gmail.com',1,1);
insert into correcao values ('josefino@gmail.com',2,4);
insert into correcao values ('costa@gov.pt',1,16);
insert into correcao values ('costa@gov.pt',2,17);
insert into correcao values ('josefino@gmail.com',3,15);
insert into correcao values ('josejose@hotmail.com',1,2);
insert into correcao values ('matos@sapo.pt',1,13);
insert into correcao values ('carlos@hotmail.com',1,4);
insert into correcao values ('joao2@gmail.com',1,1);
