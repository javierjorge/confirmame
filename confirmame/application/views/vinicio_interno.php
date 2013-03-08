<div  class="content">
<br><br><br>
<div class="eventos">
<h3><a href="<?= base_url() ?>interno/crear_evento">Crear Evento</a></h3>
<br>
<h2>Mis eventos</h2>
<br>
<table>
<?php
	$datos = false;  
	foreach ($vListEventos as $row ) {
		$datos = true; ?>
		<tr>
		<td><h4><a href="<?= base_url() ?>interno/verEvento/<?= $row->id ?>"><?= $row->nombre ?></a></h4></td> 
		<td><h4><a href="<?= base_url() ?>interno/editar_evento_invitados/<?= $row->id ?>">Avisar a mas personas</a></h4></td> 
		<td><h4><a href="<?= base_url() ?>interno/modificarEvento/<?= $row->id ?>">Modificar</a></h4></td>
		<td><h4><?php if($row->cancelado == 0) { ?><a href="<?= base_url() ?>interno/cancelarEvento/<?= $row->id ?>">Cancelar</a><?php } else {?><a href="<?= base_url() ?>interno/activarEvento/<?= $row->id ?>">Activar</a><?php } ?></h4></td>
		</tr>
<?php }?>
<?php if(!$datos) { echo "<tr><td><h2>No hay eventos creados</h2></td></tr>";}?>
</table>
</div>




<br><br><br>


<div class="invitaciones">
<h2>Mis Invitaciones</h2>
<br>
<table class="tabla_invitaciones">
	<tr>
		<td><h3>Evento nombre</h3></td>
		<td><h3>Fecha</h3></td>
		<td><h3>Hora Desde</h3></td>
		<td><h3>Hora Hasta</h3></td>
		<td><h3>Estado</h3></td>
		<td>&nbsp;</td>
	</tr>
<?php
	$datos = false;  
	foreach ($vListInvitaciones as $row ) {
		$datos = true; ?>
	<tr>
		<td><h4><a href="<?= base_url() ?>interno/verEvento/<?= $row->id_evento ?>"><?= $row->nombre ?></a></h4></td>
		<td><h4><?= $row->fecha ?></h4></td>
		<td><h4><?= substr($row->hora_desde,0,-3) ?></h4></td>
		<td><h4><?= substr($row->hora_hasta,0,-3) ?></h4></td>
		<?php
			switch ($row->confirma) {
				case "0":
					?><td><h4>A confirmar</h4></td><td><h4><a href="<?= base_url() ?>interno/voyEvento/<?= $row->id ?>">Voy</a> o <a href="<?= base_url() ?>interno/noVoyEvento/<?= $row->id ?>">No voy</a></h4></td><?php 
					break;
				case "1":
					?><td><h4>Voy</h4></td><td><h4><a href="<?= base_url() ?>interno/noVoyEvento/<?= $row->id ?>">cambiar a No voy</a></h4></td><?php 
					break;
				case "2":
					?><td><h4>No voy</h4></td><td><h4><a href="<?= base_url() ?>interno/voyEvento/<?= $row->id ?>">cambiar a voy</a></h4></td><?php 
				break;
				default:
					?><td><h4>A confirmar</h4></td><td><h4><a href="<?= base_url() ?>interno/voyEvento/<?= $row->id ?>">Voy</a> o <a href="<?= base_url() ?>interno/noVoyEvento/<?= $row->id ?>">No voy</a></h4></td><?php 
					break;			
			}
		?>
		</tr>
<?php }?>
<?php if(!$datos) { echo "<tr><td colspam=\"6\"><h2>No hay invitaciones</h2></td></tr>";}?>
	
</table>
</div>
</div>