 <?php
 include "db_conn.php";
 include "functions.php";
	// $sql = "SELECT * FROM seai.charging WHERE charger_id='202001'";
	// $result = pg_query($conn, $sql);
	// if (pg_num_rows($result)>0) {
		// $row = pg_fetch_assoc($result));
		// $current_PPK = $row['priceper_kwh']
        // }
		
	if (!empty($_GET['Confirmar'])) {
		//Se confirmou, recupera os valores introduzidos pelo utilizador no formulário e passados pelo link
		$new_ppk = $_GET['new_ppk'];
		$new_ppk_fc = $_GET['new_ppk_fc'];
		$new_ppk_green = $_GET['new_ppk_green'];
	
		//Validação dos dados
		//Assume-se que todos os campos são obrigatórios (a query insert apenas é executada se todos os campos  preenchidos)
		if (!is_numeric($new_ppk) || !is_numeric($new_ppk_fc) || !is_numeric($new_ppk_green)){
			//Nota: || é o operador OU em PHP 
			$dadosValidos = false;
			}
		else {
			$dadosValidos = true;
		}
		
		//********* 2. Executar a query e redirecionar para a página de apresentação

		if (!$dadosValidos){
			//Nota: ! é o operador NOT em PHP
			//Se dados não válidos, é gerada e guardada uma mensagem de erro em variável de sessão
			$_SESSION['msgErro'] = "Erro na inserçao do valor. Preço não válido<p>";
			
			//Também são registados em variáveis de sessão os dados introduzidos pelo utilizador no formulário, bem como o id da cidade
			$_SESSION['new_ppk'] = $new_ppk;
			$_SESSION['new_ppk_fc'] = $new_ppk_fc;
			$_SESSION['new_ppk_green'] = $new_ppk_green;
			
			//Depois de criadas as variáveis de sessão, o script é redirecionado para o formulário que irá apresentar os dados que o utilizador tinha introduzido anteriormente 			
			header("Location: ../seai/prices.php");
		}	
		else {
			//Se dados válidos, a query é executada e depois o script é redirecionado para a página de entrada	
			echo $new_ppk;
			$result = updatePrice($new_ppk, $new_ppk_fc, $new_ppk_green);
			header("Location: ../seai/prices.php");
		}

		
	}
                
 ?>