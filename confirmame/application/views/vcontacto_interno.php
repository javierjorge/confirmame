<div  class="content">
<div class="contactos">
<br>
<h2>Mis Contactos</h2>
<h3><a href="<?= base_url() ?>interno/crear_contacto">Crear Contacto</a></h3>
<br>
<table class="tabla_invitaciones">
	<tr>
		<td width="250px"><h3>Nombre</h3></td>
		<td width="250px"><h3>Email</h3></td>
		<td width="150px"><h3>Es usuario</h3></td>
		<td width="250px">&nbsp;</td>
	</tr>
<?php
	$datos = false;  
	foreach ($vListContactos as $row ) {
		$datos = true; ?>
		<tr>
		<td><h4><?= $row->nombre ?>&nbsp;<?= $row->apellido ?></h4></td>
		<td><h4><?= $row->email ?></h4></td>
		<? if($row->id_usuario == 0) { ?><td><h4>No</h4></td>
			<?php if ($row->invitaciones == 0) {?><td><h4><a href="<?= base_url() ?>interno/invitar_registrarse_contacto/<?= $row->id ?>">Invitar a registrarse</a></h4></td>
			<?php }
				  else if ($row->invitaciones == 1 && $row->invitaciones < 3) {
				  	?><td><h4> Se envio <?= $row->invitaciones ?> invitacion <a href="<?= base_url() ?>interno/invitar_registrarse_contacto/<?= $row->id ?>">Invitar una vez mas a registrarse</a></h4></td><?php
				  }
				  else if ($row->invitaciones > 1 && $row->invitaciones < 3){
				  	?><td><h4> Se enviaron <?= $row->invitaciones ?> invitaciones <a href="<?= base_url() ?>interno/invitar_registrarse_contacto/<?= $row->id ?>">Invitar una vez mas a registrarse</a></h4></td><?php 
				  }
				  else 
				  {
				  	?><td><h4> Ya se enviaron 3 invitaciones</h4></td><?php 
				  }
		} 
		else 
		{?><td><h4> Si</h4></td><?php } ?> 
		</tr>
<?php }?>
<?php if(!$datos) { echo "<tr><td colspan=\=4\"><h2>No hay contactos registrados</h2></td></tr>";}?>
</table>
</div>
</div>