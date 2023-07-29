<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [   
                'name' => 'MacBook',
                'price' => 150000,
                'description' => 'The new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.',
            ],
            [
                'name' => 'iPhone',
                'price' => 58000,
                'description' => 'iPhone is a revolutionary new mobile phone that allows you to make a call by simply tapping a name or number in your address book, a favorites list, or a call log. It also automatically syncs all your contacts from a PC, Mac, or Internet service. And it lets you select and listen to voicemail messages in whatever order you want just like email.',
            ],
            [
                'name' => 'Canon EOS 5D',
                'price' => 38000,
                'description' => "Canon's press material for the EOS 5D states that it 'defines (a) new D-SLR category', while we're not typically too concerned with marketing talk this particular statement is clearly pretty accurate. The EOS 5D is unlike any previous digital SLR in that it combines a full-frame (35 mm sized) high resolution sensor (12.8 megapixels) with a relatively compact body (slightly larger than the EOS 20D, although in your hand it feels noticeably 'chunkier').",
            ],
            // Add more product data as needed
        ];

         // Insert products into the database
        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
