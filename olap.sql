SELECT tipo_anomalia, lingua, dia_da_semana, COUNT(*) 
FROM f_anomalia NATURAL JOIN d_lingua NATURAL JOIN d_tempo 
GROUP BY CUBE(tipo_anomalia, lingua, dia_da_semana)
ORDER BY tipo_anomalia ASC, lingua ASC, CASE
   WHEN dia_da_semana = 'Segunda-Feira' THEN 1
   WHEN dia_da_semana = 'Terca-Feira' THEN 2
   WHEN dia_da_semana = 'Quarta-Feira' THEN 3
   WHEN dia_da_semana = 'Quinta-Feira' THEN 4
   WHEN dia_da_semana = 'Sexta-Feira' THEN 5
   WHEN dia_da_semana = 'Sabado' THEN 6
   WHEN dia_da_semana = 'Domingo' THEN 7
   ELSE 8
END ASC;