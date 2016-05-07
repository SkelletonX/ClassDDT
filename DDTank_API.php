<?php
/**
 * DDTank_API short summary.
 *
 * DDTank_API description.
 *
 * @version 1.0
 * @author SkelletonX
 */

error_reporting(0);
echo "APi DDTank";

class config
{
	//** Configuração do MSSQL *//
	public $host = "SKELLETONX\SQLEXPRESS";
	public $user = "sa";
	public $pass = "123456";
	public $db = "Db_Tank";
	//** Mostrar o erro, recomendado ativar apenas se foi em localhost de desenvolvimento */
	public $debug = true;
}
class DDt_API extends config
{
	public $pdo = null;

	function __construct()
	{
		//Conectar ao banco de dados
		$this->Connect();
	}

	/*
	 * Conectar ao banco de dados utilizando PDO.
	 */
	function Connect()
	{
		try {
			$this->pdo = new PDO("sqlsrv:server=" . $this->host . "; Database=" . $this->db, $this->user, $this->pass);
			//Caso o $debug esteja em true, mostrar os erros dos querys.
			if ($this->debug){
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo "<p style='color:red;'>DEBUG MODE ENABLED</p>";

			}


		} catch (PDOException $e) {
			if ($this->debug) {
				//Caso o $debug esteja em true, mostrar os erros de falha.
				var_dump($this->pdo);
				die($e->getMessage());
			} else {
				die("<h1>Internal server error.</h1><br>Por favor, visite novamente mais tarde.");
			}

		}
	}
	public function registro($user, $pass,$nick, $sex = 0, $email = "SkelletonX@SkelletonX.com.br", $gp = 20000,$money = 0,$gift = 0,$gold = 0, $ApplicationName = "DanDanTang")
	{
		$exist = $this->pdo->prepare("SELECT * FROM Sys_Users_Detail WHERE UserName=:login");
		$exist->execute(array(":login" => $user));
		$r3 = $exist->rowCount();

		if ($r3 == -1) {
			//Conta existente
			return false;
		} else {
			//Registrar usuario na Db_Membership
			$pw = strtoupper(md5($pass));
			
			$reg = $this->pdo->prepare("exec Db_Membership.dbo.Mem_Users_CreateUser @ApplicationName=:application,@UserName=:user,@password=:pass,@email=:email,@PasswordFormat='1',@PasswordSalt='MD5',@UserSex=:sex,@UserId=''");
			$reg->execute(array(
				":application" => $ApplicationName,
				":user" => $user,
				":pass" => $pw,
				":email" => $email,
				":sex" => $sex
			));
			$d = $reg->rowCount();
			if ($d > 0) {
				echo "Registrou com sucesso";
				$uid = 0;
				if($d != null AND $d != 0 AND $d == 1){
					if($sex == 0){
						$reg3 = $this->pdo->prepare("exec Db_Tank.dbo.SP_Users_RegisterNotValidate @UserName=:user,@PassWord=:pass,@NickName=N:nick,@BArmID=7026,@BHairID=3158,@BFaceID=6103,@BClothID=5160,@BHatID=1142,@GArmID=7008,@GHairID=3158,@GFaceID=6103,@GClothID=5160,@GHatID=1142,@ArmColor=N'',@HairColor=N'',@FaceColor=N'',@ClothColor=N'',@HatColor=N'',@Sex=N:sex,@StyleDate=0");
						$reg3->execute(array(
							":user" => $user,
							":pass" => $pw,
							":nick" => $nick,
							":sex" => $sex
						));
						$d = $reg3->rowCount();
						$reg4 = $this->pdo->prepare("exec Db_Tank.dbo.SP_Users_LoginWeb @UserName=N:user,@Password=N'',@FirstValidate=0,@Nickname=N:nick");
						$reg4->execute(array(
							":user" => $user,
							":nick" => $nick
						));
						$d2 = $reg4->rowCount();
						if($d > 0 && $d2 > 0){return true;}
					}
					elseif($sex == 1){
						$reg4 = $this->pdo->prepare("INSERT INTO Sys_Users_Fight ([UserID],[Attack],[Defence],[Luck],[Agility],[Delay],[Honor],[Map],[Directory],[IsExist]) VALUES(:userid,100,48,100,18,1,1,1,1,'True')");
						$reg4->execute(array(
							":userid" => $userid[0]
						));
						$d2 = $reg4->rowCount();
						if($d > 0 && $d2 > 0){return true;}
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
			print_r($this->pdo->errorInfo());
		}
	}

	/*
	  <Item Level="1" Exp(GP)="0" Blood="500" />
	  <Item Level="2" Exp(GP)="37" Blood="600" />
	  <Item Level="3" Exp(GP)="162" Blood="700" />
	  <Item Level="4" Exp(GP)="505" Blood="800" />
	  <Item Level="5" Exp(GP)="1283" Blood="900" />
	  <Item Level="6" Exp(GP)="2801" Blood="1000" />
	  <Item Level="7" Exp(GP)="5462" Blood="1200" />
	  <Item Level="8" Exp(GP)="9771" Blood="1300" />
	  <Item Level="9" Exp(GP)="16341" Blood="1400" />
	  <Item Level="10" Exp(GP)="25899" Blood="1450" />
	  <Item Level="11" Exp(GP)="39291" Blood="1530" />
	  <Item Level="12" Exp(GP)="57489" Blood="1610" />
	  <Item Level="13" Exp(GP)="81594" Blood="1690" />
	  <Item Level="14" Exp(GP)="112847" Blood="1770" />
	  <Item Level="15" Exp(GP)="152630" Blood="1850" />
	  <Item Level="16" Exp(GP)="202472" Blood="1970" />
	  <Item Level="17" Exp(GP)="264058" Blood="2090" />
	  <Item Level="18" Exp(GP)="339232" Blood="2210" />
	  <Item Level="19" Exp(GP)="430003" Blood="2330" />
	  <Item Level="20" Exp(GP)="538554" Blood="2450" />
	  <Item Level="21" Exp(GP)="667242" Blood="2620" />
	  <Item Level="22" Exp(GP)="818609" Blood="2790" />
	  <Item Level="23" Exp(GP)="995383" Blood="2960" />
	  <Item Level="24" Exp(GP)="1200489" Blood="3130" />
	  <Item Level="25" Exp(GP)="1437053" Blood="3300" />
	  <Item Level="26" Exp(GP)="1753103" Blood="3380" />
	  <Item Level="27" Exp(GP)="2112735" Blood="3460" />
	  <Item Level="28" Exp(GP)="2519637" Blood="3540" />
	  <Item Level="29" Exp(GP)="2977665" Blood="3620" />
	  <Item Level="30" Exp(GP)="3490849" Blood="3700" />
	  <Item Level="31" Exp(GP)="4145185" Blood="3870" />
	  <Item Level="32" Exp(GP)="4873978" Blood="4040" />
	  <Item Level="33" Exp(GP)="5684269" Blood="4210" />
	  <Item Level="34" Exp(GP)="6583537" Blood="4380" />
	  <Item Level="35" Exp(GP)="7579710" Blood="4550" />
	  <Item Level="36" Exp(GP)="8681174" Blood="4670" />
	  <Item Level="37" Exp(GP)="9896788" Blood="4790" />
	  <Item Level="38" Exp(GP)="11235892" Blood="4910" />
	  <Item Level="39" Exp(GP)="12708322" Blood="5030" />
	  <Item Level="40" Exp(GP)="14324419" Blood="5150" />
	  <Item Level="41" Exp(GP)="16263735" Blood="5200" />
	  <Item Level="42" Exp(GP)="18590915" Blood="5250" />
	  <Item Level="43" Exp(GP)="21383531" Blood="5300" />
	  <Item Level="44" Exp(GP)="24734669" Blood="5350" />
	  <Item Level="45" Exp(GP)="28756036" Blood="5400" />
	  <Item Level="46" Exp(GP)="33581676" Blood="5450" />
	  <Item Level="47" Exp(GP)="39372443" Blood="5500" />
	  <Item Level="48" Exp(GP)="46321365" Blood="5550" />
	  <Item Level="49" Exp(GP)="54660070" Blood="5600" />
	  <Item Level="50" Exp(GP)="63832646" Blood="5650" />
	  <Item Level="51" Exp(GP)="73922480" Blood="5680" />
	  <Item Level="52" Exp(GP)="85021297" Blood="5710" />
	  <Item Level="53" Exp(GP)="97229996" Blood="5740" />
	  <Item Level="54" Exp(GP)="110659565" Blood="5770" />
	  <Item Level="55" Exp(GP)="125432090" Blood="5800" />
	  <Item Level="56" Exp(GP)="140943242" Blood="5830" />
	  <Item Level="57" Exp(GP)="157229951" Blood="5860" />
	  <Item Level="58" Exp(GP)="174330996" Blood="5890" />
	  <Item Level="59" Exp(GP)="192287093" Blood="5920" />
	  <Item Level="60" Exp(GP)="211140995" Blood="5950" />
	  <Item Level="61" Exp(GP)="232929344" Blood="5980" />
	  <Item Level="62" Exp(GP)="254760446" Blood="6010" />
	  <Item Level="63" Exp(GP)="277932264" Blood="6040" />
	  <Item Level="64" Exp(GP)="302844798" Blood="6070" />
	  <Item Level="65" Exp(GP)="329898048" Blood="6100" />
	  <Item Level="66" Exp(GP)="492422852" Blood="6150" />
	  <Item Level="67" Exp(GP)="541665137" Blood="6200" />
	  <Item Level="68" Exp(GP)="595831651" Blood="6250" />
	  <Item Level="69" Exp(GP)="714997981" Blood="6300" />
	  <Item Level="70" Exp(GP)="857997577" Blood="6400" /> */
	public function addlevel($Level, $Exp, $nick){

		$user = $this->pdo->prepare("SELECT * FROM Sys_Users_Detail WHERE UserName=:login");
		$user->execute(array(":login" => $nick));
		$r = $user->rowCount();
		if ($r == -1) { //verificando se o player Existe
		 
		$res = $this->pdo->prepare("UPDATE Sys_Users_Detail SET Grade = :lv WHERE NickName=:nick");
		$res->execute(array(
		
			":lv" => $Level,
			":nick" => $nick
		));
		if ($res->rowCount())
		$res2 = $this->pdo->prepare("UPDATE Sys_Users_Detail SET GP = :exp WHERE NickName=:nick");
		$res2->execute(array(
			":exp" => $Exp,
			":nick" => $nick
		)); 
		if ($res2->rowCount())
		return true;
		}
		else
		{
		Echo "Player Não Existe.";
		return false;
		}
		}
	public function  playerons($serverid){
		 $stmt =$this->pdo->prepare("SELECT * FROM Server_List WHERE ID = $serverid");
		 //Caso você quiser que aparece outros canais deixa a query somente assim
		 //(SELECT * FROM Server_List);  sem Where.
		 $stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
	//Name,IP,Online,Port e ZoneName todos são opcional 
		echo "Nome do DDTank :" . $row['Name']    . "<br>";          
		echo "IP: "             .$row['IP']       . "<br>";
		echo "Players Online: " .$row['Online']   . "<br>";
		echo "Porta :"          .$row['Port']     . "<br>";
		echo "Canal: "          .$row['ZoneName'] . "<br><br>"; //nome do canal

	 }

}
    public function infoplayer($Nick){
            $query =$this->pdo->prepare("SELECT * FROM Sys_Users_Detail WHERE NickName = '$Nick'");
            $query->execute();
            $r = $query->rowCount();
            if ($r == -1) {
            while($row = $query->fetch(PDO::FETCH_ASSOC)){

            echo "Login: "    . $row['UserName']    . "<br>";
            echo "Nick: "      . $row['NickName']   . "<br>";
            echo "Level: "     . $row['Grade']      . "<br>";
            echo "Exp: "       . $row['GP']         . "<br>";
            echo "FC: "        . $row['FightPower'] . "<br>";
            echo "Moeda: "     . $row['Gold']       . "<br>";
            echo "Cupons: "    . $row['Money']      . "<br>";
            echo "Ultimo IP: " . $row['ActiveIP']   . "<br><br>";
       } 
    }
    else
    {

    echo "Player Não Existe.";

    }
}
    public function emaillog(){
            $query =$this->pdo->prepare("SELECT * FROM User_Messages");
            $query->execute();
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
            
            echo "Id do email:". $row['ID'] . "<br>" ."O Player: " . $row['Sender'] ."<br>"." envio o email, para: "
                 . $row['Receiver'] ."<br>"." Texto do email: " . $row['Content'] ."<br>". " Items enviados : " 
                 . $row['Remark']."<br><br><br>";
           }
    }
}
?>