<div class="card mb-3">
    <div class="card-body">
        <!-- ne pas mettre de html -->
        <h5 class="card-title"><?= htmlentities($post->getName()) ?></h5>
        <!-- on affiche la date et on la formate -->
        <p class="text-muted"><?= $post->getCreatedAt()->format('d F Y') ?></p>
        <!-- pour repecter les sauts de lignes (nl2br) -->
        <p><?= $post->getExcerpt() ?></p>
        <p>
            <a href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>" class="btn btn-primary"> Voir plus </a>
        </p>
    </div>
</div>