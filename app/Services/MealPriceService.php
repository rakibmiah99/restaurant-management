<?php
namespace App\Services;
use App\Models\Company;
use App\Models\MealPrice;
use App\Models\Order;

class MealPriceService{

    public $model;
    public function __construct($id)
    {
        $model = MealPrice::find($id);
        if ($model){
            $this->model = $model;
        }
        else{
            abort(404);
        }
    }


    public function canDelete(){
        if ($this->model->orders->count() || $this->model->companies->count()) {
            return false;
        }
        else {
            $this->model->delete();
            return true;
        }
    }
}
