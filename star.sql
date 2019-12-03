DROP TABLE IF EXISTS d_utilizador CASCADE;
DROP TABLE IF EXISTS d_tempo CASCADE;
DROP TABLE IF EXISTS d_local CASCADE;
DROP TABLE IF EXISTS d_lingua CASCADE;
DROP TABLE IF EXISTS f_anomalia CASCADE;

CREATE TABLE d_utilizador
(
    id_utilizador SERIAL NOT NULL,
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
    pais VARCHAR(100),
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
    CONSTRAINT fk_f_anomalia_d_utilizador 
        FOREIGN KEY(id_utilizador) REFERENCES d_utilizador(id_utilizador),
    CONSTRAINT fk_f_anomalia_d_tempo 
        FOREIGN KEY(id_tempo) REFERENCES d_tempo(id_tempo),
    CONSTRAINT fk_f_anomalia_d_local 
        FOREIGN KEY(id_local) REFERENCES d_local(id_local),
    CONSTRAINT fk_f_anomalia_d_lingua 
        FOREIGN KEY(id_lingua) REFERENCES d_lingua(id_lingua)
);


INSERT INTO d_utilizador (tipo) VALUES 
    ('Regular'),
    ('Qualificado');

INSERT INTO d_tempo (dia, dia_da_semana, semana, mes, trimestre, ano)
SELECT DISTINCT
    EXTRACT(DAY FROM ts), 
    ((SELECT 'Segunda-Feira' WHERE EXTRACT(DOW FROM ts)=1) UNION ALL 
     (SELECT 'Terca-Feira' WHERE EXTRACT(DOW FROM ts)=2) UNION ALL 
     (SELECT 'Quarta-Feira' WHERE EXTRACT(DOW FROM ts)=3) UNION ALL 
     (SELECT 'Quinta-Feira' WHERE EXTRACT(DOW FROM ts)=4) UNION ALL 
     (SELECT 'Sexta-Feira' WHERE EXTRACT(DOW FROM ts)=5) UNION ALL 
     (SELECT 'Sabado' WHERE EXTRACT(DOW FROM ts)=6) UNION ALL 
     (SELECT 'Domingo' WHERE EXTRACT(DOW FROM ts)=0)), 
    EXTRACT(WEEK FROM ts), 
    EXTRACT(MONTH FROM ts), 
    FLOOR((EXTRACT(MONTH FROM ts)-1)/3)+1, 
    EXTRACT(YEAR FROM ts)
FROM anomalia;

INSERT INTO d_local (latitude, longitude, nome) 
SELECT latitude, longitude, nome 
FROM local_publico;

INSERT INTO d_lingua (lingua, pais) VALUES 
    ('Portugues','Portugal'), 
    ('Espanhol','Espanha'), 
    ('Frances','Franca'), 
    ('Ingles','Reino Unido'), 
    ('Italiano','Italia'); 



INSERT INTO f_anomalia
SELECT
    ((SELECT id_utilizador FROM d_utilizador 
      WHERE id_utilizador=1 AND incidencia.email IN (SELECT email FROM utilizador_regular)) 
      UNION ALL 
     (SELECT id_utilizador FROM d_utilizador 
      WHERE id_utilizador=2 AND incidencia.email IN (SELECT email FROM utilizador_qualificado))
    ),
    (SELECT id_tempo FROM d_tempo 
     WHERE dia=EXTRACT(DAY FROM ts) AND 
           mes=EXTRACT(MONTH FROM ts) AND 
           ano=EXTRACT(YEAR FROM ts)
    ),
    (SELECT id_local FROM d_local 
     WHERE item.latitude=d_local.latitude AND 
           item.longitude = d_local.longitude
    ),
    (SELECT id_lingua FROM d_lingua 
     WHERE d_lingua.lingua=anomalia.lingua
    ),
    ((SELECT 'Redacao' FROM anomalia 
      WHERE tem_anomalia_redacao=true AND anomalia_id=anomalia.id) 
      UNION ALL 
     (SELECT 'Traducao' FROM anomalia 
      WHERE tem_anomalia_redacao=false AND anomalia_id=anomalia.id)
    ),
    ((SELECT true FROM incidencia 
      WHERE anomalia_id IN (SELECT anomalia_id FROM correcao) AND anomalia_id=anomalia.id) 
      UNION ALL 
     (SELECT false FROM incidencia 
      WHERE anomalia_id NOT IN (SELECT anomalia_id FROM correcao) AND anomalia_id=anomalia.id)
    )
FROM anomalia,item,incidencia 
WHERE anomalia_id=anomalia.id AND item.id=item_id;