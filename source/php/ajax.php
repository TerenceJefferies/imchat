<?php

    /*
     * ajax class, created to interact with the requests made by the imchat 
     * system
     * 
     * @author: Terence Jefferies
     * 
     * @date: 13/08/2012
     * 
     */
    class ajax{
        
        /*
         * dbHost, the hostname of the mysql server to connect to
         */
        private $dbHost = 'localhost';
        
        /*
         * dbUser, the user name of the mysql server to connect to
         */
        private $dbUser = 'root';
        
        /*
         * dbPassword, the password to access the mysql server
         */
        private $dbPassword = '';
        
        /*
         * dbName, the name of the database to select once connected
         */
        private $dbName = 'imchat';
        
        /*
         * connection, the mysql connection resource
         */
        private $connection = null;
        
        /*
         * errors, an array of errors that should be returned
         */
        private $errors = array();
        
        /*
         * __construct, used to perform startup proceedures of the ajax class
         * 
         * @params
         * - void
         * 
         * @returns
         * - void
         * 
         */
        public function __construct() {
            
            $this -> connectToDatabase();
            
        }
        
        /*
         * connectToDatabase, connects to the database using the connection 
         * variables defined upon instansiation
         * 
         * @params
         * - void
         * 
         * @returns
         * - void
         * 
         */
        private function connectToDatabase() {
            
            $this -> connection = mysql_connect($this -> dbHost,$this -> dbUser,$this -> dbPassword);
            if(mysql_error()) $this -> appendError('Unable to connect to MySQL server');
            mysql_select_db($this -> dbName,$this -> connection);
            if(mysql_error()) $this -> appendError('Unable to select database');
            
        }
        
        /*
         * appendErrors, adds an error for returning
         * 
         * @params
         * - (string) error: The error message to append
         * 
         * @returns
         * - void
         * 
         */
        private function appendError($error) {
            
            $this -> errors[] = $error;
            
        }
        
        /*
         * retrieveMessages, retrieves an array of the latest messages in the 
         * database
         * 
         * @params
         * - (optional) (integer) latest: The database UID of the latest message that is 
         * currentlly being displayed
         * 
         * @returns
         * - (array): An array containing all messages after the latest one
         * 
         */
        public function retrieveMessages($latest=null)
        {
            
            $returnArr = array();
            $query = ($latest) ? "SELECT * FROM imchat_msgs WHERE id > " . mysql_real_escape_string($latest) . " ORDER BY id ASC" : "SELECT * FROM imchat_msgs ORDER BY id ASC";
            $result = mysql_query($query);
            while($row = mysql_fetch_array($result))
            {
                
                $returnArr[] = $row;
                
            }
            if(mysql_error()) $this -> appendError('Error when retrieving messages: ' . mysql_error());
            return $returnArr;
            
        }
        
        
        /*
         * retrieveErrors, retrieves any errors generated during this instantion
         * 
         * @params
         * - void
         * 
         * @returns
         * - (array): An array of the errors generated
         * 
         */
        public function retrieveErrors() {
            
            return $this -> errors;
            
        }
        
        /*
         * __destruct, called upon the end of the class
         * 
         * @params
         * - void
         * 
         * @returns
         * - void
         * 
         */
        public function __destruct() {
            
            mysql_close($this -> connection);
            
        }
        
        /*
         * postNewMessage, posts a new message to the database
         * 
         * @params
         * - (array) data:
         * array("name" => "name_of_sender","msg" => "msg_submitted")
         * 
         * @returns
         * - (string): A response string
         * 
         */
        public function postNewMessage($data) {
            
            mysql_query("
               
                INSERT INTO imchat_msgs (sender,msg) VALUES ('" . mysql_real_escape_string($data['name']) . "','" . mysql_real_escape_string($data['msg']) . "')

            ");
            if(mysql_error()) $this -> appendError('Unable to post message: ' . mysql_error());
            return (mysql_error()) ? 'Unable to post your message! An error occured!' : 'Your message has been created';
            
        }
        
    }

?>
