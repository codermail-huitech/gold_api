<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//testing purpose-------------
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/me', 'AuthController@me');

Route::group(array('prefix' => 'dev'), function() {

    //agent
    Route::get('/agents', 'AgentController@index');
    Route::post('/agents', 'AgentController@saveAgent');
    Route::get('/getDueByAgent','AgentController@getDueByAgent');

    //customer_category
    Route::get('/getCustomerCategory', 'CustomerCategoryController@getCustomerCategory');

    //product_category
    Route::get('/productCategory', 'ProductCategoryController@getProductCategories');

    //price_code
    Route::get('/priceCodes', 'PriceCodeController@getPriceCodes');

    //bill_master
    Route::post('/saveBillMaster', 'BillMasterController@saveBillMaster');

    //testing for stock bill save
    Route::post('/testBillSave', 'BillMasterController@testBillSave');



    //job_task
    Route::post('/getTotal', 'JobTaskController@getTotal');
    Route::get('/getAllTransactions/{id}', 'JobTaskController@getAllTransactions');
    Route::post('/saveReturn', 'JobTaskController@saveReturn');
    Route::post('/getJobTaskData', 'JobTaskController@getJobTaskData');
    Route::get('/savedJobs', 'JobTaskController@getSavedJobs');
    Route::get('/finishedJobs', 'JobTaskController@getFinishedJobs');
    Route::get('/getOneJobData/{id}', 'JobTaskController@getOneJobData');

    //job_master
    Route::post('/jobs', 'JobMasterController@saveJob');
    Route::post('/finishJob', 'JobMasterController@updateGrossWeight');
    Route::get('/getTotalGoldSendById/{id}', 'JobMasterController@getTotalGoldSendById');
    Route::get('/getTotalGoldReturnById/{id}', 'JobMasterController@getTotalGoldReturnById');
    Route::get('/getTotalPanSendById/{id}', 'JobMasterController@getTotalPanSendById');
    Route::get('/getTotalPanReturnById/{id}', 'JobMasterController@getTotalPanReturnById');
    Route::get('/getTotalNitricReturnById/{id}', 'JobMasterController@getTotalNitricReturnById');

    //rate
    Route::get('/getRates', 'RateController@getRates');
    Route::post('/saveRate', 'RateController@newRate');
    Route::delete('/deleteRate/{id}', 'RateController@deleteRate');
    Route::put('/updateRate', 'RateController@updateRate');

    //product
    Route::get('/products', 'ProductController@index');
    Route::post('/products', 'ProductController@saveProduct');
    Route::patch('/products', 'ProductController@updateProduct');
    Route::delete('/products/{id}', 'ProductController@deleteProduct');
    Route::post('/getProductData', 'ProductController@getProductData');

    //materials
    Route::get('/materials', 'MaterialController@getMaterials');
    Route::get('/orderMaterials', 'MaterialController@getOrderMaterials');

    //order_master
    Route::get('/orders', 'OrderMasterController@index');
    Route::patch('/orders', 'OrderMasterController@updateOrder');
    Route::patch('/orderMaster', 'OrderMasterController@updateMaster');
    Route::delete('/orderMasterDelete/{id}', 'OrderMasterController@deleteOrderMaster');
    Route::post('/orders', 'OrderMasterController@saveOrder');
    Route::post('/testSaveOrder', 'OrderMasterController@testSaveOrder');

    //customer
    Route::get('/customers', 'CustomerController@index');
    Route::post('/customers', 'CustomerController@saveCustomer');
    Route::patch('/customers/{id}', 'CustomerController@updateCustomer');
    Route::delete('/customers/{id}', 'CustomerController@deleteCustomer');
    Route::get('/completedBillCustomers', 'CustomerController@completedBillCustomers');
    Route::post('/getCompletedBIllDetails', 'CustomerController@getCompletedBIllDetails');
    Route::post('/getFinishedBillData', 'BillMasterController@getFinishedBillData');
    Route::get('/showCompletedBills/{id}', 'CustomerController@showCompletedBills');
    Route::get('/finishedJobsCustomers', 'CustomerController@finishedJobsCustomers');
    Route::post('/fetchingDetails', 'CustomerController@getDetails');
    Route::post('/getFinishedJobData', 'CustomerController@getFinishedJobData');
    Route::get('/getGoldquantity/{id}', 'CustomerController@getGoldQuantityBill');
    Route::get('/karigarhs', 'CustomerController@getkarigarhs');
    Route::get('/getTotalGoldQuantity/{id}', 'CustomerController@getTotalGoldQuantity');
    Route::get('/getEmployeeMaterial', 'CustomerController@getEmployeeMaterial');
    Route::get('/testGetEmployeeMaterial', 'CustomerController@testGetEmployeeMaterial');
    Route::get('/MyTest', 'CustomerController@MyTest');
    Route::get('/employeeTransactionTest/{id}', 'CustomerController@employeeTransactionTest');
    Route::get('/getCustomerPassbook/{id}', 'CustomerController@CustomerTransactionTest');
    //my testing
    Route::get('/testModel', 'CustomerController@testModel');
    Route::get('/joinTest', 'CustomerController@joinTest');



    //order_detail
    Route::post('/orderDetails', 'OrderDetailController@fetchingDetails');
    Route::delete('/ordersDetailsDelete/{id}', 'OrderDetailController@deleteOrder');


    //LC received
    Route::get('/getLCReceived','LCReceivedController@SaveReceivedGold');

    //Stock Controller
    Route::get('/getStockRecord','StockController@index');
    Route::post('/createStock','StockController@saveStock');
    Route::get('/getStockCustomer','StockController@getStockCustomer');
    Route::get('/getRecordByJobMasterId/{id}','StockController@getRecordByJobMasterId');
    Route::get('/getStockList','StockController@getStockList');

    //test_api
    Route::get('/show','StockController@show');



    // Route::get('/ getAllTransactions/{id}', 'JobTaskController@getAllTransactions');
    //Route::get('/finishedJobsCustomers1', 'CustomerController@testFinished');
    // Route::get('/orderMaterials', 'MaterialController@getOrderMaterials');

    //Transaction Controller

    Route::post('/saveTransaction','TransactionInfoController@saveTransaction');
    Route::get('/getEmployees','TransactionInfoController@getEmployees');


}); //dev area ended

