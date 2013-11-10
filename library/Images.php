<?PHP 
class ClImages extends ClMysql {
	var $dir;
	var $open ;
	var $content;
	var $im;
	var $width;
	var $height;
	var $instr ;
	var $thumb;
	var $imgw;
	var $imgwh;
	var $xscale;
	var $yscale;
	var $new_width;
	var $new_height;
	var $msg="image size exceeds!";
	var $msg2="format not allowed!";
	var $redsize;
 
	function checkfile( $size,$error, $name) {  /* this function is for secure image uploading, ie invalid and malicious files uploading is restricted */
		if ( $error > 0 ) {
			echo "ERROR:". $error;
		} else {
			if($size>200005000){ /* max size , you can check this according to your needs */
				//echo $this->msg;
				return false;
			} elseif (exif_imagetype($name) != IMAGETYPE_GIF && exif_imagetype($name) != IMAGETYPE_JPEG && exif_imagetype($name) != IMAGETYPE_PNG ) {
				/* CHECK exif_imagetype() manual in php.net */
				//echo $this->msg2;
				return false;
			} else {
				return true;
			} /* returns true , if image is secured ,,,then the execution of function fileoperation() is executed*/       
		}
	}

	function fileoperation ($tmpname){     /* note this function is execueted if and only function checkfile() return true..this function is for uploading image(reaized) into mysql db.... */
		$this->open = fopen($tmpname, 'r+');
		$this->content = fread($this->open, filesize($tmpname));

		fclose($this->open);

		$this->im = imagecreatefromstring($this->content);

		$this->width = imagesx($this->im); /* get the width of the image*/
		$this->height = imagesy($this->im);  /*get the height of the image*/          

		$this->xscale=$this->width/150;  /* this is the new size 150 px width, you can change this to your own requirements*/
		$this->yscale=$this->height/180;        /* this is the new size 180 px height, you can change this to your own requirements*/

		if ($this->yscale>$this->xscale){
			$this->new_width = round($this->width * (1/$this->yscale)); /* new width*/
			$this->new_height = round($this->height * (1/$this->yscale)); /* new height */
		} else {
			$this->new_width = round($this->width * (1/$this->xscale));
			$this->new_height = round($this->height * (1/$this->xscale));
		}

		# create new image using thumbnail-size
		$this->thumb=imagecreatetruecolor( $this->new_width, $this->new_height);                  
		# copy original image to thumbnail
		imagecopyresampled($this->thumb,$this->im,0,0,0,0,$this->new_width,$this->new_height, $this->width , $this->height); #makes thumb


		$thumbname = $this->dir."/".time()."jpg";

		imagejpeg($this->thumb, $thumbname, 85);            

		$this->redsize=filesize($thumbname);   /* getting the reduced size */
		$this->instr = fopen($thumbname,"r+"); #need to move this to a safe directory

		$this->thumb = addslashes(fread($this->instr,filesize($thumbname)));
		$this->image = addslashes($this->content);
	}
}

$Images = new ClImages();
$Images->dir = $Settings->Def->UploadDir;
