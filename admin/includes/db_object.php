<?php
class Db_object
{

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

  public function find_all()
  {

    return $this->find_by_query("SELECT * FROM " . $this->db_table . "");
  }

  public function find_by_id($id)
  {

    $the_result_array = $this->find_by_query("SELECT * FROM " . $this->db_table . " WHERE id=$id LIMIT 1");

    return !empty($the_result_array) ? array_shift($the_result_array) : false;
  }

  public function find_by_query($sql)
  {
    $result_set = $this->db->query($sql);
    $the_object_array = array();
    while ($row = mysqli_fetch_array($result_set)) {
      $the_object_array[] = $this->instantiation($row);
    }
    return $the_object_array;
  }

  public function instantiation($the_record)
  {
    $calling_class = get_called_class();
    $the_object = new $calling_class($this->db);

    foreach ($the_record as $the_attribute => $value) {
      if ($the_object->has_the_attribute($the_attribute)) {
        $the_object->$the_attribute = $value;
      }
    }
    return $the_object;
  }

  private function has_the_attribute($the_attribute)
  {
    $object_properties = get_object_vars($this);

    return array_key_exists($the_attribute, $object_properties);
  }

  protected function properties()
  {
    $properties = array();
    foreach ($this->db_table_fields as $db_field) {
      if (property_exists($this, $db_field)) {
        $properties[$db_field] = $this->$db_field;
      }
    }
    return $properties;
  }
  // ===== CLEAN PROPERTIES =====//
  protected function clean_properties()
  {
    $clean_properties = array();

    foreach ($this->properties() as $key => $value) {
      $clean_properties[$key] = $this->db->escape_string($value);
    }

    return $clean_properties;
  }
  // ===== SAVE FUNCTION =====//
  public function save()
  {
    return isset($this->id) ? $this->update() : $this->create();
  }
  //=====  CREATE FUNCTION =====//
  public function create()
  {
    $properties = $this->clean_properties();

    $sql = "INSERT INTO " . $this->db_table . " (" . implode(",", array_keys($properties)) . ") ";
    $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

    if ($this->db->query($sql)) {
      $this->id = $this->db->the_insert_id();
      return true;
    } else {
      return false;
    }
  }
  //=====  UPDATE FUNCTION =====//
  public function update()
  {
    $properties = $this->clean_properties();
    $properties_pairs = array();

    foreach ($properties as $key => $value) {
      $properties_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . $this->db_table . " SET ";
    $sql .= implode(", ", $properties_pairs);
    $sql .= " WHERE id = " . $this->db->escape_string($this->id);

    $this->db->query($sql);

    return (mysqli_affected_rows($this->db->connection) == 1) ? true : false;
  }
  //=====  DELETE FUNCTION =====//
  public function delete()
  {
    $sql = "DELETE FROM " . $this->db_table . " WHERE id = " . $this->db->escape_string($this->id) . " LIMIT 1";

    $this->db->query($sql);

    return (mysqli_affected_rows($this->db->connection) == 1) ? true : false;
  }

  //===== COUNT METHOD =====// 
  public function count_all()
  {
    $sql = "SELECT COUNT(*) FROM " . $this->db_table;
    $result_set = $this->db->query($sql);
    $row = mysqli_fetch_array($result_set);

    return array_shift($row);
  }
}
