<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth'],'middleware' => ['auth.admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Client
    Route::delete('clients/destroy', 'ClientController@massDestroy')->name('clients.massDestroy');
    Route::resource('clients', 'ClientController');

    // Bus
    Route::delete('buses/destroy', 'BusController@massDestroy')->name('buses.massDestroy');
    Route::resource('buses', 'BusController');

    // Bus Station
    Route::delete('bus-stations/destroy', 'BusStationController@massDestroy')->name('bus-stations.massDestroy');
    Route::resource('bus-stations', 'BusStationController');

    // Class Room
    Route::delete('class-rooms/destroy', 'ClassRoomController@massDestroy')->name('class-rooms.massDestroy');
    Route::resource('class-rooms', 'ClassRoomController');

    // Class Section
    Route::delete('class-sections/destroy', 'ClassSectionController@massDestroy')->name('class-sections.massDestroy');
    Route::resource('class-sections', 'ClassSectionController');

    // Homework
    Route::delete('homeworks/destroy', 'HomeworkController@massDestroy')->name('homeworks.massDestroy');
    Route::post('homeworks/media', 'HomeworkController@storeMedia')->name('homeworks.storeMedia');
    Route::post('homeworks/ckmedia', 'HomeworkController@storeCKEditorImages')->name('homeworks.storeCKEditorImages');
    Route::resource('homeworks', 'HomeworkController');

    // Homework Solution
    Route::delete('homework-solutions/destroy', 'HomeworkSolutionController@massDestroy')->name('homework-solutions.massDestroy');
    Route::post('homework-solutions/media', 'HomeworkSolutionController@storeMedia')->name('homework-solutions.storeMedia');
    Route::post('homework-solutions/ckmedia', 'HomeworkSolutionController@storeCKEditorImages')->name('homework-solutions.storeCKEditorImages');
    Route::resource('homework-solutions', 'HomeworkSolutionController');

    // Message
    Route::delete('messages/destroy', 'MessageController@massDestroy')->name('messages.massDestroy');
    Route::resource('messages', 'MessageController');

    // Attendance
    Route::delete('attendances/destroy', 'AttendanceController@massDestroy')->name('attendances.massDestroy');
    Route::resource('attendances', 'AttendanceController');

    // Student Attendance
    Route::delete('student-attendances/destroy', 'StudentAttendanceController@massDestroy')->name('student-attendances.massDestroy');
    Route::resource('student-attendances', 'StudentAttendanceController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});


Route::group(['namespace' => 'Client'], function () {
    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::get('login', 'LoginController@show_login')->name("show_login");
        Route::post('logout', 'LoginController@ClientLogout')->name("logout");
        Route::post('login', 'LoginController@login')->name("login");
        Route::group(['middleware' => ['auth.client']], function () {
            Route::get('/home','HomeController@index')->name('home');
        });
    });
    Route::group([ 'middleware' => ['auth.client']], function () {
        Route::group(['prefix' => 'teacher', 'as' => 'teacher.','namespace' => 'Teacher', 'middleware' => ['is_teacher']], function () {
            Route::get('/list_sections','TeacherController@list_sections')->name('list_sections');
            Route::get('/section/{id}/view','TeacherController@view_section')->name('view_section');
            
            // Attendance
            Route::get('/section/{id}/take_attendance','AttendanceController@take_attendance')->name('take_attendance');
            Route::post('attendances/{id}/update', 'AttendanceController@update')->name("attendances.updatee");
            Route::delete('attendances/destroy', 'AttendanceController@massDestroy')->name('attendances.massDestroy');
            Route::resource('attendances', 'AttendanceController');
                
            // Homework
            Route::delete('homeworks/destroy', 'HomeworkController@massDestroy')->name('homeworks.massDestroy');
            Route::post('homeworks/media', 'HomeworkController@storeMedia')->name('homeworks.storeMedia');
            Route::post('homeworks/ckmedia', 'HomeworkController@storeCKEditorImages')->name('homeworks.storeCKEditorImages');
            Route::resource('homeworks', 'HomeworkController'); 


        });
        Route::group(['prefix' => 'student', 'as' => 'student.','namespace' => 'Student', 'middleware' => ['is_student']], function () {
            Route::get('/list_sections','StudentController@list_sections')->name('list_sections');
            Route::get('/section/{id}/view','StudentController@view_section')->name('view_section');    
            Route::get('/classsection/{id}/homeworks','HomeworkController@classsection_homeworks')->name('classsection.homeworks');    
            Route::get('/homeworks/{id}/view','HomeworkController@view')->name('homeworks.show');    
            Route::get('/homeworks/index','HomeworkController@index')->name('homeworks.index');

             // Homework Solution
            Route::delete('homework-solutions/destroy', 'HomeworkSolutionController@massDestroy')->name('homework-solutions.massDestroy');
            Route::post('homework-solutions/media', 'HomeworkSolutionController@storeMedia')->name('homework-solutions.storeMedia');
            Route::post('homework-solutions/ckmedia', 'HomeworkSolutionController@storeCKEditorImages')->name('homework-solutions.storeCKEditorImages');
            Route::get('/homeworks/{id}/my_solutions','HomeworkSolutionController@my_solutions')->name('my_solutions');
            Route::get('/homework-solutions/index','HomeworkSolutionController@index')->name('solution.index');
            Route::get('/homeworks/{id}/add_solution','HomeworkSolutionController@create')->name('solution.create');
            Route::POST('/homeworks/solution/{id}/form','HomeworkSolutionController@form')->name('solution.form');
            Route::get('/homeworks/solution/{id}/show','HomeworkSolutionController@show')->name('solution.show');

        });
    });
    
    
});
Route::get('get_student_in_class_section/{id}', 'Admin\AttendanceController@get_student_in_class_section')->name("get_student_in_class_section");

