	var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var videoStream = null;
    var preLog = document.getElementById('preLog');
    var i = 0;
    var bool = 1;

    window.addEventListener("scroll", function navabarfix()
            {
                if (window.scrollY >= 400) {
                    var nav = document.getElementsByTagName('nav');
                    nav[0].style.position = "fixed";
                }
            }, false);


    function log(text)
    {
	    if (preLog) preLog.textContent += ('\n' + text);
    	else alert(text);
    }

	function draw() {
		canvas.width = video.videoWidth;
    	canvas.height = video.videoHeight;
    	canvas.getContext('2d').drawImage(video, 0, 0);
	}
	
	function affichercanvas() {
		var fileInput = document.getElementById("file");
		var ctx = canvas.getContext('2d');
		var file = document.querySelector('input[type=file]').files[0];
    	var fr = new FileReader();
    	fr.addEventListener("load", function(){
            var img = new Image();
    		img.src = fr.result;
            img.addEventListener("load", function (){
        		canvas.width = 640;
    			canvas.height = 480;
    			ctx.drawImage(img, 0, 0, 640, 480);
    	   		canvas.style.display = "block";
            });
    	}, false);
    	if (file) {
    		fr.readAsDataURL(file);
            bool = 0;
    	}
	}

	function takeasnap(id) {
		var myButton = document.getElementById('buttonSnap');
	    if (myButton.disabled === false) {
	        var i = 1;
	        while (i <= 5) {
	            image = document.getElementById(i);
	            if (image.classList.contains("active"))
	                image.classList.remove("active");
	            i++;
	        }
	    }
	    if (myButton) {
	        myButton.disabled = false;
	    }
	    var myImage = document.getElementById(id);
	    myImage.classList.add("active");
	}
	
    function snapshot()
    {
        var filter = document.getElementsByClassName("active");
        var id_filter = filter[0].getAttribute("id");
    	if (bool == 1) {
    		draw();
        }
    	var imageData = canvas.toDataURL("image/png");
    	var xhr = new XMLHttpRequest();
    	xhr.open("POST", "controleur/image.php");
        var form = new FormData();
    	form.append('param1', imageData);
    	form.append('param2', id_filter);
    	xhr.send(form);
    	xhr.onreadystatechange = function(){
    		if (xhr.readyState == 4) {
    			var ret = xhr.responseText;
    			imag = document.createElement("img");
    			imag.setAttribute('src', ret);
    			imgs = document.getElementById('photonload');
    			imgs.insertBefore(imag, imgs.firstChild);;
    			document.getElementById('photonload').style.display = "block";
    		}
    	}
    	
    }
    function noStream()
    {
    	video.style.display = "none";
    	log('L’accès à la caméra a été refusé ! Mais vous pouvez uploader une image !');
    }

    function gotStream(stream)
    {
	    videoStream = stream;
    	log('Flux vidéo reçu.');
    	video.onerror = function ()
    	{
	    	log('video.onerror');
	    	if (video) stop();
    	};
    	stream.onended = noStream;
    	if (window.URL)video.src = window.URL.createObjectURL(stream);
    	else if (video.mozSrcObject !== undefined)
    	{
    		video.mozSrcObject = stream;
    		video.play();
    	}
    	else if (navigator.mozGetUserMedia)
    	{
    		video.src = stream;
    		video.play();
    	}
    	else if (window.URL) video.src = window.URL.createObjectURL(stream);
    	else video.src = stream;
    }

    function start()
    {
    	if ((typeof window === 'undefined') || (typeof navigator === 'undefined')) log('Cette page requiert un navigateur Web avec les objets window.* et navigator.* !');
	    else if (!(video && canvas)) log('Erreur de contexte HTML !');
    	else
    	{
	    	log('Demande d’accès au flux vidéo…');
	    	if (navigator.getUserMedia) navigator.getUserMedia({video:true}, gotStream, noStream);
	    	else if (navigator.oGetUserMedia) navigator.oGetUserMedia({video:true}, gotStream, noStream);
	    	else if (navigator.mozGetUserMedia) navigator.mozGetUserMedia({video:true}, gotStream, noStream);
	    	else if (navigator.webkitGetUserMedia) navigator.webkitGetUserMedia({video:true}, gotStream, noStream);
	    	else if (navigator.msGetUserMedia) navigator.msGetUserMedia({video:true, audio:false}, gotStream, noStream);
	    	else log('getUserMedia() n’est pas disponible depuis votre navigateur !');
    	}
    }
    if (window.location.href.indexOf("galerie") == -1)
        start();

    if (window.location.href.indexOf("galerie") > -1) {
        function afficher3() {
            var i = 0;
            var aloaders = document.getElementsByClassName('aloader');
            while (i < aloaders.length) { 
                if (i >= 3)
                    aloaders[i].style.display ="none";
                i++;
            }
        }
        afficher3();
    
        window.addEventListener("scroll", function scroller()
             {
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                    i = i + 3;
                    var j = i;
                    var aloaders = document.getElementsByClassName('aloader');
                    while (j < i + 3 && aloaders[j] !== undefined) {
                        aloaders[j].style.display = "block";
                        j++;
                    }
                }
        }, false);
    }
    