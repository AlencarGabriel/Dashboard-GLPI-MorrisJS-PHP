<?php 
	/**
	 * Constantes usadas no projeto
	 */
	class constants
	{
		
		const SQL_TOTAL_CHAMADOS = <<<EOF
		drop table if exists report;

		Create temporary table report(
		Novos int,
		N_Solucionados int,
		Outros int,
		Dt_hoje date,
		Vencidos int,
		N_Atribuidos int,
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

		) engine memory;

		insert into report values( 
		(select count(glpi_tickets.id) from glpi_tickets
		where closedate is null
		and status = 'new'
		order by id desc),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		order by id desc),

		((N_solucionados) - (Novos)), 

		(Now()),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null and
		cast(due_date as date) < Now()
		order by id desc),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null 	
		and
		not exists (select * from glpi_tickets_users 
		where glpi_tickets_users.tickets_id = glpi_tickets.id
		and glpi_tickets_users.type = '2')
		order by id desc),

		/*
		(adddate(dt_hoje, 2)),

		(adddate(dt_hoje, 3)),
		
		(adddate(dt_hoje, 4)),

		(adddate(dt_hoje, 5)),
		*/
		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 1))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 2))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 3))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 4))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 5))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 6))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 7))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 8))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 9))as date)
		),

		(select count(glpi_tickets.id) 
		from glpi_tickets
		where closedate is null
		and solvedate is null
		and cast(due_date as date) = cast((adddate(now(), 10))as date)
		)


		);

		select * from report
EOF;

		const SQL_TOTAL_TECNICO = <<<EOF
		select 
		c.id,
		count(*) as total,
        (select  count(distinct d.id, e.users_id) from glpi_tickets d inner join glpi_tickets_users e on d.id = e.tickets_id where d.solvedate <> '' and concat(month(d.solvedate) , year(d.solvedate)) = concat(month(now()) , year(now())) and e.users_id = c.id and e.type = '2'  group by c.id) as solucionados,
		c.firstname

		from 
		glpi_tickets a, 
		glpi_tickets_users b,
		glpi_users c

		where a.closedate is null
		and a.solvedate is null
		and a.id = b.tickets_id
		and b.type = '2'
		and c.id = b.users_id

		group by c.id
		order by c.firstname
EOF;

		const SQL_TOTAL_AREA = <<<EOF
		select 
		count(*) as total,
		(case tcb.name 
              when 'INFRAESTRUTURA' THEN 'Infra'
              when 'SISTEMAS' THEN 'Sis'
              ELSE 'OUTRA'
              END) as area
		from 
		glpi_tickets
		
        inner join glpi_ticketcategories tca on tca.id = glpi_tickets.ticketcategories_id        
        inner join glpi_ticketcategories tcb on tca.ticketcategories_id = tcb.id

		where glpi_tickets.closedate is null
		and glpi_tickets.solvedate is null		
        and tcb.level = 1

		group by tcb.name
		order by tcb.name


EOF;

		const SQL_TOTAL_AREA_NOVOS = <<<EOF
		select 
		count(*) as total,
		(case tcb.name 
              when 'INFRAESTRUTURA' THEN 'Infra'
              when 'SISTEMAS' THEN 'Sis'
              ELSE 'OUTRA'
              END) as area
		from 
		glpi_tickets
		
        inner join glpi_ticketcategories tca on tca.id = glpi_tickets.ticketcategories_id        
        inner join glpi_ticketcategories tcb on tca.ticketcategories_id = tcb.id

		where glpi_tickets.closedate is null
		and glpi_tickets.solvedate is null		
        and tcb.level = 1
		and glpi_tickets.status = 'new'

		group by tcb.name
		order by tcb.name


EOF;

		const INV_REQ_DATA = "INVALID REQUEST DATA";
		const SQL_EXISTE_MODIFICACAO = "select (count(*) > 0) as existe_mod, now() as timestamp from glpi_tickets where date_mod >= ";
		const SQL_EXISTE_MODIFICACAO_FOLLOW = "select (count(*) > 0) as existe_mod, now() as timestamp from glpi_ticketfollowups where is_private = 0 and content <> '' and date >= ";		
		const SQL_FOLLOW_UP = <<<EOF
		SELECT c.id as ticket, a.date, a.content, concat(b.firstname, " ",  b.realname) as realname, c.name ,
		(select count(*) > 0 from glpi_tickets_users where glpi_tickets_users.type = '2' and glpi_tickets_users.tickets_id = a.tickets_id and glpi_tickets_users.users_id =  a.users_id) as is_tecnico,
        (select count(*) > 0 from glpi_tickets_users where glpi_tickets_users.type = '1' and (glpi_tickets_users.tickets_id = a.tickets_id and glpi_tickets_users.users_id =  a.users_id or a.users_id = c.users_id_recipient)) as is_ator        
        FROM glpi.glpi_ticketfollowups a
		inner join glpi.glpi_users b on a.users_id = b.id
		inner join glpi.glpi_tickets c on a.tickets_id = c.id
		where a.is_private = 0 and a.content <> '' and a.date >= 
EOF;
	}

	?>