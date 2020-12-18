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





        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_gold_due_by_customer_id_by_agent_id_for_customer;
            CREATE FUNCTION test_db.`get_gold_due_by_customer_id_by_agent_id_for_customer`(`param_customer_id` INT, `param_agent_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                              DECLARE temp_total_billed_gold double;
                              DECLARE temp_opening_balance_Gold double;
                              DECLARE temp_total_gold_received double;
                              DECLARE temp_total_gold_due double;


                                 select get_opening_balance_gold_by_customer_id(param_customer_id) into temp_opening_balance_Gold;

                                 select sum(get_billed_gold_by_bill_master_id(id)) into temp_total_billed_gold from bill_masters
                                 where bill_masters.agent_id = param_agent_id and bill_masters.customer_id = param_customer_id ;

                                 select get_total_gold_payment_by_customer_id(param_customer_id) into temp_total_gold_received;

                                 select  temp_opening_balance_Gold + temp_total_billed_gold - temp_total_gold_received into temp_total_gold_due;

                              IF temp_total_gold_due IS NULL THEN
                                  RETURN 0;
                              END IF;
                              RETURN temp_total_gold_due;
                        END;
            ');

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_LC_due_by_customer_id_and_by_agent_id_for_customer;
            CREATE FUNCTION test_db.`get_LC_due_by_customer_id_and_by_agent_id_for_customer`(`param_customer_id` INT, `param_agent_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                                  DECLARE temp_total_billed_LC double;
                                  DECLARE temp_opening_balance_LC double;
                                  DECLARE temp_total_payment double;
                                  DECLARE temp_total_LC_due double;
                                     select get_opening_balance_LC_by_customer_id(param_customer_id) into temp_opening_balance_LC;

                                     select sum(get_billed_LC_by_bill_master_id(id)) into temp_total_billed_LC from bill_masters
                                     where bill_masters.agent_id = param_agent_id and bill_masters.customer_id = param_customer_id ;

                                     select get_total_LC_payment_by_customer_id(param_customer_id) into temp_total_payment;

                                     select  temp_opening_balance_LC + temp_total_billed_LC - temp_total_payment into temp_total_LC_due;

                                  IF temp_total_LC_due IS NULL THEN
                                      RETURN 0;
                                  END IF;
                                  RETURN temp_total_LC_due;
                               END;
            ');

        //OLD FUNCTION
//            DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_gold_quantity;
//                CREATE FUNCTION test_db.`get_gold_quantity`(`param_job_master_id` INT) RETURNS double
//                    DETERMINISTIC
//                BEGIN
//                  DECLARE temp_gold_send double;
//                  DECLARE temp_gold_ret double;
//                  DECLARE temp_pan_send double;
//                  DECLARE temp_pan_ret double;
//                  DECLARE temp_nitric_ret double;
//                  DECLARE temp_ploss_info double;
//                  DECLARE temp_gold_quantity double;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;
//
//                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;
//
//                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;
//
//                  select ifNull(sum(material_quantity),0) into temp_nitric_ret   from job_details where job_master_id=param_job_master_id and job_task_id =7;
//
//                  select (order_details.p_loss*order_details.quantity ) into temp_ploss_info from job_masters
//                  inner join order_details ON order_details.id = job_masters.order_details_id
//                  where job_masters.id=param_job_master_id;
//
//                  select temp_gold_send + temp_gold_ret  + temp_pan_send + temp_pan_ret + temp_nitric_ret + temp_ploss_info into temp_gold_quantity ;
//
//                IF temp_gold_quantity IS NULL THEN
//                    RETURN 0;
//                END IF;
//                RETURN temp_gold_quantity;
//                END;'
//            );

        //UPDATED FUNCTION
        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_gold_quantity;
            CREATE FUNCTION test_db.`get_gold_quantity`(`param_job_master_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                  DECLARE temp_gold_send double;
                  DECLARE temp_gold_ret double;
                  DECLARE temp_pan_send double;
                  DECLARE temp_pan_ret double;
                  DECLARE total_pan double;
                  DECLARE temp_nitric_ret double;
                  DECLARE temp_ploss_info double;
                  DECLARE temp_gold_quantity double;
                  DECLARE temp_billAdjustment_nitric double;

                  select bill_adjustments.value into temp_billAdjustment_nitric FROM bill_adjustments where id=2;

                  select ifNull(sum(material_quantity),0) into temp_gold_send   from job_details where job_master_id=param_job_master_id and job_task_id =1 ;

                  select ifNull(sum(material_quantity),0) into temp_gold_ret   from job_details where job_master_id=param_job_master_id and job_task_id =2;

                  select ifNull(sum(material_quantity),0) into temp_pan_send   from job_details where job_master_id=param_job_master_id and job_task_id =5;

                  select ifNull(sum(material_quantity),0) into temp_pan_ret   from job_details where job_master_id=param_job_master_id and job_task_id =6;

                  select ifNull((sum(material_quantity)*temp_billAdjustment_nitric)/100,0) into temp_nitric_ret from job_details where job_master_id=param_job_master_id and job_task_id =7;

                  select (order_details.p_loss*order_details.quantity) into temp_ploss_info from job_masters
                  inner join order_details ON order_details.id = job_masters.order_details_id
                  where job_masters.id=param_job_master_id;

                  select (((temp_pan_send + temp_pan_ret)*bill_adjustments.value)/100) into total_pan FROM bill_adjustments where id=1;

                  select temp_gold_send + temp_gold_ret  + total_pan + temp_nitric_ret + temp_ploss_info into temp_gold_quantity ;

                IF temp_gold_quantity IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_gold_quantity;
                END;
'       );

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

        DB::unprepared( 'DROP PROCEDURE IF EXISTS test_db.getBillByMasterId;
                    CREATE PROCEDURE test_db.`getBillByMasterId`(IN `temp_bill_master_id` INT)
                    BEGIN

                        select (table1.temp_LC - ((table1.discount / 100) * table1.temp_LC)) as total_LC, temp_gold from(select sum(bill_details.LC) as temp_LC , sum(bill_details.pure_gold) as temp_gold, bill_masters.discount from bill_masters
                        inner join bill_details on bill_details.bill_master_id = bill_masters.id
                        where bill_masters.id = temp_bill_master_id) as table1;

                    END;'

        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_LC_due_by_customer_id;
            CREATE FUNCTION test_db.`get_LC_due_by_customer_id`(`param_customer_id` INT) RETURNS double
                DETERMINISTIC
            BEGIN
                  DECLARE temp_total_billed_LC double;
                  DECLARE temp_opening_balance_LC double;
                  DECLARE temp_total_payment double;
                  DECLARE temp_total_LC_due double;
                     select get_opening_balance_LC_by_customer_id(param_customer_id) into temp_opening_balance_LC;

                     select sum(get_billed_LC_by_bill_master_id(id)) into temp_total_billed_LC from bill_masters where bill_masters.customer_id = param_customer_id;

                     select get_total_LC_payment_by_customer_id(param_customer_id) into temp_total_payment;

                     select  temp_opening_balance_LC + temp_total_billed_LC - temp_total_payment into temp_total_LC_due;

                  IF temp_total_LC_due IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_LC_due;
               END;');

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_gold_due_by_customer_id;
                CREATE FUNCTION test_db.`get_gold_due_by_customer_id`(`param_customer_id` INT) RETURNS double
                    DETERMINISTIC
                BEGIN
                  DECLARE temp_total_billed_gold double;
                  DECLARE temp_opening_balance_Gold double;
                  DECLARE temp_total_gold_received double;
                  DECLARE temp_total_gold_due double;


                     select get_opening_balance_gold_by_customer_id(param_customer_id) into temp_opening_balance_Gold;

                     select sum(get_billed_gold_by_bill_master_id(id)) into temp_total_billed_gold from bill_masters where customer_id = param_customer_id;

                     select get_total_gold_payment_by_customer_id(param_customer_id) into temp_total_gold_received;

                     select  temp_opening_balance_Gold + temp_total_billed_gold - temp_total_gold_received into temp_total_gold_due;

                  IF temp_total_gold_due IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_gold_due;
            END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_bill_info;
            CREATE FUNCTION test_db.`get_bill_info`(`param_bill_master_id` INT) RETURNS double
            DETERMINISTIC
            BEGIN
                  DECLARE temp_total_LC double;


                  select sum(bill_details.LC) into temp_total_LC  from bill_details where bill_details.bill_master_id = param_bill_master_id;
                  select (temp_total_LC - ((bill_masters.discount/100)*temp_total_LC)) into temp_total_LC  from bill_masters where bill_masters.id = param_bill_master_id;


                IF temp_total_LC IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_total_LC;
            END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_billed_gold_by_bill_master_id;
        CREATE FUNCTION test_db.`get_billed_gold_by_bill_master_id`(`param_bill_master_id` INT) RETURNS double
        DETERMINISTIC
        BEGIN

                  DECLARE temp_billed_gold double;

                  select sum(bill_details.pure_gold) into temp_billed_gold from bill_details where bill_details.bill_master_id = param_bill_master_id;

                  IF temp_billed_gold IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_billed_gold;
               END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_billed_LC_by_bill_master_id;
CREATE FUNCTION test_db.`get_billed_LC_by_bill_master_id`(`param_bill_master_id` INT) RETURNS double
    DETERMINISTIC
BEGIN
                  DECLARE temp_total_LC double;
                  DECLARE temp_discount double;
                  DECLARE temp_billed_LC double;

                  select sum(bill_details.quantity*bill_details.rate) into temp_total_LC from bill_details where bill_details.bill_master_id = param_bill_master_id;

                  select bill_masters.discount into temp_discount FROM bill_masters where id = param_bill_master_id ;

                  select temp_total_LC - temp_discount into temp_billed_LC;

                  IF temp_billed_LC IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_billed_LC;
               END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_opening_balance_gold_by_customer_id;
CREATE FUNCTION test_db.`get_opening_balance_gold_by_customer_id`(`param_customer_id` INT) RETURNS double
    DETERMINISTIC
BEGIN

                  DECLARE temp_opening_balance_gold double;

                  select users.opening_balance_Gold into temp_opening_balance_gold  from users where id = param_customer_id;

                  IF temp_opening_balance_gold IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_opening_balance_gold;
               END;
');

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_opening_balance_LC_by_customer_id;
CREATE FUNCTION test_db.`get_opening_balance_LC_by_customer_id`(`param_customer_id` INT) RETURNS double
    DETERMINISTIC
BEGIN

                  DECLARE temp_opening_balance_LC double;

                  select users.opening_balance_LC into temp_opening_balance_LC  from users where id = param_customer_id;

                  IF temp_opening_balance_LC IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_opening_balance_LC;
               END;
');


        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_total_gold_payment_by_customer_id;
CREATE FUNCTION test_db.`get_total_gold_payment_by_customer_id`(`param_customer_id` INT) RETURNS double
    DETERMINISTIC
BEGIN

                  DECLARE temp_total_gold_payment double;

                  select sum(payment_gold.gold_received) into temp_total_gold_payment  from payment_gold where payment_gold.person_id = param_customer_id;

                  IF temp_total_gold_payment IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_gold_payment;
               END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_total_LC_payment_by_customer_id;
CREATE FUNCTION test_db.`get_total_LC_payment_by_customer_id`(`param_customer_id` INT) RETURNS double
    DETERMINISTIC
BEGIN

                  DECLARE temp_total_LC_payment double;

                  select sum(payment_cashes.cash_received) into temp_total_LC_payment  from payment_cashes where payment_cashes.person_id = param_customer_id;

                  IF temp_total_LC_payment IS NULL THEN
                      RETURN 0;
                  END IF;
                  RETURN temp_total_LC_payment;
               END;'
        );

        DB::unprepared('DROP FUNCTION IF EXISTS test_db.get_employee_balance;
CREATE FUNCTION test_db.`get_employee_balance`(`param_employee_id` INT , `param_material_id` INT  ) RETURNS double
    DETERMINISTIC
BEGIN
                  DECLARE temp_total_instock double;
                  DECLARE temp_total_outstock double;
                  DECLARE temp_total_balance double;


                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_instock from material_transaction_masters
                  inner join material_transaction_details
                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
                  where material_transaction_details.employee_id = param_employee_id
                  and material_transaction_masters.material_id = param_material_id
                  and material_transaction_details.transaction_value = 1;

                  select ifnull(sum(material_transaction_details.quantity),0)into temp_total_outstock from material_transaction_masters
                  inner join material_transaction_details
                  on material_transaction_details.transaction_masters_id = material_transaction_masters.id
                  where material_transaction_details.employee_id = param_employee_id
                  and material_transaction_masters.material_id = param_material_id
                  and material_transaction_details.transaction_value = -1;


                  select temp_total_instock - temp_total_outstock  into temp_total_balance;


                IF temp_total_balance IS NULL THEN
                    RETURN 0;
                END IF;
                RETURN temp_total_balance;
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
