<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `articulos_historial` AFTER INSERT ON `articulos` FOR EACH ROW
        begin 
        insert into historiales 						(id,idarticulo,idasesor,titulo,fechaOrden,fechaLlegada,fechaAsignacion,fechaCulminacion,fechaRevisionInterna,	fechaEnvioPro,fechaHabilitacion,fechaEnvio,fechaAjustes,fechaAceptacion,fechaRechazo,idclasificacion,archivo,
                                idstatu,idrevista) 
        VALUES (NULL,NEW.id,NEW.idasesor,NEW.titulo,NEW.fechaOrden,NEW.fechaLlegada,NEW.fechaAsignacion,NEW.fechaCulminacion,NEW.fechaRevisionInterna,NEW.fechaEnvioPro,New.fechaHabilitacion,NEW.fechaEnvio,new.fechaAjustes,
               NEW.fechaAceptacion,NEW.fechaRechazo,NEW.idclasificacion,NEW.archivo,NEW.idstatu,NEW.idrevista);
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `update_articulos` AFTER UPDATE ON `historiales` FOR EACH ROW
        begin 

        DECLARE id_exists Boolean;
               -- Check BookingRequest table
               SELECT 1
               INTO @id_exists
               FROM articulos
               WHERE articulos.id= NEW.idarticulo;
        
               IF @id_exists = 1 and NEW.idrevista=24
               THEN
                   UPDATE articulos
                     SET articulos.fechaOrden = NEW.fechaOrden,
                    articulos.fechaLlegada = NEW.fechaLlegada,
                    articulos.fechaAsignacion = NEW.fechaAsignacion,
                    articulos.fechaCulminacion = NEW.fechaCulminacion,
                    articulos.fechaRevisionInterna = NEW.fechaRevisionInterna,
                    articulos.fechaEnvioPro = NEW.fechaEnvioPro,
                    articulos.fechaHabilitacion = NEW.fechaHabilitacion,
                    articulos.fechaEnvio = NEW.fechaEnvio,
                    articulos.fechaAjustes = NEW.fechaAjustes,
                    articulos.fechaAceptacion = NEW.fechaAceptacion,
                    articulos.fechaRechazo = NEW.fechaRechazo,
                    articulos.idstatu = NEW.idstatu,
                    articulos.idasesor = NEW.idasesor,
                    articulos.idclasificacion = NEW.idclasificacion
                   WHERE articulos.id = NEW.idArticulo;
                   ELSE
                   UPDATE articulos
         SET articulos.fechaOrden = NEW.fechaOrden,
                    articulos.fechaLlegada = NEW.fechaLlegada,
                    articulos.fechaAsignacion = NEW.fechaAsignacion,
                    articulos.fechaCulminacion = NEW.fechaCulminacion,
                    articulos.fechaRevisionInterna = NEW.fechaRevisionInterna,
                    articulos.fechaEnvioPro = NEW.fechaEnvioPro,
                    articulos.fechaHabilitacion = NEW.fechaHabilitacion,
                    articulos.fechaEnvio = NEW.fechaEnvio,
                    articulos.fechaAjustes = NEW.fechaAjustes,
                    articulos.fechaAceptacion = NEW.fechaAceptacion,
                    articulos.fechaRechazo = NEW.fechaRechazo,
                    articulos.idstatu = NEW.idstatu,
                    articulos.idasesor = NEW.idasesor,
                    articulos.idrevista = NEW.idrevista,
                    articulos.idclasificacion = NEW.idclasificacion
                   WHERE articulos.id = NEW.idArticulo;
                END IF;
        
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `usuarios_asesor` AFTER INSERT ON `users` FOR EACH ROW
        begin 
        if new.idrol=5 then 
          insert into asesors (id,id,num_documento,nombres,telefono,correo,condicion) 
          VALUES (NULL,NEW.id,NEW.num_documento,NEW.nombre,NEW.telefono,NEW.email,1);
        end if;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `usuarios_asesorventas` AFTER INSERT ON `users` FOR EACH ROW
        begin 
        if new.idrol=6 then 
          insert into asesorventas (id,id,num_documento,nombres,telefono,correo,condicion,zona_id) 
          VALUES (NULL,NEW.id,NEW.num_documento,NEW.nombre,NEW.telefono,NEW.email,1,NEW.zona_id);
        end if;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `usuarios_asesorventas_update` AFTER UPDATE ON `users` FOR EACH ROW
        BEGIN 
        IF new.idrol=6 THEN 
          UPDATE asesorventas 
                    SET asesorventas.num_documento = NEW.num_documento,
                    asesorventas.nombres = NEW.nombre,
                    asesorventas.telefono = NEW.telefono,
                    asesorventas.correo = NEW.email,
                    asesorventas.zona_id = NEW.zona_id
                    WHERE asesorventas.id = NEW.id;
        END IF;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER `tr_registrar_llamada` AFTER INSERT ON `registrosllamadas` FOR EACH ROW
        BEGIN
            INSERT INTO historial_llamadas
            (id,idllamada,idtipocontactos,fecha_llamada,duracion,
            observacion,idstatus)
            VALUES (NULL,NEW.id,NEW.idtipocontactos,NEW.fecha_llamada,NEW.duracion,NEW.observacion,
            NEW.idstatus);
        END
        ');
        DB::unprepared('
        CREATE TRIGGER `tr_actualizar_llamada` AFTER UPDATE ON `registrosllamadas` FOR EACH ROW
        BEGIN
            INSERT INTO historial_llamadas
            (id,idllamada,idtipocontactos,fecha_llamada,duracion,
            observacion,idstatus)
            VALUES (NULL,NEW.id,NEW.idtipocontactos,NEW.fecha_llamada,NEW.duracion,NEW.observacion,
            NEW.idstatus);
        END
        ');
        DB::unprepared('
        CREATE TRIGGER `tr_registrar_cuentas_por_cobrar` AFTER INSERT ON `ordentrabajo` FOR EACH ROW
        BEGIN
            INSERT INTO cuentas_por_cobrar
            (id,idordentrabajo,precio)
            VALUES (NULL,NEW.idordentrabajo,NEW.precio);
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `articulos_historial`');
        DB::unprepared('DROP TRIGGER `update_articulos`');
        DB::unprepared('DROP TRIGGER `usuarios_asesor`');
        DB::unprepared('DROP TRIGGER `usuarios_asesorventas`');
        DB::unprepared('DROP TRIGGER `usuarios_asesorventas_update`');
        DB::unprepared('DROP TRIGGER `tr_registrar_llamada`');
        DB::unprepared('DROP TRIGGER `tr_actualizar_llamada`');
        DB::unprepared('DROP TRIGGER `tr_registrar_cuentas_por_cobrar`');
    }
}
