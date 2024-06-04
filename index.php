<?php

require 'vendor/autoload.php';

use Warehouse\ProductController;
use Warehouse\UserController;
use Warehouse\Product;
use Warehouse\User;
use Carbon\Carbon;

$userController = new UserController();
$productController = new ProductController();

$accessCode = readline("Enter access code: \n");

if ($userController->validateUser($accessCode)) {
    echo "Access granted\n";

    while (true) {
        $productController->showCommands();
        $input = strtolower(readline("Enter a command: \n"));

        switch ($input) {
            case 'add':
                $productController->displayProducts();
                $id = (int)readline("Enter product id: \n");
                $name = readline("Enter product name: \n");
                $units = (int)readline("Enter units: \n");
                $productController->addProduct($id, $name, $units);
                break;

            case 'update':
                $productController->displayProducts();
                $id = (int)readline("Enter product id: \n");
                $name = readline("Enter product name: \n");
                $units = (int)readline("Enter new units: \n");
                $productController->updateProduct($id, $name, $units);
                break;

            case 'list' :
                $productController->displayProducts();
                break;

            case 'withdraw':
                $id = (int)readline("Enter product id: \n");
                $units = (int)readline("Enter units to withdraw: \n");
                $productController->withdrawProduct($id, $units);
                break;

            case 'delete':
                $id = (int)readline("Enter product id: \n");
                $productController->deleteProduct($id);
                break;

            case 'exit':
                echo "Have a nice day";
                exit;

            default:
                echo "Please enter a valid command!\n";
                break;
        }
    }
} else {
    echo "Invalid access code\n";
}