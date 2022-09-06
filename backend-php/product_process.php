<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/Products.php");
  require_once("models/Message.php");
  require_once("dao/UserDAO.php");
  require_once("dao/ProductsDAO.php");

  $message = new Message($BASE_URL);
  $userDao = new UserDAO($conn, $BASE_URL);
  $productsDao = new ProductsDAO($conn, $BASE_URL);

  // Resgata o tipo do formulário
  $type = filter_input(INPUT_POST, "type");

  // Resgata dados do usuário
  $userData = $userDao->verifyToken();

  if($type === "create") {

    // Receber os dados dos inputs
    $name = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "description");
    $quantity = filter_input(INPUT_POST, "quantity");
    $category = filter_input(INPUT_POST, "category");
    $price = filter_input(INPUT_POST, "price");

    $products = new Products();

    // Validação mínima de dados
    if(!empty($name) && !empty($price) && !empty($description) && !empty($category)) {

      $products->name = $name;
      $products->description = $description;
      $products->quantity = $quantity;
      $products->category = $category;
      $products->price = $price;
      $products->users_id = $userData->id;

      // Upload de imagem do produto
      if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        // Checando tipo da imagem
        if(in_array($image["type"], $imageTypes)) {

          // Checa se imagem é jpg
          if(in_array($image["type"], $jpgArray)) {
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
          } else {
            $imageFile = imagecreatefrompng($image["tmp_name"]);
          }

          // Gerando o nome da imagem
          $imageName = $products->imageGenerateName();

          imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

          $products->image = $imageName;

        } else {

          $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

        }

      }

      $productsDao->create($products);

    } else {

      $message->setMessage("Você precisa adicionar pelo menos: nome, preço, descrição e categoria!", "error", "back");

    }

  } else if($type === "delete") {

    // Recebe os dados do form
    $id = filter_input(INPUT_POST, "id");

    $products = $productsDao->findById($id);

    if($products) {

      // Verificar se o produto é do usuário
      if($products->users_id === $userData->id) {

        $productsDao->destroy($products->id);

      } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

      }

    } else {

      $message->setMessage("Informações inválidas!", "error", "index.php");

    }

  } else if($type === "update") { 

    // Receber os dados dos inputs
    $name = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "description");
    $quantity = filter_input(INPUT_POST, "quantity");
    $category = filter_input(INPUT_POST, "category");
    $price = filter_input(INPUT_POST, "price");
    $id = filter_input(INPUT_POST, "id");

    $productsData = $productsDao->findById($id);

    // Verifica se encontrou o produto
    if($productsData) {

      // Verificar se o produto é do usuário
      if($productsData->users_id === $userData->id) {

        // Validação mínima de dados
        if(!empty($name) && !empty($price) && !empty($description) && !empty($category)) {

          // Edição do produto
          $productsData->name = $name;
          $productsData->description = $description;
          $productsData->quantity = $quantity;
          $productsData->category = $category;
          $productsData->price = $price;

          // Upload de imagem do produto
          if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            // Checando tipo da imagem
            if(in_array($image["type"], $imageTypes)) {

              // Checa se imagem é jpg
              if(in_array($image["type"], $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
              } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
              }

              // Gerando o nome da imagem
              $products = new Products();

              $imageName = $product->imageGenerateName();

              imagejpeg($imageFile, "./img/products/" . $imageName, 100);

              $productsData->image = $imageName;

            } else {

              $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");

            }

          }

          $productsDao->update($productsData);

        } else {

          $message->setMessage("Você precisa adicionar pelo menos: nome, preço, descrição e categoria!", "error", "back");

        }

      } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

      }

    } else {

      $message->setMessage("Informações inválidas!", "error", "index.php");

    }
  
  } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

  }