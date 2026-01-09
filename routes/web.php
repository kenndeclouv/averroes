<?php

/**
 * Dokumentasi dan Aturan Penulisan Route
 *
 * 1. Penulisan nama alias Class Controller
 *    Gunakan format RoleFitur untuk penamaan alias controller.
 *    Contoh: jika controller tersebut mengelola fitur home untuk role SuperAdmin,
 *    maka penamaannya adalah SuperAdminHome. Pastikan untuk mengikuti konvensi ini
 *    agar mudah dikenali dan dikelompokkan berdasarkan peran.
 *
 * 2. Menambah Route untuk Role Baru
 *    Ketika menambahkan route untuk role baru, gunakan format berikut:
 *
 *    Route::prefix('role')->name('role.')->middleware(['auth', 'can:isRole'])->group(function () {
 *        Route::redirect('/', '/role/home', 301); // Redirect ke halaman home role
 *        Route::get('home', [RoleHome::class, 'index'])->name('home'); // Mendefinisikan route home
 *        // Di sini, Kamu dapat menambahkan semua grup fitur lainnya yang relevan untuk role ini.
 *    });
 *
 * 3. Menambah Fitur di Dalam Route Role
 *    Jika Kamu ingin menambahkan fitur di dalam route untuk role tertentu,
 *    gunakan format berikut:
 *
 *    Route::prefix('fiture')->name('fiture.')->group(function () {
 *        // Definisikan semua metode HTTP yang diperlukan seperti get, post, put, delete
 *    });
 *
 * 4. Format penulisan (PENTING!!!)
 *
 *  Route::prefix('lowercase')->name('lowercase.')->middleware(['auth'],['can:isPascalCase'])->group(function () {
 *      Route::get('/', [PascalCase::class, 'camelCase'])->name('kebab-case');
 *      Route::put('lowercase/{camelCase}', [PascalCase::class, 'camelCase'])->name('kebab-case');
 *  });
 *
 *  © 2025 by kenndeclouv
 *  https://kenn.my.id
 */

// DEPENDENCIES
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\PushSubscription;
use Illuminate\Http\Request;

// GLOBAL CONTROLLER
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AccountController;

// SUPER ADMIN
use App\Http\Controllers\SuperAdmin\HomeController as SuperAdminHome;
use App\Http\Controllers\SuperAdmin\AdminController as SuperAdminAdmin;
use App\Http\Controllers\SuperAdmin\LogViewerController as SuperAdminLogViewer;
use App\Http\Controllers\SuperAdmin\TreeViewController as SuperAdminTreeView;
use App\Http\Controllers\SuperAdmin\RouteListController as SuperAdminRouteList;
use App\Http\Controllers\SuperAdmin\PerformanceController as SuperAdminPerformance;
use App\Http\Controllers\SuperAdmin\SystemController as SuperAdminSystem;
use App\Http\Controllers\SuperAdmin\DatabaseController as SuperAdminDatabase;
use App\Http\Controllers\SuperAdmin\PushSubscriptionController as SuperAdminPushSubscription;
use App\Http\Controllers\SuperAdmin\EnvController as SuperAdminEnv;
// ADMIN
use App\Http\Controllers\AdministrationAdmin\HomeController as AdministrationAdminHome;
use App\Http\Controllers\AdministrationAdmin\AnnouncementController as AdministrationAdminAnnouncement;
use App\Http\Controllers\AdministrationAdmin\ClassesController as AdministrationAdminClasses;
use App\Http\Controllers\AdministrationAdmin\RoomController as AdministrationAdminRoom;
use App\Http\Controllers\AdministrationAdmin\StudentController as AdministrationAdminStudent;
use App\Http\Controllers\AdministrationAdmin\StudentPermitController as AdministrationAdminStudentPermit;
use App\Http\Controllers\AdministrationAdmin\TeacherController as AdministrationAdminTeacher;
use App\Http\Controllers\AdministrationAdmin\StudentRegistrantController as AdministrationAdminStudentRegistrant;
use App\Http\Controllers\AdministrationAdmin\AppSettingController as AdministrationAdminAppSetting;
use App\Http\Controllers\AdministrationAdmin\TransactionController as AdministrationAdminTransaction;
use App\Http\Controllers\AdministrationAdmin\TeachingJournalController as AdministrationAdminTeachingJournal;
use App\Http\Controllers\AdministrationAdmin\TeachingSubjectController as AdministrationAdminTeachingSubject;

