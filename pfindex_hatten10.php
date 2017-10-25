<?php
	// データベースに接続するためのスクリプトを読込
	require("./dbaccess.php");

	// H T M L に表示するための各変数
	$total_list = "";
	$result_list = "";
	$owner_list = "";
	$pets_list = "";


	// ペットを検索し、その情報　　を変更するクエリ文とその実行
	 if (isset($_POST['pname'])) {
		if (isset($_POST['petchg'])) {
			//petinsが存在するか(ペット追加の決定ボタンが押されたか) どうかを判定
			// 送られてきた各データをp e t テーブルに挿入するクエリ文
			$sql = 	"UPDATE pet SET ";
				if(!empty($_POST['rpetname']))
					$sql .= "name = '"    .$_POST['rpetname']. "' ";
			
				if((!empty($_POST['rpetbirth'])||!empty($_POST['rpetsex'])||!empty($_POST['rpetspecies']))&&!empty($_POST['rpetname'])) 	$sql .=",";
				if(!empty($_POST['rpetspecies']))
					$sql .= "species = '"    .$_POST['rpetspecies']. "' ";
				
				if((!empty($_POST['rpetbirth'])||!empty($_POST['rpetsex']))&&!empty($_POST['rpetspecies']))	$sql .= ",";
				if(!empty($_POST['rpetsex']))
					$sql .= "sex = '"    .$_POST['rpetsex']. "' ";
			
				if(!empty($_POST['rpetbirth'])&&!empty($_POST['rpetsex'])) 	$sql .=",";
				if(!empty($_POST['rpetbirth']))	
					$sql .= "birth = '"    .$_POST['rpetbirth']. "'";
	
				if(isset($_POST['s_petchg']))
					$sql .= " WHERE name LIKE '%"   .$_POST['pname'].  "%'";
				else  
					$sql .=	" WHERE name = '"   .$_POST['pname'].  "'";
			 executeQuery($sql);
		} else if (isset($_POST['petdel'])) {
			// petdelが存在する(ペット削除の決定ボタンが押されたか) かどうかを判定

			// 送られてきたデータに一致するものを削除するクエリ文
			$sql = "DELETE FROM pet
			WHERE name='".$_POST['pchange']."'";
			$result = executeQuery($sql);
			mysqli_free_result($result);
	
		}

	}

	// データベースの内容を表示
	$sql =
		"SELECT * ".
		"FROM pet";
	$result = executeQuery($sql);
	$rows = mysqli_num_rows($result);
	if($rows){
		while($row = mysqli_fetch_array($result)) {
			$total_list.=
				"<tr>".
					"<td>".$row['name']."</td>".
					"<td>".$row['species']."</td>".
					"<td>".$row['sex']."</td>".
					"<td>".$row['birth']."</td>".
				"</tr>";
		}
	}
	mysqli_free_result($result);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//JP" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>情報工学演習III用</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>

	<body>
		<header>
			情報工学演習III用システム2 <br>
		</header>
		<div>
			<table border=4 align=center>

				<tr bgcolor="#cccccc">
					<th>ペットの名前</th>
					<th>種類</th>
					<th>性別</th>
					<th>誕生日</th>
					</tr>
				<?php echo $total_list ?>
			</table>
		</div>
		<div>
			<h3>ペットの情報を変更</h3>
			<form action="pfindex_hatten10.php" method="post">
				・変更するペットの名前を入力　：<input type="text" name="pname" size="20">
				（部分一致検索ををオンにする ：	<input type="radio", name="s_petchg","1">）<br>
				変更部分を書き換えてください、複数変更可能です。<br>
					　　　名前：　　　<input type="text" name="rpetname" size="20"><br>
					　　　種類：　　　<input type="text" name="rpetspecies" size="6"><br>
					　　　性別：　　　<input type="text" name="rpetsex" size="2"><br>
					　　　生年月日：<input type="text" name="rpetbirth" size="6"><br>
				<input type="submit" value="変更" name="petchg">
				<input type="reset" value="削除">
			</form>
		</div>
	</body>
</html>