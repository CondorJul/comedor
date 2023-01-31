
/*Modificaciones alter 29/08/2019*/

/*justification_state
NR=No requiere justificacion
JP=Justificacion pendiente
JA=Justificacion aceptada
JO=Justificación observada
JD=Justificacion denegada
*/


ALTER TABLE h_d_reservation 
ADD COLUMN just_state VARCHAR(10) DEFAULT NULL,
ADD COLUMN just_state_time TIMESTAMP DEFAULT NULL,

ADD COLUMN just_request TEXT DEFAULT NULL,
ADD COLUMN just_request_time TIMESTAMP DEFAULT NULL,

ADD COLUMN Just_response TEXT DEFAULT NULL,
ADD COLUMN just_response_time TIMESTAMP DEFAULT NULL,

ADD COLUMN migration_date TIMESTAMP  NOT NULL DEFAULT now();


/*alter 17/09/2019*/
ALTER TABLE d_reservation 
ADD COLUMN inserted_from VARCHAR(10) DEFAULT NULL,
ADD COLUMN period VARCHAR(10) DEFAULT NULL;

ALTER TABLE h_d_reservation 
ADD COLUMN inserted_from VARCHAR(10) DEFAULT NULL,
ADD COLUMN period VARCHAR(10) DEFAULT NULL; /*18A, 18B, 19A, 19B*/


/*17/09/2019*/


/*Modificaciones*/
CREATE OR REPLACE FUNCTION function_del_d_reservation() RETURNS TRIGGER AS $$
DECLARE
	_id integer;
	_type int; /*1=desayuno, 2=almuerzo, 3=cena*/
	_food_start time;
	_food_end time;
	_cant int;
	_just_state varchar(10);
BEGIN
	
	IF old.assist=false THEN
		_just_state:='JP';
	ELSE
		_just_state:='NR';
	END IF;

	select  id,  type, food_start, food_end, cant into _id,  _type, _food_start, _food_end, _cant  from timetable where id=old."id_timetable";
	
	insert into h_d_reservation(eid, oid,uid,escid, subid,pid ,id_menu, id_timetable, assist,
	 assist_time, reservation_time,inserted_from , period, type, food_start, food_end, cant , just_state) 
						values(old.eid, old.oid, old.uid, old.escid, old.subid, old.pid, old.id_menu, old.id_timetable
							, old.assist, old.assist_time, old.reservation_time, old.inserted_from,old.period,  _type, _food_start, _food_end, _cant, _just_state ); 
RETURN OLD;
	 
END $$ LANGUAGE plpgsql;


/*Modificaciones fin alter 29/08/2019*/




ALTER TABLE base_users RENAME "stateC" TO state_c;
ALTER TABLE base_users ALTER COLUMN state_c TYPE VARCHAR(5);