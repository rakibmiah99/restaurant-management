<?php
namespace App\Services;
use App\Models\Company;
use App\Models\Order;

class CompanyService{

    public $model;
    public function __construct($id)
    {
        $model = Company::find($id);
        if ($model){
            $this->model = $model;
        }
        else{
            abort(404);
        }
    }


    public function canDelete(){
        if ($this->model->orders->count()) {
            return false;
        }
        else {
            $this->model->delete();
            return true;
        }
    }
}
