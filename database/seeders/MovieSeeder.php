<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Category;
use Carbon\Carbon;

class MovieSeeder extends Seeder {
    public function run() {
        $movies = [
            [
                'title' => 'Inception',
                'category_id' => Category::where('name', 'Sci-Fi')->first()->id,
                'director' => 'Christopher Nolan',
                'release_date' => Carbon::create(2010, 7, 16),
                'synopsis' => 'A thief who enters the dreams of others to steal secrets.',
                'poster' => null
            ],
            [
                'title' => 'The Dark Knight',
                'category_id' => Category::where('name', 'Action')->first()->id,
                'director' => 'Christopher Nolan',
                'release_date' => Carbon::create(2008, 7, 18),
                'synopsis' => 'Batman battles the Joker in Gotham City.',
                'poster' => null
            ],
            [
                'title' => 'Toy Story',
                'category_id' => Category::where('name', 'Animation')->first()->id,
                'director' => 'John Lasseter',
                'release_date' => Carbon::create(1995, 11, 22),
                'synopsis' => 'A group of toys come to life when humans are not around.',
                'poster' => null
            ],
            [
                'title' => 'The Conjuring',
                'category_id' => Category::where('name', 'Horror')->first()->id,
                'director' => 'James Wan',
                'release_date' => Carbon::create(2013, 7, 19),
                'synopsis' => 'Paranormal investigators work to help a family terrorized by a dark presence.',
                'poster' => null
            ],
            [
                'title' => 'Saving Private Ryan',
                'category_id' => Category::where('name', 'War')->first()->id,
                'director' => 'Steven Spielberg',
                'release_date' => Carbon::create(1998, 7, 24),
                'synopsis' => 'A group of soldiers set out to rescue a paratrooper behind enemy lines.',
                'poster' => null
            ],
            [
                'title' => 'The Lord of the Rings: The Fellowship of the Ring',
                'category_id' => Category::where('name', 'Fantasy')->first()->id,
                'director' => 'Peter Jackson',
                'release_date' => Carbon::create(2001, 12, 19),
                'synopsis' => 'A hobbit sets out on a journey to destroy a powerful ring.',
                'poster' => null
            ],
            [
                'title' => 'Se7en',
                'category_id' => Category::where('name', 'Thriller')->first()->id,
                'director' => 'David Fincher',
                'release_date' => Carbon::create(1995, 9, 22),
                'synopsis' => 'Two detectives track down a serial killer who uses the seven deadly sins as motives.',
                'poster' => null
            ]
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
