<div class="todoContainer">
    <?php if (!isset($_SESSION['userid'])) header('location: /?page=login') ?>
    <?= displayList('home', $tododb) ?>
    <?= displayList('work', $tododb) ?>
    <?= displayList('event', $tododb) ?>
</div>                
        
