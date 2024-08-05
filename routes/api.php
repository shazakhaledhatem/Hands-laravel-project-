<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\FeedbackController;


use App\Http\Controllers\Controller;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\EffectivenessController;

use App\Http\Controllers\TargetPeopleController;
use App\Http\Controllers\HealthCharitiesController;
use App\Http\Controllers\EducationCharitiesController;
use App\Http\Controllers\ReliefCharitiesController;
use App\Http\Controllers\LifehoodCharitiesController;
use App\Http\Controllers\OrdersthattransoformedfromeducationsController;
use App\Http\Controllers\OrdersthattransoformedfromhealthController;
use App\Http\Controllers\OrderthattransformedtospecificcharityController;
use App\Http\Controllers\OrdersthattransoformedfromreliefsController;
use App\Http\Controllers\OrdersthattransoformedfromlifehoodsController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FiniancialreportController;
use App\Http\Controllers\EffectivenessreportsController;
use App\Http\Controllers\OrderesfromemergencystatusController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\CaseFormController;
use App\Http\Controllers\JoinEffectivenessController;
use App\Http\Controllers\AssignOrdersVolunteerController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\CaseformHealthController;
use App\Http\Controllers\CaseformEducationController;
use App\Http\Controllers\CaseformReliefsController;
use App\Http\Controllers\CaseformLifehoodsController;
use App\Http\Controllers\EmeregencyStatusController;
use App\Helpers\NotificationFirebase;
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



//Route::post('/login','App\Http\Controllers\UserController@login');



Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::get('/index/health/charity', [UserController::class, 'indexhealth']);
Route::get('/index/education/charity', [UserController::class, 'indexeducation']);
Route::get('/index/relief/charity', [UserController::class, 'indexrelief']);
Route::get('/index/lifehood/charity', [UserController::class, 'indexlifehood']);
Route::get('/showcharity/{id}', [UserController::class, 'show']);
// Web route
//Route::post('/beneficiary/healthordersection',[BeneficiaryController::class, 'beneficiaryorderfromsection']);

//order from section
Route::middleware('api')->post('/beneficiary/order/health', [BeneficiaryController::class, 'beneficiaryorderfromhealthsection']);
Route::post('/beneficiary/order/education', [BeneficiaryController::class, 'beneficiaryorderfromeducationsection']);

Route::post('/beneficiary/order/relief', [BeneficiaryController::class, 'beneficiaryorderfromreliefsection']);
Route::post('/beneficiary/order/lifehood', [BeneficiaryController::class, 'beneficiaryorderfromlifehoodsection']);
//order from specific charity
Route::post('/beneficiary/order/health/{id}', [BeneficiaryController::class, 'beneficiaryorderfromhealthcharity']);
Route::post('/beneficiary/order/education/{id}', [BeneficiaryController::class, 'beneficiaryorderfromeducationcharity']);

Route::post('/beneficiary/order/relief/{id}', [BeneficiaryController::class, 'beneficiaryorderfromreliefcharity']);
Route::post('/beneficiary/order/lifehood/{id}', [BeneficiaryController::class, 'beneficiaryorderfromlifehoodcharity']);
Route::post('/beneficiary/emergencyorder', [OrderesfromemergencystatusController::class, 'beneficiaryemergencyorder']);
Route::get('/beneficiary/getneeds', [OrderesfromemergencystatusController::class, 'getneeds']);

Route::post('/feedback', [FeedbackController::class, 'store']);

Route::get('/userorders', [UserController::class, 'getUserOrders']);
Route::post('/updateuserinformation', [UserController::class, 'updateprofile']);
Route::get('/export',  [UserController::class, 'export']);

Route::post('/user/insertdonations/{charityId}', [DonationController::class, 'create']);
Route::get('/user/charitiesnamefordonations', [DonationController::class, 'getcharityname']);


Route::get('/user/getFinancialReportsByUserId', [DonationController::class, 'getFinancialReportsByUserId']);
/*
Route::post('/charity/register', [CharityController::class,'register']);
Route::post('/charity/login', [CharityController::class,'login']);
Route::get('/index', [CharityController::class, 'index']);
*/
//////////////////////////////////////////////////////Charity
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/index', [Controller::class, 'index']);
Route::post('/charity/register', [CharityController::class,'register']);
Route::post('/logout', [CharityController::class, 'logout']);


Route::middleware('auth:sanctum')->get('/charities', function (Request $request) {
   return Auth::user();

});
    Route::post('charity/login', [CharityController::class, 'login']);
