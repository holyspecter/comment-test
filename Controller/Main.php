<?php
class Controller_Main
{
	public function listAction()
	{
		$title = 'Comments';				

		if ('POST' === $_SERVER['REQUEST_METHOD'] && isset($_REQUEST['page'])) {			
			$comments = Model_Comment::getAll(CT_COMMENTS_PER_PAGE * ($_REQUEST['page'] - 1));

			echo json_encode($comments);			
			die;
		}

		$comments = Model_Comment::getAll();
		
		include CT_ROOT.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.'list.php';
	}

	public function addAction()	
	{
		if (
					'POST' === $_SERVER['REQUEST_METHOD']
				&&	isset($_SESSION['captcha']) 
				&& $_SESSION['captcha'] === $_POST['captcha'] 
				&& $_POST['author'] 
				&& $_POST['comment']
				) {
					$comment = new Model_Comment($_POST['author'], $_POST['comment']);
					$comment->save();

					unset($_SESSION['captcha']);

					echo json_encode($comment);
					die;
			}
		die;
	}	
}