<?php

public function getBeListAction(){

        // $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $this->view->error = NULL;

        try {
            set_include_path('.:/pear_path');
            require_once 'XML/RPC2/Client.php';
            $client = XML_RPC2_Client::create("http://api.benchmarkemail.com/1.0/"); 
            $token = $client->login("username", "password");
            $contactLists = $client->listGet($token, "", 1, 100, "", "");

            $this->view->contactLists = $contactLists;
            // print_r($contactLists);
             
        } catch (Exception $e) {
            $this->view->error = "something went wrong..";
        }
    }
