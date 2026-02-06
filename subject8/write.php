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
						<h3 class="panel-title"><h2>글쓰기</h2></h3>
					</div>
					<div class="panel-body">

						<form class="form-horizontal" action="posts/action.php" method="post">
							<input type="hidden" name="mode" value="create">
							<div class="form-group">
								<label for="userid" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" name="userid" id="userid" value="<?=$_SESSION['user']['email']?>" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="username" class="col-sm-2 control-label">작성자</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="username" id="username" value="<?=$_SESSION['user']['name']?>" readonly>
								</div>
							</div>							
							<div class="form-group">
								<label for="category" class="col-sm-2 control-label">카테고리</label>
								<div class="col-sm-10">
									<select class="form-control" name="category" id="category">
										<option value="life">life</option>
										<option value="art">art</option>
										<option value="fashion">fashion</option>
										<option value="technics">technics</option>
										<option value="etcs">etcs</option>
									</select>																	
								</div>
							</div>						
							<div class="form-group">
								<label for="title" class="col-sm-2 control-label">제목</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="title" id="title" placeholder="글 제목">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">글본문</label>
								<div class="col-sm-10">
									<textarea class="form-control" rows="8" name="comment" id="comment"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-2 control-label">이미지</label>
								<div class="col-sm-10">
									<input type="file" class="form-control" id="upimg">
								</div>
							</div>													
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">글쓰기</button>
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
					</div>
					</div>					
				</div>

				<div>
					<a href="write.php" class="writebtn btn btn-primary btn-lg col-sm-12"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a>
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