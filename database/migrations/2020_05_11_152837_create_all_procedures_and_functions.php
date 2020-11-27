<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllProceduresAndFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        DB::unprepared('DROP PROCEDURE IF EXISTS getUsers;
//                        CREATE PROCEDURE getUsers()
//                        BEGIN
//                            SELECT * FROM users;
//                        END');



            DB::unprepared('DROP PROCEDURE IF EXISTS getFullPaymentDetail;
                            CREATE PROCEDURE test_db.`getFullPaymentDetail`(IN `customer_id` INT)
                            BEGIN
                                 /*total_submitted = gold_submitted - gold_returned
                              total_amount = price * quantity
                              total_gold = total_submitted + opening_balance_Gold
                              total_LC = total_amount + opening_balance_LC
                              total_gold_received = sum of all gold_receiveds of a customer
                              total_lc_received = sum of all lc_receiveds of a customer
                              gold_due = total_gold - total_gold_received
                              cash_due =total_LC - total_lc_received */
                            select total_gold_received,(total_gold - total_gold_received) as gold_due,(total_LC - total_lc_received) as cash_due ,total_lc_received, person_id, total_submitted, gold_returned, gold_submitted, total_gold, total_amount, total_LC from
                            (select sum(gold_receiveds.gold_received) as total_gold_received,table5.total_lc_received, table5.person_id, table5.total_submitted, table5.gold_returned, table5.gold_submitted, table5.total_amount, table5.total_gold, table5.total_LC from
                            (select sum(lc_receiveds.lc_received) as total_lc_received ,table4.person_id,table4.total_submitted,table4.gold_returned,table4.gold_submitted,table4.total_amount, table4.total_gold, table4.total_LC from
                            (select table3.person_id,table3.total_submitted,table3.gold_returned,table3.gold_submitted,table3.total_amount,(users.opening_balance_LC + table3.total_amount) as total_LC,(users.opening_balance_Gold + table3.total_submitted) as total_gold from
                            (select table2.person_id,table2.total_submitted,table2.gold_returned,table2.gold_submitted, sum(order_details.quantity *order_details.price) as total_amount from
                            (select table1.person_id,(table1.gold_submitted + sum(job_details.material_quantity)) as total_submitted,sum(job_details.material_quantity) as gold_returned, table1.gold_submitted from
                            (select order_masters.person_id,sum(job_details.material_quantity)as gold_submitted from job_details
                            inner join job_masters ON job_masters.id = job_details.job_master_id
                            inner join order_details ON order_details.id = job_masters.order_details_id
                            inner join order_masters ON order_masters.id = order_details.order_master_id
                            where order_masters.person_id = customer_id and job_details.job_task_id = 1) as table1
                            inner join order_masters on order_masters.person_id = table1.person_id
                            inner join order_details on order_details.order_master_id = order_masters.id
                            inner join job_masters on job_masters.order_details_id = order_details.id
                            inner join job_details on job_details.job_master_id = job_masters.id
                            where order_masters.person_id = customer_id and job_details.job_task_id = 2) as table2
                            inner join order_masters on order_masters.person_id = table2.person_id
                            inner join order_details on order_details.order_master_id = order_masters.id
                            group by table2.person_id,table2.total_submitted,table2.gold_returned,table2.gold_submitted) as table3
                            inner join users on table3.person_id = users.id) as table4
                            inner join lc_receiveds on table4.person_id = lc_receiveds.customer_id
                            group by table4.person_id,table4.total_submitted,table4.gold_returned,table4.gold_submitted,table4.total_amount, table4.total_gold, table4.total_LC) as table5
                            inner join gold_receiveds on table5.person_id = gold_receiveds.customer_id
                            group by table5.total_lc_received, table5.person_id, table5.total_submitted, table5.gold_returned, table5.gold_submitted, table5.total_amount, table5.total_gold, table5.total_LC) as table6;

                              END;'
                            );



            DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_gold_quantity;
                CREATE FUNCTION test_db.`get_gold_quantity`(`param_job_master_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN
                  DECLARE temp_gold_send double;
                  DECLARE temp_gold_ret double;
                  DECLARE temp_pan_send double;
                  DECLARE temp_pan_ret double;
                  DECLARE temp_nitric_ret double;
                  DECLARE temp_ploss_info double;
                  DECLARE temp_gold_quantity double;

                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;

                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;

                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;

                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;

                  select ifNull(sum(material_quantity),0) into temp_nitric_ret   from job_details where job_master_id=param_job_master_id and job_task_id =7;

                  select (order_details.p_loss*order_details.quantity ) into temp_ploss_info from job_masters
                  inner join order_details ON order_details.id = job_masters.order_details_id
                  where job_masters.id=param_job_master_id;

                  select temp_gold_send + temp_gold_ret  + temp_pan_send + temp_pan_ret + temp_nitric_ret + temp_ploss_info into temp_gold_quantity ;

                IF temp_gold_quantity IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_gold_quantity;
                END;'
            );
//
//            DB::unprepared('DROP PROCEDURE IF EXISTS test_db.getStockWithTag;
//                    CREATE PROCEDURE test_db.`getStockWithTag`()
//                    BEGIN
//
//
//
//                    select stocks.id,stocks.gold, stocks.agent_id , stocks.amount, stocks.in_stock,stocks.quantity, stocks.gross_weight,stocks.material_id,products.model_number,stocks.job_master_id,order_details.size,users.id as person_id,
//                    concat( conv(SUBSTRING(tag, 5,5),10,16),'-' ,
//                    conv(SUBSTRING_INDEX(SUBSTRING_INDEX(tag,'-',-2), '-',1),10,16),'-',
//                    SUBSTRING_INDEX(tag,'-',-1)) as tag
//                    from stocks
//                    inner join job_masters ON job_masters.id = stocks.job_master_id
//                    inner join order_details ON order_details.id = job_masters.order_details_id
//                    inner join order_masters ON order_masters.id = order_details.order_master_id
//                    inner join users ON users.id = order_masters.person_id
//                    inner join products ON products.id = order_details.product_id;
//
//                    END;'
//            );

        DB::unprepared( 'DROP PROCEDURE IF EXISTS test_db.getStockWithTag;
                    CREATE PROCEDURE test_db.`getStockWithTag`()
                    BEGIN



                    select stocks.id,stocks.gold, stocks.agent_id , stocks.amount, stocks.in_stock,stocks.quantity, stocks.gross_weight,stocks.material_id,products.model_number,stocks.job_master_id,order_details.size,users.id as person_id,
                    concat( conv(SUBSTRING(tag, 5,5),10,16),\'-\' ,
                    conv(SUBSTRING_INDEX(SUBSTRING_INDEX(tag,\'-\',-2), \'-\',1),10,16),\'-\',
                    SUBSTRING_INDEX(tag,\'-\',-1)) as tag
                    from stocks
                    inner join job_masters ON job_masters.id = stocks.job_master_id
                    inner join order_details ON order_details.id = job_masters.order_details_id
                    inner join order_masters ON order_masters.id = order_details.order_master_id
                    inner join users ON users.id = order_masters.person_id
                    inner join products ON products.id = order_details.product_id
                    where stocks.in_stock=1;

                    END;'

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_procedures_and_functions');
    }
}
