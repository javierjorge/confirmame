<div  class="content">
<div class="asignar_eventos_invitar">
<br>
<h1>Gestion de invitaciones</h1>
<br>
<form method="post" id="registro" action="<?= base_url() ?>interno/invitar_gente/<?= $id_evento ?>">
	<table>
		<tr>
			<td><h2>Nombre</h2></td>
	    	<td><input class="textbox" type="text" name="nombre" id="nombre"/></td>
	    </tr>
		<tr>
			<td><h2>apellido</h2></td>
	    	<td><input class="textbox"  type="text" name="apellido" id="apellido"/></td>
	    </tr>
	    <tr>
	    	<td><h2>E-mail</h2></td>
	    	<td><input class="textbox"  type="text" name="email" id="email"/></td>
	    </tr>
	    <tr>
	    	<td colspan="2">
				<input class="button" type="submit" name="btSubmit" value="Guardar" />
		    </td>
		</tr>
	</table>
</form>
</div>
<div class="asignar_eventos_invitar_contactos">
<h2>Invitar a contactos</h2>
Nombre  | Email | Es usuario <br>
<?php
	$datos = false;  
	foreach ($vListContactos as $row ) {
		$datos = true; ?>
		<?= $row->nombre ?>&nbsp;<?= $row->apellido ?> - 
		<?= $row->email ?> - 
		<a href="<?= base_url() ?>interno/invitar_contacto/<?= $id_evento ?>/<?= $row->id ?>">Invitar contacto</a>
		<br>
<?php }?>
<?php if(!$datos) { echo "<h2>No hay contactos registrados o ya se encuentran invitados</h2>";}?>
</div>
<div class="asignar_eventos_invitados">
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
					?>A confirmar> - <a href="">Reenviar Invitacion</a><?php 
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
</div>