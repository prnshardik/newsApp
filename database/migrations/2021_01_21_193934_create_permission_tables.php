<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        $role_create = DB::table('permissions')->insertGetId(['name' => 'role-create', 'guard_name' => 'web']);
        $role_edit = DB::table('permissions')->insertGetId(['name' => 'role-edit', 'guard_name' => 'web']);
        $role_view = DB::table('permissions')->insertGetId(['name' => 'role-view', 'guard_name' => 'web']);
        $role_delete = DB::table('permissions')->insertGetId(['name' => 'role-delete', 'guard_name' => 'web']);
        $permission_create = DB::table('permissions')->insertGetId(['name' => 'permission-create', 'guard_name' => 'web']);
        $permission_edit = DB::table('permissions')->insertGetId(['name' => 'permission-edit', 'guard_name' => 'web']);
        $permission_view = DB::table('permissions')->insertGetId(['name' => 'permission-view', 'guard_name' => 'web']);
        $permission_delete = DB::table('permissions')->insertGetId(['name' => 'permission-delete', 'guard_name' => 'web']);

        $district_create = DB::table('permissions')->insertGetId(['name' => 'district-create', 'guard_name' => 'web']);
        $district_edit = DB::table('permissions')->insertGetId(['name' => 'district-edit', 'guard_name' => 'web']);
        $district_view = DB::table('permissions')->insertGetId(['name' => 'district-view', 'guard_name' => 'web']);
        $district_delete = DB::table('permissions')->insertGetId(['name' => 'district-delete', 'guard_name' => 'web']);
        $taluka_create = DB::table('permissions')->insertGetId(['name' => 'taluka-create', 'guard_name' => 'web']);
        $taluka_edit = DB::table('permissions')->insertGetId(['name' => 'taluka-edit', 'guard_name' => 'web']);
        $taluka_view = DB::table('permissions')->insertGetId(['name' => 'taluka-view', 'guard_name' => 'web']);
        $taluka_delete = DB::table('permissions')->insertGetId(['name' => 'taluka-delete', 'guard_name' => 'web']);
        $city_create = DB::table('permissions')->insertGetId(['name' => 'city-create', 'guard_name' => 'web']);
        $city_edit = DB::table('permissions')->insertGetId(['name' => 'city-edit', 'guard_name' => 'web']);
        $city_view = DB::table('permissions')->insertGetId(['name' => 'city-view', 'guard_name' => 'web']);
        $city_delete = DB::table('permissions')->insertGetId(['name' => 'city-delete', 'guard_name' => 'web']);

        $reporter_create = DB::table('permissions')->insertGetId(['name' => 'reporter-create', 'guard_name' => 'web']);
        $reporter_edit = DB::table('permissions')->insertGetId(['name' => 'reporter-edit', 'guard_name' => 'web']);
        $reporter_view = DB::table('permissions')->insertGetId(['name' => 'reporter-view', 'guard_name' => 'web']);
        $reporter_delete = DB::table('permissions')->insertGetId(['name' => 'reporter-delete', 'guard_name' => 'web']);

        $subscriber_create = DB::table('permissions')->insertGetId(['name' => 'subscriber-create', 'guard_name' => 'web']);
        $subscriber_edit = DB::table('permissions')->insertGetId(['name' => 'subscriber-edit', 'guard_name' => 'web']);
        $subscriber_view = DB::table('permissions')->insertGetId(['name' => 'subscriber-view', 'guard_name' => 'web']);
        $subscriber_delete = DB::table('permissions')->insertGetId(['name' => 'subscriber-delete', 'guard_name' => 'web']);

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        $admin_role_id = DB::table('roles')->insertGetId(['name' => 'admin', 'guard_name' => 'web']);
        DB::table('roles')->insert(['name' => 'reporter', 'guard_name' => 'web']);
        DB::table('roles')->insert(['name' => 'subscriber', 'guard_name' => 'web']);

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                        ->references('id')
                        ->on($tableNames['permissions'])
                        ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                    ->references('id')
                    ->on($tableNames['permissions'])
                    ->onDelete('cascade');

            $table->foreign('role_id')
                    ->references('id')
                    ->on($tableNames['roles'])
                    ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        DB::table('role_has_permissions')->insert(['permission_id' => $role_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $role_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $role_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $role_delete, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $permission_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $permission_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $permission_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $permission_delete, 'role_id' => $admin_role_id]);

        DB::table('role_has_permissions')->insert(['permission_id' => $district_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $district_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $district_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $district_delete, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $taluka_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $taluka_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $taluka_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $taluka_delete, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $city_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $city_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $city_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $city_delete, 'role_id' => $admin_role_id]);

        DB::table('role_has_permissions')->insert(['permission_id' => $reporter_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $reporter_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $reporter_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $reporter_delete, 'role_id' => $admin_role_id]);

        DB::table('role_has_permissions')->insert(['permission_id' => $subscriber_create, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $subscriber_edit, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $subscriber_view, 'role_id' => $admin_role_id]);
        DB::table('role_has_permissions')->insert(['permission_id' => $subscriber_delete, 'role_id' => $admin_role_id]);

        $user = DB::table('users')->where(['email' => 'superadmin@newsapp.com'])->first();
        if($user){
            DB::table('users')->where(['id' => $user->id])->update(['role_id' => $admin_role_id]);
            DB::table('model_has_roles')->insert(['role_id' => $admin_role_id, 'model_type' => 'App\Models\User', 'model_id' => $user->id]);
        }

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
