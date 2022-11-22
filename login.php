<?php

//admin controller common login.php
// $this->response->redirect($this->request->post['redirect'] . '&user_token=' . $this->session->data['user_token']); 
// yukarıdaki koddan önce eklenmelidir.

				$dataloginjson = array(
					"user_token" => $this->session->data['user_token'],
					"username"      => $this->request->post['username'],
					"password"   => $this->request->post['password'],
					"user_id"   => $this->session->data['user_id']
				);
				
				//$dataloginjson = json_encode($dataloginjson);
				$dataloginjson = base64_encode(serialize($dataloginjson));
					
				setcookie("customer_autologin_cookie", "".$dataloginjson."" , time()+(24*60*60) , "/");
        
?>       
