<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2019.07.04
 * Time: 10:26
 */
namespace Core;
class Database
{
   private $pdo;
   private $sql = '';


   public function connect()
   {
     
     $host = DB_HOST;
     $db   = DB_DATABASE;
     $user = DB_USERNAME;
     $pwrd = DB_PASSWORD;

      try {
         $pdo = new \PDO("mysql:host=$host; dbname=$db; charset=utf8", $user, $pwrd);
//         echo "Connected to DB " . $db;

      } catch (PDOException $e) {
         print 'ERROR: ' . $e->getMessage();
      }
      $this->pdo = $pdo;

   }

   public function select($field = '*')
   {
      $this->sql .= 'SELECT ' . $field;
      return $this;
   }

   public function from($table)
   {
      $this->sql .= ' FROM ' . $table;
      return $this;
   }
   public function order($fieldname, $order)
   {
      $this->sql .= ' ORDER BY ' .$fieldname .' '.$order;
      // return $this; 
   }

   public function take($amount)
   {
      $this->sql .= 'LIMIT '. $amount;
      // dd($this);
      return $this;
   }
   
//   public function limit($firstValue, $offsetValue)
//   {
//      $this->sql .= ' LIMIT ' . $firstValue . ' OFFSET ' . $offsetValue;
//      return $this;
//   }
   public function limit($value, $valueLast)
   {
      $this->sql .= ' LIMIT ' . $value . ',' . $valueLast;
      return $this;
   }
   
   public function where($fieldname, $value)
   {
      $this->sql .= ' WHERE ' . $fieldname . ' = ' . "'$value'";
      return $this;
   }
   public function whereLike($fieldname, $value)
   {
      $this->sql .= ' WHERE ' . $fieldname . ' LIKE ' . "'%$value%'";
      return $this;
   }

   public function andWhere($field, $value)
   {
      $this->sql .= " AND  $field = '$value'";
      return $this;
   }

   public function orSQL($field, $value)
   {
      $this->sql .= " OR $field = '$value'";
      return $this;
   }

   public function insert($table, $columns, $values)
   {
      $this->sql .= "INSERT INTO $table ($columns) VALUES ($values)";
   }
   public function update($table, $setContent)
   {
      $this->sql .= "UPDATE $table SET $setContent";
      return $this;
   }
   public function delete()
   {
      $this->sql .= 'DELETE ';
      return $this;
   }
   public function confirmation()
   {
      echo "Are you sure you want to delete ";
   }

   public function getOne()
   {
      $stmt = $this->execute();
      return $stmt->fetchObject();
   }

   public function getAll()
   {
      $stmt = $this->execute();
      // dump($stmt);
      $data = [];
      while ($row = $stmt->fetchObject()) {
         $data[] = $row;
      }
      return $data;
   }

   public function execute()
   {
      $this->connect();
      $sql = $this->sql;
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      //Here to provide a better answer why SQL does not work
   //   echo "\nPDOStatement::errorInfo():\n";
   //   $arr = $stmt->errorInfo();
   //   print_r($arr);
   //   echo "<br>" . "<br>";
      $this->sql = '';
      return $stmt;
   }


}