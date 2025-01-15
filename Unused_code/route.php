<!-- Source Code for Routing in web.php -->

<!--  Auth::routes(); 

    route register (after refresh table)
    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register', [RegisterController::class, 'registerSave'])->name('register.save');

    AuthController
    Route::prefix('auth')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerSave'])->name('registerSave');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
    });

    code lama routing ProductController 
        Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('products');
        Route::get('create', 'create')->name('products.create');
        Route::post('store', 'store')->name('products.store');
        Route::get('show/{id}', 'show')->name('products.show');
        Route::get('products/{id}', 'stop')->name('products.stop');
        Route::get('edit/{id}', 'edit')->name('products.edit');
        Route::put('edit/{id}', 'update')->name('products.update');
        Route::delete('destroy/{id}', 'destroy')->name('products.destroy');
            
    }); -->

    <!--         // Route::prefix('admin')->group(function(){
        //     Route::get('index', [ProjectController::class, 'index'])->name('project.index');
        //     Route::post('store', [ProjectController::class, 'store'])->name('project.store');
        //     Route::get('edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
        //     Route::put('update/{id}', [ProjectController::class, 'update'])->name('project.update');
        //     Route::delete('destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
        // }); -->

        <!-- 
        // Report Workstation
        // Route::prefix('workstation')->group(function() {
        //     Route::get('', [ForemanController::class, 'index'])->name('workstation.index');
        //     Route::post('showByMch', [ForemanController::class, 'showByMch'])->name('workstaion.showByMch');
        //     Route::get('create', [ForemanController::class, 'create'])->name('workstation.create');
        //     Route::post('store', [ForemanController::class, 'sindetore'])->name('workstation.store');
        //     Route::post('update/{id}', [ForemanController::class, 'update'])->name('workstation.update');
        //     Route::get('edit/{id}', [ForemanController::class, 'edit'])->name('workstation.edit');
        //     Route::delete('destroy/{id}', [ForemanController::class, 'destroy'])->name('workstation.destroy');
        // }); -->