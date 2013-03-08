<div  class="content">
<div class="contacto">
	<form method="post" id="registro" action="<?= base_url() ?>inicio/registrarse_guardar">
		<br><br><br>
		<table>
			<tr>
				<td coldspan="2"><h1>Contacto</h1><br></td>
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
		    	<td align="right" valign="top"><h2>Comentarios</h2></td>
		    	<td><textarea class="textarea" name="comentarios" id="comentarios" rows="8" cols="30">Tus comentarios aqu&iacute;...</textarea></td>
		    </tr>
		    <tr>
		    	<td colspan="2" align="center">
					<input class="button" type="submit" name="btSubmit" value="Enviar" onclick="javascritp:post('registro', 'inicio', 'form_registro_guardar_usuario');"/>
			    </td>
			</tr>
		</table>
	</form>
</div>
</div>