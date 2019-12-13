DROP INDEX IF EXISTS
data_hora__proposta_de_correcao_idx ON proposta_de_correcao USING btree (data_hora),
anomalia_id__incidencia_idx incidencia ON incidencia USING hash (anomalia_id),
ts_tem_anomalia_redacao_language__anomalia_idx ON anomalia USING btree (ts,tem_anomalia_redacao,language);

--1.1
É necessário analisar muitos registos e visto que a dimensão
das tabelas ultrapassa em várias ordens de grandeza a memória disponível,
o acesso ao disco vai ser muito frequente, logo não é necessário criar um index.

--1.2
Como a query filtra com o operador between, cria-se um btree index.

CREATE INDEX data_hora__proposta_de_correcao_idx ON proposta_de_correcao USING btree (data_hora);

--2
Já existe um index btree para a coluna anomalia_id devido a esta ser chave primária da incidencia,
mas quando possível deve-se criar um hash index pois este é mais eficiente para igualdades.

CREATE INDEX anomalia_id__incidencia_idx ON incidencia USING hash (anomalia_id);.

--3.1
É necessário analisar muitos registos e visto que a dimensão
das tabelas ultrapassa em várias ordens de grandeza a memória disponível,
o acesso ao disco vai ser muito frequente. Além disto já existe um index
associado à 'anomalia_id' porque a coluna faz parte da chave primária da tabela 'correcao',
logo não é necessário criar um index.

--3.2
Como a coluna 'anomalia_id' faz parte da chave primária da tabela
'correcao' existe um index associado a esta coluna e como esta é o primeiro elemento da chave
,este index pode ser utilizado para a query em questão.

--4
A ordem de filtragem das colunas é 'tem_anomalia_redacao' depois 'languages' e por fim 'ts'.
A flag 'tem_anomalia_redacao' está em primeiro lugar porque só existem dois valores possiveis (True e False)
,de seguida está a coluna 'languages' porque apenas existem cerca de 7000 línguas faladas em todo o mundo
, um número bastante insignificante em termos de afetar o performance de queries. Por fim filtra-se pelo intervalo
de tempo fornecido pelo user, este pode ser muito ou pouco abrangente.
CREATE INDEX ts_tem_anomalia_redacao_language__anomalia_idx ON anomalia USING btree (tem_anomalia_redacao,language,ts);