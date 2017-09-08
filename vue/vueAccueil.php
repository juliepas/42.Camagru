<!DOCTYPE html>
<html>
    <body>
        <!----- Accueil ----->
        <?php if ($_SESSION['loggued_on_user'] == NULL && $_GET['action'] != "galerie" && $_GET['action'] != "afficher"): ?>
            <section id="presentation">
                <h1>Présentation</h1>
                <div class="text">
                    <p>L’histoire de la communication est aussi ancienne que l’histoire de l’humanité, et l’homme a su 
                    la faire évoluer au fil des siècles au travers d’incroyables révolutions.</p>
                    <p>En 1794, Claude Chappe se pencha sur la problématique de la communication entre
                    de longues distances, qui était à l’époque limitée à la vitesse du cheval au galop. Il mit au 
                    point un ingénieux système de communication de télégraphe aérien pendant la Révolution.
                    Les “tours de Chappe” étaient coiffées d’un mât mobile, visible à la jumelle de la tour
                    voisine, distante de 10 km à 15 km.</p>
                    <p>La ligne Paris-Lille fut ainsi opérationnelle dès 1794 et permit par exemple de transmettre 
                    des messages entre ces deux villes avec une durée de neuf minutes pour transmettre 
                    une lettre via une quinzaine de tours ; le temps de transmission d’un message dépendait 
                    de sa longueur.</p>
                    <p>Les gros inconvénients du système étaient qu’il ne pouvait fonctionner ni la nuit ni par 
                    mauvaise visibilité et qu’il mobilisait beaucoup d’opérateurs (deux tous les 15 kilomètres 
                    environ).</p>
                    <br>
                    <h3>Heureusement, nous sommes en 2017.</h3>
                    <h3>Heureusement, ce site n'a rien à voir avec Claude Chappe</h3>
                </div>
                <div class="image">
                    <img src="http://telegraphe-chappe.com/chappe/images/clchap.gif"></img>
                </div>
            </section>
        
        <!----- Galerie ----->
        <?php elseif ($_GET['action'] == "galerie"): ?>
    <section id="galerie">
              <?php 
                $i = 0;
                    $images = afficherallimages();
                    foreach($images as $value) {
                        $i++;
                        $commentaires = nbcomments($value['id']);
                        $likes = nblikes($value['id']);
                        $commentaires = findcomments($value['id']);
                        $user = usersinfos($_SESSION['loggued_on_user']);
                        if (!isset($likes[0][0]))
                            $likes[0][0] = 0;
                        echo "<div id=\"aloader".$i."\" class=\"aloader\">\n";
                        echo "  <div class=\"actualite\">\n";
                        echo "  <h3>".$value['name_user']."</h3>\n";
                        if ($value['name_user'] == $_SESSION['loggued_on_user'])
                            echo "  <a href=\"controleur/image.php?action=supprimer&id=".$value['id']."\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></a>\n";
                        echo "  <img src=\"".$value['url_image']."\"></img>\n";
                        echo "  <p class=\"date\">".$value['creation_date']."</p>\n";
                        echo "  <div id=\"like".$value['id']."\">\n";
                        if ($_SESSION['loggued_on_user'] != null && wholikeswhat($value['id'], $user[0]['id']) === false) {
                            echo "       <a href=# onclick=\"like(".$value['id'].")\"><i class=\"fa fa-heart\" aria-hidden=\"true\"></i></a>\n";
                        }
                        elseif ($_SESSION['loggued_on_user'] != null && wholikeswhat($value['id'], $user[0]['id']) === true) {
                             echo "      <a href=# onclick=\"like(".$value['id'].")\"><i class=\"fa fa-heart dislike\" aria-hidden=\"true\"></i></a>\n";
                        }
                        echo "  </div>\n";
                        echo "  <div id=\"commentaire".$value['id']."\">\n";
                        if (isset($commentaires)) {
                            foreach ($commentaires as $values) {
                                echo "      <div class=\"com\">\n";
                                echo "          <p>".htmlentities($values['user_name'])."</p>\n";
                                echo "          <p>".htmlentities($values['commentaire'])."</p>\n";
                                echo "      </div>\n";
                            }
                        }
                        echo "  </div>\n";
                        echo "<hr></hr>\n";
                        if ($_SESSION['loggued_on_user'] != null) {
                            echo "  <div class=\"commentaires\">\n";
                            echo "      <form name=\"commentaire".$value[id]."\">\n";
                            echo "          <textarea id=\"commentaire\" type=\"text\" placeholder=\"Ajouter un commentaire...\">\n</textarea>";
                            echo "           <input class=\"btn-m\" type=\"button\" id=\"comment\" value=\"comment\" onclick=\"commenter(".$value['id'].")\"/>\n";
                            echo "      </form>\n";
                            echo "  </div>\n";
                        }
                        echo "  </div>\n";
                        echo "</div>\n";
                    }
                ?>
            </section>
        
        <?php elseif ($_GET['action'] == "moncompte"): ?>
            <section id="moncompte">
                <?php
                    $mesimages = lastimages($_SESSION['loggued_on_user']);
                    $user = usersinfos($_SESSION['loggued_on_user']);
                    $pictures = nbpictures($_SESSION['loggued_on_user']);
                    if (isset($user)) {
                        echo "  <div class=\"img_profile\">";
                        echo "      <img src=\"".$mesimages[0]['url_image']."\">";
                        echo "  </div>";    
                        echo "  <div class=\"infos\">";
                        echo "      <h2>".$_SESSION['loggued_on_user']."</h2>";
                        echo "      <h5>".$user[0]['mail']."</h5>";
                        echo "      <p>".$pictures[0][0]." publications</p>";
                        echo "      <p id=\"btn-modalmail\">Modifier mon mail</p>";
                        echo "      <p id=\"btn-modalmdp\">Modifier mon mot de passe</p>";
                        echo "      <p id=\"btn-modaldel\">Supprimer mon compte</p>";
                        echo "  </div>";
                    }
                    else {
                        unset($_SESSION['loggued_on_user']);
                        header("location: index.php");
                    }
                ?>
                <hr></hr>
            </section>
            <section id="imagesuser">
                <?php
                    foreach ($mesimages as $value) {
                        $commentaires = nbcomments($value['id']);
                        $likes = nblikes($value['id']);
                        echo "<div class=\"publication\">";
                        echo "      <h3>".$value['name_user']."</h3>";
                        echo "      <div class=\"social\">";
                        echo "      <i class=\"fa fa-comment\" aria-hidden=\"true\"></i>";
                        echo "      <i class=\"fa fa-heart\" aria-hidden=\"true\"></i>";
                        if ($commentaires[0] != NULL)
                            echo "          <h4>".$commentaires[0][0]."</h4>";
                        else
                            echo "          <h4>0</h4>";
                        if ($likes[0] != NULL)
                            echo "          <h4>".$likes[0][0]."</h4>";
                        else
                            echo "          <h4>0</h4>";
                        echo "      </div>";
                        echo "      <img src=\"".$value['url_image']."\"></img>";
                        echo "      <p>".$value['creation_date']."</p>";
                        echo "</div>";
                    }
                ?>
            </section>
        
        <!----- Accueil Users loggued----->
        <?php else: ?>
            <section id="stream">
                <div class="takepicture">
                    <div class="webcam">
                        <p><video id="video" autoplay="autoplay"></video></p>
                        
                        <p><canvas id="canvas"></canvas></p>
                    </div>
                    <div class="upload">
                        <form name="upload">
                            <input type="hidden" name="MAX_FILE_SIZE" value="100000">
                            <input id="file" type="file" name="file" onchange="affichercanvas()">
                        </form>
                    </div>
                    <div class="status">
                        <pre id="preLog">Chargement…</pre>
                    </div>
                    <div class="gestion">
                        <div class="filters">
                            <?php
                            $filters = getfilters();
                            foreach ($filters as $value) {
                                echo "      <img src=\"".$value['url_filter']."\" id=\"".$value['id']."\" onclick=\"takeasnap(".$value['id'].")\" class=\"\"/>";
                            }
                            ?>
                            <p><input type="button" class="btn-m btn-picture" id="buttonSnap" value="Prendre une photo" disabled="disabled" onclick="snapshot()"/></p>
                        </div>
                    </div>
                </div>
            </section>
            <section id="lastpictures">
                <div id="photonload"/>
                </div>
                <div id="photos">
                <?php
                    $images = lastimages($_SESSION['loggued_on_user']);
                    foreach ($images as $values) {
                        echo "<img src=\"".$values['url_image']."\"/>";
                    }
                ?>
                </div>
            </section>
        <?php endif; ?>
        
        <!----- Modal inscription ----->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Inscription</h1>
                </div>
                <div class="modal-body">
                    <form name="isignup">
                        <label for="login">Login</label>
                        <input id="login" type="text" name="login"/>
                        <label for="mail">E-mail</label>
                        <input id="mail" type="email" name="mail"/>
                        <label for="passwd">Mot de passe</label>
                        <input id="passwd" type="password" name="passwd"/>
                        <input class="btn-m" type="button" id="signup" value="signup" onclick="inscription()"/>
                    </form>
                    <p id="tooshort">Le mot de passe doit contenir plus de 5 caractères</p>
                    <p id="maj">Le mot de passe doit contenir au moins une majuscule</p>
                    <p id="chiffre">Le mot de passe doit contenir au moins un chiffre</p>
                    <p id="imhere">Vous êtes deja membre du site</p>
                    <p id="regmail">Merci d'insérer un mail valide</p>
                </div>
            </div>
        </div>
        
        <!----- Modal Connexion ----->
        <div id="myModalconnexion" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Connexion</h1>
                </div>
                <div class="modal-body">
                    <form name="isignin">
                        <label for="login">Login</label>
                        <input id="login" type="text" name="login"/>
                        <label for="passwd">Mot de passe</label>
                        <input id="passwd" type="password" name="passwd"/>
                        <input class="btn-m" type="button" id="signin" value="signin" onclick="connexion()"/>
                    </form>
                    <a href="#" id="btn-modalforgot">Mot de passe oublié ?</a>
                    <p id="log">Aucun utilisateur connu pour ce login</p>
                    <p id="pwd">Le mot de passe fourni ne correspond pas</p>
                </div>
            </div>
        </div>
        
        <!----- Modal MDP ----->
        <div id="myModalmdp" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Modifier mon mot de passe</h1>
                </div>
                <div class="modal-body">
                    <form name="mdpupdate">
                        <label for="login">Login</label>
                        <input id="login" type="text" name="login"/>
                        <label for="oldmdp">Ancien mot de passe</label>
                        <input id="oldmdp" type="password" name="oldmdp"/>
                        <label for="newmdp">Nouveau mot de passe</label>
                        <input id="newmdp" type="password" name="newmdp"/>
                        <input class="btn-m" type="button" id="mdp" value="mdp" onclick="pwdupdate()"/>
                    </form>
                    <p id="logg">Aucun utilisateur connu pour ce login</p>
                    <p id="pass">Le mot de passe fourni ne correspond pas</p>
                    <p id="short">Le mot de passe doit contenir plus de 5 caractères</p>
                    <p id="majus">Le mot de passe doit contenir au moins une majuscule</p>
                    <p id="chif">Le mot de passe doit contenir au moins un chiffre</p>
                </div>
            </div>
        </div>
        
         <!----- Modal MAIL ----->
        <div id="myModalmail" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Modifier mon mail</h1>
                </div>
                <div class="modal-body">
                    <form name="mailupdate">
                        <label for="login">Login</label>
                        <input id="login" type="text" name="login"/>
                        <label for="oldmail">Ancien mail</label>
                        <input id="oldmail" type="email" name="oldmail"/>
                        <label for="newmail">Nouveau mail</label>
                        <input id="newmail" type="email" name="newmail"/>
                        <input class="btn-m" type="button" id="mail" value="mail" onclick="emailupdate()"/>
                    </form>
                    <p id="loggg">Aucun utilisateur connu pour ce login</p>
                    <p id="email">Le mail fourni ne correspond pas</p>
                    <p id="regnewmail">Merci d'insérer un nouveau mail valide</p>
                </div>
            </div>
        </div>
        
        <!----- Modal DEL ----->
        <div id="myModaldel" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Supprimer mon compte</h1>
                </div>
                <div class="modal-body">
                    <form name="delaccount">
                        <label for="login">Login</label>
                        <input id="login" type="text" name="login"/>
                        <label for="passwd">Mot de passe</label>
                        <input id="passwd" type="password" name="passwd"/>
                        <input class="btn-m" type="button" id="delete"  value="delete" onclick="deleteaccount()">
                    </form>
                    <p id="logued">Aucun utilisateur connu pour ce login</p>
                   <p id="nopass">Le mot de passe fourni ne correspond pas</p>
                </div>
            </div>
        </div>
        
        <!----- Modal OUBLI ----->
            <div id="myModalforgot" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Mot de passe oublié</h1>
                    </div>
                    <div class="modal-body">
                        <form name="forgot">
                            <label for="login">Login</label>
                            <input id="login" type="text" name="login"/>
                            <label for="mail">Mail</label>
                            <input id="mail" type="email" name="mail"/>
                            <input class="btn-m" type="button" id="forgot" value="forgot" onclick="forgotpass()"/>
                        </form>
                        <p id="nologued">Aucun utilisateur connu pour ce login</p>
                       <p id="noemail">Le mail fourni ne correspond pas</p>
                    </div>
                </div>
            </div>

        <!----- Modal VALIDATION ----->
            <div id="myModalvalid" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Félicitations</h1>
                    </div>
                    <div class="modal-body">
                        <p>Vos éléments ont bien été mis à jour</p>
                    </div>
                </div>
            </div>

    </body>
</html>
