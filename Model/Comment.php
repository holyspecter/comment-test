<?php
class Model_Comment implements JsonSerializable
{
	 protected $id;

	 protected $author;

	 protected $comment;

	 protected $author_ip;

	 protected $created_at;	 

	 public function __construct($author, $comment)
	 {	 		 	
	 	$this->author = addslashes($author);
	 	$this->comment = addslashes($comment);		 	 	
	 }
	
	public function __get($key)
	{
		return $this->$key;
	}

	public function __set($key, $value)
	{
		$this->$key = $value;		
	}

	public function save()
	{
		$db = new SQLite3(CT_DB_PATH);

		$db->exec('CREATE TABLE IF NOT EXISTS ct_comment (
							id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
							author CHAR(64) NOT NULL,
							comment TEXT NOT NULL,
							author_ip CHAR(16) NOT NULL,
							created_at TEXT NOT NULL
			);');

		$this->created_at = new DateTime();
		$this->created_at = $this->created_at->format(DateTime::RFC1036);

		$db->exec(sprintf(
				"INSERT INTO ct_comment(author, comment, author_ip, created_at) VALUES('%s', '%s', '%s', '%s')",
				$this->author,
				$this->comment,
				$_SERVER['REMOTE_ADDR'],
				$this->created_at
			));
	}

	/**
	*	Gets all comments from DB
	* @return Model_Comment[]
	*/
	public static function getAll($offset = 0)
	{
		$db = new SQLite3(CT_DB_PATH);	

		$comments = array();
		$result = $db->query(
						sprintf("SELECT * FROM ct_comment ORDER BY created_at DESC LIMIT %d OFFSET %d;",
								CT_COMMENTS_PER_PAGE,
								$offset
						));		

		while ($commentArr = $result->fetchArray(SQLITE3_ASSOC)) {
			$comments[] = Model_Comment::fromArray($commentArr);
		}		

		return $comments;
	}

	/**
	*	Creates object and fills it with array values
	* @param array $arr
	* @return Model_Comment
	*/
	protected static function fromArray($arr)
	{
		$obj = new Model_Comment($arr['author'], $arr['comment']);
		$obj->author_ip = $arr['author_ip'];
		$obj->created_at = $arr['created_at'];

		return $obj;
	}

	/**
	*	Counts all comments	
	* @return Model_Comment
	*/
	public static function countAll()
	{
		$db = new SQLite3(CT_DB_PATH);

		return $db->querySingle('SELECT COUNT(*) FROM ct_comment;');
	}

	public function jsonSerialize() {
        return [
        	'id' => $this->id,
            'author' => $this->author,
            'comment' => $this->comment,
            'author_ip' => $this->author_ip,
            'created_at' => $this->created_at
        ];
    }

	public function __toString()
	{
		return $this->comment;
	}

	/**
	*	Removes all comments from DB
	*/
	public static function removeAll()
	{
		$db = new SQLite3(CT_DB_PATH);

		$db->exec('DELETE FROM ct_comment;');
	}
}