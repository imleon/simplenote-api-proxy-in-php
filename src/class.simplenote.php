<?php
class SimpleNote
{

    const BASE_URL = "http://192.168.1.20/simplenote/";
    
    const LOGIN_URL = "http://simple-note.appspot.com/api/login";
    const INDEX_URL = "http://simple-note.appspot.com/api/index";
    const NOTE_URL = "http://simple-note.appspot.com/api/note";
    const DELETE_URL = "http://simple-note.appspot.com/api/delete";
    const SEARCH_URL = "http://simple-note.appspot.com/api/search";

	private $cookie_jar_index = "/var/www/mobroad.com/simplenote/cookie.txt";
   
    public function SimpleNote()
    {
        $method = substr("http://".$_SERVER["HTTP_HOST"].$_SERVER["REDIRECT_URL"],strlen(self::BASE_URL));
        $payload = @file_get_contents("php://input");
        $params = $_SERVER["QUERY_STRING"];

        if ($method == "login")                                             //obtain a token
            echo $this->docurl(self::LOGIN_URL, $payload);
        elseif ($method == "index")                                         //get the note index
            echo $this->docurl(self::INDEX_URL."?".$params);
        elseif ($method == "note" && $_SERVER["REQUEST_METHOD"] == "GET")   //retrieve a note
            echo $this->docurl(self::NOTE_URL."?".$params);
        elseif ($method == "note" && $_SERVER["REQUEST_METHOD"] == "POST")  //update or create a note
            echo $this->docurl(self::NOTE_URL."?".$params, $payload);
        elseif ($method == "delete" && $_SERVER["REQUEST_METHOD"] == "GET") //delete a note
            echo $this->docurl(self::DELETE_URL."?".$params);
        elseif ($method == "search" && $_SERVER["REQUEST_METHOD"] == "GET") //delete a note
            echo $this->docurl(self::SEARCH_URL."?".$params);
    }

    private function docurl($url, $payload = null)
    {
	    $ch = curl_init($url);    
//		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_jar_index);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        if($payload){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }
	    $ret = curl_exec($ch);
	    curl_close($ch);
	    return $ret;
    }
}
?>
