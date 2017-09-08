    var modal = document.getElementById("myModal");
    var btn = document.getElementById("btn-modal");
    var modalconnexion = document.getElementById("myModalconnexion");
    var btnconnexion = document.getElementById("btn-modalconnexion");
    var modalmdp = document.getElementById("myModalmdp");
    var btnmdp = document.getElementById("btn-modalmdp");
    var modalmail = document.getElementById("myModalmail");
    var btnmail = document.getElementById("btn-modalmail");
    var modaldel = document.getElementById("myModaldel");
    var btndel = document.getElementById("btn-modaldel");
    var modalforgot = document.getElementById("myModalforgot");
    var btnforg = document.getElementById("btn-modalforgot");
    var modalvalid = document.getElementById("myModalvalid");
    
    if (btn !== null && btnconnexion !== null) {
        btn.onclick = function() {
            modal.style.display = "block";
        };
        btnconnexion.onclick = function() {
            modalconnexion.style.display = "block";
        };
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == modalconnexion) {
            modalconnexion.style.display = "none";
        }
        if (event.target == modalmdp) {
            modalmdp.style.display = "none"
        }
        if (event.target == modalmail) {
            modalmail.style.display = "none";
        }
        if (event.target == modaldel) {
            modaldel.style.display = "none";
        }
        if (event.target == modalforgot) {
            modalforgot.style.display = "none";
        }
        if (event.target == modalvalid) {
            modalvalid.style.display = "none";
        }
    };
    if (btnmdp !== null && btnmail !== null && btndel !== null) {
        btnmdp.onclick = function() {
            modalmdp.style.display = "block";
        };
        btnmail.onclick = function() {
            modalmail.style.display = "block";
        };
        btndel.onclick = function() {
            modaldel.style.display = "block";
        };
    }
    if (btnforg !== null) {
        btnforg.onclick = function() {
            modalconnexion.style.display = "none";
            modalforgot.style.display = "block";
        };
    }
    
    function inscription() {
        var chiff = document.getElementById("chiffre");
        var majuscule = document.getElementById("maj");
        var short = document.getElementById("tooshort");
        var log = document.getElementById('imhere');
        var matchmail = document. getElementById('regmail');
        matchmail.style.display = "none";
        chiff.style.display = "none";
        majuscule.style.display = "none";
        short.style.display = "none";
        log.style.display = "none";
        if (document.forms['isignup'].elements['passwd'].value.length >= 5) {
            if(document.forms['isignup'].elements['passwd'].value.match(/[A-Z]/,'g')) {
                if(document.forms['isignup'].elements['passwd'].value.match(/[1-9]/,'g')) {
                    if (document.forms['isignup'].elements['mail'].value.match(/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,'g')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "controleur/sign.php");
                        var form = new FormData();
                        form.append('signup', document.forms['isignup'].elements['signup'].value);
                        form.append('login', document.forms['isignup'].elements['login'].value);
                        form.append('mail', document.forms['isignup'].elements['mail'].value);
                        form.append('passwd', document.forms['isignup'].elements['passwd'].value);
                        xhr.send(form);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4) {
                            var ret = xhr.responseText;
                                if (ret == "erreurlog")
                                    log.style.display = "block";
                                else if (ret == "invalide")
                                    alert("Merci de bien vouloir entrer des valeurs");
                                else
                                    document.location.href="index.php";
                            }   
                        }   
                    }
                    else 
                        matchmail.style.display = "block";
                }
                else
                    chiff.style.display = "block";
            }
            else
                majuscule.style.display = "block";
        }
        else
            short.style.display = "block";
    }
    
    function connexion() {
        var pass = document.getElementById("pwd");
        var loggued = document.getElementById("log");
        loggued.style.display = "none";
        pass.style.display = "none";
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur/sign.php");
        var form = new FormData();
        form.append('signin', document.forms['isignin'].elements['signin'].value);
        form.append('login', document.forms['isignin'].elements['login'].value);
        form.append('passwd', document.forms['isignin'].elements['passwd'].value);
        xhr.send(form);
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                var ret = xhr.responseText;
                if (ret == "erreurlog") 
                    loggued.style.display = "block";
                else if (ret == "erreurmdp")
                    pass.style.display = "block";
                else if (ret == "invalide")
                    alert("Merci de bien vouloir entrer des valeurs");
                else
                    document.location.href="index.php";
            }
        }
    }
    
    function pwdupdate() {
        var loggued = document.getElementById("logg");
        var pass = document.getElementById("pass");
        var chiff = document.getElementById("chif");
        var majuscule = document.getElementById("majus");
        var short = document.getElementById("short");
        chiff.style.display = "none";
        majuscule.style.display = "none";
        short.style.display = "none";
        loggued.style.display = "none";
        pass.style.display = "none";
         if (document.forms['mdpupdate'].elements['newmdp'].value.length >= 5) {
            if(document.forms['mdpupdate'].elements['newmdp'].value.match(/[A-Z]/,'g')) {
                if(document.forms['mdpupdate'].elements['newmdp'].value.match(/[1-9]/,'g')) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "controleur/sign.php");
                    var form = new FormData();
                    form.append('mdp', document.forms['mdpupdate'].elements['mdp'].value);
                    form.append('login', document.forms['mdpupdate'].elements['login'].value);
                    form.append('oldmdp', document.forms['mdpupdate'].elements['oldmdp'].value);
                    form.append('newmdp', document.forms['mdpupdate'].elements['newmdp'].value);
                    xhr.send(form);
                    xhr.onreadystatechange = function(){
                        if (xhr.readyState == 4) {
                            var ret = xhr.responseText;
                            if (ret == "erreurlog") 
                                loggued.style.display = "block";
                            else if (ret == "erreurmdp")
                                pass.style.display = "block";
                            else {
                                modalmdp.style.display = "none";
                                modalvalid.style.display = "block";
                             }
                        }
                    }
                }
                else
                    chiff.style.display = "block";
            }
            else
                majuscule.style.display = "block";
        }
        else
            short.style.display = "block";
    }
    
    function emailupdate() {
        var loggued = document.getElementById("loggg");
        var mail = document.getElementById("email");
        var matchmail = document.getElementById("regnewmail");
        loggued.style.display = "none";
        mail.style.display = "none";
        matchmail.style.display = "none";
        if (document.forms['mailupdate'].elements['newmail'].value.match(/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,'g')) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "controleur/sign.php");
            var form = new FormData();
            form.append('mail', document.forms['mailupdate'].elements['mail'].value);
            form.append('login', document.forms['mailupdate'].elements['login'].value);
            form.append('oldmail', document.forms['mailupdate'].elements['oldmail'].value);
            form.append('newmail', document.forms['mailupdate'].elements['newmail'].value);
            xhr.send(form);
            xhr.onreadystatechange = function(){
                if (xhr.readyState == 4) {
                    var ret = xhr.responseText;
                    if (ret == "erreurlog") 
                        loggued.style.display = "block";
                    else if (ret == "erreurmail")
                        mail.style.display = "block";
                    else {
                        modalmail.style.display = "none";
                        modalvalid.style.display = "block";
                    }
                }
            }
        }
        else
            matchmail.style.display = "block";
    }
    
    function deleteaccount() {
        var loggued = document.getElementById("logued");
        var pass = document.getElementById("nopass");
        loggued.style.display = "none";
        pass.style.display = "none";
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur/sign.php");
        var form = new FormData();
        form.append('delete', document.forms['delaccount'].elements['delete'].value);
        form.append('login', document.forms['delaccount'].elements['login'].value);
        form.append('passwd', document.forms['delaccount'].elements['passwd'].value);
        xhr.send(form);
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                var ret = xhr.responseText;
                if (ret == "erreurlog")
                    loggued.style.display = "block";
                else if (ret == "erreurmdp")
                    pass.style.display = "block";
                else
                    document.location.href="index.php";
            }
        }
    }
    
     function forgotpass() {
        var loggued = document.getElementById("nologued");
        var mail = document.getElementById("noemail");
        loggued.style.display = "none";
        mail.style.display = "none";
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur/sign.php");
        var form = new FormData();
        form.append('forgot', document.forms['forgot'].elements['forgot'].value);
        form.append('login', document.forms['forgot'].elements['login'].value);
        form.append('mail', document.forms['forgot'].elements['mail'].value);
        xhr.send(form);
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                var ret = xhr.responseText;
                if (ret == "erreurlog")
                    logued.style.display = "block";
                else if (ret == "erreurmail")
                    mail.style.display = "block";
                else if (ret == "invalide")
                    alert("Merci de bien vouloir entrer des valeurs");
                else
                    document.location.href="index.php";
            }
        }
    }

    function commenter(id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur/comment.php");
        var form = new FormData();
        var formname = "commentaire"+id;
        form.append('comment', document.forms[formname].elements['comment'].value);
        form.append('commentaire', document.forms[formname].elements['commentaire'].value);
        form.append('id_img', id);
        xhr.send(form);
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                var newcom = document.createElement("div");
                newcom.className = "com";
                var usename = document.createElement('p');
                usename.textContent = xhr.responseText;
                newcom.appendChild(usename);
                var comment = document.createElement('p');
                comment.textContent = document.forms[formname].elements['commentaire'].value;
                newcom.appendChild(comment);
                var division = "commentaire"+id;
                document.getElementById(division).appendChild(newcom);
            }
        }
    }
    
    function like(id, nblike) {
        var divis = "like"+id;
        var elemt = document.getElementById(divis);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur/likes.php");
        var form = new FormData();
        classe = elemt.getElementsByClassName('dislike');
        if (classe[0] !== undefined)
            form.append('action', 'dislike')
        else 
            form.append('action', 'like');
        form.append('id', id);
        xhr.send(form);
        xhr.onreadystatechange = function(){
            if (xhr.readyState == 4) {
                var ret = xhr.responseText;
                if (ret == "like") {
                    var heart = elemt.getElementsByClassName('fa-heart');
                    heart[0].classList.add('dislike');
                    heart[0].style.color = "#fc3a3a";
                }
                else if (ret == "dislike") {
                    var heart = elemt.getElementsByClassName('dislike');
                    heart[0].style.color = "#5f5f5f";
                    heart[0].classList.remove('dislike');
                }
            }
        }
        
    }
    
    function ham() {
        var navbar = document.getElementById('menu');
        if (navbar.style.display == "none")
            navbar.style.display = "block";
        else
            navbar.style.display = "none";
    }

        window.addEventListener("scroll", function navabarfix()
            {
                var nav = document.getElementsByTagName('nav');
                if (window.scrollY > 200) {
                    nav[0].style.position = "fixed";
                }
                else if (window.scrollY == 0)
                    nav[0].style.position = "relative";

            }, false);

    
    
    
    
    