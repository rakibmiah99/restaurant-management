<?php

namespace App\Models;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Enums\Status;
use App\Model;
use App\Models\Scopes\DescScope;
use App\Observers\OrderObserver;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([OrderObserver::class]), ScopedBy(DescScope::class)]
class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected array $attributes_as_column = ['total_guest', 'entry_date', 'exit_date'];

    public function scopeFilter(Builder $builder){
        $request = request();
        $builder->with(['date_wise_monitor', 'country','company','hotel','hall','meal_price_for_normal','meal_price_for_ramadan']);
        if ($q = trim($request->q)) {
            foreach ($this->getColumns($this->attributes_as_column) as $column){
                if ($column == 'country_id'){
                    $builder->orWhereRelation('country', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'company_id'){
                    $builder->orWhereRelation('company', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'hotel_id'){
                    $builder->orWhereRelation('hotel', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'hall_id'){
                    $builder->orWhereRelation('hall', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'mpi_for_normal'){
                    $builder->orWhereRelation('meal_price_for_normal', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'mpi_for_ramadan'){
                    $builder->orWhereRelation('meal_price_for_ramadan', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'status' && (strtolower($q) == strtolower(Status::ACTIVE->value) || strtolower($q) == strtolower(Status::INACTIVE->value))){
                    $status = strtolower($q) == strtolower(Status::ACTIVE->value) ? 1 : 0;
                    $builder->orWhere('status', $status);
                }
                else{
                    $builder->orWhere($column, 'like', '%'.$q."%");
                }

            }
        }
    }
    public function scopeCompleteOrderFilter(Builder $builder){
        $request = request();
        if ($q = trim($request->q)) {
            foreach (array_keys(__('db.complete_order')) as $column){
                if ($column == 'order_number'){
                    $builder->where('order_number', 'like', '%'.$q.'%');
                }
                elseif ($column == 'hotel'){
                    $builder->orWhereRelation('hotel', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'hall'){
                    $builder->orWhereRelation('hall', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'cuisine_name'){
                    $builder->orWhereRelation('country', 'name', 'like', '%'.$q."%");
                }

            }
        }
    }

    public function scopeReportFilter(Builder $builder)
    {
        $request = request();
        $builder->with(['order_monitoring', 'hall', 'hotel', 'company', 'country', 'meal_systems']);

        if ($hotel_id = $request->hotel) {
            $builder->where('hotel_id', $hotel_id);
        }
        if ($hall_id = $request->hall) {
            $builder->where('hall_id', $hall_id);
        }
        if ($company_id = $request->company) {
            $builder->where('company_id', $company_id);
        }
        if ($country_id = $request->country) {
            $builder->where('country_id', $country_id);
        }
        if ($service_type = $request->service_type) {
            $builder->where('service_type', $service_type);
        }
        if ($request->from_date && $request->to_date) {
            $builder->whereBetween('order_date', [$request->from_date, $request->to_date]);
        }


        $columns = [];

        if ($request->segment(1) == "report" && $request->segment(2) == "hotel"){
            $columns = array_keys(__('db.report.hotel'));
        }
        else if ($request->segment(1) == "report" && $request->segment(2) == "hall"){
            $columns = array_keys(__('db.report.hall'));
        }
        else if ($request->segment(1) == "report" && $request->segment(2) == "order"){
            $columns = array_keys(__('db.report.order'));
        }



        if ($q = trim($request->q)) {
            foreach ($columns as $column){
                if ($column == 'order_number'){
                    $builder->orWhere($column, 'like', '%'.$q.'%');
                }
                elseif ($column == 'order_date'){
                    $builder->orWhereDate($column, $q);
                }
                elseif ($column == 'service_type' && !$request->service_type){
                    $builder->orWhere($column, 'like', '%'.$q.'%');
                }
                elseif ($column == 'hotel' && !$request->hotel){
                    $builder->orWhereRelation('hotel', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'hall' && !$request->hall){
                    $builder->orWhereRelation('hall', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'company' && !$request->company ){
                    $builder->orWhereRelation('company', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'cuisine_name' && !$request->country ){
                    $builder->orWhereRelation('country', 'name', 'like', '%'.$q."%");
                }

            }
        }
    }


    public function date_and_meal_wise_order_monitor(){
        return $this->hasMany(DateAndMealSWiseMonitor::class, 'order_id', 'id');
    }
    public function order_monitoring(){
        return $this->hasMany(OrderMonitoring::class, 'order_id', 'id');
    }

    public function date_wise_monitor(){
        return $this->hasMany(DateWiseMonitor::class, 'order_id', 'id');
    }

    public function meal_entries(){
        return $this->hasMany(MealEntries::class, 'order_id', 'id');
    }



    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function meal_systems(){
        return $this->hasMany(OrderMealSystem::class, 'order_id', 'id');
    }

    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function hall(){
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    //mpi = meal price id
    public function meal_price_for_normal(){
        return $this->belongsTo(MealPrice::class, 'mpi_for_normal', 'id');
    }

    //mpi = meal price id
    public function meal_price_for_ramadan(){
        return $this->belongsTo(MealPrice::class, 'mpi_for_ramadan', 'id');
    }


    public function getIsModifiedAttribute(): bool{
        //get duplicates meal systems
        $duplicates =  $this->meal_systems->groupBy('order_meal_system_id')->filter(function ($group){
            return $group->count() > 1;
        });

        $is_meal_system_modify = $duplicates->count() > 0;
        $has_meal_entries = $this->meal_entries->count() > 0;

        return $is_meal_system_modify || $has_meal_entries;
    }


    public function getTodayMealPriceWiseMealSystemsAttribute(){
        // Debugbar::log($this->hall->getMealSystemAttribute()?->pluck('id'));
        $hall_available_meal =  $this->hall->getMealSystemAttribute() ? $this->hall->getMealSystemAttribute()->pluck('id') : [] ;
        return $this->getMealPriceWiseMealSystemsAttribute()->whereIn('id', $hall_available_meal);
    }

    public function getTotalGuestAttribute(){
        return $this->meal_systems->sum('number_of_guest');
    }
    public function getEntryDateAttribute(){
        return $this->meal_systems->min('from_date');
    }
    public function getExitDateAttribute(){
        return $this->meal_systems->max('to_date');
    }
    public function getAllMealPriceAttribute(){
        $data = collect([]);
        return $data->concat(
            $this->meal_price_for_normal?->meal_systems ?? [],
        )->concat($this->meal_price_for_ramadan?->meal_systems ?? []);
    }


    public function getMealPriceWiseMealSystemsAttribute(){
        return $this->all_meal_price->map(function ($meal_price){
            $meal_system =  $meal_price->meal_system;
            $meal_system->meal_price_id = $meal_price->id;
            return $meal_system;
        });
    }
    public function getMealSystemNamesAttribute(){
        $meal_systems_id =  $this->meal_systems->pluck('order_meal_system_id')->unique();
        $meal_systems = MealSystem::whereIn('id', $meal_systems_id)->pluck('name')->toArray();
        return implode(', ',$meal_systems);
    }
    public function getMealSystemWiseMealCountAttribute(){
        $monitor = $this->order_monitoring;
        if (request()->from_meal_date && request()->to_meal_date){
            $monitor = $monitor->whereBetween('meal_date', [request()->from_meal_date, request()->to_meal_date]);
        }
        $data =  $monitor->groupBy('meal_system_id')
                ->map(function ($order_monitor,$meal_system_id){
                $order = $order_monitor->first()?->order;
                return (object)[
                    'id' => $meal_system_id,
                    'number_of_meals' => $order_monitor->sum('number_of_guest'),
                    'hotel' => $order?->hotel_id,
                    'country' => $order?->country_id,
                    'service_type' => $order?->service_type,
                ];
            });

        return collect($data);
    }

    public function getTotalBreakFastAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->where('id', 5)->first()?->number_of_meals ?? 0;
    }
    public function getTotalLunchAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->where('id', 6)->first()?->number_of_meals ?? 0;
    }
    public function getTotalDinnerAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->where('id', 7)->first()?->number_of_meals ?? 0;
    }
    public function getTotalSeheriAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->where('id', 9)->first()?->number_of_meals ?? 0;
    }
    public function getTotalIftarAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->where('id', 10)->first()?->number_of_meals ?? 0;
    }

    public function getTotalMealAttribute()
    {
        return $this->getMealSystemWiseMealCountAttribute()->sum('number_of_meals');
    }
    public function getFirstMealDateAttribute()
    {
        return $this->meal_systems->min('from_date');
    }
    public function getDaysAttribute()
    {
        return $this->meal_systems->sum('days');
    }
    public function getLastMealDateAttribute()
    {
        return $this->meal_systems->max('to_date');
    }
    public function getNumberOfDaysAttribute()
    {
        return $this->order_monitoring->unique('meal_date')->count();
    }
    public function getTotalEatenMealAttribute()
    {
        return $this->meal_entries->count();
    }



    public function getIsCompleteAttribute()
    {
        $status = false;

        $today = date('Y-m-d');
        if ($today > $this->getLastMealDateAttribute()){
            $status = true;
        }
        else if ($this->getTotalMealAttribute() == $this->getTotalEatenMealAttribute()){
            $status = true;
        }
        return $status;
    }

    public function getCanEditAttribute(): bool
    {
        $before_edit = CompanySetting::first()?->order_can_edit_before ?? 0;
        $before_edit_time = date('Y-m-d H:i:s', strtotime("-$before_edit hours"));
        $start_time = $this->date_wise_monitor->min('start_time');

        return $start_time > $before_edit_time;
    }


    public function getTestAttribute()
    {
        return $this->getTotalMealAttribute();
    }
    public function getAvailableMealSystemsAttribute(){

        return $data = $this->date_and_meal_wise_order_monitor()
        ->get()->groupBy('order_meal_system_id')
        ->map(function ($meal_system_data, $meal_system_id){
            //finding meal system
            $meal_system = MealSystem::find($meal_system_id);
            if (!$meal_system) {
                return null; // Skip if MealSystem is not found
            }
            //get meal price
            $price = $meal_system_data->first()->price;
            //summation of total guest
            $total_guest = $meal_system_data->sum('number_of_guest');

            //formatting and return data
            return  (object)[
              'name' => $meal_system->name."-".$meal_system->type,
              'meal_system_id' => $meal_system->id,
              'days' => $meal_system_data->count('meal_date'),
              'count_of_meal' => $total_guest,
              'price' => $price,
              'total_price' => $total_guest * $price,
            ];
        })->filter();
    }



    static function GenerateOrderNumber()
    {
        $year = Hijri::Date('Y');
        /*$order_number = Order::orderBy('id', 'desc')->first()?->order_number;
        $exp = explode('/', $order_number);
        $sl = 1;
        if(is_array($exp) && count($exp) == 2){
            $sl = $exp[1];
            $sl++;
        }*/
        $order_number = Order::orderBy('id', 'desc')->first();
        $sl = $order_number ? $order_number->id : 1;

        $sl =  str_pad($sl,5,"0",STR_PAD_LEFT );
        return $year."/".$sl;
    }

}
