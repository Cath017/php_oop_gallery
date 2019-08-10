<?php
class User extends Db_object
{
  protected $db;
  protected  $db_table = 'users';
  protected  $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  public $user_image;
  public $upload_directory = "images";
  public $image_placeholder = "../image/avatar.png";

  public $tmp_path;

  public $errors = array();
  public $upload_errors_array = array(

    UPLOAD_ERR_OK => 'There is no error.',
    UPLOAD_ERR_INI_SIZE => 'The upload file exceeds the upload_max_filesize directive',
    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that',
    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
  );

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  // public function set_file($file)
  // {

  //   if (empty($file) || !$file || !is_array($file)) {
  //     $this->errors[] = 'There was no file uploaded here';
  //     return false;
  //   } elseif ($file['error'] != 0) {
  //     $this->errors[] = $this->upload_errors_array[$file['error']];
  //     return false;
  //   } else {
  //     $this->user_image = basename($file['name']);
  //     $this->tmp_path = $file['tmp_name'];
  //     $this->type = $file['type'];
  //     $this->size = $file['size'];
  //   }
  // }


  // public function upload_image()
  // {
  //   if (!empty($this->errors)) {
  //     return false;
  //   }

  //   if (empty($this->user_image) || empty($this->tmp_path)) {
  //     $this->errors[] = 'The file was not available';
  //     return false;
  //   }

  //   $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

  //   if (file_exists($target_path)) {
  //     $this->errors[] = "The file {$this->user_image} already exists";
  //     return false;
  //   }

  //   if (move_uploaded_file($this->tmp_path, $target_path)) {

  //     unset($this->tmp_path);
  //     return true;
  //   } else {
  //     $this->errors = "The file directory probably does not have permission";
  //     return false;
  //   }
  // }


  public function image_placeholder()
  {
    return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
  }


  public function verify_user($username, $password)
  {
    $username = $this->db->escape_string($username);
    $password = $this->db->escape_string($password);

    $sql = "SELECT * FROM " . $this->db_table . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";

    $the_result_array = $this->find_by_query($sql);

    return !empty($the_result_array) ? array_shift($the_result_array) : false;
  }

  public function ajax_save_user_image($user_image, $user_id)
  {
    $user_image = $this->db->escape_string($user_image);
    $user_id = $this->db->escape_string($user_id);

    $this->user_image = $user_image;
    $this->id = $user_id;

    $sql = "UPDATE " . $this->db_table . " SET user_image = '{$this->user_image}' WHERE id = {$this->id}";
    $update_image = $this->db->query($sql);

    echo $this->image_placeholder();
  }

  public function delete_photo()
  {
    if ($this->delete()) {
      $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;
      return unlink($target_path) ? true : false;
    } else {
      return false;
    }
  }

  public function photos(Photo $photo)
  {
    return $photo->find_by_query("SELECT * FROM photos WHERE user_id = " . $this->id);
  }
}
