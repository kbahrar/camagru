<?php
	$title = "Post";
	ob_start();
	if(!empty($_SESSION["name"]))
	{
		$title = "Welcome " . $_SESSION["name"];
		$img = $_SESSION["img"];
		$name = $_SESSION["name"];
?>
			<li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="gallery.php">Gallery <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="home.php?action=decon">Deconnexion</a>
			</li>
			</ul>
			<a class="navbar-brand" href="profile.php">
				<img src="<?= $img; ?>" width="50" height="50" class="img_prf">
				<?= htmlspecialchars($name); ?>
			</a>
<?php
	}
	else
	{
?>
		<li class="nav-item">
		<a class="nav-link" href="index.php">Connexion</a>
		</li>
		</ul>
<?php
	}
	$nav = ob_get_clean();
	ob_start();
// get informations and write this on html
	$data = $post;
?>
	<div class="card text-center mt-3 mx-5">
		<div class="card-header">
			<img src="../<?= $data["pdp"] ?>" width="50" height="50" class="img_prf">
			<em><b><?= htmlspecialchars($data['uname']) ?></b><em>
			<div class="text-right text-muted">(<?= $data['created_at'] ?>)</div>
		</div>
		<div class="card-body">
			<img src="<?= $data['img'] ?>" class=" img-thumbnail">
		</div>
		<div class="card-footer">
			<div class="container">
				<div class="row">
				<?php
					if ($like == -1)
					{
				?>
					<div class="col-sm p-2 m-2 badge badge-primary">
						<a href="post.php?action=like&post_id=<?= $data['id'] ?>" class="badge badge-primary p-2">
							Likes (<?= $data['likeCount'] ?>)
						</a>
					</div>
				<?php
					}
					else
					{
				?>
						<div class="col-sm p-2 m-2 badge badge-danger">
						<a href="post.php?action=unlike&post_id=<?= $data['id'] ?>" class="badge badge-danger p-2">
								Unlike (<?= $data['likeCount'] ?>)
						</a>
						</div>
				<?php
					}
				?>
					<div class="col-sm p-2 m-2 badge badge-success pt-3">
						Comments (<?= $data['cmntCount'] ?>)
					</div>
				</div>
			</div>
		</div>
	</div>
	<form method="post" action="post.php?action=cmnt&post_id=<?= $data['id'] ?>">
		<div class="card mt-3 mx-5 p-3">
			<div class="input-group" >
				<input type="text"  class="form-control form-control-lg" name="cmnt" placeholder="type your comment ...">
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="submit">Comment</button>
				</div>
		</div>
	</div>
	</form>
	<div class="mb-5">
<?php
	while ($cmnt = $cmnts->fetch())
	{
?>
	<div class="card mt-1 mx-5">
		<div class="card-header">
			<div class="container ">
				<div class="row">
					<div class="col-sm">
						<img src="../<?= $cmnt["pdp"] ?>" width="50" height="50" class="img_prf">
						<em><b><?= htmlspecialchars($cmnt['uname']) ?></b></em>
					</div>
					<div class="col-sm"><div class="text-right text-muted">(<?= $cmnt['created_at'] ?>)</div></div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="container">
				<div class="row">
					<div class="col-6">
						<b><?= htmlspecialchars($cmnt['body']) ?></b>
					</div>
<?php
	if ($data['user_id'] == $_SESSION['id'] || $cmnt['user_id'] == $_SESSION['id'])
	{
?>
					<div class="col text-right">
						<a href="post.php?action=del&post_id=<?= $data['id'] ?>&cmnt_id=<?= $cmnt['id'] ?>&user_id=<?= hash('whirlpool', $_SESSION['id']) ?>">Delete</a>
					</div>
<?php
	}
?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
	</div>
<?php
	$content = ob_get_clean();
	require("template2.php");
?>