<?php

class FilesOps
{

    public function uploadImage($target_dir, $filedetails, $prefix, $requiredsize)
    {
        $target_file = $target_dir . $prefix . basename($filedetails["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($filedetails["tmp_name"]);
            if ($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($filedetails["size"] > $requiredsize) {
            //echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "bmp" && $imageFileType != "gif" && $imageFileType != "webp"
        ) {
            //echo "Sorry, only JPG, JPEG, PNG, WEBP & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {

            return false;
        } else {
            if (move_uploaded_file($filedetails["tmp_name"], $target_file)) {

                return $prefix . basename($filedetails["name"]);
            } else {

                return false;
            }
        }
    }

    public function uploadFile($target_dir, $filedetails, $prefix, $requiredsize, $exts)
    {

        $file_ext = explode('.', $filedetails["name"]);

        $file_ext_check = strtolower(end($file_ext));

        $valid_file_ext = $exts;

        if (strlen($filedetails["name"]) > 1 && $filedetails["size"] < $requiredsize) {

            if ($filedetails["error"] == 0) {

                if (in_array($file_ext_check, $valid_file_ext)) {

                    $newfilename = $prefix . $filedetails["name"];

                    $destfile = $target_dir . $newfilename;

                    if (move_uploaded_file($filedetails['tmp_name'], $destfile)) {

                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function readFileContent($filepath)
    {

        $filestream = fopen($filepath, "r");

        if ($filestream == true) {

            $content = fread($filestream, filesize($filepath));
            fclose($filestream);

            return $content;
        } else {

            return false;
        }
    }

    public function writeFileContent($filepath, $content)
    {

        $filestream = fopen($filepath, "w");

        if ($filestream == true) {

            fwrite($filestream, $content);
            fclose($filestream);

            return true;
        } else {

            return false;
        }
    }

    public function compressImage($source, $destination, $quality)
    {
        // Get image info 
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Create a new image from file 
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }

        // Save image 
        imagejpeg($image, $destination, $quality);

        // Return compressed image 
        return $destination;
    }

    public function uploadAndCompressImage($target_dir, $filedetails, $prefix)
    {
        // If file upload form is submitted 
        $status = $statusMsg = '';
        $uploadPath = $target_dir;
        $status = 'error';
        if (!empty($filedetails["name"])) {
            // File info 
            $fileName = basename($filedetails["name"]);
            $imageUploadPath = $uploadPath . $prefix . $fileName;
            $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

            // Allow certain file formats 
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Image temp source 
                $imageTemp = $filedetails["tmp_name"];
                $imageSize = $filedetails["size"];

                // Compress size and upload image 
                $compressedImage = $this->compressImage($imageTemp, $imageUploadPath, 60);

                if ($compressedImage) {

                    $compressedImageSize = filesize($compressedImage);

                    $status = 'success';
                    // $statusMsg = "Image compressed successfully."; 

                    return $prefix . $fileName;;
                } else {
                    $statusMsg = "Image compress failed!";
                }
            } else {
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
            }
        } else {
            $statusMsg = 'Please select an image file to upload.';
        }

        // Display status message 
        echo $statusMsg;
    }
}
