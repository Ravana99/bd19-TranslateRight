DROP TABLE IF EXISTS d_utilizador CASCADE;
DROP TABLE IF EXISTS d_tempo CASCADE;
DROP TABLE IF EXISTS d_local CASCADE;
DROP TABLE IF EXISTS d_lingua CASCADE;
DROP TABLE IF EXISTS f_anomalia CASCADE;

CREATE TABLE d_utilizador (
    id_utilizador SERIAL NOT NULL,
    email VARCHAR(100),
    tipo VARCHAR(20),
    CONSTRAINT pk_d_utilizador PRIMARY KEY(id_utilizador)
);

CREATE TABLE d_tempo (
    id_tempo SERIAL NOT NULL,
    dia INTEGER,
    dia_da_semana VARCHAR(20),
    semana INTEGER,
    mes INTEGER,
    trimestre INTEGER,
    ano INTEGER,
    CONSTRAINT pk_d_tempo PRIMARY KEY(id_tempo)
);

CREATE TABLE d_local (
    id_local SERIAL NOT NULL,
    latitude NUMERIC(8,6),
    longitude NUMERIC(9,6),
    nome VARCHAR(100),
    CONSTRAINT pk_d_local PRIMARY KEY(id_local)
);

CREATE TABLE d_lingua (
    id_lingua SERIAL NOT NULL,
    lingua VARCHAR(100),
    CONSTRAINT pk_d_lingua PRIMARY KEY(id_lingua)
);

CREATE TABLE f_anomalia (
    id_utilizador INTEGER,
    id_tempo INTEGER,
    id_local INTEGER,
    id_lingua INTEGER,
    tipo_anomalia VARCHAR(20),
    com_proposta BOOLEAN,
    CONSTRAINT pk_f_anomalia PRIMARY KEY(id_utilizador, id_tempo, id_local, id_lingua),
    CONSTRAINT fk_f_anomalia_d_utilizador FOREIGN KEY(id_utilizador)
        REFERENCES d_utilizador(id_utilizador) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_f_anomalia_d_tempo FOREIGN KEY(id_tempo)
        REFERENCES d_tempo(id_tempo) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_f_anomalia_d_local FOREIGN KEY(id_local)
        REFERENCES d_local(id_local) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_f_anomalia_d_lingua FOREIGN KEY(id_lingua)
        REFERENCES d_lingua(id_lingua) ON DELETE CASCADE ON UPDATE CASCADE
);


INSERT INTO d_utilizador (email, tipo) 
SELECT DISTINCT email,
CASE
    WHEN EMAIL IN (SELECT email FROM utilizador_regular) THEN 'Regular'
    ELSE 'Qualificado'
END
FROM incidencia
ORDER BY email ASC; 

INSERT INTO d_tempo (dia, dia_da_semana, semana, mes, trimestre, ano)
SELECT DISTINCT
    EXTRACT(DAY FROM ts) AS D,
    (SELECT CASE
        WHEN EXTRACT(DOW FROM ts)=1 THEN 'Segunda-Feira'
        WHEN EXTRACT(DOW FROM ts)=2 THEN 'Terca-Feira'
        WHEN EXTRACT(DOW FROM ts)=3 THEN 'Quarta-Feira'
        WHEN EXTRACT(DOW FROM ts)=4 THEN 'Quinta-Feira'
        WHEN EXTRACT(DOW FROM ts)=5 THEN 'Sexta-Feira'
        WHEN EXTRACT(DOW FROM ts)=6 THEN 'Sabado'
        WHEN EXTRACT(DOW FROM ts)=0 THEN 'Domingo'
    END), 
    EXTRACT(WEEK FROM ts), 
    EXTRACT(MONTH FROM ts) AS M, 
    CEILING(EXTRACT(MONTH FROM ts)/3), 
    EXTRACT(YEAR FROM ts) AS Y
FROM anomalia
ORDER BY Y ASC, M ASC, D ASC;

INSERT INTO d_local (latitude, longitude, nome) 
SELECT DISTINCT latitude, longitude,
    (SELECT nome FROM local_publico
     WHERE item.latitude=local_publico.latitude AND
     item.longitude=local_publico.longitude) AS R
FROM item
ORDER BY R ASC;

INSERT INTO d_lingua (lingua)
SELECT DISTINCT lingua
FROM anomalia
ORDER BY lingua ASC;


INSERT INTO f_anomalia
SELECT
    (SELECT id_utilizador FROM d_utilizador 
      WHERE incidencia.email=d_utilizador.email
    ) AS A,
    (SELECT id_tempo FROM d_tempo 
     WHERE dia=EXTRACT(DAY FROM ts) AND mes=EXTRACT(MONTH FROM ts) AND ano=EXTRACT(YEAR FROM ts)
    ) AS B,
    (SELECT id_local FROM d_local 
     WHERE item.latitude=d_local.latitude AND item.longitude=d_local.longitude
    ) AS C,
    (SELECT id_lingua FROM d_lingua 
     WHERE d_lingua.lingua=anomalia.lingua
    ) AS D,
    (SELECT CASE
        WHEN tem_anomalia_redacao=true THEN 'Redacao'
        ELSE 'Traducao'
     END
     FROM anomalia
     WHERE anomalia_id=anomalia.id
    ) AS E,
    (SELECT CASE
        WHEN anomalia_id IN (SELECT anomalia_id FROM correcao) THEN true 
        ELSE false
     END
     FROM incidencia
     WHERE anomalia_id=anomalia.id
    ) AS F
FROM anomalia,item,incidencia 
WHERE anomalia_id=anomalia.id AND item.id=item_id
ORDER BY A ASC, B ASC, C ASC, D ASC, E ASC, F DESC;
