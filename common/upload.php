<?php

  class upload {
    var $file, $filename, $destination, $permissions, $extensions, $tmp_filename, $message ,$TmpExt ,$TmpFile;

    function upload($file = '', $destination = '', $permissions = '777', $extensions = '') {
		
		$this->set_file($file);
		$this->set_destination($destination);
		$this->set_permissions($permissions);
		$this->set_extensions($extensions);

     

      if (tep_not_null($this->file) && tep_not_null($this->destination)) {
        

        if ( ($this->parse() == true) && ($this->save() == true) ) {
          return true;
        } else {
          return false;
        }
      }
    }

    function parse() {


      if (isset($_FILES[$this->file])) {
        $file = array('name' => $_FILES[$this->file]['name'],
                      'type' => $_FILES[$this->file]['type'],
                      'size' => $_FILES[$this->file]['size'],
                      'tmp_name' => $_FILES[$this->file]['tmp_name']);
      } elseif (isset($GLOBALS['HTTP_POST_FILES'][$this->file])) {
        global $HTTP_POST_FILES;

        $file = array('name' => $HTTP_POST_FILES[$this->file]['name'],
                      'type' => $HTTP_POST_FILES[$this->file]['type'],
                      'size' => $HTTP_POST_FILES[$this->file]['size'],
                      'tmp_name' => $HTTP_POST_FILES[$this->file]['tmp_name']);
      } else {
        $file = array('name' => (isset($GLOBALS[$this->file . '_name']) ? $GLOBALS[$this->file . '_name'] : ''),
                      'type' => (isset($GLOBALS[$this->file . '_type']) ? $GLOBALS[$this->file . '_type'] : ''),
                      'size' => (isset($GLOBALS[$this->file . '_size']) ? $GLOBALS[$this->file . '_size'] : ''),
                      'tmp_name' => (isset($GLOBALS[$this->file]) ? $GLOBALS[$this->file] : ''));
      } 

      if ( tep_not_null($file['tmp_name']) && ($file['tmp_name'] != 'none') && is_uploaded_file($file['tmp_name']) ) {
        if (sizeof($this->extensions)> 0) 
		{
			
			
          	if (!in_array(strtolower(substr($file['name'], strrpos($file['name'], '.')+1)), $this->extensions)) {
		      	
				$this->set_messages ( "ERROR FILETYPE NOT ALLOWED ");
            	return false;
          	}
        }

        $this->set_file($file);
        $this->set_filename($file['name']);
        $this->set_tmp_filename($file['tmp_name']);

        
		return $this->check_destination();
		
      } else {
        
          $this->set_messages ( "WARNING NO FILE UPLOADED ");
        
        return false;
      }
    }

    function save() {
     

      if (substr($this->destination, -1) != '/') $this->destination .= '/';
	  	
		$TmpExt  =substr($this->filename, strrpos($this->filename, '.')+1);
		$TmpFile = str_replace( ".".$TmpExt ,"",$this->filename);
		
	 	$destfile=$this->destination.$TmpFile.".".$TmpExt;
		$cnt=0;	
		if (file_exists($destfile)) 
		{
		
			do {
				
				$cnt++;
				$destfile=$this->destination.$TmpFile."$cnt.".$TmpExt;	
				
			} while (file_exists($destfile));
			$this->filename=$TmpFile."$cnt.".$TmpExt;
		}
		
		
      if (move_uploaded_file($this->file['tmp_name'], $this->destination . $this->filename)) {
        chmod($this->destination . $this->filename, $this->permissions);

       
         $this->set_messages ( "SUCCESS_FILE_SAVED_SUCCESSFULLY");
		 

        return true;
      } else {
        $this->set_messages ( " ERROR FILE NOT SAVED ");
        return false;
      }
    }

    function set_file($file) {
      $this->file = $file;
    }

    function set_destination($destination) {
      $this->destination = $destination;
    }

    function set_permissions($permissions) {
      $this->permissions = octdec($permissions);
    }

    function set_filename($filename) {
      $this->filename = $filename;
    }
	
   

    function set_tmp_filename($filename) {
      $this->tmp_filename = $filename;
    }

    function set_extensions($extensions) {
      if (tep_not_null($extensions)) {
        if (is_array($extensions)) {
          $this->extensions = $extensions;
        } else {
          $this->extensions = array($extensions);
        }
      } else {
        $this->extensions = array();
      }
    }

    function check_destination() {

			
      if (!is_writeable($this->destination) ) {
	  
        return false;
      } else {
        return true;
      }
    }

    function set_messages($msg) {
		 $this->message= $msg;
	}
  }
  function tep_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value)> 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value))> 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

?>
