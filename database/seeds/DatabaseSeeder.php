<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;
use App\Companies\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $this->call(ImportCepTable::class);
	    $this->call(ZizacoSeeder::class);
	    $this->call(ImportSettingTable::class);

        $company = \App\Companies\Company::create([
            'franchise'    => 0,
        ]);

        $user = User::create([
            'company_id'    => NULL,
            'name'          => 'Root',
            'email'         => 'root@email.com',
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

	    $user->attachRole(1);

	    /*
		$user = User::create([
			'company_id'    => NULL,
			'name'          => 'Administrador da Oficina',
			'email'         => 'admin-office@email.com',
			'password'      => bcrypt('123'),
			'cpf'           => '00000000002',
			'rg'            => '00000002',
		]);

		$user->attachRole(2);

		$user = User::create([
			'company_id'    => NULL,
			'name'          => 'Técnico da Oficina',
			'email'         => 'tech-office@email.com',
			'password'      => bcrypt('123'),
			'cpf'           => '00000000003',
			'rg'            => '00000003',
		]);

		$user->attachRole(3);


		$user = User::create([
			'company_id'    => NULL,
			'name'          => 'Administrador da Franquia',
			'email'         => 'admin-franchise@email.com',
			'password'      => bcrypt('123'),
			'cpf'           => '00000000004',
			'rg'            => '00000004',
		]);

		$user->attachRole(4);

		$user = User::create([
			'company_id'    => NULL,
			'name'          => 'Técnico da Franquia',
			'email'         => 'tech-franchise@email.com',
			'password'      => bcrypt('123'),
			'cpf'           => '00000000005',
			'rg'            => '00000005',
		]);

		$user->attachRole(5);

		*/
    }
}
