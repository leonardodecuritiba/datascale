<?php

use App\Models\Users\Role;
use Illuminate\Database\Seeder;

class FranchiseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=FranchiseSeeder
        $this->command->info( 'SETANDO tech-franchise' );
        $franchise               = new Role(); // Gerência = tudo
        $franchise->name         = 'tech-franchise';
        $franchise->display_name = 'Técnico da Franquia'; // optional
        $franchise->description  = 'Usuário com acesso restrito ao sistema da franquia'; // optional
        $franchise->save();



        $user = \App\Models\Users\User::create([
            'company_id'    => NULL,
            'name'          => 'Técnico Franquia',
            'email'         => 'franquia@email.com',
            'password'      => bcrypt('123'),
            'cpf'           => '00000000001',
            'rg'            => '00000001',
            'idcolaborador' => NULL,
            'idtecnico'     => NULL,

            'cnh_id'        => NULL,
            'work_permit_id'=> NULL,
            'inmetro_id'    => NULL,
            'ipem_id'       => NULL,

            'discount_max'  => 0,
            'increase_max'  => 0,
        ]);


        $user->attachRole($franchise);

    }
}
