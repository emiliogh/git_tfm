<?php include "../php/sesionSecurityForms.php"; ?>
<html>
  <head>
    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="scripts/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />	
	<script src="scripts/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
    <script src="scripts/jtable/jquery.jtable.js" type="text/javascript"></script>	
    <script type="text/javascript" src="scripts/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="scripts/jquery.validationEngine-es.js"></script>
	<link href="scripts/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/componentes.js"></script> 
  </head>
  <body onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table width="100%" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
		<tr>
			<td style="height: 20px; width: 80px; font-family: Vegur, 'PT Sans', Verdana, sans-serif;">
				Establecimiento:  
			</td>	
			<td>
				<select name="idEstablecimiento" id="idEstablecimiento" style="width: 100%">
				  <option value="0" SELECTED>Seleccione un opción.</option>
				</select> 
			</td>
		</tr>
		<tr>	
			<td style="height: 20px; width: 80px; font-family: Vegur, 'PT Sans', Verdana, sans-serif;">
				Punto Emisión: 
			</td>	
			<td>	
				<select name="idPuntoEmision" id="idPuntoEmision" style="width: 100%">
				  <option value="0" SELECTED>Seleccione una opción.</option>
				</select> 
			</td>
		</tr>
		<tr>	
			<td style="height: 20px; width: 80px; font-family: Vegur, 'PT Sans', Verdana, sans-serif;">
				Personal: 
			</td>	
			<td>	
				<select name="idCajero" id="idCajero" style="width: 100%">
				  <option value="0" SELECTED>Seleccione una opción.</option>
				</select> 
			</td>
		</tr>
		<tr>
			<td colspan="2" style="height: 400px; vertical-align: top;">
				<div id="tableContainer" style="width: 100%;"></div>
			</td>
		</tr>
	</table>
	<script type="text/javascript">		
		$(document).ready(function () {
			var cmb=new componente.cmb
			cmb.ini('idEstablecimiento')
			
			cmb.loadFromUrl('../../lib/cmb/cmbEstablecimientos.php')
			cmb.setChangeFunction(dataPuntosEmision)

			var cmb2=new componente.cmb
			cmb2.ini('idPuntoEmision')
						
			function dataPuntosEmision(){
				cmb2.clear()
				cmb2.loadFromUrl('../../lib/cmb/cmbPuntosEmision.php',{id:cmb.getSelectedValue()})
				cmb2.setChangeFunction(dataCajeros)
			}
			
			var cmb3=new componente.cmb
			cmb3.ini('idCajero')
						
			function dataCajeros(){
				cmb3.clear()
				cmb3.loadFromUrl('../../lib/cmb/cmbCajerosPuntoEmision.php',
								{id:cmb.getSelectedValue(),id2:cmb2.getSelectedValue()})
				cmb3.setChangeFunction(busquedaInformacion)
			}
			
			function busquedaInformacion(){
				//window.top.document.getElementById('load').style.display = 'block';
				document.cookie = "idEstablecimiento="+document.getElementById('idEstablecimiento').value;
				document.cookie = "idPuntoEmision="+document.getElementById('idPuntoEmision').value;
				document.cookie = "idPersonal="+document.getElementById('idCajero').value;
				$('#tableContainer').jtable('load');
				//window.top.document.getElementById('load').style.display = 'none';
			}
			
			$('#tableContainer').jtable({
				title: 'Asignación de los cajeros a los puntos de emisión',
				actions: {
					listAction: 'crud_tscCajeros.php?action=list',
					createAction: 'crud_tscCajeros.php?action=create',
					updateAction: 'crud_tscCajeros.php?action=update',
					deleteAction: 'crud_tscCajeros.php?action=delete',
				},
				fields: {
					id_establecimiento: {
						create: false,
						edit: false,
						list: false
					},
					id_punto_emision: {
						create: false,
						edit: false,
						list: false
					},
					id_personal: {
						create: false,
						edit: false,
						list: false
					},
					secuencia: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					descripcion: {
						title: 'Descripción',
						width: '40%'
					},
					inicio_acceso: {
						title: 'Desde',
						width: '20%',
						type: 'date'
					},
					finalizacion_acceso: {
						title: 'Hasta',
						width: '20%',
						type: 'date'
					},
					id_horario_acceso: {
						title: 'Horario',
						width: '20%',
						create: false,
						edit: false,
						list: false
					},
					estado: {
						title: 'Estado',
						width: '10%',
						list:  true,
						create: false,
						edit: false,
						options: {
							"N" : "Selecciona una opción",
							"A" : "ACTIVO",
							"F" : "FINALIZADO",
							"I" : "INACTIVO"
						}
					}
				}
			  });
			//$('#tableContainer').jtable('load');
		});
		

	</script>
  </body>
</html>
