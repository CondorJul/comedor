
CREATE TABLE menu(
	id serial primary key,
	type int check(type>=1 and type<=3), /*1=desayuno, 2=almuerzo, 3=cena*/

	soup varchar(200), /*sopa de moron*/
	second varchar(200), /*escabeche*/
	drink varchar(200), /*bebidas*/
	dessert varchar(200), /*postre*/
	fruit varchar(200), /*frutas*/
	aditional varchar(200),
	/*Otros atributos como la tabla nutricional*/
	skd_date date, /*fecha programada del menu*/

	/*reservacion activa o no */
	state_reser int, /*1=activo 0*inactivo*/
	reser_date_start timestamp,/*Fecha de inicio de reserva, programada para este menu, por ejemplo un ida antes */
	reser_date_end timestamp, /*Fecha de fin, programada de reserva para este menu, por ejemplo hasta la hora de atencion*/

	unique(type, skd_date),

	check(reser_date_start::date<=skd_date),
	check(reser_date_start<reser_date_end)

);

/*Tabla para controlar los intevalos de resrvacion*/
CREATE TABLE timetable(
	id serial primary key,
	type int, /*1=desayuno, 2=almuerzo, 3=cena*/
	food_start time, /*12:00*/
	food_end time, /*12:20*/
	cant int, /*120 porciones para este intervalo de tiempo*/
	check(food_start<food_end)
);



CREATE TABLE d_reservation(
	id serial primary key,

	eid varchar(150),
	oid varchar(150), 
	uid varchar(15),
	escid varchar(15),
	subid varchar(10),


	id_menu int, /*id del menu programado*/
	

	id_timetable int,     /*opcional*/
	assist boolean default false,
	assist_time timestamp,
	reservation_time timestamp default now(),/*fecha captura */
	
	foreign key(id_menu) references menu(id),
	foreign key(id_timetable) references timetable(id),
	
	unique(id_menu, uid)
);


ALTER TABLE d_reservation ALTER COLUMN assist
SET DEFAULT null;



ALTER TABLE d_reservation 
ADD COLUMN pid VARCHAR(15) DEFAULT NULL;


CREATE TABLE noticias(
	id serial primary key, 
	title varchar(300),
	date_pub timestamp not null default now(), 
	descrip text, 
	state int
);



CREATE OR REPLACE FUNCTION function_upd_d_reservation() RETURNS TRIGGER AS $$
DECLARE
	_state_reser integer;
	_skd_date date;
	_reser_date_start timestamp;
	_reser_date_end timestamp;
	_state boolean:=true;
BEGIN

	IF new.assist=true THEN
		new.assist_time=now();
		new.id_timetable=old.id_timetable;
		_state:=false;
	END IF;

	/*verificamos que la asistencia se realizo*/
	IF old.assist=true THEN 
		RAISE EXCEPTION '<MSG>No se puede realizar ningun tipo de modificacion en esta reservación<MSG>';
		/*new.assist=old.assist;*/
		/*new.assist_time=old.assist_time;*/
	END IF;

	select  state_reser  , skd_date  ,
	 reser_date_start, reser_date_end into _state_reser, _skd_date,  _reser_date_start, _reser_date_end from menu where id=new."id_menu";

	IF _state_reser=0 THEN
		RAISE EXCEPTION '<MSG>La reserva de este menú esta desactivado por el momento.<MSG>';
	END IF;

	/*comprobamos que el menu este activo par la reservacion*/

	IF _state and now() <_reser_date_start THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Reservación no disponible. La reservación comenzará a las %.<MSG>',to_char( _reser_date_start, 'HH:MIam DD-mm-YYYY') ;
	END IF;

	IF _state and now()>_reser_date_end THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Lo sentimos, esta reservación vencío a las %<MSG>', to_char( _reser_date_end, 'HH:MIam DD-mm-YYYY') ;
	END IF;
	/*comprobamos que no sobrepasamos  la cantidad de reservacion*/
	IF _state and (select cant from timetable where id=new."id_timetable")<=(select count(id_timetable) from d_reservation where id_menu=new."id_menu" and id_timetable=new."id_timetable") THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Lo sentimos, en estos momentos no hay cupos disponibles.<MSG>';
	END IF;


	/*Propioas del update*/	
	IF old.id_timetable<>new.id_timetable THEN 
		new.reservation_time=now();
	END IF;

	IF new.id_timetable is null THEN
		new.assist=null;
	END IF;

	IF new.id_timetable is not null and old.id_timetable is null THEN 
		new.assist=false;
		new.reservation_time=now();
	END IF;

 RETURN new;
 
END $$ LANGUAGE plpgsql;




CREATE OR REPLACE FUNCTION function_add_d_reservation() RETURNS TRIGGER AS $$
DECLARE
	_state_reser integer;
	_skd_date date;
	_reser_date_start timestamp;
	_reser_date_end timestamp;

	/*DATOS DE ALUMNO*/
	_rid varchar(5);
	_state_c varchar(5);