// TEACHER
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncement;
use App\Http\Controllers\Teacher\StudentPermitController as TeacherStudentPermit;
use App\Http\Controllers\Teacher\TeachingJournalController as TeacherTeachingJournal;
use App\Http\Controllers\Teacher\QuizController as TeacherQuiz;
use App\Http\Controllers\Teacher\MaterialController as TeacherMaterial;

// STUDENT
use App\Http\Controllers\Student\StudentPermitController as StudentStudentPermit;
use App\Http\Controllers\Student\QuizController as StudentQuiz;
use App\Http\Controllers\Student\MaterialController as StudentMaterial;
use App\Http\Controllers\AdministrationAdmin\MaterialController as AdminMaterial;

// STUDENT REGISTRANT
use App\Http\Controllers\StudentRegistrant\HomeController as StudentRegistrantHome;
// TREASURER
use App\Http\Controllers\Treasurer\HomeController as TreasurerHome;
use App\Http\Controllers\Treasurer\TransactionController as TreasurerTransaction;


/**
 * **Root**
 */
Route::get('/', function () {
    return view('index');
});

/**
 * **Auth Routes**
 */
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'email'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'reset'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'update'])->middleware('guest')->name('password.update');

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend', 'throttle:6,1'])->middleware('auth')->name('verification.send');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('auth')->name('verification.verify');

Route::post('/api/subscribe', function (Request $request) {
    $user = Auth::user();
    PushSubscription::create([
        'user_id' => $user->id,
        'data' => $request->getContent()
    ]);
    return response()->json(['message' => 'Subscribed to push notifications!']);
})->name('subscribe');

/**
 * **Common Routes**
 */
Route::prefix('account')->name('account.')->middleware(['auth'])->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::put('update/{user}', [AccountController::class, 'update'])->name('update');
    Route::put('updatestudent/{student}', [AccountController::class, 'updateStudent'])->name('update-student');
    Route::put('updateteacher/{teacher}', [AccountController::class, 'updateTeacher'])->name('update-teacher');
});
Route::prefix('chat')->name('chat.')->middleware(['auth'])->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('contacts', [ChatController::class, 'contacts'])->name('contacts');
    Route::post('send/', [ChatController::class, 'send'])->name('send');
    Route::get('history/{recipientId}', [ChatController::class, 'history'])->name('history');
    Route::post('read/', [ChatController::class, 'read'])->name('read');
    Route::post('setstatus/{user}', [ChatController::class, 'setStatus'])->name('set-status');
    Route::put('edituser/{user}', [ChatController::class, 'editUser'])->name('edit-user');
});
Route::prefix('kanban')->name('kanban.')->middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('common.kanban.index');
    })->name('index');
    // Route::get('/', [KanbanController::class, 'index'])->name('index');
    // Route::post('create', [KanbanController::class, 'create'])->name('create');
    // Route::put('update/{task}', [KanbanController::class, 'update'])->name('update');
    // Route::delete('delete/{task}', [KanbanController::class, 'destroy'])->name('destroy');
});

