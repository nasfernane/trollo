<!-- page de création de nouveau compte utilisateur -->
<section class="signUpSection">
    <h1>Inscription</h1>

    <!-- alerte l'utilisateur si ses mots de passe ne correspondent pas -->
    <?= $_SESSION['wrongPwCreate'] === true ? 'Vos mots de passe ne correspondent pas' : ''; ?>

    <!-- formulaire avec login, mot de passe et confirmation de mot de passe -->
    <form method="POST" class=signUpForm>
        <div class="signUpForm__field">
            <label for="signUpForm__login">Votre nom</label>
            <input type="text" name="newlogin" id="signUpForm__login" autocomplete="off" placeholder="Ex: Jean-Edern"/>
        </div>

        <div class="signUpForm__field">
            <label for="signUpForm__pw">Votre mot de passe</label>
            <input type="password" name="newpw" id="signUpForm__pw" autocomplete="off" placeholder="Ex: le nom de votre Teckel">
        </div>

        <div class="signUpForm__field">
            <label for="signUpForm__pwConfirm">Confirmation mot de passe</label>
            <input type="password" name="newpwconfirm" id="signUpForm__pwConfirm" autocomplete="off" placeholder="Ex: A priori votre teckel a toujours le même nom">
        </div>     

        <button type="submit">Créer votre compte </button>
      
    </form>
</section>                        
        