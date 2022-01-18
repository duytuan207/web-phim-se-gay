<?php
// date created: 04/01/2004 
// ftp class by michael norman rondero (Author)
// required: procedural concept of uploading, deleting, changing files and dirs
class upload_file {
var $jpeg;
var $conn;
var $auth;
var $user_ftp = "xemphimon";
var $pwd_ftp = "z2Tddv3";
var $hostadd = "xemphimon.com";
var $pasv;
var $sop;
var $connected;
  //upload_file() - Class Initiated, initialize the ftp connection
  function upload_file() {
   global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;
   if (isset($HTTP_COOKIE_VARS)) $HTTPCV = $HTTP_COOKIE_VARS;
   else if (isset($HTTP_POST_VARS)) $HTTPPV =  $HTTP_POST_VARS;
   else if (isset($HTTP_GET_VARS)) $HTTPGV =  $HTTP_GET_VARS;
   $this->conn = ftp_connect($this->hostadd,21) or die("Error!!! can't connect to ftp server");
   $this->auth = ftp_login($this->conn,$this->user_ftp,$this->pwd_ftp) or die("Error!!! invalid authentication");
   $this->pasv = ftp_pasv($this->conn,false) or die("ERROR FTP->PASV [$this->conn]");
  }

  //ftp_transaction() - Upload file from local to ftp server 
  function ftp_transaction($file_path=null,$file_name=null,$file_type=null) {
		if(!$this->conn) {
		$this->upload_file();
		}
		switch($file_type) {
		 case 1 : {
		  $set_file_type = ".gif";
		  $ftp_compression = FTP_BINARY;	 
		 } break;
		 case 2 : {
		  $set_file_type = ".jpg";	 
		  $ftp_compression = FTP_BINARY;	 
		 } break;
		 case 3 : {
		  $set_file_type = ".png";	 
		  $ftp_compression = FTP_BINARY;
		 } break;
		 default : {
		  $set_file_type = $file_type;
		  $ftp_compression = FTP_ASCII;		 
		  }
		  break;
		}
       $ret = ftp_put($this->conn,"/xemphimon.com/public_html/fimx/".$file_name,$file_path,$ftp_compression) or die("conf failed, click back button");
	   if($ret == FTP_FAILED)
	   {
	   	 die("upload failed, click back button");
	   }
  }  
   function ftp_transactionthumb($file_path=null,$file_name=null,$file_type=null) {
		if(!$this->conn) {
		$this->upload_file();
		}
		switch($file_type) {
		 case 1 : {
		  $set_file_type = ".gif";
		  $ftp_compression = FTP_BINARY;	 
		 } break;
		 case 2 : {
		  $set_file_type = ".jpg";	 
		  $ftp_compression = FTP_BINARY;	 
		 } break;
		 case 3 : {
		  $set_file_type = ".png";	 
		  $ftp_compression = FTP_BINARY;
		 } break;
		 default : {
		  $set_file_type = $file_type;
		  $ftp_compression = FTP_ASCII;		 
		  }
		  break;
		}
       $ret = ftp_put($this->conn,"/xemphimon.com/public_html/fimx/_thumb/".$file_name,$file_path,$ftp_compression) or die("conf failed, click back button");
	   if($ret == FTP_FAILED)
	   {
	   	 die("upload failed, click back button");
	   }
  }
  //delete_2_dir() - Experimental, delete 2 directory  
  function delete_2_dir($target_key_folder=null,$folder1=null,$folder2=null) {
    if(!$this->conn) {
	$this->upload_file();
	}
	$state = false;
	if(ftp_chdir($this->conn,$target_key_folder)) {
        if(ftp_rmdir($this->conn, $folder1)) { 
        if(ftp_rmdir($this->conn, $folder2)) {
		  $state=true;
	    }
		}		 
	}
	return $state;
  }
  
