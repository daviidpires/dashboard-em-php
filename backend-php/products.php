<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/Products.php");
  require_once("dao/ProductsDAO.php");
  require_once("dao/ReviewDAO.php");

  // Pegar o id do produto
  $id = filter_input(INPUT_GET, "id");

  $products;

  $productsDao = new ProductsDAO($conn, $BASE_URL);

  $reviewDao = new ReviewDAO($conn, $BASE_URL);

  if(empty($id)) {

    $message->setMessage("O produto não foi encontrado!", "error", "dashboard.php");

  } else {

    $products = $productsDao->findById($id);

    // Verifica se o produto existe
    if(!$products) {

      $message->setMessage("O produto não foi encontrado!", "error", "dashboard.php");

    }

  }

  // Checar se o produto tem imagem
  if($products->image == "") {
    $products->image = "products_cover.jpg";
  }

  // Checar se o produto é do usuário
  $userOwnsProducts = false;

  if(!empty($userData)) {

    if($userData->id === $products->users_id) {
      $userOwnsProducts = true;
    }

    // Resgatar os comentários dos produtos
    $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
 
  }

  // Resgatar os comentários dos produtos
  $productsReviews = $reviewDao->getProductsReview($products->id);

?>
<div id="main-container" class="container-fluid">
  <div class="row">
    <div class="offset-md-1 col-md-6 products-container">
      <h1 class="page-title"><?= $products->name ?></h1>
      <p class="products-details">
        <span>Preço: <?= $products->price ?></span>
        <span class="pipe"></span>
        <span><?= $products->category ?></span>
        <span class="pipe"></span>
        <span><i class="fas fa-star"></i> <?= $products->rating ?></span>
      </p>
      <iframe src="<?= $products->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      <p><?= $products->description ?></p>
    </div>
    <div class="col-md-4">
      <div class="products-image-container" style="background-image: url('<?= $BASE_URL ?>img/products/<?= $products->image ?>')"></div>
    </div>
    <div class="offset-md-1 col-md-10" id="reviews-container">
      <h3 id="reviews-products">Avaliações:</h3>
      <!-- Verifica se habilita a review para o usuário ou não -->
      <?php if(!empty($userData) && !$userOwnsProducts && !$alreadyReviewed): ?>
      <div class="col-md-12" id="review-form-container">
        <h4>Envie seu comentário:</h4>
        <p class="page-description">Preencha o formulário com a nota e comentário sobre o produto</p>
        <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
          <input type="hidden" name="type" value="create">
          <input type="hidden" name="products_id" value="<?= $products->id ?>">
          <div class="form-group">
            <label for="rating">Nota do produto:</label>
            <select name="rating" id="rating" class="form-control">
              <option value="">Selecione</option>
              <option value="10">10</option>
              <option value="9">9</option>
              <option value="8">8</option>
              <option value="7">7</option>
              <option value="6">6</option>
              <option value="5">5</option>
              <option value="4">4</option>
              <option value="3">3</option>
              <option value="2">2</option>
              <option value="1">1</option>
            </select>
          </div>
          <div class="form-group">
            <label for="review">Seu comentário:</label>
            <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou do produto?"></textarea>
          </div>
          <input type="submit" class="btn card-btn" value="Enviar comentário">
        </form>
      </div>
      <?php endif; ?>
      <!-- Comentários -->
      <?php foreach($productsReviews as $review): ?>
        <?php require("templates/user_review.php"); ?>
      <?php endforeach; ?>
      <?php if(count($productsReviews) == 0): ?>
        <p class="empty-list">Não há comentários para este produto ainda...</p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
  require_once("templates/footer.php");
?>