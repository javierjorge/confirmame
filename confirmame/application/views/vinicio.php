
<div  class="content">
<div class="inicio">
	<form method="post" id="registro" action="<?= base_url() ?>inicio/logIn">
		<br><br><br>
		<table>
			<tr>
				<td coldspan="2"><h1>Login</h1><br></td>
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
		    	<td colspan="2">
		    		<h2><?= $mensaje ?></h2><br>
		    	</td>
		    </tr>
		    <tr>
		    	<td colspan="2" align="center">
					<input class="button" type="submit" name="btSubmit" value="Ingresar" />
			    </td>
			</tr>
		</table>
	</form>
</div>
</div>
