<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    
    private $id, $barbershopId;
    private $name, $email, $password, $active;

    public function setId ($id=null):void
    {
        $this->id = $id;
    }

    public function setBarbershopId ($barbershopId=null):void
    {
        $this->barbershopId = $barbershopId;
    }

    public function setName ($name=null):void
    {
        $this->name = $name;
    }

    public function setEmail ($email=null):void
    {
        $this->email = $email;
    }

    public function setPassword ($password=null):void
    {
        $this->password = $password;
    }

    public function setActive ($active=null):void
    {
        $this->active = $active;
    }

    public function storeUser ():object
    {
        
        if ( !isset($this->name) || empty($this->name) ) {
        
            return response( 'O campo nome é obrigatório', 400 );

        }

        if ( !isset($this->email) || empty($this->email) ) {
            
            return response( 'O campo email é obrigatório', 400 );

        }

        if ( !isset($this->password) || empty($this->password) ) {
            
            return response( 'O campo password é obrigatório', 400 );

        }

        if ( !isset($this->barbershopId) || empty($this->barbershopId) ) {
            
            return response( 'O campo barbershop_id é obrigatório', 400 );

        }

        if ( !isset($this->active) || empty($this->active) ) {
            
            return response( 'O campo active é obrigatório', 400 );

        }

        try {

            $id = DB::table('users')->insertGetId([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'barbershop_id' => $this->barbershopId,
                'active' => $this->active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response( json_encode([ 
                                "message"=>"Usuario criado com sucesso",
                                "id" => $id 
                            ]), 201 );
            
        } catch (\Throwable $th) {

            switch ($th->errorInfo[0]) {
                case '23505':
                    return response( 'Atenção, o email " '.$this->email.' " já foi cadastrado.', 400 );
                break;                
                default:
                    return response( 'Ocorreu um erro no servidor', 500 );
                break;
            }
            
        }

    }

    public function checkUserAlreadyExists()
    {        

        try {

            $user = DB::table('users')->where('id', $this->id)->first();

            if( isset($user) && !empty($user) ) {
                return true;
            } else {
                return false;
            }

        } catch (\Throwable $th) {

            return response('Atenção, ocorreu um erro ao alterar o usuaio', 500);
            
        }        

    }

    public function updateUser()
    {

        if ( !isset($this->id) || empty($this->id) ) {
            
            return response( 'O campo id é obrigatório', 400 );

        }

        if ( !isset($this->name) || empty($this->name) ) {
            
            return response( 'O campo nome é obrigatório', 400 );

        }

        if ( !isset($this->email) || empty($this->email) ) {
            
            return response( 'O campo email é obrigatório', 400 );

        }

        if ( !isset($this->password) || empty($this->password) ) {
            
            return response( 'O campo password é obrigatório', 400 );

        }

        if ( !isset($this->barbershopId) || empty($this->barbershopId) ) {
            
            return response( 'O campo barbershop_id é obrigatório', 400 );

        }

        if ( !isset($this->active) || empty($this->active) ) {
            
            return response( 'O campo active é obrigatório', 400 );

        }

        $userExistCheck = $this->checkUserAlreadyExists();

        if( !$userExistCheck ){
            return response( 'Ateção o usuario selecionado não foi encontrado na base de dados para alteração.', 400 );
        }

        DB::table('users')
            ->where('id', $this->id)
            ->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'barbershop_id' => $this->barbershopId,
                'active' => $this->active,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

    }

    public function getUser ():object
    {

        if ( !isset($this->id) || empty($this->id) ) {
            
            return response( 'O campo id é obrigatório', 400 );

        }

        $user = DB::table('users')->where('id', $this->id)->first();

        unset($user->password); //removing password

        $user = isset($user) && !empty($user) ? $user : [];

        return response(json_encode( $user ), 200);

    }

}
