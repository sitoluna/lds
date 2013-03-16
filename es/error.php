	<div class="error" id="divError" style="display: block">
		<table width="400px" height="300px" summary="errores">
			<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="../backoffice/images/delete.gif" border="0"></a></td></tr>
			<tr valign="top">
				<td>
					<font color="black" align="center"><b>Se han detectado los siguientes errores:<br/><br/>
					<?php echo $error;?></b></font>
				</td>
			</tr>
		</table>
	</div>