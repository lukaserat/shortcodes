<?php

public function addNewsLetterSocialpageAction() {
        set_include_path('.:<path_to_pear>');
        require_once 'XML/RPC2/Client.php'; // Added for BenchMark Email 29 Mar 2013
        $status = false;
        $message = ''; 
        try {
            $client = XML_RPC2_Client::create("http://api.benchmarkemail.com/1.0/"); // Added for BenchMark Email 29 Mar 2013
            $token = $client->login("username", "password"); // Added for BenchMark Email 29 Mar 2013
            $config = Zend_Registry::get('config');
            $email = $this->getRequest()->getParam('email');
            $name = $this->getRequest()->getParam('name');
            $listID = 'list_id';
            $record1['email'] = $email;
            $record1['firstname'] = $name;

            if (!$email || !$name) {
                throw new Exception('Please enter your email address and first name!');
            }

            // Add the parameters for the constant contact post
            // Changed to use additional parameters from list for BenchMark Email
            if($name == 'NoName') $name = '';
            $postFields = array(
                'email_address' => $email,
                'first_name' => $name
            );
            
            // Add user to BenchMark Email list
            $rec = array($record1);
            $result = $client->listAddContacts($token, $listID, $rec);
            set_include_path('.:/usr/lib/ZendFramework-1.11.11-minimal/library');

            // Send a email to the user
            $html = new Zend_View();
            $html->setScriptPath(APPLICATION_PATH . '/views/email/');
            if($name) {
                $name = "Hi ".$name;
            } else {
                $name = "Dear Tennis Fan";
            }
            $html->assign('name', $name);

            // Send an email
            $mail = new Zend_Mail();
            $mail->setBodyHtml($html->render('newsletter.phtml'));
            $mail->setFrom($config->email->address->reply, $config->email->address->from);
            $mail->addTo($email);
            $mail->setSubject('Championship Tennis Tours Newsletter');
            $mail->send();

            $status = true;
        } catch (Exception $e) {
            // TODO: Handle the error
            $message = $e->getMessage();
        }
        if($status) setcookie('newsletter',1,time()+3600*24*365*3,'/');
        $this->_helper->json(array('status' => $status, 'message' => $message));
    }
