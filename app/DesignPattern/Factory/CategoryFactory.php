<?php


namespace App\DesignPattern\Factory;

use App\Models\category;


class CategoryFactory implements CategoryFactoryInterface
{
    
       public function getAddCategoryPage()
    {
        return view('BackEnd.category.addCategory');
    }
    

    
    public function createCategory(array $data): category
    {
        $category = new category($data);
        $category->save();
        return $category;
    }

    public function updateCategory(int $categoryId, array $data): category
    {
        $category = category::findOrFail($categoryId);
        $category->update($data);
        return $category;
    }

    public function activateCategory(int $categoryId): category
    {
        $category = category::findOrFail($categoryId);
        $category->category_status = 1;
        $category->save();
        return $category;
    }

    public function deactivateCategory(int $categoryId): category
    {
        $category = category::findOrFail($categoryId);
        $category->category_status = 0;
        $category->save();
        return $category;
    }

    public function deleteCategory(int $categoryId): void
    {
        $category = category::findOrFail($categoryId);
        $category->delete();
    }

    public function getAllCategories()
    {
        return category::all();
    }
}
