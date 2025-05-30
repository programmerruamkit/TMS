<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>WebcamJS Test Page - Large Capture</title>
	<style type="text/css">
		body { font-family: Helvetica, sans-serif; }
		h2, h3 { margin-top:0; }
		form { margin-top: 15px; }
		form > input { margin-right: 15px; }
		#results { float:right; margin:20px; padding:20px; border:1px solid; background:#ccc; }
	</style>
</head>
<body>
	<div id="results">Your captured image will appear here...</div>

	<h1>WebcamJS Test Page - Large Capture</h1>
	<h3>Demonstrates 640x480 large capture with 320x240 small display</h3>

	<div id="my_camera"></div>

	<!-- First, include the Webcam.js JavaScript Library -->
	<script type="text/javascript" src="../webcam.min.js"></script>

	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 320,
			height: 240,
			dest_width: 640,
			dest_height: 480,
			image_format: 'jpeg',
			jpeg_quality: 90,
			user_callback: function(data_uri) {
				// display results in page
				document.getElementById('results').innerHTML = 
					'<h2>Here is your large image:</h2>' + 
					'<img src="'+data_uri+'"/>';
			}
		});
		Webcam.attach( '#my_camera' );
	</script>
</body>
</html>