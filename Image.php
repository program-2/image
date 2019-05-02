<?php


/* A library for uploading images safely with an object oriented approach for PHP 
 * author Ehsan Yousefi 
 * copyright 2019-2025 Ehsan Yousefi <mailbox5517@gmail.com> | https://fsdeveloper.ir 
 * version 0.0.0     */
class Image
{
    
    //input assigned-name
    public $name;

    //system assigned temporary name
    public $tmpName;
    
    public $allowedTypes = [];
    
    public $maxSize = 0;
    
    public $message;
    
    public function save($name, $directory, $file=null)
    {
        try{
            $tmpName = $_FILES[$name]['tmp_name']; 
            if($tmpName == null){
                throw new exception('There is no uploaded file');
                }
            $this->tmpName = $tmpName;
            $this->name = $name;
       
            /*All safty checking for the uploading file. */  
            $this->secureimage();
            $this->size();
           }
        catch (exception $e){
            $this->message = $e->getMessage();
            return 0;
        }
       
        //if the new file name not inserted the original name will be used.
        if($file == null){$file = $tmpName;}
        //making the destination path from input parameters.
        $filePath = $directory.'/'.$file;
        //final and main operation.
        return move_uploaded_file($tmpName, $filePath);
    }   
    protected function secureimage()
    {
        /*I am going to ckeck inside of the 
        uploading file for any unwanted PHP script!
        Please note that short php file start '<?' should be
        turned off at php interpreter configs and should not be 
        subject to search beacause many images include it!   */
        $subject = "<?php";
        $content = file_get_contents($this->tmpName);
        $check = strpos($content , $subject);
        if ($check) {
             throw new exception('Script is not allowed');
        }
          /* This is maybe the strongest way available to 
        test if the file is a valid image file or not. 
        please let me know if you know the like for any 
        other file types: mailbox5517@gmail.com */
        $checking = exif_imagetype($this->tmpName);
        if(!$checking){
            throw new exception('The file is not a valid image');
        } echo $checking;
        /*checking if the uploaded file is in compliance
        with allowedTypes array in two following ways: */
        if($this->allowedTypes != null){
        
            #1)checking the header of the uploaded file (week method).
            $type = $_FILES["$this->name"]['type'];
            $extractedEx = explode('/', $type);
            $extractedEx = end($extractedEx); 
            $check = in_array($extractedEx, $this->allowedTypes);
            if(!$check){
                throw new exception('This image type '.$extractedEx. ' is not allowed 0');
            }
            
            #2)checking the extention of the uploaded file (more stronger method).
            $fileName = $_FILES["$this->name"]['name'];
            $ext = explode('.', $fileName);
            $ext = end($ext);
            $check = in_array ($ext, $this->allowedTypes);
            if(!$check){
                throw new exception('This image type '.$ext.' is not allowed 1');
            }
         }
    }
    protected function size()
    {
        if($this->maxSize != null){
            $size = filesize($this->tmpName);
            $maxSize = $this->maxSize;
            if($maxSize < $size){
                throw new exception('The image size '. $size.' bytes exceeded it\'s allowed value');
            }
        }
    }
    //use this method to return the error message or empty string. 
    public function errorMessage()
    {   
        if($this->message != null){
        return 'A message from image saving system:'.str_repeat('&nbsp;', 3).
        "$this->message".'.'.str_repeat('&nbsp;', 2);
        }else {
        return "";
        }
    } 
}
