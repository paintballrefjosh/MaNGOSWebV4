<?php
class IMAGE
{
  function send_thumbnail($fullpath,$width=80,$height=60,$resample=-1)
  {       
        @$w = getimagesize($fullpath);
        if (!$w) return false;
        if (@$lim = $this->return_bytes(ini_get('memory_limit')))
        {
                $sz = ( $w[0]*$w[1] + $width*$height ) * 5 + (function_exists('memory_get_usage') ? memory_get_usage() : 0); // approximate size of image in memory (yes, 5 bytes per pixel!!)
                if ($sz >= $lim) return false;
        }
       
        if (!function_exists('imagecreate') || !function_exists('imagecopyresized')) return false;

        $p = pathinfo($fullpath);
        @$ext = strtolower($p['extension']);
        if (in_array($ext,array('jpeg','jpe','jpg'))) $ext = 'jpeg';
       
        if (function_exists($func = 'imagecreatefrom'.$ext)) $src = $func($fullpath);
        else return false;
       
        //proportions
        $new_width = round(($height/$w[1])*$w[0]);
        $new_height = round(($width/$w[0])*$w[1]);
        if ($new_width>$width) $new_width = $width;
        if ($new_height>$height) $new_height = $height;
        
        if ($width>$w[0] && $height>$w[1]){
            echo file_get_contents($fullpath);
            return true;
        }
       
        if (!function_exists($cfunc = 'imagecreatetruecolor')) $cfunc='imagecreate';
        $thumb = $cfunc($new_width,$new_height);
       
        $func = $resample===true ? 'imagecopyresampled' : 'imagecopyresized';
       
        // optimisations for big images
        $c = 2;
        if ($func != 'imagecopyresized' && ($w[0] > $c*$new_width || $w[1] > $c*$new_height))
        {
                $thumb_c = $cfunc($c*$new_width,$c*$new_height);
                imagecopyresized($thumb_c,$src,0,0,0,0,$c*$new_width,$c*$new_height,$w[0],$w[1]);
                imagedestroy($src);
                $src = $thumb_c;
                list($w[0],$w[1]) = array($c*$new_width,$c*$new_height);
        }
       
        $func($thumb,$src,0,0,0,0,$new_width,$new_height,$w[0],$w[1]);

        imagedestroy($src);
        imagejpeg($thumb, null, 90);
        imagedestroy($thumb);
       
        return true;
  }
  
  function return_bytes($val) {
      $val = trim($val);
      $last = strtolower($val{strlen($val)-1});
      switch($last) {
          // The 'G' modifier is available since PHP 5.1.0
          case 'g':
              $val *= 1024;
          case 'm':
              $val *= 1024;
          case 'k':
              $val *= 1024;
      }

      return $val;
  }
    
    function get_fullinfo($fullpath){
        $result = array();
        $extensions = array('','gif','jpg','png','swf','psd','bmp','tiff','tiff','jpc','jp2','jpx','jb2','swc','iff','wbmp','xbm');
        $w = getimagesize($fullpath);
        $result['width'] = $w[0];
        $result['height'] = $w[1];
        $result['resolution'] = $w[0].'x'.$w[1];
        $result['mime'] = $w['mime'];
        $result['ext'] = $extensions[$w[2]];
        $result['size'] = filesize($fullpath);
        return $result;
    }

}
?>