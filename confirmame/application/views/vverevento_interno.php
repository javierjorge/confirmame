<div  class="content">
<table>
	<tr>
		<td coldspan="2"><h1>Registro</h1><br></td>
	</tr>
	<tr>
		<td><h2>Nombre</h2></td>
    	<td><?= $evento->nombre ?></td>
    </tr>
	<tr>
		<td><h2>Descripcion</h2></td>
    	<td><?= $evento->descripcion ?></td>
    </tr>
    <tr>
    	<td><h2>Fecha</h2></td>
    	<td><?= $evento->fecha ?></td>
    </tr>
    <tr>
    	<td><h2>Hora Desde</h2></td>
    	<td><?= $evento->hora_desde ?></td>
    </tr>
    <tr>
    	<td><h2>Hora Hasta</h2></td>
    	<td><?= $evento->hora_hasta ?></td>
    </tr>
    <tr>
    	<td><h2>Fecha Vencimiento</h2></td>
    	<td><?= $evento->fecha_venc ?></td>
    </tr>
</table>

<h2>Mis Invitados</h2>
Nombre  | mail | Estado  <br>

<?php
	$datos = false;  
	foreach ($vListInvitaciones as $row ) {
		$datos = true; ?>
		<?= $row->nombre ?>&nbsp;<?= $row->apellido ?> - 
		<?= $row->email ?> - 
		<?php
			switch ($row->confirma) {
				case "0":
					?>A confirmar <?php if ($envMail == 1 && $row->cantidad_enviadas < 3) { ?> - <?php if($row->cantidad_enviadas == 0){ ?> Se envio 1 vez la invitacion. <?php }?> <?php if($row->cantidad_enviadas > 0){ ?> Se envio <?= $row->cantidad_enviadas ?> veces la invitacion. <?php }?> <a href="<?= base_url() ?>interno/reenviar_invitacion/<?= $row->id ?>">Reenviar Invitacion</a><?php }
					break;
				case "1":
					?>Voy<?php 
					break;
				case "2":
					?>No voy<?php 
				break;
				default: 
					break;			
			}
		?>
		<br>
<?php }?>
<?php if(!$datos) { echo "<h2>No hay invitados</h2>";}?>
</div>