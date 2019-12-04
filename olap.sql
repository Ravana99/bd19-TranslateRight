(SELECT tipo_anomalia, lingua, dia_da_semana, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_lingua NATURAL JOIN d_tempo 
 GROUP BY tipo_anomalia, lingua, dia_da_semana
 ORDER BY tipo_anomalia ASC, lingua ASC, CASE
    WHEN dia_da_semana = 'Segunda-Feira' THEN 1
    WHEN dia_da_semana = 'Terca-Feira' THEN 2
    WHEN dia_da_semana = 'Quarta-Feira' THEN 3
    WHEN dia_da_semana = 'Quinta-Feira' THEN 4
    WHEN dia_da_semana = 'Sexta-Feira' THEN 5
    WHEN dia_da_semana = 'Sabado' THEN 6
    WHEN dia_da_semana = 'Domingo' THEN 7
 END ASC)

UNION ALL

(SELECT tipo_anomalia, lingua, NULL, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_lingua 
 GROUP BY tipo_anomalia, lingua
 ORDER BY tipo_anomalia ASC, lingua ASC)

UNION ALL

(SELECT tipo_anomalia, NULL, dia_da_semana, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_tempo 
 GROUP BY tipo_anomalia, dia_da_semana
 ORDER BY tipo_anomalia ASC, CASE
    WHEN dia_da_semana = 'Segunda-Feira' THEN 1
    WHEN dia_da_semana = 'Terca-Feira' THEN 2
    WHEN dia_da_semana = 'Quarta-Feira' THEN 3
    WHEN dia_da_semana = 'Quinta-Feira' THEN 4
    WHEN dia_da_semana = 'Sexta-Feira' THEN 5
    WHEN dia_da_semana = 'Sabado' THEN 6
    WHEN dia_da_semana = 'Domingo' THEN 7
 END ASC)

UNION ALL

(SELECT NULL, lingua, dia_da_semana, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_lingua NATURAL JOIN d_tempo 
 GROUP BY lingua, dia_da_semana
 ORDER BY lingua ASC, CASE
    WHEN dia_da_semana = 'Segunda-Feira' THEN 1
    WHEN dia_da_semana = 'Terca-Feira' THEN 2
    WHEN dia_da_semana = 'Quarta-Feira' THEN 3
    WHEN dia_da_semana = 'Quinta-Feira' THEN 4
    WHEN dia_da_semana = 'Sexta-Feira' THEN 5
    WHEN dia_da_semana = 'Sabado' THEN 6
    WHEN dia_da_semana = 'Domingo' THEN 7
 END ASC)

UNION ALL

(SELECT tipo_anomalia, NULL, NULL, COUNT(*) 
 FROM f_anomalia 
 GROUP BY tipo_anomalia
 ORDER BY tipo_anomalia ASC)

UNION ALL

(SELECT NULL, lingua, NULL, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_lingua 
 GROUP BY lingua
 ORDER BY lingua ASC)

UNION ALL

(SELECT NULL, NULL, dia_da_semana, COUNT(*) 
 FROM f_anomalia NATURAL JOIN d_tempo 
 GROUP BY dia_da_semana
 ORDER BY CASE
    WHEN dia_da_semana = 'Segunda-Feira' THEN 1
    WHEN dia_da_semana = 'Terca-Feira' THEN 2
    WHEN dia_da_semana = 'Quarta-Feira' THEN 3
    WHEN dia_da_semana = 'Quinta-Feira' THEN 4
    WHEN dia_da_semana = 'Sexta-Feira' THEN 5
    WHEN dia_da_semana = 'Sabado' THEN 6
    WHEN dia_da_semana = 'Domingo' THEN 7
 END ASC)

UNION ALL

(SELECT NULL, NULL, NULL, COUNT(*) 
 FROM f_anomalia);