/**
 * **Super Admin Routes**
 */
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'can:isSuperAdmin'])->group(function () {
    Route::redirect('/', '/superadmin/home', 301);
    Route::get('home', [SuperAdminHome::class, 'index'])->name('home');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [SuperAdminAdmin::class, 'index'])->name('index');
        Route::get('create', [SuperAdminAdmin::class, 'create'])->name('create');
        Route::post('store', [SuperAdminAdmin::class, 'store'])->name('store');
        Route::get('show/{admin}', [SuperAdminAdmin::class, 'show'])->name('show');
        Route::get('edit/{admin}', [SuperAdminAdmin::class, 'edit'])->name('edit');
        Route::put('update/{admin}', [SuperAdminAdmin::class, 'update'])->name('update');
        Route::delete('destroy/{admin}', [SuperAdminAdmin::class, 'destroy'])->name('destroy');

        Route::get('/{admin}/permissions', [SuperAdminAdmin::class, 'permissions'])->name('permissions');
        Route::post('/{admin}/permissions', [SuperAdminAdmin::class, 'permissionsStore'])->name('permissions-store');
        // Route::delete('/{admin}/permissions/{permission}/delete', [SuperAdminAdmin::class, 'permissionsDestroy'])->name('permissions-destroy');
        Route::delete('superadmin/admin/permissions/{permission}', [SuperAdminAdmin::class, 'permissionsDestroy'])->name('permissions-destroy')->where('permission', '[0-9]+');
    });
    Route::prefix('logviewer')->name('logs.')->group(function () {
        Route::get('/', [SuperAdminLogViewer::class, 'index'])->name('index');
        Route::get('/show/{filename}', [SuperAdminLogViewer::class, 'show'])->name('show');
        Route::delete('/delete/{filename}', [SuperAdminLogViewer::class, 'destroy'])->name('destroy');
        Route::get('/download/{filename}', [SuperAdminLogViewer::class, 'download'])->name('download');
    });
    Route::prefix('foldertree')->name('foldertree.')->middleware(['auth'])->group(function () {
        Route::get('/', [SuperAdminTreeView::class, 'index'])->name('index');
    });
    Route::prefix('routelist')->name('routelist.')->group(function () {
        Route::get('/', [SuperAdminRouteList::class, 'index'])->name('index');
    });
    Route::prefix('performance')->name('performance.')->group(function () {
        Route::get('/', [SuperAdminPerformance::class, 'index'])->name('index');
    });
    Route::prefix('database')->name('database.')->group(function () {
        Route::get('/', [SuperAdminDatabase::class, 'index'])->name('index');
        Route::get('/database', [SuperAdminDatabase::class, 'indexDatabase'])->name('index-database');
        Route::get('/indexsql', [SuperAdminDatabase::class, 'indexSql'])->name('index-sql');
        Route::post('/sql', [SuperAdminDatabase::class, 'sql'])->name('sql');
        Route::get('/show/{tableName}', [SuperAdminDatabase::class, 'showTable'])->name('show');
        Route::post('/store/{tableName}', [SuperAdminDatabase::class, 'store'])->name('store');
        Route::put('/update/{tableName}/{id}', [SuperAdminDatabase::class, 'update'])->name('update');
        Route::delete('/destroy/{tableName}/{id}', [SuperAdminDatabase::class, 'destroy'])->name('destroy');
        Route::delete('/empty/{tableName}', [SuperAdminDatabase::class, 'empty'])->name('empty');
    });

    Route::prefix('system')->name('system.')->group(function () {
        Route::get('/', [SuperAdminSystem::class, 'index'])->name('index');
        Route::post('runcli', [SuperAdminSystem::class, 'runCLI'])->name('run-cli');
    });

    Route::prefix('notification')->name('notification.')->group(function () {
        Route::get('/', [SuperAdminPushSubscription::class, 'index'])->name('index');
        Route::post('send/{sub}', [SuperAdminPushSubscription::class, 'sendNotification'])->name('send');
        Route::post('send-all', [SuperAdminPushSubscription::class, 'sendNotificationToAll'])->name('send-all');
    });

    Route::prefix('env')->name('env.')->group(function () {
        Route::get('/', [SuperAdminEnv::class, 'index'])->name('index');
        Route::put('update', [SuperAdminEnv::class, 'update'])->name('update');
    });
});

/**
 * **Administration Admin Routes**
 */
