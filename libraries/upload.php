<?php
/**
 * Upload helper.
 * 
 * Remember to define your form with "enctype=multipart/form-data" or file
 * uploading will not work!
 * 
 * Written by Chris Hayes for use by OKD Marketing.
 * 
 * @author      Chris Hayes <chris@chrishayes.ca, chayes@okd.com>
 * @copyright   (c) 2012 Chris Hayes
 */
class Upload {
    /**
     * Upload a file.
     * 
     * @param   array   $file
     * @param   string  $directory  Relative to default upload directory
     * @return  string              On success, relative path to image
     * @return  false               On failure 
     */
    public static function save($file, $directory = NULL)
    {
        // Ignore corrupted uploads
        if (!isset($file['tmp_name']) OR !is_uploaded_file($file['tmp_name']))
        {
            return FALSE;
        }
        
        // Make sure the directory exists and is writable.
        if ( ! is_dir($directory) OR ! is_writable(realpath($directory)))
		{
			return false;
		}

        // Produce a random number to prepend to image name for security reasons.
        $filename = uniqid() . $file['name'];

        // Remove spaces from the filename
        $filename = preg_replace('/\s+/u', '_', $filename);
        
        // Create our target image path with the prepended random number.
        $path = $directory . $filename;

        if (move_uploaded_file($file['tmp_name'], $path))
        {
            return $filename;
        }

        return false;
    }

}