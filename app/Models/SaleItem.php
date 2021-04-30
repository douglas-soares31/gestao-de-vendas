<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    public function storeSaleItems($saleOrder, $sale_items)
    {

        foreach ($sale_items as $item) {

            $saleItem = new SaleItem();
            $item = (object) $item;

            if (strpos($item->unitary_value, "R$ ") !== false) {

                $item->unitary_value = str_replace("R$ ", "", $item->unitary_value);
                $item->unitary_value = str_replace(".", "", $item->unitary_value);
                $item->unitary_value = str_replace(",", ".", $item->unitary_value);
            }

            $saleItem->sale_order_id = $saleOrder->id;
            $saleItem->register_product_id = $item->register_product_id;
            $saleItem->quantity = $item->quantity;
            $saleItem->unitary_value = $item->unitary_value;

            $saleItem->save();

            $stockProduct = new Stock();

            $stockProduct->decrementStock($saleOrder, $saleItem);
        }
    }

    public function removeSaleItems($saleOrder)
    {

        $sale_items = SaleItem::where('sale_order_id', $saleOrder->id)->get();

        foreach ($sale_items as $item) {
            $item = (object) $item;

            $stockProduct = new Stock();
            $item->delete();
            
            $stockProduct->incrementStock($saleOrder, $item);
        }
    }
}
