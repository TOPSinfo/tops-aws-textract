<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Analyze Document using AWS Textract</title>
</head>
<body>
	<h2>Analyze Document using AWS Textract</h2>
	<form enctype="multipart/form-data"	method="POST">
		@csrf
		<label>Select Document (JPEG, PNG)</label>
		<input type="file" name="document" />
		<input type="submit" name="submit" value="submit">
	</form>
</body>
</html>