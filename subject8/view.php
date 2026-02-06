<?php require_once "db.php"; ?>

<?php
	$sql = "SELECT u.id, u.name, COUNT(p.id) AS post_cnt FROM users u JOIN posts p ON p.userid = u.id GROUP BY u.id, u.name";
    
    $pstmt = $db->prepare($sql);
    $pstmt->execute([]);

    $users = $pstmt->fetchAll();

	$sql = "SELECT
	p.id,
	p.userid,
	u.name AS name,
	p.category,
	p.title,
	p.text,
	p.date,
	p.img,
	COUNT(c.id) AS comment_cnt
	FROM posts p
	JOIN users u ON u.id = p.userid
	LEFT JOIN comments c ON c.postid = p.id
	GROUP BY p.id
	ORDER BY p.date DESC";
    
    $pstmt = $db->prepare($sql);
    $pstmt->execute([]);

    $posts = $pstmt->fetchAll();

	$sql = "SELECT
    p.id,
    p.userid,
    u.name AS name,
    u.email AS email,
    p.category,
    p.title,
    p.text,
    p.date,
    p.img
	FROM posts p
	JOIN users u ON u.id = p.userid
	LEFT JOIN comments c ON c.postid = p.id
	WHERE p.id = :id
	GROUP BY p.id";
	
	$pstmt = $db->prepare($sql);
	$pstmt->execute([
		"id" => $_GET['id']
	]);

	$post = $pstmt->fetch();
	
	$sql = "SELECT
        c.id,
        c.postid,
		c.userid,
        u.name AS name,
		u.email AS email,
        c.text,
        c.date
    FROM comments c
    JOIN users u ON u.id = c.userid
    WHERE c.postid = :postid
    ORDER BY c.date ASC";
	
	$pstmt = $db->prepare($sql);
	$pstmt->execute([
		"postid" => $_GET['id']
	]);

	$comments = $pstmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>Our Blog</title>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="jumbotron">
  	<h1><a href="index.php">Our Blog</a></h1>
  	<p>Our Blog는 우리의 꿈과 희망을 나누는 곳입니다.</p>
  	<p>
			<form class="form-inline" role="search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
			</form>
  	</p>
		</div>
		<div class="row">

			<!-- 블로그 글 본문 보기 -->
			<div class="col-md-9">

				<!-- 블로그 글 -->
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><h2><?=$post->title?></h2></h3>
					</div>
					<div class="panel-body">
						<?php if ($post->img): ?>
							<img class="img-responsive" src="images/sample1.jpg" alt="image sample">
						<?php endif; ?>
						<p style="word-break: break-word;">
							<?=$post->text?>
						</p>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6"><span class="category"><strong>[<?=$post->category?>]</strong></span>&nbsp;&nbsp;
							<span class="writer"><?=$post->name?></span>&nbsp;&nbsp;<span class="date"><?=$post->date?></span>&nbsp;&nbsp;
							<span class="commentcount">댓글수 <span class="badge"><?=count($comments)?></span></span></div>
							<div class="col-md-6 btns">
								<?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post->userid): ?>
									<a href="modify.php" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> 수정</a>
									<a href="/posts/action.php?mode=delete&id=<?=$post->id?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 삭제</a>
								<?php endif; ?>	
								<a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-th-list"></span> 목록으로</a>
							</div>
						</div>						
					</div>
				</div>
				<!-- //블로그 글 -->

				<!-- 댓글 폼 -->
				<?php if (isset($_SESSION['user'])): ?>	
					<div class="row">
						<form class="form-horizontal" action="/comments/action.php" method="post">
							<input type="hidden" name="mode" value="create">
							<input type="hidden" name="postid" value="<?=$post->id?>">
							<div class="form-group">
								<label for="userid" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="email" id="userid" placeholder="<?=$_SESSION['user']['email']?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">댓글내용</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="3" name="comment" id="comment"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">댓글저장</button>
								</div>
							</div>
						</form>
					</div>
				<?php endif; ?>	
				<!-- //댓글 폼 -->

				<!-- 댓글 리스트 -->
				<div class="commentlist">
					<?php foreach ($comments as $comment): ?>
						<div class="comment">
							<h3><?=$comment->name?> <?=$comment->email?> <?=$comment->date?></h3>
							<p style="word-break: break-word;"><?=$comment->text?> 
							<?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $comment->userid): ?>	
								<a href="/comments/action.php?mode=delete&id=<?=$comment->id?>&postid=<?=$comment->postid?>" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a></p>
							<?php endif; ?>	
						</div>
					<?php endforeach; ?>
				</div>
				<!-- //댓글 리스트 -->

			</div>
			<!-- //블로그 글 본문 보기 -->

			<!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->
			<div class="col-md-3">

				<div class="loginarea">
					<div class="panel panel-default">
					<div class="panel-body">
						<?php if (isset($_SESSION['user'])): ?>
							<div class="text-center">
								<strong><?=$_SESSION['user']['name']?></strong>
								<p class="small text-muted"><?=$_SESSION['user']['email']?></p>
								</div>

								<hr>

								<div class="text-center">
								<p class="mb10">
									내가 쓴 글<br>
									<strong class="h4">
										<?php
											$pstmt = $db->prepare(
												"SELECT COUNT(*) FROM posts WHERE userid = :id"
											);
											$pstmt->execute([
												"id" => $_SESSION['user']['id']
											]);
											$postcnt = $pstmt->fetchColumn();
											echo $postcnt;
										?>
									</strong> 개
								</p>

								<a href="/users/action.php?mode=logout"
									class="btn btn-default btn-sm btn-block">
									로그아웃
								</a>
							</div>
						<?php else: ?>
							<form class="form-horizontal" method="post" action="users/action.php">
								<input type="hidden" name="mode" value="login">
								<div class="form-group">
									<div class="col-sm-12">
									<input type="email" class="form-control" name="userid" id="userid" placeholder="email@domain.com">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
									<input type="password" class="form-control" name="userpass" id="userpass" placeholder="비밀번호">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
									<button type="submit" class="btn btn-default">로그인</button>
									<a href="join.php"><button type="button" class="btn btn-info">회원가입</button></a>
									</div>
								</div>
							</form>
						<?php endif; ?>
					</div>
					</div>					
				</div>

				<div>
					<?php if (isset($_SESSION['user'])): ?>
						<a href="write.php" class="writebtn btn btn-primary btn-lg col-sm-12"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a>
					<?php endif; ?>
				</div>

				<div class="categories">
					<h3>Categories</h3>
					<ul>
						<li>전체보기 <span class="badge"><?=count($posts)?></span></li>
						<li>life <span class="badge"><?=count(array_filter($posts, fn($p) => $p->category === 'life'))?></span></li>
						<li>art <span class="badge"><?=count(array_filter($posts, fn($p) => $p->category === 'art'))?></span></li>
						<li>fashion <span class="badge"><?=count(array_filter($posts, fn($p) => $p->category === 'fashion'))?></span></li>
						<li>technics <span class="badge"><?=count(array_filter($posts, fn($p) => $p->category === 'technics'))?></span></li>
						<li>etcs <span class="badge"><?=count(array_filter($posts, fn($p) => $p->category === 'etcs'))?></span></li>
					</ul>
				</div>

				<div class="authors">
					<h3>Authors</h3>
					<ul>
						<?php foreach ($users as $user): ?>
							<li>
								<?= $user->name ?>
								<span class="badge"><?= $user->post_cnt ?></span>
							</li>
						<?php endforeach; ?>
					</ul>					
				</div>

			</div>
			<!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->

		</div>
		<div class="footer">
			Copyright &copy; <strong>Our Blog</strong> All rights reserved.
		</div>
	</div>
</body>
</html>