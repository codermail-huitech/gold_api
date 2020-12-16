<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model\CustomerCategory;
use App\Model\PersonType;
use App\Model\PriceCode;
use App\Model\JobTask;
use App\Model\MaterialCategory;
use App\Model\Rate;
use App\Model\ProductCategory;
use App\Model\Material;
use App\Model\StatusType;
use App\Model\BillAdjustment;
use App\Model\TransactionType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */



    public function run()
    {
        StatusType::create(['id'=>1, 'name'=>'Started']);
        StatusType::create(['id'=>40, 'name'=>'Not Started']);
        StatusType::create(['id'=>100, 'name'=>'Finished']);
//        StatusType::create(['id'=>101, 'name'=>'Bill Created']);
        StatusType::create(['id'=>102, 'name'=>'Stock Created']);

        BillAdjustment::create(['name'=>'pan', 'value'=>40]);
        BillAdjustment::create(['name'=>'nitric', 'value'=>96]);

        //customer_categories table data
        CustomerCategory::create(['customer_category_name'=>'Base']);
        CustomerCategory::create(['customer_category_name'=>'Base-50']);
        CustomerCategory::create(['customer_category_name'=>'Base-100']);
        CustomerCategory::create(['customer_category_name'=>'Base-150']);
        CustomerCategory::create(['customer_category_name'=>'Not Applicable']);


        //person_types table data
        PersonType::create(['person_type_name' => 'Owner']);
        PersonType::create(['person_type_name' => 'Manager']);
        PersonType::create(['person_type_name' => 'Manager Workshop']);
        PersonType::create(['person_type_name' => 'Manager Sales']);
        PersonType::create(['person_type_name' => 'Manager Accounts']);
        PersonType::create(['person_type_name' => 'Office Staff']);
        PersonType::create(['person_type_name' => 'Agent']);
        PersonType::create(['person_type_name' => 'Worker']);
        PersonType::create(['person_type_name' => 'Developer']);
        PersonType::create(['person_type_name' => 'Customer']);
        PersonType::create(['person_type_name' => 'Karigarh']);

        // user
        User::create(['person_name'=>'Vivekananda Ghsoh','mobile1'=>'9836444999','mobile2'=>'','email'=>'bangle312@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>1,'customer_category_id'=>1]);

//        User::create(['person_name'=>'Abishek Basak','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle396@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7]);
//        User::create(['person_name'=>'Pushpendu Pal','mobile1'=>'9836444568','mobile2'=>'','email'=>'bangle363@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7,'customer_category_id'=>3]);
//        User::create(['person_name'=>'Abishek Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle314@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7,'customer_category_id'=>3]);

        User::create(['person_name'=>'Counter Agent','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle396@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7]);
        User::create(['person_name'=>'Abishek Basak','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39612@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7]);
        User::create(['person_name'=>'Sudip Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39600@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7]);
        User::create(['person_name'=>'Bijon Dey','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39611@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>7]);

        User::create(['person_name'=>'Rik Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39600@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>2]);
        User::create(['person_name'=>'Abijit Basak','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39612000@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>3]);
        User::create(['person_name'=>'Sudipto Roy','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle39600005@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>4]);
        User::create(['person_name'=>'Bijit Dey','mobile1'=>'9836444451','mobile2'=>'','email'=>'bangle3961100@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>5]);
        User::create(['person_name'=>'Prodip Ghosh','mobile1'=>'9836444785','mobile2'=>'','email'=>'bangle3710@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>6]);

        User::create(['person_name'=>'Pushpendu Roy','mobile1'=>'9836444426','mobile2'=>'','email'=>'bangle376@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>8,'customer_category_id'=>4]);
        User::create(['person_name'=>'Pushpendu Ghosh','mobile1'=>'9836444785','mobile2'=>'','email'=>'bangle371@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>10,'customer_category_id'=>2]);

        User::create(['person_name'=>'Joy Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle322@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>11,'customer_category_id'=>3]);
        User::create(['person_name'=>'Erik Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle333@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>11,'customer_category_id'=>3]);
        User::create(['person_name'=>'Tuhin Ghosh','mobile1'=>'9836444972','mobile2'=>'','email'=>'bangle344@gmail.com','password'=>"81dc9bdb52d04dc20036dbd8313ed055",'person_type_id'=>11,'customer_category_id'=>3]);



        //price_code table data
        PriceCode::create(['price_code_name'=>'A']);
        PriceCode::create(['price_code_name'=>'B']);
        PriceCode::create(['price_code_name'=>'C']);
        PriceCode::create(['price_code_name'=>'D']);
        PriceCode::create(['price_code_name'=>'E']);
        PriceCode::create(['price_code_name'=>'F']);
        PriceCode::create(['price_code_name'=>'G']);
        PriceCode::create(['price_code_name'=>'H']);
        PriceCode::create(['price_code_name'=>'I']);
        PriceCode::create(['price_code_name'=>'J']);
        PriceCode::create(['price_code_name'=>'K']);
        PriceCode::create(['price_code_name'=>'L']);
        PriceCode::create(['price_code_name'=>'M']);
        PriceCode::create(['price_code_name'=>'N']);
        PriceCode::create(['price_code_name'=>'O']);
        PriceCode::create(['price_code_name'=>'P']);
        PriceCode::create(['price_code_name'=>'Q']);
        PriceCode::create(['price_code_name'=>'R']);
        PriceCode::create(['price_code_name'=>'S']);
        PriceCode::create(['price_code_name'=>'T']);
        PriceCode::create(['price_code_name'=>'U']);
        PriceCode::create(['price_code_name'=>'V']);
        PriceCode::create(['price_code_name'=>'W']);
        PriceCode::create(['price_code_name'=>'X']);
        PriceCode::create(['price_code_name'=>'Y']);
        PriceCode::create(['price_code_name'=>'Z']);

        //job_tasks table data
        JobTask::create(['task_name'=>'Gold Submit']);
        JobTask::create(['task_name'=>'Gold Return']);
        JobTask::create(['task_name'=>'Dal Submit']);
        JobTask::create(['task_name'=>'Dal Return']);
        JobTask::create(['task_name'=>'Pan Submit']);
        JobTask::create(['task_name'=>'Pan Return']);
        JobTask::create(['task_name'=>'Nitric Return']);
        JobTask::create(['task_name'=>'Bronze Submit']);

        //material_categories table data
        MaterialCategory::create(['mc_name' => 'Gold']);
        MaterialCategory::create(['mc_name' => 'Silver']);
        MaterialCategory::create(['mc_name' => 'Copper']);
        MaterialCategory::create(['mc_name' => 'Bronze']);
        MaterialCategory::create(['mc_name' => 'Zinc']);
        MaterialCategory::create(['mc_name' => 'Dal']);


         //materials  table data
         Material::create(['material_name' => 'Pure Gold','material_category_id'=>1,'gold'=>100,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => 'Pure Silver','material_category_id'=>2,'gold'=>0,'silver'=>100,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => '92 Ginnie','material_category_id'=>1,'gold'=>92,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>1,'main_material_id'=>0,'is_order_material'=>1]);
         Material::create(['material_name' => 'Pan','material_category_id'=>1,'gold'=>40,'silver'=>20,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => '90 Ginnie','material_category_id'=>1,'gold'=>90,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => 'Dal','material_category_id'=>6,'gold'=>10,'silver'=>70,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => 'Nitric','material_category_id'=>1,'gold'=>88,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => 'Production_dust ','material_category_id'=>1,'gold'=>20,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>0]);
         Material::create(['material_name' => '92 Ginnie Return ','material_category_id'=>1,'gold'=>92,'silver'=>0,'is_main_production_material'=>1,'is_base_material'=>1,'main_material_id'=>3]);
         Material::create(['material_name' => 'Dal Return','material_category_id'=>6,'gold'=>10,'silver'=>70,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>6]);
         Material::create(['material_name' => 'Pan Return','material_category_id'=>1,'gold'=>40,'silver'=>20,'is_main_production_material'=>1,'is_base_material'=>0,'main_material_id'=>4]);
         Material::create(['material_name' => 'Nitric Return','material_category_id'=>1,'gold'=>88,'silver'=>0,'is_main_production_material'=>0,'is_base_material'=>0,'main_material_id'=>7]);

        //rates  table data
        //base Rate
        Rate::create(['price_code_id'=>1,'price'=>'175','p_loss'=>'0.1','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>2,'price'=>'200','p_loss'=>'0.19','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>3,'price'=>'225','p_loss'=>'0.28','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>4,'price'=>'250','p_loss'=>'0.37','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>5,'price'=>'275','p_loss'=>'0.46','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>6,'price'=>'300','p_loss'=>'0.55','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>7,'price'=>'325','p_loss'=>'0.64','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>8,'price'=>'350','p_loss'=>'0.73','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>9,'price'=>'375','p_loss'=>'0.82','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>10,'price'=>'400','p_loss'=>'0.91','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>11,'price'=>'425','p_loss'=>'1','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>12,'price'=>'450','p_loss'=>'1.09','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>13,'price'=>'475','p_loss'=>'1.18','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>14,'price'=>'500','p_loss'=>'1.27','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>15,'price'=>'525','p_loss'=>'1.36','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>16,'price'=>'550','p_loss'=>'1.45','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>17,'price'=>'575','p_loss'=>'1.54','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>18,'price'=>'600','p_loss'=>'1.63','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>19,'price'=>'625','p_loss'=>'1.72','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>20,'price'=>'650','p_loss'=>'1.81','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>21,'price'=>'675','p_loss'=>'1.9','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>22,'price'=>'700','p_loss'=>'1.99','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>23,'price'=>'725','p_loss'=>'2.08','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>24,'price'=>'750','p_loss'=>'2.17','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>25,'price'=>'775','p_loss'=>'2.26','customer_category_id'=>1]);
        Rate::create(['price_code_id'=>26,'price'=>'800','p_loss'=>'2.35','customer_category_id'=>1]);

        //base-50
        Rate::create(['price_code_id'=>1,'price'=>'125','p_loss'=>'0.1','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>2,'price'=>'150','p_loss'=>'0.19','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>3,'price'=>'175','p_loss'=>'0.28','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>4,'price'=>'200','p_loss'=>'0.37','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>5,'price'=>'225','p_loss'=>'0.46','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>6,'price'=>'250','p_loss'=>'0.55','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>7,'price'=>'275','p_loss'=>'0.64','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>8,'price'=>'300','p_loss'=>'0.73','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>9,'price'=>'325','p_loss'=>'0.82','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>10,'price'=>'350','p_loss'=>'0.91','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>11,'price'=>'375','p_loss'=>'1','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>12,'price'=>'400','p_loss'=>'1.09','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>13,'price'=>'425','p_loss'=>'1.18','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>14,'price'=>'450','p_loss'=>'1.27','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>15,'price'=>'475','p_loss'=>'1.36','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>16,'price'=>'500','p_loss'=>'1.45','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>17,'price'=>'525','p_loss'=>'1.54','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>18,'price'=>'550','p_loss'=>'1.63','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>19,'price'=>'575','p_loss'=>'1.72','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>20,'price'=>'600','p_loss'=>'1.81','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>21,'price'=>'625','p_loss'=>'1.9','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>22,'price'=>'650','p_loss'=>'1.99','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>23,'price'=>'675','p_loss'=>'2.08','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>24,'price'=>'700','p_loss'=>'2.17','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>25,'price'=>'725','p_loss'=>'2.26','customer_category_id'=>2]);
        Rate::create(['price_code_id'=>26,'price'=>'750','p_loss'=>'2.35','customer_category_id'=>2]);

        //base-100
        Rate::create(['price_code_id'=>1,'price'=>'75','p_loss'=>'0.1','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>2,'price'=>'125','p_loss'=>'0.19','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>3,'price'=>'175','p_loss'=>'0.28','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>4,'price'=>'225','p_loss'=>'0.37','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>5,'price'=>'275','p_loss'=>'0.46','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>6,'price'=>'325','p_loss'=>'0.55','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>7,'price'=>'375','p_loss'=>'0.64','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>8,'price'=>'425','p_loss'=>'0.73','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>9,'price'=>'475','p_loss'=>'0.82','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>10,'price'=>'525','p_loss'=>'0.91','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>11,'price'=>'575','p_loss'=>'1','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>12,'price'=>'625','p_loss'=>'1.09','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>13,'price'=>'675','p_loss'=>'1.18','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>14,'price'=>'725','p_loss'=>'1.27','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>15,'price'=>'775','p_loss'=>'1.36','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>16,'price'=>'825','p_loss'=>'1.45','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>17,'price'=>'875','p_loss'=>'1.54','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>18,'price'=>'925','p_loss'=>'1.63','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>19,'price'=>'975','p_loss'=>'1.72','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>20,'price'=>'1025','p_loss'=>'1.81','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>21,'price'=>'1075','p_loss'=>'1.9','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>22,'price'=>'1125','p_loss'=>'1.99','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>23,'price'=>'1175','p_loss'=>'2.08','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>24,'price'=>'1225','p_loss'=>'2.17','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>25,'price'=>'1275','p_loss'=>'2.26','customer_category_id'=>3]);
        Rate::create(['price_code_id'=>26,'price'=>'1325','p_loss'=>'2.35','customer_category_id'=>3]);

        //Base-150
        Rate::create(['price_code_id'=>1,'price'=>'25','p_loss'=>'0.1','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>2,'price'=>'75','p_loss'=>'0.19','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>3,'price'=>'125','p_loss'=>'0.28','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>4,'price'=>'175','p_loss'=>'0.37','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>5,'price'=>'225','p_loss'=>'0.46','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>6,'price'=>'275','p_loss'=>'0.55','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>7,'price'=>'325','p_loss'=>'0.64','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>8,'price'=>'375','p_loss'=>'0.73','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>9,'price'=>'425','p_loss'=>'0.82','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>10,'price'=>'475','p_loss'=>'0.91','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>11,'price'=>'525','p_loss'=>'1','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>12,'price'=>'575','p_loss'=>'1.09','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>13,'price'=>'625','p_loss'=>'1.18','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>14,'price'=>'675','p_loss'=>'1.27','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>15,'price'=>'725','p_loss'=>'1.36','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>16,'price'=>'775','p_loss'=>'1.45','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>17,'price'=>'825','p_loss'=>'1.54','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>18,'price'=>'875','p_loss'=>'1.63','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>19,'price'=>'925','p_loss'=>'1.72','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>20,'price'=>'975','p_loss'=>'1.81','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>21,'price'=>'1025','p_loss'=>'1.9','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>22,'price'=>'1075','p_loss'=>'1.99','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>23,'price'=>'1125','p_loss'=>'2.08','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>24,'price'=>'1175','p_loss'=>'2.17','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>25,'price'=>'1225','p_loss'=>'2.26','customer_category_id'=>4]);
        Rate::create(['price_code_id'=>26,'price'=>'1275','p_loss'=>'2.35','customer_category_id'=>4]);


        //product_categories table data
        ProductCategory::create(['category_name'=>'Baby']);
        ProductCategory::create(['category_name'=>'churi']);
        ProductCategory::create(['category_name'=>'solid churi']);
        ProductCategory::create(['category_name'=>'Mina Thokai patla']);
        ProductCategory::create(['category_name'=>'Thokai Churi']);
        ProductCategory::create(['category_name'=>'Bouty']);
        ProductCategory::create(['category_name'=>'Thokai Patla']);
        ProductCategory::create(['category_name'=>'Kankan']);
        ProductCategory::create(['category_name'=>'Xsample']);
        ProductCategory::create(['category_name'=>'Mima Churi']);
        ProductCategory::create(['category_name'=>'Holo Churi']);
        ProductCategory::create(['category_name'=>'Holo']);

        TransactionType::create(['transaction_type'=>'Inward']);
        TransactionType::create(['transaction_type'=>'Outward']);
        TransactionType::create(['transaction_type'=>'Transferred']);
        TransactionType::create(['transaction_type'=>'Withdrawal']);


        //use following command for products in separate seeding products are not seeding here
       // php artisan db:seed --class=ProductSeeder

        factory(User::class,500)->create();
    }
}
