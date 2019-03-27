<?php
	/**
	 * Constantes usadas no projeto
	 */
	class constants
	{

		const SQL_TOTAL_CHAMADOS = <<<EOF
		DROP TABLE IF EXISTS report;

		CREATE temporary TABLE report
		  (
		     Novos int,
			 N_Solucionados int,
			 N_Solucionados_User int,
			 Outros int,
			 Dt_hoje date,
			 Vencidos int,
			 N_Atribuidos int,
			 Internos int,
			 Venc_umdia int,
			 Venc_doisdia int,
			 Venc_tresdia int,
			 Venc_quatrodia int,
			 Venc_cincodia int,
			 Venc_seisdia int,
			 Venc_setedia int,
			 Venc_oitodia int,
			 Venc_novedia int,
			 Venc_dezdia int
		  /*

		  Dois_dias datetime,
		  Tres_Dias datetime,
		  Quatro_dias datetime,
		  Cinco_dias datetime,
		  Venc_umdia int

		  Venc_doisdias int,
		  Venc_tresdias int,
		  Venc_quatrodias int,
		  Venc_cincodias int*/
		  )
		engine memory;

		INSERT INTO report
		VALUES     ( (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND status = 1
		                     AND is_deleted = 0
		                     AND itilcategories_id not in (3, 4, 9, 14)
		              ORDER  BY id DESC),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		              ORDER  BY id DESC),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND itilcategories_id not in (3, 4, 9, 14)
		              ORDER  BY id DESC),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
                             AND itilcategories_id in (0, 14, 9)
		              ORDER  BY id DESC),

		             ( Now() ),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) < Now()
		              ORDER  BY id DESC), /* corrigir sql */

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND NOT EXISTS (SELECT *
		                                     FROM   glpi_tickets_users
		                                     WHERE  glpi_tickets_users.tickets_id =
		                                            glpi_tickets.id
		                                            AND glpi_tickets.is_deleted = 0
		                                            AND glpi_tickets_users.type = '2')
		              ORDER  BY id DESC), /* corrigir sql */

		             /*
		             (adddate(dt_hoje, 2)),

		             (adddate(dt_hoje, 3)),

		             (adddate(dt_hoje, 4)),

		             (adddate(dt_hoje, 5)),
		             */

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND itilcategories_id in (3, 4)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 1))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 2))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 3))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 4))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 5))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 6))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 7))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 8))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 9))AS
		                                                  date)),

		             (SELECT Count(glpi_tickets.id)
		              FROM   glpi_tickets
		              WHERE  closedate IS NULL
		                     AND solvedate IS NULL
		                     AND is_deleted = 0
		                     AND Cast(time_to_Resolve AS date) = Cast((Adddate(Now(), 10))AS
		                                                  date)) );

		SELECT * FROM   report
EOF;

		const SQL_TOTAL_TECNICO = <<<EOF
						SELECT c.id,
		       count(*) as total,
		       (SELECT Count(DISTINCT d.id, e.users_id)
		        FROM   glpi_tickets d
		               INNER JOIN glpi_tickets_users e
		                       ON d.id = e.tickets_id
		        WHERE  d.solvedate <> ''
		               AND Concat(Month(d.solvedate), Year(d.solvedate)) =
		                   Concat(Month(Now()), Year(Now()))
					   AND d.is_deleted = 0
		               AND e.users_id = c.id
		               AND e.type = '2'
		        GROUP  BY c.id) AS solucionados,
		       c.firstname
		FROM   glpi_tickets a,
		       glpi_tickets_users b,
		       glpi_users c
		WHERE  a.closedate IS NULL
		       AND a.solvedate IS NULL
		       AND a.id = b.tickets_id
		       AND b.type = '2'
		       AND c.id = b.users_id
		       AND a.is_deleted = 0
		group by c.firstname
		ORDER  BY c.firstname
