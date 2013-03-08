<div  class="content">
<div class="crear_contacto">
<br>
<form method="post" id="registro" action="<?= base_url() ?>interno/crear_contacto_guardar">
	<table>
		<tr>
			<td coldspan="2"><h1>Crear Contacto</h1><br></td>
		</tr>
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
</div>