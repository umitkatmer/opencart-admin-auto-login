# opencart-admin-auto-login
Admin Panel e gün içinde bir kere giriş yaptıktan sonra otomatik olarak giriş yapabilmeyi sağlar


<h3 id="isleyis">Admin > Controller > Common > login.php</h3>

```php

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
```
<h3 id="isleyis">Admin > Controller > Common > header.php</h3>

```php

<?php
//admin controller common header.php
// public function index() {
// yukarıdaki koddan sonra eklenmelidir.

		if(isset($_COOKIE["customer_autologin_cookie"])){  
			
			if(!isset($this->session->data['logins'])){  
				
				$customer_autologin_cookie = unserialize(base64_decode($_COOKIE["customer_autologin_cookie"]));
				$username                  = $customer_autologin_cookie['username'];
				$password                  = $customer_autologin_cookie['password'];
				
				$loginpanel = $this->user->login($username, html_entity_decode($password, ENT_QUOTES, 'UTF-8'));
				
				if($loginpanel){
					
					$this->session->data['user_token'] = token(32);
					$this->session->data['logins'] = 1;
					$this->session->data['token'] =  $this->session->data['user_token'];
					$this->response->redirect($this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'].'', true));
							
				}
				
			}
		
		}
?>
```