BEGIN

	new.assist=false;


	select  state_reser  , skd_date  ,
	 reser_date_start, reser_date_end into _state_reser, _skd_date,  _reser_date_start, _reser_date_end from menu where id=new."id_menu";


	 select rid, state_c into _rid, _state_c from base_users where eid=new.eid and oid=new.oid and uid=new.uid and escid=new.escid and subid=new.subid and pid=new.pid;

	IF _rid<>'AL' THEN
				RAISE EXCEPTION '<MSG>Lo sentimos, la reserva solo aplica para alumnos activos de pre-grado.<MSG>';
	END IF;

	IF _state_c<>'A' THEN
				RAISE EXCEPTION '<MSG>Lo sentimos, usted no puede realizar reservas, si es un error, acercase a la Dirección del Comedor Universitario.<MSG>';
	END IF;

	 /*Comprobamos que la resrvacion no este desactivada*/
	IF _state_reser=0 THEN
		RAISE EXCEPTION '<MSG>La reserva de este menú esta desactivado por el momento.<MSG>';
	END IF;
	/*comprobamos que el menu este activo par la reservacion*/
	IF now() <_reser_date_start THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Reservación no disponible. La reservación comenzará a las %.<MSG>',to_char( _reser_date_start, 'HH:MIam DD-mm-YYYY') ;
	END IF;

	IF now()>_reser_date_end THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Lo sentimos, esta reservación vencío a las %<MSG>', to_char( _reser_date_end, 'HH:MIam DD-mm-YYYY') ;
	END IF;

	/*comprobamos que no sobrepasamos  la cantidad de reservacion*/
	IF (select cant from timetable where id=new."id_timetable")<=(select count(id_timetable) from d_reservation where id_menu=new."id_menu" and id_timetable=new."id_timetable") THEN
		 /*RAISE EXCEPTION  USING errcode = 50078;*/
		 RAISE EXCEPTION '<MSG>Lo sentimos, en estos momentos no hay cupos disponibles.<MSG>';
	END IF;


 RETURN new;
	 /*EXCEPTION 
	WHEN SQLSTATE '50078' THEN
		RAISE NOTICE  'Lo sentimos, en estos mosmentos no hay cupos disponibles.';
	WHEN OTHERS THEN
		raise notice '% %', SQLERRM, SQLSTATE;*/

 
END $$ LANGUAGE plpgsql;


CREATE TRIGGER trigger_upd_d_reservation BEFORE 
UPDATE ON d_reservation
FOR EACH ROW EXECUTE PROCEDURE function_upd_d_reservation();

CREATE TRIGGER trigger_add_d_reservation BEFORE 
INSERT ON d_reservation
FOR EACH ROW EXECUTE PROCEDURE function_add_d_reservation();

/*inicio-crear tabla historial-prodedure-trigger-evento*/
CREATE TABLE h_d_reservation(
	id serial primary key,
	/*alumno*/
	eid varchar(150),
	oid varchar(150), 
	uid varchar(15),
	escid varchar(15),
	subid varchar(10),

	/*id menu*/
	id_menu int, /*id del menu programado*/

	id_timetable int,     /*opcional*/
	assist boolean,
	assist_time timestamp,
	reservation_time timestamp,/*fecha captura */


	/*horary*/
	type int, /*1=desayuno, 2=almuerzo, 3=cena*/
	food_start time, /*12:00*/
	food_end time, /*12:20*/
	cant int /*120 porciones para este intervalo de tiempo*/

);

ALTER TABLE h_d_reservation 
ADD COLUMN pid VARCHAR(15) DEFAULT NULL;

CREATE OR REPLACE FUNCTION function_del_d_reservation() RETURNS TRIGGER AS $$
DECLARE
	_id integer;
	_type int; /*1=desayuno, 2=almuerzo, 3=cena*/
	_food_start time;
	_food_end time;
	_cant int;
BEGIN


	select  id,  type, food_start, food_end, cant into _id,  _type, _food_start, _food_end, _cant  from timetable where id=old."id_timetable";
	insert into h_d_reservation(eid, oid,uid,escid, subid ,id_menu, id_timetable, assist,
	 assist_time, reservation_time, type, food_start, food_end, cant ) 
						values(old.eid, old.oid, old.uid, old.escid, old.subid, old.id_menu, old.id_timetable
							, old.assist, old.assist_time, old.reservation_time, _type, _food_start, _food_end, _cant ); 
RETURN OLD;
	 
END $$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_del_d_reservation BEFORE 
DELETE ON d_reservation
FOR EACH ROW EXECUTE PROCEDURE function_del_d_reservation(); 


/*fin- crear tabla historial*/



create table token_users_firebase(
	token VARCHAR(500) PRIMARY KEY,
	
	eid varchar(150),
	oid varchar(150), 
	uid varchar(15),
	escid varchar(15),
	subid varchar(10),
	pid VARCHAR(15),
	
	date_subscribed timestamp,
	
	date_logged_in timestamp, 
	date_logout timestamp,
	
	foreign key(eid, oid, uid, escid, subid, pid) references base_users(eid, oid, uid, escid, subid, pid)
	
);



ALTER TABLE d_reservation 
ADD COLUMN score int DEFAULT NULL,
ADD COLUMN comment varchar(500) DEFAULT NULL;

ALTER TABLE h_d_reservation 
ADD COLUMN score int DEFAULT NULL,
ADD COLUMN comment varchar(500) DEFAULT NULL;

ALTER TABLE base_users 
ADD COLUMN token varchar(200) DEFAULT NULL;