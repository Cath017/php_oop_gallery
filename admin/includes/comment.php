<?php
class Comment extends Db_object
{
  protected $db;
  protected  $db_table = 'comments';
  protected  $db_table_fields = array('id', 'photo_id', 'author', 'body');
  public $id;
  public $photo_id;
  public $author;
  public $body;
  public $created_at;

  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  public function create_comment($photo_id, $author = 'John', $body = '')
  {

    if (!empty($photo_id) && !empty($author) && !empty($body)) {
      $comment = new Comment(new Database);

      $comment->photo_id = (int) $photo_id;
      $comment->author = $author;
      $comment->body = $body;

      return $comment;
    } else {
      return false;
    }
  }

  public function find_comments($photo_id = 0)
  {
    $sql = "SELECT * FROM " . $this->db_table . " WHERE photo_id= " . $this->db->escape_string($photo_id) . " ORDER BY id ASC";

    return $this->find_by_query($sql);
  }
}
