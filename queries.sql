/*Query #1*/

SELECT nome
FROM item NATURAL JOIN local_publico NATURAL JOIN incidencia 
WHERE id=item_id 
GROUP BY nome, latitude, longitude 
HAVING COUNT(*)>=ALL (
    SELECT COUNT(*) 
    FROM item NATURAL JOIN incidencia 
    WHERE id=item_id 
    GROUP BY latitude, longitude
);

/*Query #2*/

SELECT email 
FROM anomalia NATURAL JOIN anomalia_traducao NATURAL JOIN incidencia NATURAL JOIN utilizador_regular 
WHERE ts>='2019-01-01 00:00:00' AND 
      ts<='2019-06-30 23:59:59' AND 
      id=anomalia_id 
GROUP BY email
HAVING COUNT(*)>=ALL (
    SELECT COUNT(*) 
    FROM anomalia NATURAL JOIN anomalia_traducao NATURAL JOIN incidencia NATURAL JOIN utilizador_regular 
    WHERE ts>='2019-01-01 00:00:00' AND 
          ts<='2019-06-30 23:59:59' AND 
          id=anomalia_id 
    GROUP BY email
);

/*Query #3*/

SELECT email 
FROM utilizador 
WHERE email NOT IN (
    SELECT DISTINCT email 
    FROM (
        (SELECT email,latitude,longitude FROM utilizador,local_publico WHERE latitude>39.336775) 
        EXCEPT 
        (SELECT DISTINCT email,latitude,longitude 
        FROM anomalia,incidencia,item NATURAL JOIN local_publico 
        WHERE item_id=item.id AND 
              anomalia_id=anomalia.id AND 
              EXTRACT(year FROM ts)=2019 AND 
              latitude>39.336775)
    ) AS R
);

/*Query #4*/

SELECT DISTINCT email 
FROM (
    (SELECT email,anomalia_id 
    FROM anomalia,incidencia,item NATURAL JOIN local_publico 
    WHERE item.id=item_id AND
          anomalia.id=anomalia_id AND 
          latitude<39.336775 AND 
          EXTRACT(year FROM ts)=EXTRACT(year FROM CURRENT_DATE) AND 
          email IN (SELECT email FROM utilizador_qualificado)) 
    EXCEPT 
    (SELECT email,anomalia_id FROM correcao)
) AS R;