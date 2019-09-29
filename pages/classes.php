<?php
    class Tools
    {
        public static function connect($host='localhost:3306',$user='root', $password='', $dbname='consultsdb')
        {
            $cs = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
            ];
            try
            {
                $pdo= new PDO($cs, $user, $password, $options);
                return $pdo;
            }
            catch(PDOException $ex)
            {
                echo $ex->getMessage();
                return false;
            }
        }

        public static function register($login, $password, $image_path)
        {
            $login = trim(htmlspecialchars($login));
            $password = trim(htmlspecialchars($password));
            $image_path = trim(htmlspecialchars($image_path));
            if($login == '' || $password == '' || $image_path == ''){
                echo  "<script>alert('Fill All Required Fields')</script>";
                return false;
            }
            Tools::connect();
            $customer = new Customer($login, $password, $image_path);
            $err = $customer->intoDb();
            if($err){
                if($err == 1062){
                    echo  "<script>alert('This login is Already Token')</script>";
                }
                else {
                    echo  "<script>alert($err)</script>";
                }
                return false;
            }
            return true;
        }

        public static function signIn($login, $password)
        {
            if($login === '' || $password === ''){
                echo  "<script>alert('Fill All Required Fields')</script>";
                return false;
            }
            $login = trim(htmlspecialchars($login));
            $password = md5(trim(htmlspecialchars($password)));
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare("select * from customers where customers.login = ? and customers.password = ?");            
                $ps->execute([$login, $password]);
                if($row = $ps->fetch()){
                    return $row;
                }
                else return false;
                
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        }
    }

    class Customer
    {
        protected $id;
        protected $login;
        protected $password;
        protected $role_id;
        protected $discount;  //null
        protected $image_path; //null
        public function __construct($login, $password, $image_path, $id = 0)
        {
            $this->login = $login;
            $this->password = md5($password);
            $this->image_path = $image_path;
            $this->id = 0;
            $this->role_id = 2;
        }
        public function intoDb()
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare('insert into customers(login, password, role_id, discount, image_path) values(:login, :password, :role_id, :discount, :image_path)');
                $array =  ['login'=>$this->login, 'password'=>$this->password, 'role_id'=>$this->role_id, 'discount'=>$this->discount, 'image_path'=> $this->image_path];
                $ps->execute($array);
            } catch (PDOException $ex) {
                $err = $ex->getMessage();
                if(substr($err ,0 ,strpos($err, ':')) =='SQLSTATE[23000]:Integrity constraint violation'){
                    return 1062;
                }
                else{
                    return $ex->getMessage();
                }
            }
        }
        public static function fromDb($id)
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare("select * from customers where id=?");            
                $ps->execute([$id]);
                $row = $ps->fetch();
                $customer = new Customer($row['login'], $row['password'], $row['image_path'], $row['id']);
                return $customer;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        }
        public function getLogin()
        {
            return $this->login;
        }
    }

    class Room
    {
        protected $id;
        protected $number;
        protected $size;

        public function __construct($number, $size, $id = 0)
        {
            $this->number = $number;
            $this->size = $size;
            $this->id = 0;
        }
        public function intoDb()
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare('insert into rooms(number, size) values(:number, :size)');
                $array =  ['number'=>$this->number, 'size'=>$this->size];
                $ps->execute($array);
            } catch (PDOException $ex) {
                $err = $ex->getMessage();
                if(substr($err ,0 ,strpos($err, ':')) =='SQLSTATE[23000]:Integrity constraint violation'){
                    return 1062;
                }
                else{
                    return $ex->getMessage();
                }
            }
        }
        public static function fromDb($id)
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare("select * from rooms where id=?");            
                $ps->execute([$id]);
                $row = $ps->fetch();
                $room = new Room($row['number'], $row['size'], $row['id']);
                return $room;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        }
    }

    class Consult
    {
        protected $id;
        protected $room_id;
        protected $customer_id;
        protected $date;
        protected $pare;
        protected $students;
        protected $info;
        protected $approved;
        public function __construct($room_id, $customer_id, $date, $pare, $students, $info, $approved = 0, $id = 0)
        {
            $this->room_id = $room_id;
            $this->customer_id = $customer_id;
            $this->date = $date;
            $this->pare = $pare;
            $this->students = $students;
            $this->info = $info;
            $this->approved = $approved;
            $this->id = 0;
        }
        public function intoDb()
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare("insert into consults(room_id, customer_id, date, pare, students, info, approved) values(:room_id, :customer_id, :date, :pare, :students, :info, :approved)");
                $array = ['room_id'=>$this->room_id, 'customer_id'=>$this->customer_id, 'date'=>$this->date, 'pare'=>$this->pare, 'students'=>$this->students, 'info'=>$this->info, 'approved'=>$this->approved];
                $ps->execute($array);
            } catch (PDOException $ex) {
                $err = $ex->getMessage();
                if(substr($err ,0 ,strpos($err, ':')) =='SQLSTATE[23000]:Integrity constraint violation'){
                    return 1062;
                }
                else{
                    return $ex->getMessage();
                }
            }
        }
        public static function fromDb($id)
        {
            try {
                $pdo = Tools::connect();
                $ps = $pdo->prepare("select * from consults where id=?");            
                $ps->execute([$id]);
                $row = $ps->fetch();
                $consult = new Consult($row['room_id'], $row['customer_id'], $row['date'], $row['pare'], $row['students'], $row['info'], $row['approved'], $row['id']);
                return $consult;
            } catch (PDOException $ex) {
                echo $ex->getMessage();
                return false;
            }
        }
    }
?>