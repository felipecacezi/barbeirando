<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{   
    /**
     * @dataProvider newUserRequiedFieldsProvider
     */
    public function testNewUserShouldBeRequiredFields ( $name, $email, $password, $barbershop_id, $active, $expected )
    {
           
        $response = $this->post('/api/user/store',[
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'barbershop_id' => $barbershop_id,
            'active' => $active,
        ]);

        $response->assertStatus($expected);
        
    }

    /**
     * @dataProvider updateUserRequiedFieldsProvider
     */
    public function testUpdateUserShouldBeRequireFields ( $name, $email, $password, $barbershop_id, $active, $expected ) 
    {

        $response = $this->patch('/api/user/update/1',[
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'barbershop_id' => $barbershop_id,
            'active' => $active,
        ]);

        $response->assertStatus($expected);

    }

    public function newUserRequiedFieldsProvider ()
    {

        $causeArray = [ 
            "shouldBeRequiredName" => [
                "",
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "A",
                400
            ],
            "shouldBeRequiredEmail" => [
                $this->random_str_generator(10),
                "",
                $this->random_str_generator(5),
                "1",
                "A",
                400
            ],
            "shouldBeRequiredPassword" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                "",
                "1",
                "A",
                400
            ],
            "shouldBeRequiredBarberShopId" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "",
                "A",
                400
            ],
            "shouldBeRequiredActive" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "",
                400
            ],
            "shouldBeRequiredFieldsOk" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "A",
                201
            ],
        ];

        return $causeArray;

    }

    public function updateUserRequiedFieldsProvider ()
    {

        return [ 
            "shouldBeRequiredName" => [
                "",
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "A",
                400
            ],
            "shouldBeRequiredEmail" => [
                $this->random_str_generator(10),
                "",
                $this->random_str_generator(5),
                "1",
                "A",
                400
            ],
            "shouldBeRequiredPassword" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                "",
                "1",
                "A",
                400
            ],
            "shouldBeRequiredBarberShopId" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "",
                "A",
                400
            ],
            "shouldBeRequiredActive" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "",
                400
            ],
            "shouldBeRequiredFieldsOk" => [
                $this->random_str_generator(10),
                $this->random_str_generator(5)."@email.com",
                $this->random_str_generator(10),
                "1",
                "A",
                200
            ],
        ];

    }

    public function testNewUserShouldBeDuplicatedEmail (  )
    {

        $user = DB::table('users')->first();
        

        $response = $this->post('/api/user/store',[
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'barbershop_id' => $user->barbershop_id,
            'active' => $user->active,
        ]);

        $response->assertStatus(400);

    }

    public function random_str_generator ($stringLength):string
    {        
        if ( !isset($stringLength) || empty($stringLength) ){
            return false;
        }
        $randomStr = null;
        $chars = null;
        $varSize = null;
        $x = 0;
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $var_size = strlen($chars);
        for( $x = 0; $x < $stringLength; $x++ ) {  
            $randomStr .= $chars[rand( $x, $var_size )]; 
        } 
        return $randomStr;

    }

    
}