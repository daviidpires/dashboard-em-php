<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/User.php");
  require_once("dao/UserDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

?>
  <div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-product-container">
      <h1 class="page-title">Adicionar Produto</h1>
      <p class="page-description">Adicione seu produto!</p>
      <form action="<?= $BASE_URL ?>product_process.php" id="add-products-form" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="type" value="create">
        <div class="form-group">
          <label for="title">Nome:</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Digite o nome do seu produto">
        </div>
        <div class="form-group">
          <label for="image">Imagem:</label>
          <input type="file" class="form-control-file" name="image" id="image">
        </div>
        <div class="form-group">
          <label for="price">Preço:</label>
          <input type="text" class="form-control" id="price" name="price" placeholder="Digite o preço do produto">
        </div>
        <div class="form-group">
          <label for="category">Category:</label>
          <select name="category" id="category" class="form-control">
            <option value="">Selecione</option>
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outros">Outros</option>
            <option value="Acessórios">Acessórios</option>
          </select>
        </div>
        <div class="form-group">
          <label for="quantity">Quantidade:</label>
          <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Insira a quantidade de produtos em estoque">
        </div>
        <div class="form-group">
          <label for="description">Descrição:</label>
          <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o produto..."></textarea>
        </div>
        <input type="submit" class="btn card-btn" value="Adicionar produto">
      </form>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>