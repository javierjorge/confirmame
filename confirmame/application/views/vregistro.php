<div  class="content">
<div class="registro">
	<form method="post" id="registro" action="<?= base_url() ?>inicio/registrarse_guardar">
		<br><br><br>
		<table>
			<tr>
				<td coldspan="2"><h1>Registro</h1><br></td>
			</tr>
			<tr>
				<td align="right"><h2>Nombre</h2></td>
		    	<td><input class="textbox" type="text" name="nombre" id="nombre"/></td>
		    </tr>
			<tr>
				<td align="right"><h2>Apellido</h2></td>
		    	<td><input class="textbox"  type="text" name="apellido" id="apellido"/></td>
		    </tr>
		    <tr>
		    	<td align="right"><h2>Email</h2></td>
		    	<td><input class="textbox"  type="text" name="email" id="email"/></td>
		    </tr>
		    <tr>
		    	<td align="right"><h2>Contrase&ntilde;a</h2></td>
		    	<td><input class="textbox"  type="password" name="password" id="password"/></td>
		    </tr>
		    <tr>
		    	<td align="right"><h2>Repetir Contrase&ntilde;a</h2></td>
		    	<td><input class="textbox"  type="password" name="repassword" id="repassword"/></td>
		    </tr>
		    <tr>
		    	<td colspan="2">
		    		<h2><?= $mensaje ?></h2><br>
		    	</td>
		    </tr>
		    <tr>
		    	<td colspan="2" align="center">
					<input class="button" type="submit" name="btSubmit" value="Guardar" onclick="javascritp:post('registro', 'inicio', 'form_registro_guardar_usuario');"/>
			    </td>
			</tr>
		</table>
	</form>
</div>
</div>