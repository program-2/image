## Image  is a library for uploading images  

\
\
## Introduction

This minimal PHP library is my attempt to upload images safely by an object oriented approach.

It's 79 lines.


## Aims

1- to provide safe uploading.

2- to be fully in an object oriented approach.

3- to have ability to define image name and image extension to save with,
  
   also maxSize, imageTypes, errorMassage.

## How to use it



#### parameters 

This is the main method of Image class:

    save($name, $directory, $file)
    
**$name** 

-Is the name that html form assigns to the uploaded image.

**$directory**

-Is the destination directory that the image will be saved in.

-This should be an already existing directory on server.

**$file**

-Is the name and extention that you choose for the new uploaded file like personel.png  .

-This third parameter can be omitted from the save() method.

-If no $file value is provided, the client's uploaded name and extension will be used. 



#### return value

-class returns TRUE on success.

-class returns FALSE on failure.



#### image type and size configuration  (object manipulation)

-After instantiating the Image class and before using the save() method you can

allocate values of $maxSize  :int (IN BYTES) and  $alowedTypes :array (of extensions only),
 
not feeding them means accepting all sizes and all image types. 



#### errorMessage3

-Get and directly show the error message any where with using the errorMessage() method of the same object.

-It returns NULL on a successful image saving.



#### A Complete Example:
\
\
    $obj = new Image  //-> or any other way like dependency injection

    $obj -> maxSize = 4900000;
    
    $obj -> allowedTypes = ['png', 'jpg', 'jpeg']; 
    
    $obj -> save('image','pics/lastfolder','personel.png');
    
    echo ($obj -> errorMessage());
\
\
## credit

Developed by Ehsan Yousefi <mailbox5517@gmail.com> [https://fsdeveloper.ir]
    
## updates    
    
"20/4/2019 first release 0.0.0"

