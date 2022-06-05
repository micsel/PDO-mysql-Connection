<?php
ini_set("display_errors","1"); /* @WARNING: BEFORE USING THIS SAMPLE FOR PRODUCT USE CHANGE THIS VALUE TO 0 */
ini_set("session.sid_length","150"); /* LENGTH OF SESSION SID - DEFAULT TO 150 CHARACTERS */
ini_set("session.hash_function","sha512"); /* HASH FUNCTION USED TO ENCRYPT THE SESSION CONTENT */
ini_set("session.use_strict_mode","0"); /* USE STRICT MODE */
error_reporting(E_ALL); /* @CHANGE THIS TO THE ERRORS YOU WANT TO GET LIKE [E_WARNING] - [E_ALERT] - [E_INFO] - [0] */

if(session_status() === PHP_SESSION_DISABLED){die("please enable sessions in your browser!");}
else if(session_status() === PHP_SESSION_NONE) {session_start();}

/* INCLUDE THE DEFINED DATABASE PARAMETERS */
/*************** WARNING: do not edit ********************/
@require_once("const.php");


/************************ CONNECTION PROPERTIES *************************/
/*************** WARNING: do not edit ********************/
trait makeProperties
{
  protected static $DBNAME              = DBNAME;
  protected static $DBHOST               = DBHOST;
  protected static $DBUSER                = DBUSER;
  protected static $DBPASSWORD      = DBPASSWORD;
  protected static $DBPORT                = DBPORT;
  protected static $DBCHAR               = DBCHAR;

  protected static function __ErrorLogger()
  {
    error_log("You have and error on line " . __LINE__ . " in file location " . $_SERVER["PHP_SELF"], 0);
  }

  protected static function __dbname() :string { return self::$DBNAME; }
  protected static function __dbhost() :string { return self::$DBHOST; }
  protected static function __dbuser() :string { return self::$DBUSER; }
  protected static function __dbpassword() :string { return self::$DBPASSWORD; }
  protected static function __dbport() :string { return self::$DBPORT; }
  protected static function __dbchar() :string { return self::$DBCHAR; }
}

/**************** CLASS CONNECTION *****************/
class InvokeDatabase
{
  /*******************   WARNING    *******************/
  /******************* DO NOT EDIT ******************/
  use makeProperties {makeProperties::__dbname as protected; }
  use makeProperties {makeProperties::__dbhost as protected; }
  use makeProperties {makeProperties::__dbuser as protected; }
  use makeProperties {makeProperties::__dbpassword as protected; }
  use makeProperties {makeProperties::__dbport as protected; }
  use makeProperties {makeProperties::__dbchar as protected; }
  use makeProperties {makeProperties::__ErrorLogger as protected; }

  const GLOBAL_SQL = "SELECT * FROM TABLE_NAME LIMIT 1"; /* ONLY FOR TESTING SHOW PURPOSE ------- you can remove/edit it if you want*/

/*************** DATABASE CONNECTION *****************/
/*************** WARNING: do not edit ********************/

   private static function InvokeConnection() : mixed /* returning an unknow value */
   {
     try
     {
       $openSocket = ("mysql:host=" . self::__dbhost() . ";dbname=" . self::__dbname() . ";dbport=" . self::__dbport() . ";dbchar=" . self::__dbchar());
       $OpenConnection = new PDO($openSocket, self::__dbuser(), self::__dbpassword());

       $OpenConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


       /* CHECK FOR CONNECTION SUCCESS */
       if(!$OpenConnection) { throw new PDOException(); }
       else{
         $OpenConnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
       }

       /*************** RETURN THE SUCCESSFULY CONNECTION ****************/
       return $OpenConnection;

     }catch(PDOException $__Caught)
     {
         self::__ErrorLogger();
         return (bool)false;
     }
   }

   /********** THIS FUNCTION IS ONLY FOR TESTING THE CODE ************/
   /* @UNCOMMENT THE FOLLOWING FUNCTION TO TEST IT */


   /* +++++++ REMOVE THIS LINE HERE +++++++
   public function __GetUsers():mixed
   {
     try{
       ob_start();
       $user = NULL;
       $connection = self::InvokeConnection();
       if($connection === (bool)false)
       {
         throw new Exception();
       }else{
         $getUsers = $connection->prepare(self::GLOBAL_SQL);
         $getUsers->execute();
         if(!$getUsers){ throw new Exception();}
         if($getUsers->rowCount() > 0)
         {
           while($thisRow = $getUsers->fetch(PDO::FETCH_OBJ))
           {
             $user = $thisRow->COLUMN_NAME;
           }
           return (string)$user;
         }
         return (int)0;
       }
     }catch(Exception $Error)
     {
       self::__ErrorLogger();
       ob_get_clean();
       $connection = NULL;
       return (bool)false;
     }
   }
   ++++++ REMOVE THIS LINE HERE++++++  */

}
/* INSTANTIATE THE NEW CONNECTION ---- [means create a new connection] */
$newConnection = new InvokeDatabase();

/* EXAMPLE: create the session id for user loged */
/* UNCOMMENT THE FOLLOWING TO TEST IT */
/* NOTE: IF YOU SEE 'connection success in your browser means everything is ok, otherwise check const.php file for your connection parameters!' */

/* +++++++ REMOVE THIS LINE HERE ++++++++

if($newConnection->__GetUsers() === (bool)false) {echo "connection failed!<br>";}else{echo "connection success!<br>";}
$_SESSION["userID"] = $newConnection->__GetUsers();
echo "USERNAME: " . $_SESSION["userID"];

/* ++++++++ REMOVE THIS LINE HERE +++++++++*/
 ?>
