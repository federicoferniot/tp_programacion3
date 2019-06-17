<?php

class Usuario{
    public $id;
    public $username;
    public $password;

    public function InsertarUsuario(){
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (username, password)values(:username, :password)");
        $consulta->bindValue(':username', $this->username, PDO::PARAM_STR);
        $consulta->bindValue(':password', hash('sha512', $this->password.$this->username));
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

	public static function TraerUnUsuario($usuario) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select id as id, username as username, password as password from usuario WHERE username=:username");
        $consulta->bindValue(':username', $usuario, PDO::PARAM_STR);
        $consulta->execute();
        $usuarioBuscado= $consulta->fetchObject('Usuario');
        return $usuarioBuscado;
	}
}