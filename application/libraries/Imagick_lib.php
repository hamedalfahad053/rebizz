<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imagick_lib {


   function Tiff_Splitter($file){

       //echo $file = realpath('uploads/multipage.tif');
       $image = new Imagick($file);

       $count = $image->getNumberImages();

       $x =0;
       foreach ( $image as $image ) {
           $x++;
           $image->setImageFormat( 'png' );
           $image->thumbnailImage(500, 500);

           $image_array[] = $image;
       }

       //<img id='" . $x . "' src='data:image/png;base64,".base64_encode($image)."' />

       return $image_array;

   }


}


