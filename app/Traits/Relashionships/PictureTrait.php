<?php

namespace App\Traits\Relashionships;
use App\Models\Commons\Picture;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


trait PictureTrait {

    public function getImageAttribute()
    {
        return $this->getFileView();
    }

    public function getThumbImageAttribute()
    {
        return $this->getThumbFileView();
    }

    public function hasPicture()
    {
        return ($this->picture != NULL);
    }

    //============================================================
    //========================= FILE =============================
    //============================================================

	public function attachPicture(array $attributes)
	{
		try {
			$file = $attributes['src'];
			$attributes['src'] = md5(time()) .'.'. $file->getClientOriginalExtension();

			$path = self::getPath();
			$thumb_path = $path . 'thumb_' . $attributes['src'];
			$file_path = $path . $attributes['src'];

			if($this->picture_id != NULL){ //DELETAR
				$this->dettachPicture();
			}

			$path = public_path($path);
			File::makeDirectory($path, $mode = 0777, true, true);
			$file->move($path, $attributes['src']);

			$picture = Picture::create($attributes);
			$this->picture_id = $picture->id;

			// create instance
			$img = Image::make($file_path)->resize(null, 48*2, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});

			// resize image to fixed size
			$img->save($thumb_path);
		} catch (\Exception $e) {
			dd($e->getMessage());
			return false;
		}
	}

	public function dettachPicture()
	{
		try {
			File::delete(self::getFullLinkPath());
			File::delete(self::getFullLinkThumbPath());
			$this->picture->delete();
		} catch (\Exception $e) {
			dd($e->getMessage());
			return false;
		}
	}

	static public function getPath()
	{
		return 'uploads' . DIRECTORY_SEPARATOR . self::$img_path
		       . DIRECTORY_SEPARATOR;
	}

	public function getLinkFile()
	{
		return self::getPath() . $this->picture->src;
	}

	public function getLinkThumbFile()
	{
		return self::getPath() . 'thumb_' . $this->picture->src;
	}

    public function getThumbFileView()
    {
    	return ($this->picture_id != NULL) ?  asset($this->getLinkThumbFile()) : asset('assets/images/temp.jpg');
    }

    public function getFileView()
    {
	    return ($this->picture_id != NULL) ?  asset($this->getLinkFile()) : asset('assets/images/temp.jpg');
    }

    public function getFullLinkPath()
    {
        return public_path($this->getLinkFile());
    }

    public function getFullLinkThumbPath()
    {
        return public_path($this->getLinkThumbFile());
    }


    public function picture()
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }
}