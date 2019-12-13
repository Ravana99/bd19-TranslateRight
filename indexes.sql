DROP INDEX IF EXISTS data_hora__proposta_de_correcao_idx;
DROP INDEX IF EXISTS anomalia_id__incidencia_idx;
DROP INDEX IF EXISTS ts_tem_anomalia_redacao_lingua__anomalia_idx;

/*
--1.1
E necessario analisar muitos registos e visto que a dimensao das tabelas
ultrapassa em varias ordens de grandeza a memoria disponivel, o acesso ao
disco vai ser muito frequente, logo nao e necessario criar um index.

--1.2
Como a query filtra com o operador between, cria-se um btree index.
*/

CREATE INDEX data_hora__proposta_de_correcao_idx ON proposta_de_correcao USING btree (data_hora);

/*
--2
Ja existe um index btree para a coluna anomalia_id devido a esta ser chave
primaria da incidencia, mas quando possivel deve-se criar um hash index pois
este e mais eficiente para igualdades.
*/

CREATE INDEX anomalia_id__incidencia_idx ON incidencia USING hash (anomalia_id);

/*
--3.1
E necessario analisar muitos registos e visto que a dimensao das tabelas ultrapassa
em varias ordens de grandeza a memoria disponivel, o acesso ao disco vai ser muito frequente.
Alem disto ja existe um index associado a 'anomalia_id' porque a coluna faz parte da
chave primaria da tabela 'correcao', logo nao e necessario criar um index.

--3.2
Como a coluna 'anomalia_id' faz parte da chave primaria da tabela 'correcao'
existe um index associado a esta coluna e como esta e o primeiro elemento da chave,
este index pode ser utilizado para a query em questao.

--4
A ordem de filtragem das colunas e 'tem_anomalia_redacao' depois 'lingua' e por fim 'ts'.
A flag 'tem_anomalia_redacao' esta em primeiro lugar porque so existem dois valores
possiveis (True e False), de seguida esta a coluna 'lingua' porque apenas existem cerca 
de 7000 linguas faladas em todo o mundo, um numero bastante insignificante em termos de
afetar a performance de queries. Por fim filtra-se pelo intervalo de tempo fornecido
pelo user, este pode ser muito ou pouco abrangente.
*/

CREATE INDEX ts_tem_anomalia_redacao_lingua__anomalia_idx ON anomalia USING btree (tem_anomalia_redacao,lingua,ts);
