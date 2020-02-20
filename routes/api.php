<?php

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

Route::group([
    // 'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('reset', 'Auth\PasswordResetController@reset');
    Route::post('create', 'Auth\PasswordResetController@create');
    Route::get('find/{token}', 'Auth\PasswordResetController@find');
    Route::post('me', 'AuthController@me');
    Route::post('prueba', 'AuthController@prueba');
    Route::post('/user/permission/create', 'NewControllers\user\management\PermissionController@create');
    Route::post('/user/permission/search', 'NewControllers\user\management\PermissionController@search');
    Route::post('/user/permission/update', 'NewControllers\user\management\PermissionController@update');
    Route::post('/user/permission/delete', 'NewControllers\user\management\PermissionController@delete');
    Route::post('/user/rol/create', 'NewControllers\user\management\PermissionController@create_rol');
    Route::post('/user/rol/delete_rol', 'NewControllers\user\management\PermissionController@delete_rol');
    Route::post('/user/rol/searchs', 'NewControllers\user\management\PermissionController@searchs');
    Route::post('/user/rol/search', 'NewControllers\user\management\PermissionController@search_rol');
    Route::post('/user/rol/update_rol', 'NewControllers\user\management\PermissionController@update_rol');
    Route::post('/user/rol/update_permission_rol', 'NewControllers\user\management\PermissionController@update_permission_rol');

    Route::post('/company/create', 'NewControllers\company\CompanyController@create');
    Route::post('/company/searchs', 'NewControllers\company\CompanyController@searchs');
    Route::post('/company/update', 'NewControllers\company\CompanyController@update');
    Route::post('/company/list_company', 'NewControllers\company\CompanyController@list_company');

    Route::post('/contract/create', 'NewControllers\contract\ContractController@create');
    Route::post('/contract/searchs', 'NewControllers\contract\ContractController@searchs');
    Route::post('/contracts/list_contract', 'NewControllers\contract\ContractController@list_contract');
    Route::post('/contract/onchangesearchs', 'NewControllers\contract\ContractController@onchangesearchs');
    Route::post('/contract/update', 'NewControllers\contract\ContractController@update');
    Route::post('/list/contract', 'NewControllers\contract\ContractController@search_contracts');

    Route::post('/user/users/create', 'NewControllers\user\users\UsersController@create');
    Route::post('/user/users/update', 'NewControllers\user\users\UsersController@update');
    Route::post('/user/users/delete', 'NewControllers\user\users\UsersController@delete');
    Route::post('/user/users/searchs', 'NewControllers\user\users\UsersController@searchs');
    Route::post('/user/users/search_contract', 'NewControllers\user\users\UsersController@search_contract');
    Route::post('/user/users/delete_contract', 'NewControllers\user\users\UsersController@delete_contract');
    Route::post('/user/users/search_user', 'NewControllers\user\users\UsersController@search_user');

    Route::post('/login/login', 'NewControllers\login\LoginController@login');
    Route::post('/login/load_rol', 'NewControllers\login\LoginController@load_rol');

    Route::post('/employee/create', 'NewControllers\employee\EmployeeController@create');
    Route::post('/employee/search_employee', 'NewControllers\employee\EmployeeController@search_employee');
    Route::post('/employee/update', 'NewControllers\employee\EmployeeController@update');

    Route::get('/employee/autocomplete', 'NewControllers\employee\EmployeeController@autocomplete');
    Route::post('/employee/create_arl', 'NewControllers\employee\EmployeeController@create_arl');
    Route::post('/employee/search_arl', 'NewControllers\employee\EmployeeController@search_arl');
    Route::post('/employee/delete_arl', 'NewControllers\employee\EmployeeController@delete_arl');
    Route::post('/employee/search_eps', 'NewControllers\employee\EmployeeController@search_eps');
    Route::post('/employee/create_eps', 'NewControllers\employee\EmployeeController@create_eps');
    Route::post('/employee/delete_eps', 'NewControllers\employee\EmployeeController@delete_eps');
    Route::post('/employee/search_pension', 'NewControllers\employee\EmployeeController@search_pension');
    Route::post('/employee/create_pension', 'NewControllers\employee\EmployeeController@create_pension');
    Route::post('/employee/delete_pension', 'NewControllers\employee\EmployeeController@delete_pension');

    //servicios o obras de gas
    /////////////////////////////////////////-------------------------------------///////////////////////////
    Route::post('/typework/create', 'NewControllers\administration\work\TypeController@create');
    Route::post('/typework/update', 'NewControllers\administration\work\TypeController@update');
    Route::post('/typework/search', 'NewControllers\administration\work\TypeController@search');

    Route::post('/statework/search', 'NewControllers\administration\work\StateController@search');
    Route::post('/statework/create', 'NewControllers\administration\work\StateController@create');
    Route::post('/statework/update', 'NewControllers\administration\work\StateController@update');

    Route::post('/work/create', 'NewControllers\Work\WorkController@create');
    Route::post('/work/update', 'NewControllers\Work\WorkController@update');

    Route::get('/work/search', 'NewControllers\Work\WorkController@search');
    Route::get('/work/search_name', 'NewControllers\Work\WorkController@search_name');
    Route::get('/work/search_dni', 'NewControllers\Work\WorkController@search_dni');
    Route::get('/work/search_hub', 'NewControllers\Work\WorkController@search_hub');
    Route::post('/work/check', 'NewControllers\Work\ImportController@check');
    Route::post('/work/dataimport', 'NewControllers\Work\ImportController@dataimport');

    Route::post('/inspection/create', 'NewControllers\Inspection\InspectionController@create');
    Route::post('/inspection/update', 'NewControllers\Inspection\InspectionController@update');
    Route::get('/inspection/search', 'NewControllers\Inspection\InspectionController@search');

    /////////////////////////////////////////-------------------------------------///////////////////////////

    Route::get('/list/list_company', 'NewControllers\lists\ListController@list_company');

    //-------------------------------------------------///---------------------------------//---------------

    Route::post('/list/list_eps', 'NewControllers\lists\ListController@list_eps');
    Route::post('/list/list_arl', 'NewControllers\lists\ListController@list_arl');
    Route::post('/list/list_pension', 'NewControllers\lists\ListController@list_pension');
    Route::post('/list/list_service', 'NewControllers\lists\ListController@list_service');
    Route::post('/list/list_photos', 'NewControllers\lists\ListController@list_photos');
    Route::post('/list/list_municipality', 'NewControllers\lists\ListController@list_municipality');
    Route::post('/list/list_type_network', 'NewControllers\lists\ListController@list_type_network');
    Route::post('/list/list_photos_service', 'NewControllers\lists\ListController@list_photos_service');
    Route::post('/list/list_ubigeos', 'NewControllers\lists\ListController@list_ubigeos');
    Route::post('/list/list_provinces', 'NewControllers\lists\ListController@list_provinces');

    Route::post('/list/list_typework', 'NewControllers\lists\ListController@list_typework');
    Route::post('/list/list_statework', 'NewControllers\lists\ListController@list_statework');

    Route::post('/contract/list_contract_params', 'NewControllers\lists\ListController@list_contract_params');

    Route::post('/odi/create', 'NewControllers\odi\OdiController@create');
    Route::post('/odi/update', 'NewControllers\odi\OdiController@update');

    Route::get('/odi/autocomplete', 'NewControllers\odi\OdiController@autocomplete');
    Route::post('/odi/photoid', 'NewControllers\odi\OdiController@photoid');

    Route::post('/odi/send_image', 'NewControllers\odi\ImageController@Uploadimage');
    Route::post('/odi/search_image', 'NewControllers\odi\ImageController@search_image');
    Route::post('/odi/send_image_movil', 'NewControllers\odi\ImageController@send_image_movil');
    Route::post('/odi/delete_photo', 'NewControllers\odi\ImageController@delete_photo');

    Route::post('/odi/defectos', 'NewControllers\odi\OdiController@defectos');
    Route::post('/odi/search_defectos', 'NewControllers\odi\OdiController@search_defectos');
    Route::post('/odi/correcion_defectos', 'NewControllers\odi\OdiController@correcion_defectos');
    Route::post('/odi/search_correcion_defectos', 'NewControllers\odi\OdiController@search_correcion_defectos');
    Route::post('/odi/save_test', 'NewControllers\odi\OdiController@save_test');
    Route::post('/odi/search', 'NewControllers\odi\OdiController@search');
    Route::post('/odi/certficate_create', 'NewControllers\odi\OdiController@certficate_create');
    Route::post('/odi/certficate_search', 'NewControllers\odi\OdiController@certficate_search');

    Route::post('/odi/certficate_delete', 'NewControllers\odi\OdiController@certficate_delete');

    Route::get('/autocomplete/autocomplete_certicate', 'NewControllers\autocomplete\AutocompleteController@autocomplete_certicate');
    Route::post('/client/create', 'NewControllers\client\ClientController@create');
    Route::post('/client/create_account', 'NewControllers\client\ClientController@create_account');
    Route::post('/client/delete_account', 'NewControllers\client\ClientController@delete_account');
    Route::get('/client/search', 'NewControllers\client\ClientController@search');
    Route::post('/client/search_account', 'NewControllers\client\ClientController@search_account');

    Route::post('/movil/login', 'NewControllers\appmovil\AppMovilController@login');
    Route::post('/movil/totalasignadas', 'NewControllers\appmovil\AppMovilController@totalasignadas');
    Route::post('/movil/seach_asignadas', 'NewControllers\appmovil\AppMovilController@seach_asignadas');
    Route::post('/movil/photos_service', 'NewControllers\appmovil\AppMovilController@photos_service');
    Route::post('/movil/registerToken', 'NewControllers\appmovil\AppMovilController@registerToken');
    Route::get('/movil/search_materials', 'NewControllers\appmovil\AppMovilController@search_materials');
    Route::get('/movil/search_builder', 'NewControllers\appmovil\AppMovilController@search_builder');
    Route::get('/movil/search_builder', 'NewControllers\appmovil\AppMovilController@search_builder');
    Route::post('/movil/search_certificate', 'NewControllers\appmovil\AppMovilController@search_certificate');
    Route::post('/movil/save_certificate', 'NewControllers\appmovil\AppMovilController@save_certificate');
    Route::post('/movil/number', 'NewControllers\appmovil\AppMovilController@number_certificate');
    Route::post('/movil/ViewImage', 'NewControllers\appmovil\AppMovilController@ViewImage');
    Route::post('/movil/SaveService', 'NewControllers\appmovil\AppMovilController@SaveService');
    Route::post('/movil/SaveCliente', 'NewControllers\appmovil\AppMovilController@SaveCliente');
    Route::get('/movil/ListClient', 'NewControllers\appmovil\AppMovilController@SearchClient');
    Route::get('/movil/AutoListClient', 'NewControllers\appmovil\AppMovilController@AutoListClient');
    Route::post('/movil/ListAcount', 'NewControllers\appmovil\AppMovilController@ListAcount');
    Route::get('/movil/ListCity', 'NewControllers\appmovil\AppMovilController@ListCity');
    Route::get('/movil/AutoCity', 'NewControllers\appmovil\AppMovilController@AutoCity');
    Route::get('/movil/ListMaterial', 'NewControllers\appmovil\AppMovilController@ListMaterial');
    Route::get('/movil/AutoListMaterial', 'NewControllers\appmovil\AppMovilController@AutoListMaterial');
    Route::post('/materials/savemovil', 'NewControllers\administration\material\MaterialController@savemovil');
    Route::get('/movil/MaterialCertificate', 'NewControllers\appmovil\AppMovilController@MaterialCertificate');
    Route::get('/movil/listsic', 'NewControllers\appmovil\AppMovilController@listsic');
    Route::get('/movil/listcom', 'NewControllers\appmovil\AppMovilController@listcom');

    Route::post('/movil/certificate_material', 'NewControllers\appmovil\AppMovilController@certificate_material');
    Route::post('/movil/sic_builder', 'NewControllers\appmovil\AppMovilController@sic_builder');
    Route::post('/movil/com_builder', 'NewControllers\appmovil\AppMovilController@com_builder');

    Route::get('/movil/ListBuilder', 'NewControllers\appmovil\AppMovilController@ListBuilder');
    Route::get('/movil/ListBuilder', 'NewControllers\appmovil\AppMovilController@ListBuilder');
    Route::get('/movil/search_address', 'NewControllers\appmovil\AppMovilController@search_address');
    Route::post('/movil/change_state', 'NewControllers\appmovil\AppMovilController@change_state');
    Route::post('/movil/change_active', 'NewControllers\appmovil\AppMovilController@change_active');
    Route::post('/movil/change_active_service', 'NewControllers\appmovil\AppMovilController@change_active_service');

    Route::post('/photos/create', 'NewControllers\administration\photos\PhotosController@create');
    Route::post('/photos/search', 'NewControllers\administration\photos\PhotosController@search');

    Route::post('/photos/update', 'NewControllers\administration\photos\PhotosController@update');
    Route::post('/photos/delete', 'NewControllers\administration\photos\PhotosController@delete');

    Route::post('/network/create', 'NewControllers\administration\type_network\type_network@create');
    Route::post('/network/search', 'NewControllers\administration\type_network\type_network@search');
    Route::post('/network/update', 'NewControllers\administration\type_network\type_network@update');
    Route::post('/network/delete', 'NewControllers\administration\type_network\type_network@delete');
    Route::post('/network/create_photo', 'NewControllers\administration\type_network\type_network@create_photo');
    Route::post('/network/search_photo', 'NewControllers\administration\type_network\type_network@search_photo');
    Route::post('/network/delete_photo', 'NewControllers\administration\type_network\type_network@delete_photo');

    Route::post('/materials/create', 'NewControllers\administration\material\MaterialController@create');

    Route::post('/materials/search', 'NewControllers\administration\material\MaterialController@search');
    Route::post('/materials/update', 'NewControllers\administration\material\MaterialController@update');
    Route::post('/materials/create_certificate', 'NewControllers\administration\material\MaterialController@create_certificate');
    Route::post('/materials/search_certificate', 'NewControllers\administration\material\MaterialController@search_certificate');
    Route::post('/materials/send_document', 'NewControllers\administration\material\MaterialController@send_document');
    Route::post('/materials/search_document', 'NewControllers\administration\material\MaterialController@search_document');
    Route::post('/materials/delete_document', 'NewControllers\administration\material\MaterialController@delete_document');
    Route::post('/materials/delete', 'NewControllers\administration\material\MaterialController@delete');
    Route::post('/materials/update_certificate', 'NewControllers\administration\material\MaterialController@update_certificate');
    Route::post('/materials/delete_certificate', 'NewControllers\administration\material\MaterialController@delete_certificate');

    Route::post('/builder/create', 'NewControllers\administration\builder\BuilderController@create');
    Route::get('/builder/search', 'NewControllers\administration\builder\BuilderController@search');
    Route::post('/builder/create_sic', 'NewControllers\administration\builder\BuilderController@create_sic');
    Route::post('/builder/search_sic', 'NewControllers\administration\builder\BuilderController@search_sic');
    Route::post('/builder/send_document', 'NewControllers\administration\builder\BuilderController@send_document');
    Route::post('/builder/search_sic_document', 'NewControllers\administration\builder\BuilderController@search_sic_document');
    Route::post('/builder/delete_sic_document', 'NewControllers\administration\builder\BuilderController@delete_sic_document');
    Route::post('/builder/create_competition', 'NewControllers\administration\builder\BuilderController@create_competition');
    Route::post('/builder/search_competition', 'NewControllers\administration\builder\BuilderController@search_competition');
    Route::post('/builder/search_document_competition', 'NewControllers\administration\builder\BuilderController@search_document_competition');
    Route::post('/builder/delete_document_competition', 'NewControllers\administration\builder\BuilderController@delete_document_competition');
    Route::post('/builder/delete_competition', 'NewControllers\administration\builder\BuilderController@delete_competition');
    Route::post('/builder/delete', 'NewControllers\administration\builder\BuilderController@delete');

    Route::post('/competition/create', 'NewControllers\administration\competition\CompetitionController@save');
    Route::post('/competition/delete', 'NewControllers\administration\competition\CompetitionController@delete');
    Route::get('/competition/search', 'NewControllers\administration\competition\CompetitionController@search');

    Route::post('/certificate/create', 'NewControllers\administration\certificate\CertificateController@create');
    Route::post('/certificate/delete', 'NewControllers\administration\certificate\CertificateController@delete');
    Route::get('/certificate/search', 'NewControllers\administration\certificate\CertificateController@search');

    Route::get('/autocomplete/autocomplete_materials', 'NewControllers\autocomplete\AutocompleteController@AutocompleteMaterial');
    Route::get('/autocomplete/autocomplete_constrctor', 'NewControllers\autocomplete\AutocompleteController@AutocompleteConstructor');
    Route::get('/autocomplete/autocomplete_city', 'NewControllers\autocomplete\AutocompleteController@autocomplete_city');

    Route::post('/import/import', 'NewControllers\odi\ImporController@import');

    Route::post('/programming/search', 'NewControllers\odi\ProgrammingController@search');

    ///---------------------------actividades-------------------------------------------
    Route::post('/activities/create', 'NewControllers\operation\ActitiviControllers\ActivitiController@create');
    Route::post('/activities/search', 'NewControllers\operation\ActitiviControllers\ActivitiController@search');
    Route::post('/activities/update', 'NewControllers\operation\ActitiviControllers\ActivitiController@update');
    Route::post('/activities/delete', 'NewControllers\operation\ActitiviControllers\ActivitiController@delete');
    Route::post('/activities/save_activities', 'NewControllers\operation\ActitiviControllers\ActivitiController@save_activities');
    Route::post('/activities/search_activities', 'NewControllers\operation\ActitiviControllers\ActivitiController@search_activities');
    Route::post('/activities/search_activities', 'NewControllers\operation\ActitiviControllers\ActivitiController@search_activities');
    Route::post('/activities/delete_activities', 'NewControllers\operation\ActitiviControllers\ActivitiController@delete_activities');

    Route::post('/report/obra', 'NewControllers\report\ReportController@ReportObra');
    Route::get('/autocomplete/autocomplete_activities', 'NewControllers\autocomplete\AutocompleteController@autocomplete_activities');
});
