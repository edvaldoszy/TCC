<!DOCTYPE html><!-- Edvaldo Szymonek -->
<html lang="<?= $this->getLanguage() ?>">
<head>
    <meta charset="<?= $this->getCharset() ?>">
    <base href="<?= $this->getBaseUrl() ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->getTitle() ?></title>

	<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2 sidebar">SIDEBAR</div>
			<div class="span10 content">
				<div class="row-fluid">
					<div class="span12">TÍTULO</div>
				</div>
				<div class="row-fluid">
					<div class="span12">CONTEÚDO</div>
				</div>
			</div>
		</div>
	</div>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>