Route::prefix('administrationadmin')->name('administrationadmin.')->middleware(['auth', 'can:isAdministrationAdmin'])->group(function () {
    Route::redirect('/', '/administrationadmin/home', 301);
    Route::get('home', [AdministrationAdminHome::class, 'index'])->name('home');

    Route::prefix('student')->name('student.')->middleware('permission:show_student')->group(function () {
        Route::get('/', [AdministrationAdminStudent::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminStudent::class, 'create'])->middleware('permission:create_student')->name('create');
        Route::post('store', [AdministrationAdminStudent::class, 'store'])->middleware('permission:create_student')->name('store');
        Route::get('show/{student}', [AdministrationAdminStudent::class, 'show'])->middleware('permission:show_student')->name('show');
        Route::get('edit/{student}', [AdministrationAdminStudent::class, 'edit'])->middleware('permission:edit_student')->name('edit');
        Route::put('update/{student}', [AdministrationAdminStudent::class, 'update'])->middleware('permission:edit_student')->name('update');
        Route::delete('destroy/{student}', [AdministrationAdminStudent::class, 'destroy'])->middleware('permission:delete_student')->name('destroy');

        Route::prefix('graduate')->name('graduate.')->group(function () {
            Route::get('/', [AdministrationAdminStudent::class, 'graduateIndex'])->name('index');
            Route::put('{student}', [AdministrationAdminStudent::class, 'graduate'])->middleware('permission:edit_student')->name('graduate');
            Route::put('undo/{student}', [AdministrationAdminStudent::class, 'undoGraduate'])->middleware('permission:edit_student')->name('undo-graduate');
        });

        Route::prefix('nis')->name('nis.')->middleware(['permission:show_student'])->group(function () {
            Route::get('/', [AdministrationAdminStudent::class, 'nisIndex'])->name('index');
            Route::put('update/{student}', [AdministrationAdminStudent::class, 'nisUpdate'])->middleware('permission:edit_student')->name('update');
            Route::delete('destroy/{student}', [AdministrationAdminStudent::class, 'nisDestroy'])->middleware('permission:delete_student')->name('destroy');
            Route::put('auto-generate/{student}', [AdministrationAdminStudent::class, 'nisAutoGenerate'])->middleware('permission:edit_student')->name('auto-generate');
        });
    });
    Route::prefix('teacher')->name('teacher.')->middleware(['permission:show_teacher'])->group(function () {
        Route::get('/', [AdministrationAdminTeacher::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminTeacher::class, 'create'])->middleware('permission:create_teacher')->name('create');
        Route::post('store', [AdministrationAdminTeacher::class, 'store'])->middleware('permission:create_teacher')->name('store');
        Route::get('show/{teacher}', [AdministrationAdminTeacher::class, 'show'])->middleware('permission:show_teacher')->name('show');
        Route::get('edit/{teacher}', [AdministrationAdminTeacher::class, 'edit'])->middleware('permission:edit_teacher')->name('edit');
        Route::put('update/{teacher}', [AdministrationAdminTeacher::class, 'update'])->middleware('permission:edit_teacher')->name('update');
        Route::delete('destroy/{teacher}', [AdministrationAdminTeacher::class, 'destroy'])->middleware('permission:delete_teacher')->name('destroy');

        Route::prefix('nip')->name('nip.')->middleware(['permission:show_teacher'])->group(function () {
            Route::get('/', [AdministrationAdminTeacher::class, 'nipIndex'])->name('index');
            Route::put('update/{teacher}', [AdministrationAdminTeacher::class, 'nipUpdate'])->middleware('permission:edit_teacher')->name('update');
            Route::delete('destroy/{teacher}', [AdministrationAdminTeacher::class, 'nipDestroy'])->middleware('permission:delete_teacher')->name('destroy');
            Route::put('auto-generate/{teacher}', [AdministrationAdminTeacher::class, 'nipAutoGenerate'])->middleware('permission:edit_teacher')->name('auto-generate');
        });
    });
    Route::prefix('class')->name('class.')->middleware(['permission:show_class'])->group(function () {
        Route::get('/', [AdministrationAdminClasses::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminClasses::class, 'create'])->middleware('permission:create_class')->name('create');
        Route::post('store', [AdministrationAdminClasses::class, 'store'])->middleware('permission:create_class')->name('store');
        Route::get('show/{class}', [AdministrationAdminClasses::class, 'show'])->middleware('permission:show_class')->name('show');
        Route::get('edit/{class}', [AdministrationAdminClasses::class, 'edit'])->middleware('permission:edit_class')->name('edit');
        Route::put('update/{class}', [AdministrationAdminClasses::class, 'update'])->middleware('permission:edit_class')->name('update');
        Route::delete('destroy/{class}', [AdministrationAdminClasses::class, 'destroy'])->middleware('permission:delete_class')->name('destroy');
        Route::get('list/{class}', [AdministrationAdminClasses::class, 'list'])->middleware('permission:show_class')->name('list');

        Route::delete('list/deletestudent/{student}', [AdministrationAdminClasses::class, 'deleteStudentFromClass'])->middleware('permission:delete_student_from_room')->name('delete-student-from-class');
        Route::get('list/add-student/{class}', [AdministrationAdminClasses::class, 'addStudentToClassForm'])->middleware('permission:add_student_to_room')->name('add-student-to-class-form');
        Route::post('list/add-student/{class}', [AdministrationAdminClasses::class, 'addStudentToClass'])->middleware('permission:add_student_to_room')->name('add-student-to-class');
    });
    Route::prefix('room')->name('room.')->middleware(['permission:show_room'])->group(function () {
        Route::get('/', [AdministrationAdminRoom::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminRoom::class, 'create'])->middleware('permission:create_room')->name('create');
        Route::post('store', [AdministrationAdminRoom::class, 'store'])->middleware('permission:create_room')->name('store');
        Route::get('show/{room}', [AdministrationAdminRoom::class, 'show'])->middleware('permission:show_room')->name('show');
        Route::get('edit/{room}', [AdministrationAdminRoom::class, 'edit'])->middleware('permission:edit_room')->name('edit');
        Route::put('update/{room}', [AdministrationAdminRoom::class, 'update'])->middleware('permission:edit_room')->name('update');
        Route::delete('destroy/{room}', [AdministrationAdminRoom::class, 'destroy'])->middleware('permission:delete_room')->name('destroy');
        Route::get('list/{room}', [AdministrationAdminRoom::class, 'list'])->middleware('permission:show_room')->name('list');
        Route::delete('list/deletestudent/{student}', [AdministrationAdminRoom::class, 'deleteStudentFromRoom'])->middleware('permission:delete_student_from_room')->name('delete-student-from-room');
        Route::get('list/addstudent/{room}', [AdministrationAdminRoom::class, 'addStudentToRoomForm'])->middleware('permission:add_student_to_room')->name('add-student-to-room-form');
        Route::post('list/addstudent/{room}', [AdministrationAdminRoom::class, 'addStudentToRoom'])->middleware('permission:add_student_to_room')->name('add-student-to-room');
    });
    Route::prefix('studentpermit')->name('studentpermit.')->middleware(['permission:show_student_permit'])->group(function () {
        Route::get('/', [AdministrationAdminStudentPermit::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminStudentPermit::class, 'create'])->middleware('permission:create_student_permit')->name('create');
        Route::post('store', [AdministrationAdminStudentPermit::class, 'store'])->middleware('permission:create_student_permit')->name('store');
        Route::get('show/{studentPermit}', [AdministrationAdminStudentPermit::class, 'show'])->middleware('permission:show_student_permit')->name('show');
        Route::get('edit/{studentPermit}', [AdministrationAdminStudentPermit::class, 'edit'])->middleware('permission:edit_student_permit')->name('edit');
        Route::put('update/{studentPermit}', [AdministrationAdminStudentPermit::class, 'update'])->middleware('permission:edit_student_permit')->name('update');
        Route::delete('destroy/{studentPermit}', [AdministrationAdminStudentPermit::class, 'destroy'])->middleware('permission:delete_student_permit')->name('destroy');
    });
    Route::prefix('announcement')->name('announcement.')->middleware(['permission:show_announcement'])->group(function () {
        Route::get('/', [AdministrationAdminAnnouncement::class, 'index'])->name('index');
        Route::get('create', [AdministrationAdminAnnouncement::class, 'create'])->middleware('permission:create_announcement')->name('create');
        Route::post('store', [AdministrationAdminAnnouncement::class, 'store'])->middleware('permission:create_announcement')->name('store');
        Route::get('show/{announcement}', [AdministrationAdminAnnouncement::class, 'show'])->middleware('permission:show_announcement')->name('show');
        Route::get('edit/{announcement}', [AdministrationAdminAnnouncement::class, 'edit'])->middleware('permission:edit_announcement')->name('edit');
        Route::put('update/{announcement}', [AdministrationAdminAnnouncement::class, 'update'])->middleware('permission:edit_announcement')->name('update');
        Route::delete('destroy/{announcement}', [AdministrationAdminAnnouncement::class, 'destroy'])->middleware('permission:delete_announcement')->name('destroy');
    });
    Route::prefix('studentregistrant')->name('studentregistrant.')->middleware(['permission:show_student_registrant'])->group(function () {
        Route::get('/', [AdministrationAdminStudentRegistrant::class, 'index'])->name('index');
        Route::get('show/{studentRegistrant}', [AdministrationAdminStudentRegistrant::class, 'show'])->middleware('permission:show_student_registrant')->name('show');
        Route::put('approve/{studentRegistrant}', [AdministrationAdminStudentRegistrant::class, 'approve'])->middleware('permission:edit_student_registrant')->name('approve');
        Route::put('reject/{studentRegistrant}', [AdministrationAdminStudentRegistrant::class, 'reject'])->middleware('permission:edit_student_registrant')->name('reject');
        Route::delete('destroy/{studentRegistrant}', [AdministrationAdminStudentRegistrant::class, 'destroy'])->middleware('permission:delete_student_registrant')->name('destroy');

        Route::get('indexuser', [AdministrationAdminStudentRegistrant::class, 'indexUser'])->middleware('permission:show_student_registrant_user')->name('index-user');
        Route::get('createuser', [AdministrationAdminStudentRegistrant::class, 'createUser'])->middleware('permission:create_student_registrant_user')->name('create-user');
        Route::post('storeuser', [AdministrationAdminStudentRegistrant::class, 'storeUser'])->middleware('permission:create_student_registrant_user')->name('store-user');
        Route::get('edituser/{user}', [AdministrationAdminStudentRegistrant::class, 'editUser'])->middleware('permission:edit_student_registrant_user')->name('edit-user');
        Route::put('updateuser/{user}', [AdministrationAdminStudentRegistrant::class, 'updateUser'])->middleware('permission:edit_student_registrant_user')->name('update-user');
        Route::delete('destroyuser/{user}', [AdministrationAdminStudentRegistrant::class, 'destroyUser'])->middleware('permission:delete_student_registrant_user')->name('destroy-user');
    });

    Route::prefix('appsetting')->name('appsetting.')->middleware(['permission:show_app_setting'])->group(function () {
        Route::get('/', [AdministrationAdminAppSetting::class, 'index'])->name('index');
        Route::put('/update', [AdministrationAdminAppSetting::class, 'update'])->name('update');
    });


    // TRANSACTION
    Route::prefix('transaction')->name('transaction.')->middleware(['permission:show_transaction'])->group(function () {
        Route::get('/', [AdministrationAdminTransaction::class, 'index'])->name('index');
        Route::get('show/{transaction}', [AdministrationAdminTransaction::class, 'show'])->name('show');
    });

    // TEACHING JOURNAL
    Route::resource('journals', AdministrationAdminTeachingJournal::class);

    // TEACHING SUBJECTS
    Route::resource('teaching-subjects', AdministrationAdminTeachingSubject::class);

    // SEMESTERS
    Route::resource('semesters', \App\Http\Controllers\Admin\SemesterController::class);

    // MATERIALS
    Route::resource('materials', AdminMaterial::class)->only(['index', 'destroy', 'show']);

    // QUIZZES
    Route::resource('quizzes', \App\Http\Controllers\AdministrationAdmin\QuizController::class)->only(['index', 'show', 'destroy']);

    // CLASS SCHEDULES
    Route::resource('class-schedules', \App\Http\Controllers\AdministrationAdmin\ClassScheduleController::class);
});

