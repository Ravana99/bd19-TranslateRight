DROP TABLE IF EXISTS local_publico CASCADE;
DROP TABLE IF EXISTS item CASCADE;
DROP TABLE IF EXISTS anomalia CASCADE;
DROP TABLE IF EXISTS anomalia_traducao CASCADE;
DROP TABLE IF EXISTS duplicado CASCADE;
DROP TABLE IF EXISTS utilizador CASCADE;
DROP TABLE IF EXISTS utilizador_qualificado CASCADE;
DROP TABLE IF EXISTS utilizador_regular CASCADE;
DROP TABLE IF EXISTS incidencia CASCADE;
DROP TABLE IF EXISTS proposta_de_correcao CASCADE;
DROP TABLE IF EXISTS correcao CASCADE;

CREATE TABLE local_publico
(
    latitude NUMERIC(8,6) NOT NULL,
    longitude NUMERIC(9,6) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    CONSTRAINT pk_local_publico PRIMARY KEY(latitude, longitude),
    CONSTRAINT check_latitude CHECK (latitude>=-90 AND latitude<=90),
    CONSTRAINT check_longitude CHECK (longitude>=-180 AND longitude<=180) 
);

CREATE TABLE item
(
    id SERIAL NOT NULL UNIQUE,
    descricao TEXT NOT NULL,
    localizacao VARCHAR(100) NOT NULL,
    latitude NUMERIC(8,6) NOT NULL,
    longitude NUMERIC(9,6) NOT NULL,
    CONSTRAINT pk_item PRIMARY KEY(id),
    CONSTRAINT fk_item_local_publico FOREIGN KEY(latitude, longitude) REFERENCES local_publico(latitude, longitude) ON DELETE CASCADE
);

CREATE TABLE anomalia
(
    id SERIAL NOT NULL UNIQUE,
    zona BOX NOT NULL,
    imagem VARCHAR(1000) NOT NULL,
    lingua VARCHAR(100) NOT NULL,
    ts TIMESTAMP NOT NULL,
    descricao TEXT NOT NULL,
    tem_anomalia_redacao BOOLEAN NOT NULL,
    CONSTRAINT pk_anomalia PRIMARY KEY(id)
);

CREATE TABLE anomalia_traducao
(
    id INTEGER NOT NULL UNIQUE,
    zona2 BOX NOT NULL,
    lingua2 VARCHAR(100) NOT NULL,
    CONSTRAINT pk_anomalia_traducao PRIMARY KEY(id),
    CONSTRAINT fk_anomalia_traducao_anomalia FOREIGN KEY(id) REFERENCES anomalia(id) ON DELETE CASCADE ON UPDATE CASCADE
);
/* Missing constraints RI-1 AND RI-2 */

CREATE TABLE duplicado
(
    item1 INTEGER NOT NULL,
    item2 INTEGER NOT NULL,
    CONSTRAINT pk_duplicado PRIMARY KEY(item1, item2),
    CONSTRAINT fk_duplicado_item1 FOREIGN KEY(item1) REFERENCES item(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_duplicado_item2 FOREIGN KEY(item2) REFERENCES item(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT check_items CHECK (item1<item2)
);

CREATE TABLE utilizador
(
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    CONSTRAINT pk_utilizador PRIMARY KEY(email),
    CONSTRAINT check_email CHECK (email LIKE '%@%.%')
);
/* Missing constraint RI-4 */

CREATE TABLE utilizador_qualificado
(
    email VARCHAR(100) NOT NULL UNIQUE,
    CONSTRAINT pk_utilizador_qualificado PRIMARY KEY(email),
    CONSTRAINT fk_utilizador_qualificado_utilizador FOREIGN KEY(email) REFERENCES utilizador(email) ON DELETE CASCADE ON UPDATE CASCADE
);
/* Missing constraint RI-5 */

CREATE TABLE utilizador_regular
(
    email VARCHAR(100) NOT NULL UNIQUE,
    CONSTRAINT pk_utilizador_regular PRIMARY KEY(email),
    CONSTRAINT fk_utilizador_regular_utilizador FOREIGN KEY(email) REFERENCES utilizador(email) ON DELETE CASCADE ON UPDATE CASCADE
);
/* Missing constraint RI-6 */

CREATE TABLE incidencia
(
    anomalia_id INTEGER NOT NULL UNIQUE,
    item_id INTEGER NOT NULL,
    email VARCHAR(100) NOT NULL,
    CONSTRAINT pk_incidencia PRIMARY KEY(anomalia_id),
    CONSTRAINT fk_incidencia_anomalia FOREIGN KEY(anomalia_id) REFERENCES anomalia(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_incidencia_item FOREIGN KEY(item_id) REFERENCES item(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_incidencia_utilizador FOREIGN KEY(email) REFERENCES utilizador(email) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE proposta_de_correcao
(
    email VARCHAR(100) NOT NULL,
    nro INTEGER NOT NULL,
    data_hora TIMESTAMP NOT NULL,
    texto TEXT NOT NULL,
    CONSTRAINT pk_proposta_de_correcao PRIMARY KEY(email, nro),
    CONSTRAINT fk_proposta_de_correcao_utilizador_qualificado FOREIGN KEY(email) REFERENCES utilizador_qualificado(email) ON DELETE CASCADE ON UPDATE CASCADE
);
/* Missing constraint RI-7 */

CREATE TABLE correcao
(
    email VARCHAR(100) NOT NULL,
    nro INTEGER NOT NULL,
    anomalia_id INTEGER NOT NULL,
    CONSTRAINT pk_correcao PRIMARY KEY(email, nro, anomalia_id),
    CONSTRAINT fk_correcao_proposta_de_correcao FOREIGN KEY(email, nro) REFERENCES proposta_de_correcao(email, nro) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_correcao_incidencia FOREIGN KEY(anomalia_id) REFERENCES incidencia(anomalia_id) ON DELETE CASCADE ON UPDATE CASCADE
);
