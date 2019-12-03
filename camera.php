<html>
<head>
<style type="text/css">
#Global #bend {
    float:left;
	margin-right: 5%;
    width:55%;
}

#Global #bend2 {
    float:left;
	display: inline-block;
	overflow: scroll;
	display: block;
	height: 85%;
	margin: 1vw 0 0 0;
}
.controller{
    max-width: 300px;
    margin: auto;
    border:1px #333 solid;
    padding: 10px;
}
.video-wrap{
    max-width: 300px;
    margin: auto;
}
.canvasy{
    max-width: 300px;
    margin: auto;
}
.stickies{
    
    float:center;
    margin: auto;
}
</style>
</head>
<body>
    <br>
    <br>
<!--Stream video via webcam-->
    <div class="video-wrap">
        <video id="video" width="300" height="300" playsinline autoplay>

        </video>
    </div>
    <div class="controller">
        <button id="snap">Capture</button>
        <button id="apply100">Apply 100</button>
        <button id="applyapple">Apply Apple</button>
        <button id="applylaugh">Apply Laugh</button>
        <button id="save">Save</button>
        <!---<form  class="upload" action="upload.php" method="post" enctype="multipart/form-data">--->
        <form  class="upload" action="upload.php" method="post" enctype="multipart/form-data">Select image to upload
        <input type="file" name="fileToUpload" id="fileToUpload" required>
		<input id="form" type="submit" value="Upload Image" name="submit">
		</form>
    </div>
    
    <!-- Webcam video snapshot-->
    <div class="canvasy">
    <img src="include/stickers/1.png" alt="100" id="hundred" width=80 height=80>
    <img src="include/stickers/2.png" alt="apple" id="apple" width=80 height=80>
    <img src="include/stickers/3.png" alt="laugh" id="laugh" width=80 height=80>
    <canvas id="canvas" width="300" height="300"></canvas><div class="stickies">
    </div>
    </div>
    <script>
    'use strict';
    
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const snap = document.getElementById('snap');
    const save = document.getElementById('save');
    const apply100 = document.getElementById('apply100');
    const applylaugh = document.getElementById('applylaugh');
    const applyapple = document.getElementById('applyapple');
    const errorMsgElement = document.getElementById('spanErrorMsg');

    const constraints = {
        audio: false,
        video:{
            width:300, height: 300
        }
    };
    //Access webcam
    async function init(){
        try{
            const stream = await navigator.mediaDevices.getUserMedia(constraints);
            handleSuccess(stream);
        }
        catch(e){
            errorMsgElement.innerHTML = 'navigator.getUserMedia.error:${e.toString()}';
        }
    }
    
    // Success
    function handleSuccess(stream){
        window.stream = stream;
        video.srcObject = stream;
    }
    // Load init
    init();
    //Draw Image
    var context = canvas.getContext('2d');
    snap.addEventListener("click", function(){
        context.drawImage(video, 0, 0, 300, 300);
    });
    apply100.addEventListener('click', function() {
    context.drawImage(hundred, 10, 10);
    });

    function handleSuccess(stream){
        window.stream = stream;
        video.srcObject = stream;
    }
    // Load init
    init();
    //Draw Image
    var context = canvas.getContext('2d');
    snap.addEventListener("click", function(){
        context.drawImage(video, 0, 0, 300, 300);
    });
    applyapple.addEventListener('click', function() {
    context.drawImage(apple, 10, 10);
    });
    function handleSuccess(stream){
        window.stream = stream;
        video.srcObject = stream;
    }
    // Load init
    init();
    //Draw Image
    var context = canvas.getContext('2d');
    snap.addEventListener("click", function(){
        context.drawImage(video, 0, 0, 300, 300);
    });
    applylaugh.addEventListener('click', function() {
    context.drawImage(laugh, 10, 10);
    });
    
    
    save.addEventListener("click", function() { 
        var dataURL = canvas.toDataURL("image/png");
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            console.log(xhr.status, xhr.responseText);
            };
            xhr.open('POST', 'store.php', true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("data=" + dataURL);
            });
    </script>
    <?php// include('footer.php') ?>
</body>
</html>