<?php

use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\TimeInController;
use App\Models\EmpInfo;
use App\Models\MSDUserInfo;
use App\Models\PAMOUserInfo;
use App\Models\TempPassword;
use App\Models\TSDUserInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function(){
    return redirect(route('home'));
})->name('login');

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Route::get('print-passwords', function () {
    $passwords = TempPassword::all();
    return view('print-passwords', [
        'passwords' => $passwords
    ]);
});

Route::group(['prefix' => 'settings','as' => 'settings.'], function () {
    Route::middleware('auth')->group(function () {
        Route::get('', [SettingsController::class, 'settings'])->name('index');
        Route::post('update-password', [SettingsController::class, 'updatePassword'])->name('updatePassword');
    });
});

Route::get('/time-in', [TimeInController::class, 'index'])->name('timein');
Route::post('/time-in/attempt', [TimeInController::class, 'attempt'])->name('timein.attempt')->middleware('guest');
Route::get('/time-in/show', [TimeInController::class, 'show'])->name('timein.show')->middleware('auth');

Route::group(['prefix' => 'time-entries', 'as' => 'timeEntries.'], function () {
    Route::middleware('auth')->group(function () {
        Route::post('', [TimeEntryController::class, 'store'])->name('store');
        Route::get('print-dtr', [TimeEntryController::class, 'printDtr'])->name('printDtr');
    });
});

Route::group(['prefix' => 'accomplishments', 'as' => 'accomplishments.'], function () {
    Route::middleware('auth')->group(function () {
        Route::post('', [AccomplishmentController::class, 'store'])->name('store');
        Route::get('edit/{id}', [AccomplishmentController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [AccomplishmentController::class, 'update'])->name('update');
        Route::delete('{id}', [AccomplishmentController::class, 'delete'])->name('delete');
        Route::get('download-file/{id}', [AccomplishmentController::class, 'downloadFile'])->name('downloadFile');
        Route::delete('delete-file/{id}', [AccomplishmentController::class, 'deleteFile'])->name('deleteFile');
    });
});

Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
    Route::middleware('auth')->group(function () {
        Route::post('', [TaskController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TaskController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('{id}', [TaskController::class, 'delete'])->name('delete');
    });
});

Route::group(['prefix' => 'storages', 'as' => 'storage.'], function () {
    Route::middleware('auth')->group(function () {
        Route::get('view-image/{filename}', [AccomplishmentController::class, 'viewImage'])->name('viewImage');
    });
    
});

Route::get('/user-guide', function (Request $request) { return view('user-guide', [
    'title' => 'User Guide',
    'division' => $request->input('division'),
]); })->name('userGuides');


// Route::get('migrate', function () {
//     User::truncate();
//     EmpInfo::truncate();
//     TempPassword::truncate();
//     return DB::transaction(function () {
//         migrateUsers(MSDUserInfo::class, 'msd');
//         migrateUsers(TSDUserInfo::class, 'tsd');
//         migrateUsers(PAMOUserInfo::class, 'pamo');

//         return response()->json(['message' => 'Successfully migrated.']);
//     });
// });

// function migrateUsers($UserClass, $division) { 
//     $UserClass::whereIn('status', ['Permanent', 'COS'])->get()->map(function ($user) use ($division) {
//         $password = generatePassword($user->name);
//         $username = $user->status == 'Permanent' ? $user->SSN : $user->tin;
//         TempPassword::create([
//             'name' => $user->name,
//             'username' => $username,
//             'password' => $password,
//         ]);
//         $_user = User::create([
//             'name' => $user->name,
//             'username' => $username,
//             'password' => bcrypt($password),
//         ]);
//         EmpInfo::create([
//             'user_id' => $_user->id,
//             'userID' => $user->userID,
//             'badgeNumber' => $user->badgeNumber,
//             'SSN' => $user->SSN,
//             'name' => $user->name,
//             'gender' => $user->gender,
//             'position' => $user->position,
//             'contact' => $user->contact,
//             'birthday' => null,
//             'address' => $user->address,
//             'tin' => $user->tin,
//             'salary_type' => $user->salary_type,
//             'monthly_rate' => $user->monthly_rate,
//             'daily_rate' => $user->daily_rate,
//             'w_premium' => $user->w_premium,
//             'pap' => $user->pap,
//             'status' => $user->status,
//             'is_active' => $user->is_active,
//             'division' => $division
//         ]);
//     });
// }

// function generatePassword(string $name, int $length = 4): string
// {
//     // Extract initials from name (e.g., "Juan Dela Cruz" -> "JDC")
//     $words = preg_split('/\s+/', trim($name));
//     $initials = strtoupper(implode('', array_map(fn($w) => $w[0], $words)));

//     // Generate random number with given length
//     $randomNumber = str_pad((string)random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);

//     return $initials . $randomNumber;
// }