  //create_sub_sub_dir - Experimental, create sub directory in another sub directory
  function create_sub_sub_dir($parent_dir=null,$sub_dir=null){
    $this->upload_file();
	$state = false;
    if($this->_change_sub_dir($parent_dir)){
      $this->_create_sub_dir($sub_dir);
	  $state = true;
	}  
	return $state;
  }
  
  //_change_dir - Change DIR
  function _change_dir($parent_dir=null) {  
    if(!$this->conn) {
	$this->upload_file();
	}
	sleep(3);	
    if (ftp_chdir($this->conn, $parent_dir)) {
      return true;
    } else { 
      return false;
    }
  }

  //_change_sub_dir - Experimental (Change Sub Directory)
  function _change_sub_dir($sub_dir=null) {
    if(!$this->conn) {
	$this->upload_file();
	}  
	sleep(3);	
    if (ftp_chdir($this->conn, $sub_dir)) {
      return true;
    } else { 
      return false;
    }  
  }

  //_create_sub_dir - Experimental (Create Sub Directory)  
  function _create_sub_dir($folder_name=null) {
    if(!$this->conn) {
	$this->upload_photo();
	}  
	sleep(3);	
    if (ftp_mkdir($this->conn, $folder_name)) {
      return true;
    } else {
      return false;
    }  
  }

  //_remove_dir - (Delete Directory)  
  function _remove_dir($folder_name=null) {
    if(!$this->conn) {
	$this->upload_file();
	}  
	sleep(3);	
    if (ftp_rmdir($this->conn, $folder_name)) {
      return true;
    } else {
      return false;
    }  
  }  

  //_chk_lst - (Check if the folder name exist in ftp server)    
 function _chk_list($folder_name = null){
    if(!$this->conn) {
	$this->upload_file();
	}  
	$folder_name = "./" . $folder_name;
    $str_list = ftp_nlist($this->conn, ".");
	if(in_array($folder_name,$str_list)) {  
      return 1;
    } else {
      return 0;
    }  
 }
 
  //_remove_file - (remove file in the ftp server)    
 function _remove_file($str_filename){
    if(!$this->conn) {
	$this->upload_file();
	}  
	sleep(3);	
    if (ftp_delete($this->conn, $str_filename)) {
		return true;
    } else {
		return false;
    }   
 }
 
  //_current_dir() - (stay in current directory)    
 function _current_dir(){
    if(!$this->conn) {
	$this->upload_file();
	} 
	return ftp_pwd($this->conn); 
 }
 
  //_remove_set() - (Experimental- Remove all data in the Directory)    
 function _remove_set($target_folder=null,$folder1=null,$folder2=null){
   	$this->upload_file();       
	if(ftp_chdir($this->conn,$target_folder)) {
     $_files = ftp_nlist($this->conn,$folder1);
	 $_many = count($_files);
	 if(!ftp_chdir($this->conn,$folder1)) {
	 return false;
	 }
	 if($_many > 0) {
	  $next = 0;
	  while($_many > $next) {
	   if(!ftp_delete($this->conn,str_replace($folder1."/","",$_files[$next]))){   
	   	 return false;
	   }
	   $next++;
	  } 
	 }
	 ftp_cdup($this->conn);
     $_files = ftp_nlist($this->conn,$folder2);
	 $_many = count($_files);
	 if(!ftp_chdir($this->conn,$folder2)) {  
	     return false;
	 }
	 if($_many > 0) {
	  $next = 0;
	  while($_many > $next) {
	   if(!ftp_delete($this->conn,str_replace($folder2."/","",$_files[$next]))) {      
	   	 return false;
	   }
	   $next++;
	  } 
	 }	 
	}
	ftp_cdup($this->conn);
	if(!ftp_rmdir($this->conn,$folder1)) {
		 return false;
	}
	if(!ftp_rmdir($this->conn,$folder2)) {
		 return false;
	}
    ftp_close($this->conn);	
	return true;
 }
 //_close_connection - Close FTP Connection
	function _close_connection()
	{
		ftp_close($this->conn);	
	} 

/*This class is tested from 2004 until current
  You may change the class structure it depends on
  usage of your project.
*/
}
?>