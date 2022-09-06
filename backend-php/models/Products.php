<?php

  class Products {

    public $id;
    public $name;
    public $description;
    public $image;
    public $quantity;
    public $category;
    public $price;
    public $users_id;

    public function imageGenerateName() {
      return bin2hex(random_bytes(60)) . ".jpg";
    }

  }

  interface ProductsDAOInterface {

    public function buildProducts($data);
    public function findAll();
    public function getLatestProducts();
    public function getProductsByCategory($category);
    public function getProductsByUserId($id);
    public function findById($id);
    public function findByName($name);
    public function create(Products $products);
    public function update(Products $products);
    public function destroy($id);

  }