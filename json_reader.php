<?php

// base class with member properties and methods
class JsonReader {

   function JsonReader($json) 
   {
      $this->decode($json);
   }

    function get_path($comma_delimited_path){
      $tmp = $this->data;
      $path = explode(',', $comma_delimited_path);
      foreach ($path as &$key) { 
        $tmp = $tmp[$key];
      };
      return $tmp;
    }

    private function decode($json){
      $data = json_decode($json,TRUE);
      if (array_key_exists('errors',$data)) {
        echo $data['errors'][0]['message'];
      }
      $this->data = $data;
    }

} 

?>

