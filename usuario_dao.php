<?php

  include_once 'dao.php';

  class UsuarioDAO extends DAO {
    function cadastrar($nome, $usuario, $email, $senha) {
      $conexao = new PDO("mysql:host=localhost;dbname=banco_de_usuarios", "root", "");
      
      $senha = md5($senha);
      $stmt = $conexao->prepare("INSERT INTO usuario(nome, usuario, email, senha) VALUES(?, ?, ?, ?)");
      $stmt->bindParam(1, $nome);
      $stmt->bindParam(2, $usuario);
      $stmt->bindParam(3, $email);
      $stmt->bindParam(4, $senha);

      $resultado = null;
      
      try {
        $resultado = $stmt->execute();
      } catch (\Throwable $th) {
        if(str_contains($th, "Duplicate entry") &&
          str_contains($th, "key 'email'")) {
          return "O e-mail inserido já está sendo utilizado.";
        } else if(str_contains($th, "Duplicate entry") &&
          str_contains($th, "key 'usuario'")) {
          return "O usuário inserido já está sendo utilizado.";
        }

        return "Ocorreu um erro desconhecido. Por favor, tente novamente.";
      }

      return null;
    }

    function login($usuario, $senha) {
      $conexao = new PDO("mysql:host=localhost;dbname=banco_de_usuarios", "root", "");
      
      $preparacao = $conexao->prepare("SELECT * FROM usuario WHERE usuario=? and senha=?;");
      
      $senha = md5($senha);
      $preparacao->bindParam(1, $usuario);
      $preparacao->bindParam(2, $senhaCriptografada);

      $resultado = $preparacao->execute();

      return $resultado;
    }

    function listar_usuarios($nome) {
      $resultado = "";

      $conexao = new PDO("mysql:host=localhost;dbname=banco_de_usuarios", "root", "");
      
      if($nome != null) {
        $resultado = $conexao->query("SELECT * FROM usuario WHERE nome like '%$nome%';");
      } else {
        $resultado = $conexao->query("SELECT * FROM usuario;");
      }

      return $resultado;
    }
  }
