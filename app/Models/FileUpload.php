<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;
class FileUpload extends Model {

    
    private static function generateFolderPath() {
        
		$folderPath         = date("Y")."/".intval(date("m"))."/";
		return $folderPath;
	}
	
    /**
     * Make a Filename, based on the uploaded file.
     *
     * @return string
     */
    private static function generateFilename($fileObj) {

        // Get the file name original name
        // and encrypt it with sha1
        $name = sha1 (
            time() . $fileObj->getClientOriginalName()
        );

        // Get the extension of the photo.
        $extension = $fileObj->getClientOriginalExtension();

        // Then set name = merge those together.
        return "{$name}.{$extension}";
    }

    /**
     * get filename with full path
     * save this path to db and folder
     * @return string
     */
    public static function generateFilepath($fileObj) {

        $folderPath =   self::generateFolderPath();
        $ret        =   $folderPath. self::generateFilename($fileObj);
        return $ret;
    }
    
    /**
     * display file path with filename 
     * for viewing
     * @return string
     */
    public static function getFilepath($fileObj) {

        //make condition here....
        $ret        =   $fileObj->filepath;
        return $ret;
    }
    
    /*
     * upload orifinal file
     */
    public static function uploadFile($file) {
			$filenameToSave     =   self::generateFilename($file);
            $filePathToStore    =   self::generateFilepath($file);
            \Storage::disk('event')->put($filePathToStore,  \File::get($file));//big file
            //TODO :: will make thumbnail...
        return "/uploads/".$filePathToStore;
    }
    
}