//secured links here
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');

    //cash_payment
    Route::post('/saveCashPayment', 'PaymentCashController@saveCashPayment');

    //owner_transaction_type
    Route::get('/getTransactionType', 'TransactionTypeController@getTransactionType');

    //gold_payment
    Route::post('/saveGoldPayment', 'PaymentGoldController@saveGoldPayment');

    //bill_adjustment
    Route::get('/getBillAdjustment', 'BillAdjustmentController@getBillAdjustment');

    //agent
    Route::get('/agents', 'AgentController@index');
    Route::post('/agents', 'AgentController@saveAgent');
    Route::delete('/agents/{id}', 'AgentController@deleteAgent');
    Route::patch('/agents/{id}', 'AgentController@updateAgent');
    Route::get('/getDueByAgent','AgentController@getDueByAgent');
    Route::get('/getCustomerUnderAgent/{id}','AgentController@getCustomerUnderAgent');

    //customer_category
    Route::get('/getCustomerCategory', 'CustomerCategoryController@getCustomerCategory');

    //product_category
    Route::get('/productCategory', 'ProductCategoryController@getProductCategories');

    //stock_controller
    Route::get('/getStockRecord','StockController@index');

    //price_code
    Route::get('/priceCodes', 'PriceCodeController@getPriceCodes');

    //bill_master
    Route::post('/saveBillMaster', 'BillMasterController@saveBillMaster');

    //testing for stock bill save
    Route::post('/testBillSave', 'BillMasterController@testBillSave');

    //job_task
    Route::post('/getTotal', 'JobTaskController@getTotal');
    Route::get('/getAllTransactions/{id}', 'JobTaskController@getAllTransactions');
    Route::post('/saveReturn', 'JobTaskController@saveReturn');
    Route::post('/getJobTaskData', 'JobTaskController@getJobTaskData');
    Route::get('/savedJobs', 'JobTaskController@getSavedJobs');
    Route::get('/finishedJobs', 'JobTaskController@getFinishedJobs');
    Route::get('/getOneJobData/{id}', 'JobTaskController@getOneJobData');

    //job_master
    Route::post('/jobs', 'JobMasterController@saveJob');
    Route::post('/finishJob', 'JobMasterController@updateGrossWeight');


    //rate
    Route::get('/getRates', 'RateController@getRates');
    Route::post('/saveRate', 'RateController@newRate');
    Route::delete('/deleteRate/{id}', 'RateController@deleteRate');
    Route::put('/updateRate', 'RateController@updateRate');

    //product
    Route::get('/products', 'ProductController@index');
    Route::post('/products', 'ProductController@saveProduct');
    Route::patch('/products', 'ProductController@updateProduct');
    Route::delete('/products/{id}', 'ProductController@deleteProduct');
    Route::post('/getProductData', 'ProductController@getProductData');

    //materials
    Route::get('/materials', 'MaterialController@getMaterials');
    Route::get('/orderMaterials', 'MaterialController@getOrderMaterials');

    //order_master
    Route::get('/orders', 'OrderMasterController@index');
    Route::patch('/orders', 'OrderMasterController@updateOrder');
    Route::patch('/orderMaster', 'OrderMasterController@updateMaster');
    Route::delete('/orderMasterDelete/{id}', 'OrderMasterController@deleteOrderMaster');
    Route::post('/orders', 'OrderMasterController@saveOrder');
    Route::post('/testSaveOrder', 'OrderMasterController@testSaveOrder');

    //customer
    Route::get('/customers', 'CustomerController@index');
    Route::post('/customers', 'CustomerController@saveCustomer');
    Route::patch('/customers/{id}', 'CustomerController@updateCustomer');
    Route::delete('/customers/{id}', 'CustomerController@deleteCustomer');
    Route::get('/completedBillCustomers', 'CustomerController@completedBillCustomers');
    Route::post('/getCompletedBIllDetails', 'CustomerController@getCompletedBIllDetails');
    Route::post('/getFinishedBillData', 'BillMasterController@getFinishedBillData');
    Route::get('/showCompletedBills/{id}', 'CustomerController@showCompletedBills');
    Route::get('/finishedJobsCustomers', 'CustomerController@finishedJobsCustomers');
    Route::post('/fetchingDetails', 'CustomerController@getDetails');
    Route::post('/getFinishedJobData', 'CustomerController@getFinishedJobData');
    Route::get('/getGoldquantity/{id}', 'CustomerController@getGoldQuantityBill');
    Route::get('/karigarhs', 'CustomerController@getkarigarhs');
    Route::get('/getTotalGoldQuantity/{id}', 'CustomerController@getTotalGoldQuantity');
    Route::get('/testGetEmployeeMaterial', 'CustomerController@testGetEmployeeMaterial');
    Route::get('/getEmployeeMaterial', 'CustomerController@getEmployeeMaterial');
    Route::get('/myTest', 'CustomerController@MyTest');
    Route::get('/getCustomerPassbook/{id}', 'CustomerController@CustomerTransactionTest');




    //order_detail
    Route::post('/orderDetails', 'OrderDetailController@fetchingDetails');
    Route::delete('/ordersDetailsDelete/{id}', 'OrderDetailController@deleteOrder');

    //gold_receiveds
    Route::get('/getCompletedBills','GoldReceivedController@getCompletedBills');
    Route::post('/SaveReceivedGold','GoldReceivedController@SaveReceivedGold');

    //LC received
    Route::get('/getLCReceived','LCReceivedController@SaveReceivedGold');
    Route::post('/SaveLCReceived','LCReceivedController@SaveLCReceived');

    //Stock Controller

    Route::get('/getStockRecord','StockController@index');
    Route::post('/createStock','StockController@saveStock');
    Route::get('/getStockCustomer','StockController@getStockCustomer');
    Route::get('/getRecordByJobMasterId/{id}','StockController@getRecordByJobMasterId');
    Route::get('/getStockList','StockController@getStockList');
    Route::post('/updateStockByAgentId','StockController@updateStockByAgentId');
    Route::post('/updateStockByDefaultAgentId','StockController@updateStockByDefaultAgentId');

    //Material TransactionMaster Controller

    Route::post('/saveTransaction','MaterialTransactionMasterController@saveTransaction');
    Route::get('/getEmployees','MaterialTransactionMasterController@getEmployees');

    // Route::get('/agents', 'AgentController@index');

    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