/**
 * **Teacher Routes**
 */
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'can:isTeacher'])->group(function () {
    Route::redirect('/', '/teacher/home', 301);
    Route::get('home', [AdministrationAdminHome::class, 'index'])->name('home');

    Route::prefix('studentpermit')->name('studentpermit.')->group(function () {
        Route::get('/', [TeacherStudentPermit::class, 'index'])->name('index');
        Route::get('create', [TeacherStudentPermit::class, 'create'])->name('create');
        Route::post('store', [TeacherStudentPermit::class, 'store'])->name('store');
        Route::get('show/{studentPermit}', [TeacherStudentPermit::class, 'show'])->name('show');
        Route::get('edit/{studentPermit}', [TeacherStudentPermit::class, 'edit'])->name('edit');
        Route::put('update/{studentPermit}', [TeacherStudentPermit::class, 'update'])->name('update');
        Route::delete('destroy/{studentPermit}', [TeacherStudentPermit::class, 'destroy'])->name('destroy');
        Route::put('approve/{studentPermit}', [TeacherStudentPermit::class, 'approve'])->name('approve');
        Route::put('reject/{studentPermit}', [TeacherStudentPermit::class, 'reject'])->name('reject');
    });
    Route::prefix('announcement')->name('announcement.')->group(function () {
        Route::get('/', [TeacherAnnouncement::class, 'index'])->name('index');
        Route::get('create', [TeacherAnnouncement::class, 'create'])->name('create');
        Route::post('store', [TeacherAnnouncement::class, 'store'])->name('store');
        Route::get('show/{announcement}', [TeacherAnnouncement::class, 'show'])->name('show');
        Route::get('edit/{announcement}', [TeacherAnnouncement::class, 'edit'])->name('edit');
        Route::put('update/{announcement}', [TeacherAnnouncement::class, 'update'])->name('update');
        Route::delete('destroy/{announcement}', [TeacherAnnouncement::class, 'destroy'])->name('destroy');
    });

    // TEACHING JOURNAL
    Route::resource('journals', TeacherTeachingJournal::class);

    // QUIZZES
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [TeacherQuiz::class, 'index'])->name('index');
        Route::get('create', [TeacherQuiz::class, 'create'])->name('create');
        Route::post('store', [TeacherQuiz::class, 'store'])->name('store');
        Route::get('edit/{quiz}', [TeacherQuiz::class, 'edit'])->name('edit');
        Route::put('update/{quiz}', [TeacherQuiz::class, 'update'])->name('update');
        Route::delete('destroy/{quiz}', [TeacherQuiz::class, 'destroy'])->name('destroy');

        // Question Routes
        Route::post('{quiz}/questions', [TeacherQuiz::class, 'storeQuestion'])->name('questions.store');
        Route::put('{quiz}/questions/{question}', [TeacherQuiz::class, 'updateQuestion'])->name('questions.update');
        Route::delete('questions/{question}', [TeacherQuiz::class, 'destroyQuestion'])->name('questions.destroy');

        // Results
        Route::get('{quiz}/results', [TeacherQuiz::class, 'results'])->name('results');
        Route::get('attempts/{attempt}', [TeacherQuiz::class, 'showAttempt'])->name('attempts.show');
        Route::put('attempts/{attempt}/grade', [TeacherQuiz::class, 'gradeAttempt'])->name('attempts.grade');
        Route::delete('attempts/{attempt}/reset', [TeacherQuiz::class, 'resetAttempt'])->name('attempts.reset');
    });

    // MATERIALS
    Route::resource('materials', TeacherMaterial::class);
});

