<?php

  require_once("models/products.php");
  require_once("models/Message.php");

  // Review DAO
  require_once("dao/ReviewDAO.php");

  class productsDAO implements productsDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
      $this->conn = $conn;
      $this->url = $url;
      $this->message = new Message($url);
    }

    public function buildProducts($data) {

      $products = new Products();

      $products->id = $data["id"];
      $products->name = $data["name"];
      $products->description = $data["description"];
      $products->image = $data["image"];
      $products->quantity = $data["quantity"];
      $products->category = $data["category"];
      $products->price = $data["price"];
      $products->users_id = $data["users_id"];

      // Recebe as ratings do produto
      $reviewDao = new ReviewDao($this->conn, $this->url);

      $rating = $reviewDao->getRatings($products->id);

      $products->rating = $rating;

      return $products;

    }

    public function findAll() {

    }

    public function getLatestProducts() {

      $products = [];

      $stmt = $this->conn->query("SELECT * FROM products ORDER BY id DESC");

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $productsArray = $stmt->fetchAll();

        foreach($productsArray as $products) {
          $products[] = $this->buildProducts($products);
        }

      }

      return $products;

    }

    public function getProductsByCategory($category) {

      $products = [];

      $stmt = $this->conn->prepare("SELECT * FROM products
                                    WHERE category = :category
                                    ORDER BY id DESC");

      $stmt->bindParam(":category", $category);

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $productsArray = $stmt->fetchAll();

        foreach($productsArray as $products) {
          $products[] = $this->buildProducts($products);
        }

      }

      return $products;

    }

    public function getProductsByUserId($id) {

      $products = [];

      $stmt = $this->conn->prepare("SELECT * FROM products
                                    WHERE users_id = :users_id");

      $stmt->bindParam(":users_id", $id);

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $productsArray = $stmt->fetchAll();

        foreach($productsArray as $products) {
          $products[] = $this->buildProducts($products);
        }

      }

      return $products;

    }

    public function findById($id) {

      $products = [];

      $stmt = $this->conn->prepare("SELECT * FROM products
                                    WHERE id = :id");

      $stmt->bindParam(":id", $id);

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $productsData = $stmt->fetch();

        $products = $this->buildProducts($productsData);

        return $products;

      } else {

        return false;

      }

    }

    public function findByName($name) {

      $products = [];

      $stmt = $this->conn->prepare("SELECT * FROM products
                                    WHERE name LIKE :name");

      $stmt->bindValue(":name", '%'.$name.'%');

      $stmt->execute();

      if($stmt->rowCount() > 0) {

        $productsArray = $stmt->fetchAll();

        foreach($productsArray as $products) {
          $products[] = $this->buildProducts($products);
        }

      }

      return $products;

    }

    public function create(Products $products) {

      $stmt = $this->conn->prepare("INSERT INTO products (
        name, description, quantity, price, image, category, users_id
      ) VALUES (
        :name, :description, :quantity, :price, :image, :price, :users_id
      )");

      $stmt->bindParam(":name", $products->name);
      $stmt->bindParam(":description", $products->description);
      $stmt->bindParam(":quantity", $products->quantity);
      $stmt->bindParam(":price", $products->price);
      $stmt->bindParam(":image", $products->image);
      $stmt->bindParam(":category", $products->category);
      $stmt->bindParam(":users_id", $products->users_id);

      $stmt->execute();

      // Mensagem de sucesso por adicionar produto
      $this->message->setMessage("Produto adicionado com sucesso!", "success", "dashboard.php");

    }

    public function update(Products $products) {

      $stmt = $this->conn->prepare("UPDATE products SET
        name = :name,
        description = :description,
        quantity = :quantity,
        price = :price,
        image = :image,
        category = :category
        WHERE id = :id      
      ");

      $stmt->bindParam(":name", $products->name);
      $stmt->bindParam(":description", $products->description);
      $stmt->bindParam(":quantity", $products->quantity);
      $stmt->bindParam(":price", $products->price);
      $stmt->bindParam(":image", $products->image);
      $stmt->bindParam(":category", $products->category);
      $stmt->bindParam(":id", $products->id);

      $stmt->execute();

      // Mensagem de sucesso por editar produto
      $this->message->setMessage("Produto atualizado com sucesso!", "success", "dashboard.php");

    }

    public function destroy($id) {

      $stmt = $this->conn->prepare("DELETE FROM products WHERE id = :id");

      $stmt->bindParam(":id", $id);

      $stmt->execute();

      // Mensagem de sucesso por remover produto
      $this->message->setMessage("Produto removido com sucesso!", "success", "dashboard.php");

    }

  }