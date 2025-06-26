<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// *** Controladores de Autenticación (generalmente no se versionan de la misma manera que los recursos de la API) ***
// Estos controladores suelen permanecer en su namespace original `App\Http\Controllers\Auth`
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// *** Controladores de Recursos de la API (ahora en el nuevo namespace Api\V1) ***
// Asegúrate de que estos "use" statements apunten al nuevo namespace
use App\Http\Controllers\Api\V1\PatientController;    // Si tienes un PatientController en Api/V1
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\MedicalRecordController; 
use App\Http\Controllers\Api\V1\MedicationController;   
use App\Http\Controllers\Api\V1\PaymentController;    
use App\Http\Controllers\Api\V1\ReviewController;      
use App\Http\Controllers\Api\V1\StaffController;
use App\Http\Controllers\Api\V1\DashboardController;       

// =================================================================================================
// RUTAS PARA USUARIOS NO AUTENTICADOS (LOGIN/REGISTRO)
// Estas rutas no suelen tener un prefijo de versión de API (ej. /api/register, no /api/v1/register)
// =================================================================================================
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest'); // Asegura que solo invitados puedan registrarse

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest'); // Asegura que solo invitados puedan iniciar sesión


// =================================================================================================
// RUTAS PARA EL USUARIO AUTENTICADO (Ej. obtener datos del usuario logueado, logout)
// Estas rutas también suelen estar fuera del prefijo de versión de API,
// ya que son funcionalidades transversales a la autenticación.
// =================================================================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
});

// <--- ADD THIS ROUTE FOR THE DASHBOARD DATA ---
Route::get('/dashboard', [DashboardController::class, 'index']); // Or any other method name
// ---------------------------------------------


// =================================================================================================
// RUTAS DE LA API - VERSIÓN 1 (V1)
// Agrupamos todas las rutas de la versión 1 bajo el prefijo 'v1'
// y aplicamos el middleware 'auth:sanctum' a todo el grupo.
// También usamos 'name' para prefijar los nombres de ruta generados, útil para referencias.
// =================================================================================================
Route::prefix('v1')->name('api.v1.')->middleware(['auth:sanctum'])->group(function () {

    // Rutas de recursos para tus modelos, ahora apuntando a los controladores en Api\V1
    // La URL de acceso será por ejemplo: /api/v1/patients, /api/v1/doctors, etc.
    Route::apiResources([
        'patients' => PatientController::class,
        'doctors' => DoctorController::class,
        'appointments' => AppointmentController::class,
        'services' => ServiceController::class,
        'medical-records' => MedicalRecordController::class, // Incluir esta
        'medications' => MedicationController::class,       // Incluir esta
        'payments' => PaymentController::class,
        'reviews' => ReviewController::class,
        'staff' => StaffController::class,
    ]);
});

// =================================================================================================
// FUTURAS VERSIONES DE LA API (ej. V2)
// Si en el futuro necesitas una V2, simplemente crearías otro grupo de rutas:
// =================================================================================================
/*
Route::prefix('v2')->name('api.v2.')->middleware(['auth:sanctum'])->group(function () {
    use App\Http\Controllers\Api\V2\PatientController; // Tendrías que crear estos controladores
    // ...
    Route::apiResource('patients', PatientController::class);
    // ...
});
*/