<?php

  require_once("templates/header.php");

  // Checa autenticação
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ProductsDAO.php");

  $userModel = new User();

  // Verifica o token, se não for o correto redireciona para a home
  $auth = new UserDAO($conn, $BASE_URL);

  $userData = $auth->verifyToken();

  $productsDao = new ProductsDAO($conn, $BASE_URL);

  $id = filter_input(INPUT_GET, "id");

  $products = $productsDao->findById($id);

?>
<div id="main-container" class="container-fluid">
  <div class="col-md-12">
    <div class="row"> 
      <div class="col-md-6 offset-md-1">
        <h1><?= $products->name ?></h1>
        <p class="page-description">Altere os dados do produto abaixo:</p>
        <form id="add-products-form" action="<?= $BASE_URL ?>product_process.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="type" value="update">
          <input type="hidden" name="id" value="<?= $products->id ?>">
          <div class="form-group">
              <label for="name">Nome:</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do produto" value="<?= $products->name ?>">
          </div>
          <div class="form-group">
              <label for="image">Imagem:</label>
              <input type="file" name="image" class="form-control-file">
          </div>
          <div class="form-group">
              <label for="price">Preço:</label>
              <input type="text" class="form-control" id="price" name="price" placeholder="Digite o preço do produto" value="<?= $products->price ?>">
          </div>
          <div class="form-group">
              <label for="category">Categoria do produto:</label>
              <select class="form-control" name="category" id="cateogry">
                  <option value="">Selecione</option>
                  <option value="Cachorro" <?= $products->category === "Cachorro" ? "selected" : "" ?>>Cachorro</option>
                  <option value="Gato" <?= $products->category === "Gato" ? "selected" : "" ?>>Gato</option>
                  <option value="Outros" <?= $products->category === "Outros" ? "selected" : "" ?>>Outros</option>
                  <option value="Acessórios" <?= $products->category === "Acessórios" ? "selected" : "" ?>>Acessórios</option>
              </select>
          </div>
          <div class="form-group">
              <label for="quantity">Quantidade:</label>
              <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Insira a quantidade de produtos em estoque" value="<?= $products->quantity ?>">
          </div>
          <div class="form-group">
              <label for="description">Descrição:</label>
              <textarea class="form-control" name="description" id="description" rows="5"><?= $products->description ?></textarea>
          </div>
          <input type="submit" class="btn card-btn" value="Alterar produto">
        </form>
      </div>
      <div class="col-md-3">
        <?php if(!empty($products->image)): ?>
          <div class="products-image-container" style="background-image: url('<?= $BASE_URL ?>img/products/<?= $products->image ?>')"></div>
        <?php else: ?>
          <p>Este produto não possui foto ainda!</p>
        <?php endif; ?>
      </div>    
    </div>   
  </div>
</div>
<?php

  require_once("templates/footer.php");

?>