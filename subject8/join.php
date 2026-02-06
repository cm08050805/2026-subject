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

			<!-- 블로그 글 쓰기 -->
			<div class="col-md-9">

				<!-- 블로그 글쓰기 폼 -->
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><h2>회원가입</h2></h3>
					</div>
					<div class="panel-body">

						<form class="form-horizontal" action="users/create.php" method="post">
							<div class="form-group">
								<label for="userid" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="userid" id="userid" placeholder="email@domain.com">
								</div>
							</div>
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label">이름</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="username" id="username" placeholder="이름">
								</div>
							</div>												
							<div class="form-group">
								<label for="userpass" class="col-sm-2 control-label">비밀번호</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="userpass" id="userpass" placeholder="비밀번호">
								</div>
							</div>
							<div class="form-group">
								<label for="userpass2" class="col-sm-2 control-label">비밀번호확인</label>
								<div class="col-sm-10">
									<input type="password" class="form-control" name="userpass2" id="userpass2" placeholder="비밀번호 확인 ">
								</div>
							</div>																				
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">회원가입</button>
								</div>
							</div>
						</form>
						
					</div>
				</div>
				<!-- //블로그 글쓰기 폼 -->

			</div>
			<!-- //블로그 글 쓰기 -->

			<!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->
			<div class="col-md-3">

				<div class="loginarea">
					<div class="panel panel-default">
					<div class="panel-body">
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
						      <button type="button" class="btn btn-info">회원가입</button>
						    </div>
						  </div>
						</form>
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