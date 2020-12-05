CREATE or REPLACE Function calcular_capacidad(instalacion integer, fecha varchar(100), cap_buques integer)
RETURNS TABLE (id integer, dias_disponibles varchar(100), porcentaje_ocupacion decimal) AS $$

DECLARE 
tupla RECORD;
decim float;


BEGIN

	CREATE TABLE cant_buques_muelle(cantidad integer); 
	FOR TUPLA IN SELECT COUNT(permisos_muelle.patente_barco) AS cantidad FROM permisos_muelle WHERE permisos_muelle.id_instalacion = instalacion AND fecha = SUBSTRING(CAST(permisos_muelle.fecha_atraque AS varchar(100)), 1,10) LOOP
		INSERT INTO cant_buques_muelle VALUES (tupla.cantidad);
	END LOOP;

	CREATE TABLE cant_buques_astillero(cantidad integer);
	FOR TUPLA IN SELECT COUNT(permisos_astillero.patente_barco) AS cantidad FROM permisos_astillero WHERE permisos_astillero.id_instalacion = instalacion AND SUBSTRING(CAST(permisos_astillero.fecha_atraque AS varchar(100)), 1,10) <= fecha AND SUBSTRING(CAST(permisos_astillero.fecha_salida AS varchar(100)), 1,10) >= fecha LOOP
		INSERT INTO cant_buques_astillero VALUES (tupla.cantidad);
	END LOOP;

	CREATE TABLE suma_cant_buques AS (SELECT SUM(cantidad) total FROM (SELECT cant_buques_muelle.cantidad FROM cant_buques_muelle UNION ALL SELECT cant_buques_astillero.cantidad FROM cant_buques_astillero) t);

	CREATE TABLE capacidad_itinerario(id integer, dias_disponibles varchar(100), porcentaje_ocupacion decimal);
	FOR tupla IN SELECT * FROM suma_cant_buques LOOP
		IF tupla.total < cap_buques THEN 
			decim = CAST(tupla.total as float);
			INSERT INTO capacidad_itinerario VALUES (instalacion, fecha, (decim/cap_buques)*100);
		END IF;
	END LOOP;

	RETURN QUERY SELECT * FROM capacidad_itinerario;

	DROP TABLE capacidad_itinerario;
	DROP TABLE cant_buques_muelle;
	DROP TABLE cant_buques_astillero;
	DROP TABLE suma_cant_buques;

	RETURN;
END;
$$ language plpgsql;


        
