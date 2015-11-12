<form action="" method="post">
	<input type="file" name="anexo[]" multiple onchange="sendFile(this)">
</form>

<button onclick="sendInfo({nome: 'Edvaldo', idade: 20})">Send Info</button>

<script>

	var op = {
		url: '/admin/teste',

		success: function (response) {
			console.info(response);
		}
	};

	function sendFile(input)
	{
		var req = [];
		for (var n in input.files) {
			var data = new FormData();
			data.append('f[]', input.files[n]);

			req.push(new Ajax(op));
			req[n].send(data, req[n].METHOD_POST);
		}
	}

	function sendInfo(info)
	{
		var ajax = new Ajax(op);
		var data = new FormData();
		for (var n in info) {
			data.append(n, info[n]);
		}

		ajax.send(data, ajax.METHOD_POST);
	}
</script>