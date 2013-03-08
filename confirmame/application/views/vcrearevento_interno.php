<div  class="content">
<div class="crear_evento">
<br>
<form method="post" id="registro" action="<?= base_url() ?>interno/crear_evento_guardar">
	<table>
		<tr>
			<td coldspan="2"><h1>Crear Evento</h1><br></td>
		</tr>
		<tr>
			<td><h2>Nombre</h2></td>
	    	<td><input class="textbox" type="text" name="nombre" id="nombre"/></td>
	    </tr>
		<tr>
			<td><h2>Descripcion</h2></td>
	    	<td><input class="textbox"  type="text" name="descripcion" id="descripcion"/></td>
	    </tr>
	    <tr>
	    	<td><h2>Fecha</h2></td>
	    	<td><input class="textbox"  type="text" name="fecha" id="fecha"/></td>
	    </tr>
	    <tr>
	    	<td><h2>Hora Desde</h2></td>
	    	<td><input class="textbox"  type="text" name="hora_desde" id="hora_desde"/></td>
	    </tr>
	    <tr>
	    	<td><h2>Hora Hasta</h2></td>
	    	<td><input class="textbox"  type="text" name="hora_hasta" id="hora_hasta"/></td>
	    </tr>
	    <tr>
	    	<td><h2>Fecha Vencimiento</h2></td>
	    	<td><input class="textbox"  type="text" name="fecha_venc" id="fecha_venc"/></td>
	    </tr>
	    <tr>
	    	<td colspan="2">
	    		<h2><?= $mensaje ?></h2><br>
	    	</td>
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