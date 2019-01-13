<!doctype html>
<html>
<head>
	<meta charset="utf-8">

	<title>Desafio Back-End Master</title>

	<!-- Fonts -->
	<link href="styles.css" rel="stylesheet" type="text/css">

</head>
<body>
	<script type="text/javascript" src="sortable.js"></script>
		 	    	
	<div class="content">
		<table class="sortable">
			<caption>Tickets</caption>			  
			<thead>
				<tr>
					<th><a>N° do Ticket</a></th>
					<th><a>Data Criação</a></th>
					<th><a>Data Atualização</a></th>
					<th><a>Pioridade</a></th>
					<th><a>Ultima Mensagem</a></th>
				</tr>
			</thead>

			<tbody>

				<?php

			  	//Variaveis para leitura do json
				
				$arquivo = file_get_contents("tickets.json");   
				$json = json_decode($arquivo);
				$tickets = $json;

				
			  	// Loop para percorrer a primeira camada do Array
				
				foreach($tickets as $t):

					$ticketid = $t->TicketID;
					$dateCreate = $t->DateCreate;
					$dateUpdate = $t->DateUpdate;
					$intr = $t->Interactions; 
					

		        	// Loop para percorrer a segunda camada do Array

					foreach ( $intr as $i ){       		

						$subj = $i->Subject;
						$msg = $i->Message;
						$snd = $i->Sender;      		 

			       		// Filtro de prioridade com base em ocorrência de índice       		

						if (stristr($snd, 'customer') and 
							stristr( $subj, 'reclam') || 
							stristr( $subj, 'difer') || 
							stristr($msg, 'solu') || 
							stristr($msg, 'provid')  || 
							stristr($msg,'mas já') || 
							stristr($msg, 'demora') || 
							stristr($msg, 'tentativa') || 
							stristr($msg, 'continua') || 
							stristr($msg, 'procon')|| 
							stristr($msg, 'errado') || 
							stristr($msg, 'cancela') ||
							stristr($msg, 'sistema') ||
							str_word_count($msg, 0) > 30 || 
							stristr($msg, 'satisf') and
							stristr($subj, 'elogio') === FALSE ) 
						{

							$tpriorty = " Alta! ";
						}else{

							$tpriorty = " Normal ";						
						}						
					}
					?>	
					<tr>
						<td id="ticketId"><?php echo $ticketid; ?></td>
						<td id="dateCt"><?php echo $dateCreate; ?></td>
						<td id="dateUp"><?php echo $dateUpdate; ?></td>
						<td id="prior"><?php echo $tpriorty; ?></td>
						<td id="msg"><?php 
							$str = $msg;
							//conta numero de caracteres da string
							$tam = strlen($str);
							//se string tiver mais que X caracteres
							if($tam > 75){
						    //Exibe apenas X caracteres
								$rest = substr($str, 0, 75); 
								echo $rest . "...";
							}else{ echo $msg; } ?></td>			      
					</tr>
				<?php endforeach; ?>			    
			</tbody>
		</table>
	</div>                       
</body>
</html>   
