<head>
	<title><?=$title; ?></title>
	<script type="text/javascript" src="<?= '..'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jquery-1.10.2.min.js'; ?>"></script>		
	<script type="text/javascript" src="<?= '..'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'list.js'; ?>"></script>	
	<script type="text/javascript">
		var perPage = <?= CT_COMMENTS_PER_PAGE ?>;
		var countComments = <?= Model_Comment::countAll() ?>;		
	</script>
	<link rel="stylesheet" type="text/css" href="<?= '..'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'main.css'; ?>">

</head>

<body>
	<div id="layout">
		<div>
			<h2><?=$title; ?></h2>
		</div>				
		<div id="form-add">
			<h3>Your Opinion:</h3>
			<div id="form-errors"></div>
			<form method="post" action="/index.php?action=add" id="add-comment">
				<label for="author">Name:</label><br/>
				<input type="text" name="author" id="author"  /><br/>
				<label for="comment">Comment:</label><br/>
				<textarea name="comment" id="comment" placeholder="Type your comment..." ></textarea><br/>
				<label for="captcha">We need to be sure you are human:</label><br/>
				<img src="<?= '..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'cool-php-captcha-0.3.1'.DIRECTORY_SEPARATOR.'captcha.php' ?>" id="captcha" /><br/>				
				<input type="text" name="captcha_text" id="captcha-text"  /><br/>
				<a id='submit'>Send</a>				
			</form>
		</div>
		<div id='comments-block'>
			<?php foreach ($comments as $comment) : ?>
				<div class="comment">
					<strong><?= $comment->author ?></strong> says:<br/>
					<?= $comment->comment ?><br/>
					<span class='date'><?= $comment->created_at ?></span>
				</div>
			<?php endforeach; ?>			
		</div>
		<div id='navigation'>
				<?php 
					$pages = (0 < Model_Comment::countAll() % CT_COMMENTS_PER_PAGE) ? 
						Model_Comment::countAll() / CT_COMMENTS_PER_PAGE + 1 : 
						Model_Comment::countAll() / CT_COMMENTS_PER_PAGE;
					for ($i = 1; $i < $pages; $i++) : 
				?>
						<span class="page"><?= $i; ?></span>
				<?php endfor; ?>
		</div>
	</div>	
</body>
