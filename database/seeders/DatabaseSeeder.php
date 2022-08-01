<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Office;
use App\Models\Permission;
use App\Models\Rent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\User::factory(10)->create();
          // $office = new Office();


     //    /* office seed */
     //    $office_array = [
     //        array("name"=>"Office 1", "contact"=>9242424, "email"=>"office1@test.com", "address"=>"Brgy. Obrero"),
     //        array("name"=>"Office 2", "contact"=>9242423, "email"=>"office2@test.com", "address"=>"Brgy. Capoocan"),
     //        array("name"=>"Office 3", "contact"=>9242422, "email"=>"office3@test.com", "address"=>"Brgy. Carmen"),
     //        array("name"=>"Office 4", "contact"=>9242421, "email"=>"office4@test.com", "address"=>"Brgy. Dagum"),
     //        array("name"=>"Office 5", "contact"=>9242420, "email"=>"office5@test.com", "address"=>"Brgy. Payahan"),
     //    ];

     //    foreach($office_array as $value)
     //    {
     //        $office = new Office();

     //        $office->name = $value['name'];
     //        $office->contact = $value['contact'];
     //        $office->email = $value['email'];
     //        $office->address = $value['address'];

     //        $office->save();

     //    }
     //   /* brand seed */
     //    $array = [
     //        "Nissan",
     //        "Toyota",
     //        "Mazda",
     //        "Mitsubishi",
     //        "Suzuki"
     //    ];

     //    foreach($array as $brands)
     //    {
     //        $brand = new Brand();

     //        $brand->name = $brands;
     //        $brand->save();
     //    }
     
     //   /* customer seed */
     //   $customer_array = [
     //        array('first'=>'Alexis John','last'=>'Cabanto','purok'=>'Purok 1','barangay'=>'Matobato','city'=>'Calbayog City','contact'=>97,'email'=>'alexis@gmail.com','password'=>'alexis123','status'=>1),
     //        array('first'=>'Jason','last'=>'Belano','purok'=>'Purok 4','barangay'=>'Basud','city'=>'Calbayog City','contact'=>914,'email'=>'jason@gmail.com','password'=>'jason123','status'=>1),
     //        array('first'=>'Sean','last'=>'Misolas','purok'=>'Purok 3','barangay'=>'Carayman','city'=>'Calbayog City','contact'=>91234,'email'=>'sean@gmail.com','password'=>'sean123','status'=>1),
     //        array('first'=>'Mark Leouie','last'=>'Tabique','purok'=>'Purok 4','barangay'=>'Carayman','city'=>'Calbayog City','contact'=>915,'email'=>'mark@gmail.com','password'=>'mark123','status'=>1),
     //        array('first'=>'Florence','last'=>'Bagaan','purok'=>'Purok 2','barangay'=>'Cahumpan','city'=>'Calbayog City','contact'=>94,'email'=>'florence@gmail.com','password'=>'florence123','status'=>1),
          
     //   ];

     //   foreach($customer_array as $value)
     //   {
     //        $customer = new Customer();

     //        $customer->first_name = $value['first'];
     //        $customer->last_name = $value['last'];
     //        $customer->purok = $value['purok'];
     //        $customer->barangay = $value['barangay'];
     //        $customer->city = $value['city'];
     //        $customer->contact = $value['contact'];
     //        $customer->email = $value['email'];
     //        $customer->password = $value['password'];
     //        $customer->status = $value['status'];

     //        $customer->save();
     //   }
     
     //      /* role seeder */
     //   $role_array = [
     //        'Admin',
     //        'Attendant'
     //   ];
     
     //   foreach($role_array as $value)
     //   {
     //        $role = new Role();

     //        $role->type = $value;
     //        $role->save();
     //   }

     //   $permission_array = [

     //        'Add',
     //        'View',
     //        'Update',
     //        'Delete',

     //   ];

     //   foreach ($permission_array as $value) {

     //        $permission = new Permission();
     //        $permission->type = $value;

     //        $permission->save();
     //   }


     //      /* Cars Seeder */
     //   $cars_array = [
     //      array('name'=>'car 1', 'description'=>'car 1 description', 'plate_no'=>123, 'brand_id'=>1),
     //      array('name'=>'car 2', 'description'=>'car 2 description', 'plate_no'=>321, 'brand_id'=>2),
     //      array('name'=>'car 3', 'description'=>'car 3 description', 'plate_no'=>565, 'brand_id'=>3),
     //      array('name'=>'car 4', 'description'=>'car 4 description', 'plate_no'=>13212, 'brand_id'=>4),
     //      array('name'=>'car 5', 'description'=>'car 5 description', 'plate_no'=>15343, 'brand_id'=>5),
     //   ];

     
     //   foreach($cars_array as $value)
     //   {
     //      $office = Office::find(1);
     //      $office->cars()->create([
     //           "name" => $value['name'],
     //           "description" => $value['description'],
     //           "plate_number" => $value['plate_no'],
     //           "brand_id" => $value['brand_id'],
     //        ]);
     //   }


          /* USER SEEDERS */
     // $user_array = [

     //      array('name'=>'Jason Belano','contact'=>612312,'address'=>'Basud','email'=>'jason@test.com','password'=>'jason123','role_id'=>1),
     //      array('name'=>'Sean Misolas','contact'=>4321121,'address'=>'Carayman','email'=>'sean@test.com','password'=>'sean123','role_id'=>2),
     // ];

     // foreach ($user_array as $value) {
     //      $office = Office::find(2);

     //      $office->users()->create([
     //           "name"=> $value['name'],
     //           "contact"=> $value['contact'],
     //           "address"=> $value['address'],
     //           "email"=> $value['email'],
     //           "password"=> Hash::make($value['password']),
     //           "role_id"=> $value['role_id'],
     //      ]);
     // }

     // /* PERMISSION_ROLE SEEDERS */
     // $array = [
     //      1,
     //      2,
     //      3,
     //      4,
     // ];
     
     // foreach($array as $value)
     // {
     //      $role = Role::find(1);
     //      $role->permissions()->attach($value);
     // }
     

     /* RENT SEEDERS */
     // $car_array = [

     //      array('quantity'=>'1', 'date'=>"2022-07-12", 'return'=>'2022-07-29','customer_id'=>1),
     //      array('quantity'=>'1', 'date'=>"2022-07-12", 'return'=>'2022-07-28','customer_id'=>2),
     //      array('quantity'=>'1', 'date'=>"2022-07-12", 'return'=>'2022-07-27','customer_id'=>3),
     //      array('quantity'=>'1', 'date'=>"2022-07-12", 'return'=>'2022-07-26','customer_id'=>4),
     //      array('quantity'=>'1', 'date'=>"2022-07-12", 'return'=>'2022-07-25','customer_id'=>5),
     // ];

     // foreach($car_array as $value)
     // {
          // $cars = Car::find(1);
     //      $cars->rents()->create([
     //           "quantity"=> $value['quantity'],
     //           "rent_date"=> $value['date'],
     //           "return_date"=> $value['return'],
     //           "customer_id"=> $value['customer_id'],
     //      ]);
          // $cars->update([
          //      'status' => 1
          // ]);
     // }
   


     //        /* OFFICE_CUSTOMER SEEDERS */
     // $array = [
     //      1,
     //      2,
     //      3,
     //      4,
     //      5,
     // ];
     
     // foreach($array as $value)
     // {
     //      $role = Office::find(1);
     //      $role->customers()->attach($value);
     // }
  
}
    }

