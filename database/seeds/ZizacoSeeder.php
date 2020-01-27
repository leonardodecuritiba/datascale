<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Role;

class ZizacoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=ZizacoSeeder
	    $start = microtime( true );
	    $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
	    $this->command->info( 'SETANDO SuperAdministrador' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'root';
	    $admin->display_name = 'Root'; // optional
	    $admin->description  = 'Usuário com acesso total ao sistema'; // optional
	    $admin->save();


        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Administrador' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'admin';
        $admin->display_name = 'Admin'; // optional
        $admin->description  = 'Usuário com parcial total ao sistema'; // optional
        $admin->save();


        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Técnico' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'tecnico';
        $admin->display_name = 'Técnico'; // optional
        $admin->description  = 'Usuário com parcial ao sistema'; // optional
        $admin->save();


        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Vendedor' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'vendedor';
        $admin->display_name = 'Vendedor'; // optional
        $admin->description  = 'Usuário com parcial ao sistema'; // optional
        $admin->save();



        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Financeiro' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'financeiro';
        $admin->display_name = 'Financeiro'; // optional
        $admin->description  = 'Usuário com parcial ao sistema'; // optional
        $admin->save();



        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Gestor' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'gestor';
        $admin->display_name = 'Gestor'; // optional
        $admin->description  = 'Usuário com parcial ao sistema'; // optional
        $admin->save();




	    /*

	    // OFICINA
	    $this->command->info( 'SETANDO admin-office' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'admin-office';
	    $admin->display_name = 'Administrador da Oficina'; // optional
	    $admin->description  = 'Usuário com acesso total ao sistema da oficina'; // optional
	    $admin->save();

	    $this->command->info( 'SETANDO tech-office' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'tech-office';
	    $admin->display_name = 'Técnico da Oficina'; // optional
	    $admin->description  = 'Usuário com acesso restrito ao sistema da oficina'; // optional
	    $admin->save();


	    // FRANQUIA
	    $this->command->info( 'SETANDO admin-franchise' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'admin-franchise';
	    $admin->display_name = 'Administrador da Franquia'; // optional
	    $admin->description  = 'Usuário com acesso total ao sistema da franquia'; // optional
	    $admin->save();

	    $this->command->info( 'SETANDO tech-franchise' );
	    $admin               = new Role(); // Gerência = tudo
	    $admin->name         = 'tech-franchise';
	    $admin->display_name = 'Técnico da Franquia'; // optional
	    $admin->description  = 'Usuário com acesso restrito ao sistema da franquia'; // optional
	    $admin->save();



	    */


	    //SETANDO PERMISSÕES
	    /*
	    $arrays = ['admins','dashboards','clients','sub_clients','devices','sensors','sensor_types','alerts','reports','permissions'];
	    $options = ['index','create','edit','active','destroy'];

	    foreach($arrays as $array){
		    foreach($options as $option){
			    $data = new Permission();
			    $data->name         = $array.'.'.$option;
			    $data->display_name = $array.'.'.$option; // optional
			    $data->save();

			    $admin->attachPermission($data);
			    if(($array != 'admins') && ($array != 'clients') && ($array != 'sensor_types') && ($array != 'permissions')){
				    $client->attachPermission($data);
				    if(($array != 'sub_clients')){
					    $sub_client->attachPermission($data);
				    }
			    }
		    }
	    }

	    */

	    echo "\n*** Completo em " . round((microtime(true) - $start), 3) . "s ***";
    }
}
