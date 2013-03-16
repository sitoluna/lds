<?php

?>
	<div class="error" id="divError" style="display: block">
		<table width="400px" height="300px" summary="errores">
			<tr align="right" height="4px"><td><a href="#" onclick="javascript:getElementById('divError').style.display = 'none';"><img src="images/delete.gif" border="0"></a></td></tr>
			<tr valign="top">
				<td>
					<font color="#FFFFFF"><b><?php echo "<p>Se han detectado los siguientes errores:</p><br/>".$errors;?></b></font>
				</td>
			</tr>
		</table>
	</div>