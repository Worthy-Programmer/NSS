<?php

namespace Fahd\NSS;


class PFP
{
  const DIR = "../view/static/pfp/";
  const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

  public DB $db;
  public function __construct(public string $id) {}

  public function uploadPFP($file): Response
  {
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = $this->id . "." . $file_extension;
    $target_file = self::DIR . basename($filename);

    $file_type = mime_content_type($file['tmp_name']);

    $res = new Response(Status::Error, "Error in file upload: " . $file['error']);
    
    if(!in_array($file_type, self::ALLOWED_TYPES))  {
      $res->status = Status::Error;
      $res->response = "File type is not supported. Please upload PNG/JPEG format images";
      return $res;

    }

    // Check for upload errors
    if ($file['error'] === UPLOAD_ERR_OK) {
      // Try to move the uploaded file to the target directory
      $old_pfp = $this->getPFPLink();
      if($old_pfp->status == Status::OK) unlink($old_pfp->response);

      if (move_uploaded_file($file['tmp_name'], $target_file)) {
        $res->status = Status::OK;
        $res->response =  "Profile Picture updated successfully";
      } else {
        $res->response =  "Sorry, there was an error uploading your file.";
      }
    }

    return $res;
  }


  public function getPFPLink(): Response
  {
    $matching_files = glob(self::DIR . $this->id . "*");
    $res = new Response(Status::NotOK, "No files found");

    if (!empty($matching_files)) {
      $res->status = Status::OK;
      $res->response = $matching_files[0];
    }
    return $res;
  }
}