/**
 * **Student Routes**
 */
Route::prefix('student')->name('student.')->middleware(['auth', 'can:isStudent'])->group(function () {
    Route::redirect('/', '/student/home', 301);
    Route::get('home', [AdministrationAdminHome::class, 'index'])->name('home');

    Route::prefix('permit')->name('permit.')->group(function () {
        Route::get('/', [StudentStudentPermit::class, 'index'])->name('index');
        Route::get('create', [StudentStudentPermit::class, 'create'])->name('create');
        Route::post('store', [StudentStudentPermit::class, 'store'])->name('store');
        Route::get('show/{studentPermit}', [StudentStudentPermit::class, 'show'])->name('show');
        Route::get('edit/{studentPermit}', [StudentStudentPermit::class, 'edit'])->name('edit');
        Route::put('update/{studentPermit}', [StudentStudentPermit::class, 'update'])->name('update');
        Route::delete('destroy/{studentPermit}', [StudentStudentPermit::class, 'destroy'])->name('destroy');
    });

    // QUIZZES
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [StudentQuiz::class, 'index'])->name('index');
        Route::get('take/{quiz}', [StudentQuiz::class, 'show'])->name('take');
        Route::post('submit/{quiz}', [StudentQuiz::class, 'store'])->name('submit');
        Route::post('autosave/{quiz}', [StudentQuiz::class, 'currentSave'])->name('autosave');
        Route::get('result/{quiz}', [StudentQuiz::class, 'result'])->name('result');
        Route::get('review/{quiz}', [StudentQuiz::class, 'review'])->name('review');
    });

    // MATERIALS
    Route::get('materials', [StudentMaterial::class, 'index'])->name('materials.index');
    Route::get('materials/{material}', [StudentMaterial::class, 'show'])->name('materials.show');
});


