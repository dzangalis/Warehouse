<?php

namespace Warehouse;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;

class ProductController
{
    private array $products = [];
    private string $productsFile = 'products.json';

    public function __construct()
    {
        $this->loadProducts();
    }

    private function loadProducts(): void
    {
        $productsData = file_get_contents($this->productsFile);
        $this->products = json_decode($productsData, true)['products'] ?? [];
    }

    private function saveProducts(): void
    {
        $data = ['products' => $this->products];
        file_put_contents($this->productsFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addProduct(int $id, string $name, int $units): void
    {
        $creationTime = Carbon::now()->toDateTimeString();
        $updateTime = $creationTime;
        $this->products[] = ['id' => $id, 'name' => $name, 'units' => $units, 'creationTime' => $creationTime, 'updateTime' => $updateTime];
        $this->saveProducts();
    }


    public function updateProduct(int $id, string $name, int $units): void
    {
        $updateTime = Carbon::now()->toDateTimeString();
        foreach ($this->products as &$product) {
            if ($product['id'] === $id) {
                $product['name'] = $name;
                $product['units'] = $units;
                $product['updateTime'] = $updateTime;
                $this->saveProducts();
            }
        }
        echo "Product with ID $id not found.\n";
    }

    public function withdrawProduct($id, $units)
    {
        foreach ($this->products as &$product) {
            if ($product['id'] === $id) {
                if ($product['units'] >= $units) {
                    $product['units'] -= $units;
                    $updateTime = Carbon::now()->toDateTimeString();
                    $product['updateTime'] = $updateTime;
                    $this->saveProducts();
                    echo "$units units withdrawn from product with ID $id.\n";
                } else {
                    echo "Not enough units available for withdrawal.\n";
                }
                return;
            }
        }
        echo "Product with ID $id not found.\n";
    }

    public function deleteProduct($id)
    {
        foreach ($this->products as $key => $product) {
            if ($product['id'] === $id) {
                unset($this->products[$key]);
                $this->saveProducts();
                return;
            }
        }
        echo "Product with ID $id not found.\n";
    }

    public function displayProducts()
    {
        if (empty($this->products)) {
            echo "No products available.\n";
        } else {
            $output = new ConsoleOutput();
            $table = new Table($output);
            $table->setHeaders(['ID', 'Name', 'Units', 'Created At', 'Last Updated']);

            foreach ($this->products as $product) {
                $creationTime = date('Y-m-d H:i:s', strtotime($product['creationTime']));
                $updateTime = date('Y-m-d H:i:s', strtotime($product['updateTime']));
                $table->addRow([$product['id'], $product['name'], $product['units'], $creationTime, $updateTime]);
            }

            $table->render();
        }
    }

    public function showCommands()
    {
        $output = new ConsoleOutput();
        $table = new Table($output);
        $table
            ->setHeaders(['Command', 'Description'])
            ->setRows([
                ['Add', 'Add a new item for the user'],
                ['List', 'List all items by the user'],
                ['Update', 'Update the name and amount from a users item'],
                ['Withdraw', 'Withdraw amount from an item'],
                ['Delete', 'Delete a TODO'],
                ['Exit', 'Exit the application']
            ]);

        $table->render();
    }
}