Route::post('/effectiveness/create', [EffectivenessController::class,'createeffectiveness']);
Route::post('/effectiveness/update/{id}', [EffectivenessController::class,'update']);
Route::get('/effectiveness/show/{id}', [EffectivenessController::class,'show']);
Route::get('/effectiveness/index', [EffectivenessController::class,'index']);
Route::delete('/effectiveness/destroy/{id}', [EffectivenessController::class,'destroy']);


Route::post('/charitytargetpeople/complete', [TargetPeopleController::class,'completecharitytargetinformation']);
Route::get('/charitytargetpeople/index', [TargetPeopleController::class,'indexcharitytargetinformation']);
Route::post('/charitytargetpeople/update', [TargetPeopleController::class,'updatecharitytargetinformation']);


Route::get('/charity/getall/healthsection', [HealthCharitiesController::class,'index']);
Route::post('/charity/select/healthsection', [HealthCharitiesController::class,'selecthealthsection']);
Route::post('/charity/update/healthsection', [HealthCharitiesController::class,'updatehealthsection']);

Route::get('/charity/getall/educationsection', [EducationCharitiesController::class,'index']);
Route::post('/charity/select/educationsection', [EducationCharitiesController::class,'selecteducationsection']);
Route::post('/charity/update/educationsection', [EducationCharitiesController::class,'updateducationsection']);



Route::get('/charity/getall/reliefsection', [ReliefCharitiesController::class,'index']);
Route::post('/charity/select/reliefsection', [ReliefCharitiesController::class,'selectreliefsection']);
Route::post('/charity/update/reliefsection', [ReliefCharitiesController::class,'updatereliefsection']);



Route::get('/charity/getall/lifehoodsection', [LifehoodCharitiesController::class,'index']);
Route::post('/charity/select/lifehoodsection', [LifehoodCharitiesController::class,'selectlifehoodsection']);
Route::post('/charity/update/lifehoodsection', [LifehoodCharitiesController::class,'updatelifehoodsection']);

//index charity's order
Route::get('/charity/myorderpending/', [CharityController::class,'indexorderspending']);
Route::get('/charity/myorderaccepted/', [CharityController::class,'indexordersaccepted']);
Route::get('/charity/healthordersection/', [CharityController::class,'indexhealtsection']);
Route::get('/charity/reliefordersection/', [CharityController::class,'indexreliefsection']);
Route::get('/charity/educationordersection/', [CharityController::class,'indexeducationsection']);
Route::get('/charity/lifehoodordersection/', [CharityController::class,'indexlifehoodsection']);
Route::get('/charity/showDetailsOrder/{id}', [CharityController::class,'showDetailsOrder']);

Route::post('/charity/searchon orders', [CharityController::class, 'search']);


Route::post('/charity/acceptorders/{id}', [CharityController::class, 'acceptorders']);
Route::post('/charity/rejectorders/{id}', [CharityController::class, 'rejectorders']);
Route::post('/charity/completedorders/{id}', [CharityController::class, 'completedorders']);
Route::post('/charity/transformedorderstocaseform/{id}', [CharityController::class, 'transformedorderstocaseform']);


Route::post('/charity/acceptvolunteerorders/{volunterorderid}', [CharityController::class, 'acceptvolunteerorders']);
Route::post('/charity/rejectvolunteerorders/{volunterorderid}', [CharityController::class, 'rejectvolunteerorders']);
Route::get('/charity/indexvolunteerorders', [CharityController::class, 'indexvolunteerorders']);
Route::get('/charity/detailsvolunteerorders/{volunteerorderId}', [CharityController::class, 'detailsvolunteerorders']);



Route::post('/charity/transform/{id}', [OrdersthattransoformedfromeducationsController::class, 'transform']);
//Route::post('/charity/transformLifehood/{id}', [OrdersthattransoformedfromlifehoodsController::class, 'transformLifehood']);
//Route::post('/charity/transformrelief/{id}', [OrdersthattransoformedfromreliefsController::class, 'transformrelief']);
Route::post('/charity/transformCharity/{orderId}/{charityId}', [OrderthattransformedtospecificcharityController::class, 'transformCharity']);
Route::get('/charity/indexcharitiesintransformpage', [OrderthattransformedtospecificcharityController::class, 'indexcharitiesintransformpage']);
Route::post('/charity/Orderesfromemergency/{id}', [OrderesfromemergencystatusController::class, 'proccessemergencyorder']);
Route::get('/charity/OrderesfromemergencystatusController', [OrderesfromemergencystatusController::class, 'showemergencyorder']);
Route::get('/charity/detailsemergencyorder/{id}', [OrderesfromemergencystatusController::class, 'detailsemergencyorder']);

