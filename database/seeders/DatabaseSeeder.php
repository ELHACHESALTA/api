<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Tarea;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $permissions = [
            'create tarea',
            'edit tarea',
            'delete tarea',
            'view tarea',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $usuario = Role::create(['name' => 'usuario']);

        $admin->givePermissionTo($permissions);
        $usuario->givePermissionTo(['view tarea']);

        $user1 = User::create([
            'name' => 'Administrador',
            'email' => 'administrador@gmail.com',
            'password' => bcrypt('admin123'),
        ]);

        $user2 = User::create([
            'name' => 'Usuario Uno',
            'email' => 'usuariouno@gmail.com',
            'password' => bcrypt('us1abc'),
        ]);

        $user3 = User::create([
            'name' => 'Usuario Dos',
            'email' => 'usuariodos@gmail.com',
            'password' => bcrypt('us2abc'),
        ]);

        $user1->assignRole('admin');
        $user2->assignRole('usuario');
        $user3->assignRole('usuario');

        $tarea = Tarea::create([
            'titulo' => 'Preparar reporte',
            'descripcion' => 'Crear un reporte de ventas',
            'estado' => 'pendiente',
            'prioridad' => 'alta'
        ]);

        $tarea->users()->attach([2, 3]);
    }
}
