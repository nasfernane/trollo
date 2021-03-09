
<!-- Page de connexion  -->
<section class="loginSection">
    <h1>Connexion</h1>

    <!-- alerte l'utilisateur en cas de données incorrectes -->
    <?= $_SESSION['wrongLogin'] === true ? '<p class="logFail">Vos identifiants sont incorrects</p>' : ''; ?>

    <!-- formulaire avec login et pw -->
    <form method="POST" class=loginForm>
        <!-- affiche une alerte en cas d'idenfifiants incorrects -->
        <?= isset($_SESSION['wrongLoging']) ? '<p>Vos identifiants sont incorrects</p>' : ''; ?>
        <div class="loginForm__field">
            <label for="loginForm__login">Votre nom</label>
            <input type="text" name="login" id="loginForm__login" autocomplete="off" placeholder="Ex: Jean-Edern"/>
        </div>

        <div class="loginForm__field">
            <label for="loginForm__pw">Votre mot de passe</label>
            <input type="password" name="pw" id="loginForm__pw" autocomplete="off" placeholder="Ex: Un mot de passe hyper secure genre 1234">
        </div>  

        <button type="submit">Se connecter</button>
    </form>
</section>   