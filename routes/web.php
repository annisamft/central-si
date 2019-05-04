<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group( function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin/home', 'HomeController@index')->name('admin.home');
    Route::get('/admin/dashboard', 'DashboardController@index')->name('admin.dashboard');

    /** Routing Pengelolaan Dosen */
    Route::post('/admin/dosen/cari', 'DosenCariController@show')->name('admin.dosencari.show'); //routing pencarian dosen
    Route::get('/admin/dosen/cari', 'DosenController@index')->name('admin.dosencari.index'); //routing pencarian dosen

    Route::get('/admin/dosen', 'DosenController@index')->name('admin.dosen.index');  //routing lihat daftar dosen
    Route::post('/admin/dosen', 'DosenController@store')->name('admin.dosen.store'); //routing simpan data dosen baru
    Route::get('/admin/dosen/create', 'DosenController@create')->name('admin.dosen.create'); //routing tampilkan form data dosen baru
    Route::delete('/admin/dosen/{dosen}', 'DosenController@destroy')->name('admin.dosen.destroy'); //routing hapus data dosen baru
    Route::patch('/admin/dosen/{dosen}', 'DosenController@update')->name('admin.dosen.update'); //routing simpan perubahan data dosen
    Route::get('/admin/dosen/{dosen}', 'DosenController@show')->name('admin.dosen.show'); //routing tampilkan detail dosen
    Route::get('/admin/dosen/{dosen}/edit', 'DosenController@edit')->name('admin.dosen.edit');  //routing tampilkan form edit dosen

    /** Routing Pengelolaan Proposal KP */
    Route::post('/admin/proposal-kp/cari', 'ProposalKPCariController@show')->name('admin.proposal-kpcari.show'); //routing pencarian dosen
    Route::get('/admin/proposal-kp/cari', 'ProposalKPController@index')->name('admin.proposal-kpcari.index'); //routing pencarian dosen

    Route::get('/admin/proposal-kp', 'ProposalKPController@index')->name('admin.proposal-kp.index');  //routing lihat daftar proposal kp
    Route::post('/admin/proposal-kp', 'ProposalKPController@store')->name('admin.proposal-kp.store'); //routing simpan data proposal kp baru
    Route::post('/admin/proposal-kp/member', 'ProposalKPController@insert')->name('admin.proposal-kp.insert'); //routing simpan data proposal kp baru
    Route::get('/admin/proposal-kp/create', 'ProposalKPController@create')->name('admin.proposal-kp.create'); //routing tampilkan form data proposal kp baru
    Route::patch('/admin/proposal-kp/{id}', 'ProposalKPController@update')->name('admin.proposal-kp.update'); //routing simpan perubahan data proposal kp
    Route::delete('/admin/proposal-kp/{id}', 'ProposalKPController@destroy')->name('admin.proposal-kp.destroy'); //routing hapus data proposal kp
    Route::delete('/admin/proposal-kp/{id}/delanggota', 'ProposalKPController@hapusAnggota')->name('admin.proposal-kp.hapusanggota'); //routing hapus data proposal kp
    Route::get('/admin/proposal-kp/{id}', 'ProposalKPController@show')->name('admin.proposal-kp.show'); //routing tampilkan detail proposal kp
    Route::get('/admin/proposal-kp/{id}/show', 'ProposalKPController@showKelompok')->name('admin.proposal-kp.showkelompok'); //routing tampilkan detail proposal kp
    Route::get('/admin/proposal-kp/{id}/edit', 'ProposalKPController@edit')->name('admin.proposal-kp.edit');  //routing tampilkan form edit proposal kp
    Route::get('/admin/proposal-kp/{id}/add', 'ProposalKPController@add')->name('admin.proposal-kp.add');  //routing tampilkan form tambah anggota kp


    /** Routing Pengelolaan Mahasiswa */
    Route::post('/admin/mahasiswa/cari', 'MahasiswaCariController@show')->name('admin.mahasiswacari.show'); //routing pencarian mahasiswa
    Route::get('/admin/mahasiswa/cari', 'MahasiswaController@index')->name('admin.mahasiswacari.index'); //routing pencarian mahasiswa
    Route::get('/admin/mahasiswa', 'MahasiswaController@index')->name('admin.mahasiswa.index');  //routing lihat daftar mahasiswa
    Route::post('/admin/mahasiswa', 'MahasiswaController@store')->name('admin.mahasiswa.store'); //routing simpan data mahasiswa baru
    Route::get('/admin/mahasiswa/create', 'MahasiswaController@create')->name('admin.mahasiswa.create'); //routing tampilkan form data mahasiswa baru
    Route::delete('/admin/mahasiswa/{mahasiswa}', 'MahasiswaController@destroy')->name('admin.mahasiswa.destroy'); //routing hapus data mahasiswa baru
    Route::patch('/admin/mahasiswa/{mahasiswa}', 'MahasiswaController@update')->name('admin.mahasiswa.update'); //routing simpan perubahan data mahasiswa
    Route::get('/admin/mahasiswa/{mahasiswa}', 'MahasiswaController@show')->name('admin.mahasiswa.show'); //routing tampilkan detail mahasiswa
    Route::get('/admin/mahasiswa/{mahasiswa}/edit', 'MahasiswaController@edit')->name('admin.mahasiswa.edit');  //routing tampilkan form edit mahasiswa

    /** Routing untuk tugas mulai dari sini */
    Route::get('pembimbing/submit', 'PembimbingSubmissionController@create')->name('admin.pembimbing.create');
    Route::post('pembimbing/submit', 'PembimbingSubmissionController@store')->name('admin.pembimbing.store');

});

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function(){
    //Laravel Permission spatie/permissions
    Route::resource('permissions', 'Backend\PermissionsController');
    Route::post('permissions_mass_destroy', ['uses' => 'Backend\PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
    Route::resource('roles', 'Backend\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Backend\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
    Route::resource('users', 'Backend\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Backend\UsersController@massDestroy', 'as' => 'users.mass_destroy']);
});

