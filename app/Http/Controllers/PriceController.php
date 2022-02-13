<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * @return \Illuminate\Support\LazyCollection
     */
    public function getPrices()
    {
        return DB::table('prices')
            ->select('prices.id', 'prices.guid', 'prices.price', 'products.guid as product')
            ->join('products','products.id', '=', 'prices.product_id')
            ->cursor();
    }

    /**
     * @param $productGuid
     * @param Request $request
     * @return array
     */
    public function updatePrices($productGuid, Request $request)
    {
        $priceGuids = [];
        $updated = [];
        try {
            $json = $request->json()->all();
            $product = Product::where('guid', $productGuid)->firstOrFail();
            $productId = $product->id;

            foreach ($json['prices'] as $priceGuid) {
                $priceGuids[] = $priceGuid['guid'];

                $updated[] = Price::updateOrCreate(
                    ['guid' => $priceGuid['guid'], 'product_id' => $productId],
                    ['price' => $priceGuid['price']]);
            }
            $deleted = Price::whereNotIn('guid', $priceGuids)->delete();
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }
        return ['updated' => $updated, 'deleted' => $deleted];
    }
}