/**
 * **Student Registrant Routes**
 */
Route::prefix('studentregistrant')->name('studentregistrant.')->middleware(['auth', 'can:isStudentRegistrant'])->group(function () {
    Route::redirect('/', '/studentregistrant/home', 301);
    Route::get('home', [StudentRegistrantHome::class, 'index'])->name('home');

    Route::post('store', [StudentRegistrantHome::class, 'store'])->name('store');
    Route::put('update/{studentRegistrant}', [StudentRegistrantHome::class, 'update'])->name('update');
});

/**
 * **Treasurer Routes**
 */
Route::prefix('treasurer')->name('treasurer.')->middleware(['auth', 'can:isTreasurer'])->group(function () {
    Route::redirect('/', '/treasurer/home', 301);
    Route::get('home', [TreasurerHome::class, 'index'])->name('home');

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('/', [TreasurerTransaction::class, 'index'])->name('index');
        Route::get('create', [TreasurerTransaction::class, 'create'])->name('create');
        Route::post('store', [TreasurerTransaction::class, 'store'])->name('store');
        Route::get('show/{transaction}', [TreasurerTransaction::class, 'show'])->name('show');
        Route::get('edit/{transaction}', [TreasurerTransaction::class, 'edit'])->name('edit');
        Route::put('update/{transaction}', [TreasurerTransaction::class, 'update'])->name('update');
        Route::delete('destroy/{transaction}', [TreasurerTransaction::class, 'destroy'])->name('destroy');
    });

    Route::prefix('transactioncategory')->name('transactioncategory.')->group(function () {
        Route::post('store', [TreasurerTransaction::class, 'categoryStore'])->name('store');
        Route::put('update/{category}', [TreasurerTransaction::class, 'categoryUpdate'])->name('update');
        Route::delete('destroy/{category}', [TreasurerTransaction::class, 'categoryDestroy'])->name('destroy');
    });
});

/**
 * **Facilities Admin Routes**
 */
Route::prefix('facilitiesadmin')->name('facilitiesadmin.')->middleware(['auth', 'can:isFacilitiesAdmin'])->group(function () {
    Route::redirect('/', '/facilitiesadmin/home', 301);
    Route::get('home', [\App\Http\Controllers\FacilitiesAdmin\HomeController::class, 'index'])->name('home');

    Route::get('inventories/print', [\App\Http\Controllers\FacilitiesAdmin\InventoryController::class, 'print'])->name('inventories.print');
    Route::resource('inventories', \App\Http\Controllers\FacilitiesAdmin\InventoryController::class);
    Route::resource('rooms', \App\Http\Controllers\FacilitiesAdmin\RoomController::class);
});
