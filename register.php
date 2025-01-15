<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Registration</title>
    <script src="face-api.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        nav {
            background-color:#082d54;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        form {
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background:#082d54;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background:#082d54;
        }

        .info {
            margin-top: 20px;
        }

    </style>
</head>

<body>
    <nav>
        <div class="logo">Face Registration</div>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Welcome to Face Registration</h1>
       
        <form action="save_user.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="username">email:</label>
            <input type="text" id="username" name="email" required>


            <label for="username">Phone number</label>
            <input type="text" id="username" name="number" required>

            <label for="image">Upload Face Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <input type="hidden" id="faceDescriptor" name="faceDescriptor">

            <button type="button" id="captureFace" onclick="captureDescriptor()">Capture Face Descriptor</button>
            <button type="submit">Register</button>
        </form>

       
    </div>

    <script>
        async function captureDescriptor() {
         
            console.log("loading.");
            await faceapi.nets.ssdMobilenetv1.loadFromUri('models');
            await faceapi.nets.faceRecognitionNet.loadFromUri('models');
            await faceapi.nets.faceLandmark68Net.loadFromUri('models');
            console.log("models loaded");

          
            const imageInput = document.getElementById('image');
            const file = imageInput.files[0];
            if (!file) {
                alert('Please upload an image.');
                return;
            }

            const img = await faceapi.bufferToImage(file);

           
            const detections = await faceapi.detectSingleFace(img)
                .withFaceLandmarks()
                .withFaceDescriptor();

            if (detections) {
              
                const descriptor = detections.descriptor;
                document.getElementById('faceDescriptor').value = JSON.stringify(descriptor);
                console.log("Face descriptor captured:", descriptor);
                alert('Face descriptor captured successfully!');
            } else {
                alert('No face detected in the image. Please try again with a different image.');
            }
        }
    </script>
</body>

</html>
