<?php

  if(empty($products->image)) {
    $products->image = "products_cover.jpg";
  }

?>
<div class="card products-card">
  <div class="card-img-top" style="background-image: url('<?= $BASE_URL ?>img/products/<?= $products->image ?>')"></div>
  <div class="card-body">
    <p class="card-rating">
      <i class="fas fa-star"></i>
      <span class="rating"><?= $products->rating ?></span>
    </p>
    <h5 class="card-title">
      <a href="<?= $BASE_URL ?>products.php?id=<?= $products->id ?>"><?= $products->name ?></a>
    </h5>
    <a href="<?= $BASE_URL ?>products.php?id=<?= $products->id ?>" class="btn btn-primary card-btn">Conhecer</a>
  </div>
</div>