Route::get('/charity/indexdonations', [DonationController::class, 'index']);
Route::get('/charity/indexdonations/detailes/{donationId}', [DonationController::class, 'show']);


Route::get('/charity/getdonationsnameforreports', [FiniancialreportController::class, 'create']);
Route::post('/charity/createdonationreports/{donationId}', [FiniancialreportController::class, 'store']);
Route::get('/charity/indexdonationreport', [FiniancialreportController::class, 'index']);
Route::post('/charity/destroydonationreports/{donationId}', [FiniancialreportController::class, 'destroy']);
Route::post('/charity/updatedonationreports/{id}', [FiniancialreportController::class, 'update']);
//reports
Route::get('/charity/geteffectivenessnameforreports', [EffectivenessreportsController::class, 'create']);
Route::post('/charity/createeffectivenessreports/{effectivenessId}', [EffectivenessreportsController::class, 'store']);
Route::get('/charity/indexeffectivenessreport', [EffectivenessreportsController::class, 'index']);
Route::post('/charity/destroyeffectivenessreports/{reportId}', [EffectivenessreportsController::class, 'destroy']);
Route::post('/charity/updateeffectivenessreports/{id}', [EffectivenessreportsController::class, 'update']);


Route::get('/charity/indexVolunteersname', [AssignOrdersVolunteerController::class, 'indexVolunteersname']);
Route::post('/charity/assignordersvolunteer/{volunteerId}/{beneficiaryId}', [AssignOrdersVolunteerController::class, 'assignordersvolunteer']);


Route::post('/upload-slider-images', [SliderController::class, 'storeImages']);
Route::post('/indexImages', [SliderController::class, 'indexImages']);
Route::post('/deleteImage/{id}', [SliderController::class, 'deleteImage']);




Route::get('/charity/getCaseformsByCharity', [CharityController::class, 'getCaseformsByCharity']);









Route::get('/getemergencyactive', [EmeregencyStatusController::class, 'getemergencyactive']);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//volunterr
Route::post('/volunteer/createvolunteerOrder/{charityId}', [VolunteerController::class, 'createvolunteerOrder']);
Route::get('/volunteer/getcharityvolunteer', [VolunteerController::class, 'getcharityvolunteer']);

Route::post('/volunteer/storecaseform/{beneId}/{charityId}', [CaseFormController::class, 'store']);
Route::post('/volunteer/updatecaseform/{caseFormId}', [CaseFormController::class, 'update']);
Route::get('/volunteer/indexcaseform', [CaseFormController::class, 'index']);
Route::get('/volunteer/detailscaseform/{caseFormId}', [CaseFormController::class, 'show']);


Route::post('/volunteer/joinWithEffectiveness/{effectivenessId}', [JoinEffectivenessController::class, 'joinWithEffectiveness']);
Route::post('/volunteer/UnjoinWithEffectiveness/{effectivenessId}', [JoinEffectivenessController::class, 'UnjoinWithEffectiveness']);

Route::get('/volunteer/getassignedformcasetovolunteer', [AssignOrdersVolunteerController::class, 'getAssignedFormCaseToVolunteer']);

Route::post('/volunteer/createhealthcaseform/{assignId}', [CaseformHealthController::class, 'createhealthCaseform']);
Route::post('/volunteer/createducationCaseform/{assignId}', [CaseformEducationController::class, 'createducationCaseform']);
Route::post('/volunteer/createreliefCaseform/{assignId}', [CaseformReliefsController::class, 'createreliefCaseform']);
Route::post('/volunteer/createlifehoodCaseform/{assignId}', [CaseformLifehoodsController::class, 'createlifehoodCaseform']);
;

Route::post('/send-notification', function (Request $request) {
    $request->validate([
        'token' => 'required|string',
        'title' => 'required|string',
        'body' => 'required|string',
    ]);

    $notification = new NotificationFirebase();
    $response = $notification->send($request->input('token'), $request->input('title'), $request->input('body'));

    return response()->json($response);
});

Route::post('/send-multicast-notification', function (Request $request) {
    $request->validate([
        'tokens' => 'required|array',
        'title' => 'required|string',
        'body' => 'required|string',
    ]);

    $notification = new NotificationFirebase();
    $response = $notification->sendMulticast($request->input('tokens'), $request->input('title'), $request->input('body'));

    return response()->json(['success' => $response]);
});