EOF;

		const SQL_TOTAL_AREA = <<<EOF
				SELECT Count(*) AS total,
		       ( CASE ( CASE tca.level
		                  WHEN 1 THEN tca.name
		                  WHEN 2 THEN tcb.name
		                  WHEN 3 THEN tcc.name
		                  WHEN 4 THEN tcd.name
		                end )
		           WHEN 'Sistemas' THEN 'Sis'
				   WHEN 'Infraestrutura' THEN 'Infra'
				   WHEN 'GPE' THEN 'GPE'
                   ELSE 'N/A'
		         end )  AS area
		FROM   glpi_tickets
		       INNER JOIN glpi_itilcategories tca
		               ON tca.id = glpi_tickets.itilcategories_id
		       LEFT JOIN glpi_itilcategories tcb
		              ON tca.itilcategories_id = tcb.id
		       LEFT JOIN glpi_itilcategories tcc
		              ON tcb.itilcategories_id = tcc.id
		       LEFT JOIN glpi_itilcategories tcd
		              ON tcc.itilcategories_id = tcd.id
		WHERE  glpi_tickets.closedate IS NULL
		       AND glpi_tickets.solvedate IS NULL
		       AND glpi_tickets.is_deleted = 0
		GROUP  BY 2
		ORDER  BY 2
EOF;

		const SQL_TOTAL_AREA_NOVOS = <<<EOF
				SELECT count(*) AS total,
		       ( CASE ( CASE tca.level
		                  WHEN 1 THEN tca.name
		                  WHEN 2 THEN tcb.name
		                  WHEN 3 THEN tcc.name
		                  WHEN 4 THEN tcd.name
		                end )
		           WHEN 'Sistemas' THEN 'Sis'
				   WHEN 'Infraestrutura' THEN 'Infra'
				   WHEN 'GPE' THEN 'GPE'
                   ELSE 'N/A'
		         end )  AS area
		       /*tca.level,
		       tca.name,
		       tcb.name,
		       tcc.name,
		       tcd.name */
		FROM   glpi_tickets
		       INNER JOIN glpi_itilcategories tca
		               ON tca.id = glpi_tickets.itilcategories_id
		       LEFT JOIN glpi_itilcategories tcb
		              ON tca.itilcategories_id = tcb.id
		       LEFT JOIN glpi_itilcategories tcc
		              ON tcb.itilcategories_id = tcc.id
		       LEFT JOIN glpi_itilcategories tcd
		              ON tcc.itilcategories_id = tcd.id
		WHERE  glpi_tickets.closedate IS NULL
		       AND glpi_tickets.solvedate IS NULL
		       AND glpi_tickets.status = 1
		       AND glpi_tickets.is_deleted = 0
		GROUP  BY 2
		ORDER  BY 2
EOF;

		const INV_REQ_DATA = "INVALID REQUEST DATA";
		const SQL_EXISTE_MODIFICACAO = "select (count(*) > 0) as existe_mod, now() as timestamp from glpi_tickets where is_deleted = 0 and date_mod >= ";
		const SQL_EXISTE_MODIFICACAO_FOLLOW = "select (count(*) > 0) as existe_mod, now() as timestamp from glpi_ticketfollowups where is_private = 0 and content <> '' and date >= ";
		const SQL_FOLLOW_UP = <<<EOF
		SELECT c.id as ticket, a.date, a.content, concat(b.firstname, " ",  b.realname) as realname, c.name ,
		(select count(*) > 0 from glpi_tickets_users where glpi_tickets_users.type = '2' and glpi_tickets_users.tickets_id = a.tickets_id and glpi_tickets_users.users_id =  a.users_id) as is_tecnico,
        (select count(*) > 0 from glpi_tickets_users where glpi_tickets_users.type = '1' and (glpi_tickets_users.tickets_id = a.tickets_id and glpi_tickets_users.users_id =  a.users_id or a.users_id = c.users_id_recipient)) as is_ator
        FROM glpi.glpi_ticketfollowups a
		inner join glpi.glpi_users b on a.users_id = b.id
		inner join glpi.glpi_tickets c on a.tickets_id = c.id
		where c.is_deleted = 0 and a.is_private = 0 and a.content <> '' and a.date >=
EOF;
		const SQL_INSERT_TIMELINE = "INSERT INTO glpi.glpi_plugin_timelineticket_states (tickets_id, date, old_status, new_status, delay) VALUES (:tickets_id, :date, :old_status, :new_status, :delay) ";
		const SQL_OLD_DATA_TIMELINE = "SELECT * FROM glpi.glpi_plugin_timelineticket_states WHERE tickets_id = :tickets_id ORDER BY id DESC LIMIT 1 ";
		const SQL_TICKET_DATA = "SELECT * FROM glpi.glpi_tickets WHERE is_deleted = 0 AND id = :id  ";
		const SQL_UPDATE_TICKET = "UPDATE glpi.glpi_tickets SET status = :status WHERE id = :id LIMIT 1 ";
	}

	?>