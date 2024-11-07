<?php

namespace App\DesignPattern\Factory;

use App\Models\category;

interface CategoryFactoryInterface {
     public function getAddCategoryPage();
   public function createCategory(array $data): category;
    public function updateCategory(int $categoryId, array $data): category;
    public function activateCategory(int $categoryId): category;
    public function deactivateCategory(int $categoryId): category;
    public function deleteCategory(int $categoryId): void;
    public function getAllCategories();
}
