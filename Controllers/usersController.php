<?php

class User extends AppController{

	public function __contruct(){
		parent::__contruct();
	}

	public function index(){
		$users = $this->User->find("users", "all");	
		$this->set("users", $users);
	}
	
	public function add(){
		if($_POST){

			
			
			if($this->User->save("users", $_POST)){
				$this->redirect(array("controller"=>"users", "action"=>"index"));	
			}else{
				$this->redirect(array("controller"=>"users", "action"=>"add"));
			}
		}
	}

	public function edit($id = null){
		if($_POST){
			$filter = new Validations();
			$pass = new Password();

			$_POST["password"] = $filter->sanitizeText($_POST["password"]);
			$_POST["password"] = $pass->getPassword($_POST["password"]);

			if($this->User->update("users", $_POST)){
				$this->redirect(array("controller"=>"users", "action"=>"index"));
			}else{
				$this->redirect(array("controller"=>"users", "action"=>"edit"));
			}
		}		
		$user = $this->User->find("users", "first", array(
			"conditions" => "users.id=$id"
		));
		$this->set("user", $user);

		//$groups = $this->User->find("groups", "all");
		//$this->set("groups", $groups);
	}

	public function login(){
		if($_POST){
			$pass = new Password();
			$filter = new Validations();
			$auth = new Authorization();

			$username = $filter->sanitizeText($_POST["username"]);
			$password = $filter->sanitizeText($_POST["password"]);

			$options['conditions'] = " username = '$username'";
			$user = $this->User->find("users", "first", $options);

			if($pass->isValid($password, $user['password'])){
				$auth->login($user);
				$this->redirect(array("controller"=>"users", "action"=>"index"));
			}else{
				echo "Usuario Invalido";
			}
		}
	}

	public function logout(){
		$auth = new Authorization();
		$auth->logout();
	}	

	public function delete($id = null){
		
		}

		private function sendMail($email, $name){

			$email = new PHPMailer();
			//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'user@example.com';                 // SMTP username
$mail->Password = 'secret';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'team@app.com';
$mail->FromName = 'team app';
$mail->addAddress('darwin.lazaro28@gmail.com', 'Darwin User');     // Add a recipient
              // 


$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

		}
		
	}	
