<?php

namespace App\Imports;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ArticlesImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'categories' => 'required|string|max:45',
            'tags' => 'required|string|max:45',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $categories = collect(explode(',', $row['categories']))->map(function ($categoryName) {
            return Category::firstOrCreate(['name' => trim($categoryName)])->id;
        });

        $tags = collect(explode(',', $row['tags']))->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => trim($tagName)])->id;
        });

        $article = Article::create([
            'title' => $row['title'],
            'content' => $row['content'],
        ]);

        $article->categories()->sync($categories);
        $article->tags()->sync($tags);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
