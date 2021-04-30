<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;


    public function storePurchaseItems($purchaseOrder, $purchase_items)
    {

        foreach ($purchase_items as $item) {

            $purchaseItem = new PurchaseItem();
            $item = (object) $item;

            if (strpos($item->unitary_value, "R$ ") !== false) {

                $item->unitary_value = str_replace("R$ ", "", $item->unitary_value);
                $item->unitary_value = str_replace(".", "", $item->unitary_value);
                $item->unitary_value = str_replace(",", ".", $item->unitary_value);
            }

            $purchaseItem->purchase_order_id = $purchaseOrder->id;
            $purchaseItem->register_product_id = $item->register_product_id;
            $purchaseItem->quantity = $item->quantity;
            $purchaseItem->unitary_value = $item->unitary_value;

            $purchaseItem->save();

            $stockProduct = new Stock();

            $stockProduct->incrementStock($purchaseOrder, $purchaseItem);
        }
    }

    public function removePurchaseItems($purchaseOrder)
    {

        $purchase_items = PurchaseItem::where('purchase_order_id', $purchaseOrder->id)->get();

        foreach ($purchase_items as $item) {
            $item = (object) $item;

            $stockProduct = new Stock();
            $item->delete();
            
            $stockProduct->decrementStock($purchaseOrder, $item);
        }
    }
}
