<?php

declare(strict_types=1);

use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = (bool) config('permission.teams');
        /** @var array<string, mixed> $tableNames */
        $tableNames = (array) config('permission.table_names');
        /** @var array<string, mixed> $columnNames */
        $columnNames = (array) config('permission.column_names');
        $pivotRole = is_string($columnNames['role_pivot_key'] ?? null) ? $columnNames['role_pivot_key'] : 'role_id';
        $pivotPermission = is_string($columnNames['permission_pivot_key'] ?? null) ? $columnNames['permission_pivot_key'] : 'permission_id';

        throw_if(count($tableNames) === 0, 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        throw_if($teams && ! is_string($columnNames['team_foreign_key'] ?? null), 'Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        $permissionsTable = is_string($tableNames['permissions'] ?? null) ? $tableNames['permissions'] : 'permissions';
        $rolesTable = is_string($tableNames['roles'] ?? null) ? $tableNames['roles'] : 'roles';
        $modelHasPermissionsTable = is_string($tableNames['model_has_permissions'] ?? null) ? $tableNames['model_has_permissions'] : 'model_has_permissions';
        $modelHasRolesTable = is_string($tableNames['model_has_roles'] ?? null) ? $tableNames['model_has_roles'] : 'model_has_roles';
        $roleHasPermissionsTable = is_string($tableNames['role_has_permissions'] ?? null) ? $tableNames['role_has_permissions'] : 'role_has_permissions';
        $teamForeignKey = is_string($columnNames['team_foreign_key'] ?? null) ? $columnNames['team_foreign_key'] : 'team_id';
        $modelMorphKey = is_string($columnNames['model_morph_key'] ?? null) ? $columnNames['model_morph_key'] : 'model_id';

        /**
         * See `docs/prerequisites.md` for suggested lengths on 'name' and 'guard_name' if "1071 Specified key was too long" errors are encountered.
         */
        Schema::create($permissionsTable, static function (Blueprint $table): void {
            $table->uuid('id')->primary(); // permission id
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        /**
         * See `docs/prerequisites.md` for suggested lengths on 'name' and 'guard_name' if "1071 Specified key was too long" errors are encountered.
         */
        Schema::create($rolesTable, static function (Blueprint $table) use ($teams, $teamForeignKey): void {
            $table->uuid('id')->primary(); // role id
            if ($teams || config('permission.testing')) { // permission.testing is a fix for sqlite testing
                $table->unsignedBigInteger($teamForeignKey)->nullable();
                $table->index($teamForeignKey, 'roles_team_foreign_key_index');
            }

            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$teamForeignKey, 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        Schema::create($modelHasPermissionsTable, static function (Blueprint $table) use ($permissionsTable, $modelMorphKey, $teamForeignKey, $pivotPermission, $teams): void {
            $table->uuid($pivotPermission);

            $table->string('model_type');
            $table->uuid($modelMorphKey);
            $table->index([$modelMorphKey, 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($permissionsTable)
                ->cascadeOnDelete();
            if ($teams) {
                $table->unsignedBigInteger($teamForeignKey);
                $table->index($teamForeignKey, 'model_has_permissions_team_foreign_key_index');

                $table->primary([$teamForeignKey, $pivotPermission, $modelMorphKey, 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $modelMorphKey, 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }
        });

        Schema::create($modelHasRolesTable, static function (Blueprint $table) use ($rolesTable, $modelMorphKey, $teamForeignKey, $pivotRole, $teams): void {
            $table->uuid($pivotRole);

            $table->string('model_type');
            $table->uuid($modelMorphKey);
            $table->index([$modelMorphKey, 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($rolesTable)
                ->cascadeOnDelete();
            if ($teams) {
                $table->unsignedBigInteger($teamForeignKey);
                $table->index($teamForeignKey, 'model_has_roles_team_foreign_key_index');

                $table->primary([$teamForeignKey, $pivotRole, $modelMorphKey, 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $modelMorphKey, 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        Schema::create($roleHasPermissionsTable, static function (Blueprint $table) use ($permissionsTable, $rolesTable, $pivotRole, $pivotPermission): void {
            $table->uuid($pivotPermission);
            $table->uuid($pivotRole);

            $table->foreign($pivotPermission)
                ->references('id') // permission id
                ->on($permissionsTable)
                ->cascadeOnDelete();

            $table->foreign($pivotRole)
                ->references('id') // role id
                ->on($rolesTable)
                ->cascadeOnDelete();

            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        $cacheStore = config('permission.cache.store');
        $cacheKey = config('permission.cache.key');

        resolve(Factory::class)
            ->store(is_string($cacheStore) && $cacheStore !== 'default' ? $cacheStore : null)
            ->forget(is_string($cacheKey) ? $cacheKey : 'spatie.permission.cache');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /** @var array<string, mixed> $tableNames */
        $tableNames = (array) config('permission.table_names');

        throw_if(count($tableNames) === 0, 'Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');

        $permissionsTable = is_string($tableNames['permissions'] ?? null) ? $tableNames['permissions'] : 'permissions';
        $rolesTable = is_string($tableNames['roles'] ?? null) ? $tableNames['roles'] : 'roles';
        $modelHasPermissionsTable = is_string($tableNames['model_has_permissions'] ?? null) ? $tableNames['model_has_permissions'] : 'model_has_permissions';
        $modelHasRolesTable = is_string($tableNames['model_has_roles'] ?? null) ? $tableNames['model_has_roles'] : 'model_has_roles';
        $roleHasPermissionsTable = is_string($tableNames['role_has_permissions'] ?? null) ? $tableNames['role_has_permissions'] : 'role_has_permissions';

        Schema::dropIfExists($roleHasPermissionsTable);
        Schema::dropIfExists($modelHasRolesTable);
        Schema::dropIfExists($modelHasPermissionsTable);
        Schema::dropIfExists($rolesTable);
        Schema::dropIfExists($permissionsTable);
    }
};
