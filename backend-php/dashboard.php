<?php
  require_once("templates/header.php");

  // Verifica se usuário está autenticado
  require_once("models/User.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ProductsDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);
  $productsDao = new ProductsDAO($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $userProducts = $productsDao->getProductsByUserId($userData->id);

?>
  <div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos produtos que você enviou</p>
    <div class="col-md-12" id="add-products-container">
      <a href="<?= $BASE_URL ?>newproduct.php" class="btn card-btn">
        <i class="fas fa-plus"></i> Adicionar Produto
      </a>
    </div>
    <div class="col-md-12" id="products-dashboard">
      <table class="table">
        <thead>
          <th scope="col">Nome</th>
          <th scope="col">Preço</th>
          <th scope="col">Quantidade</th>
          <th scope="col" class="actions-column">Ações</th>
        </thead>
        <tbody>
          <?php foreach($userProducts as $products): ?>
          <tr>
            <td><?= $products->name ?></td>
            <td>R$ <?= $products->price ?></td>
            <td><?= $products->quantity ?></td>
            <td class="actions-column">
              <a href="<?= $BASE_URL ?>editproducts.php?id=<?= $products->id ?>" class="edit-btn">
                <i class="far fa-edit"></i> Editar
              </a>
              <form action="<?= $BASE_URL ?>products_process.php" method="POST">
                <input type="hidden" name="type" value="delete">
                <input type="hidden" name="id" value="<?= $products->id ?>">
                <button type="submit" class="delete-btn">
                  <i class="fas fa-times"></i> Deletar
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php
  require_once("templates/footer.php");
?>