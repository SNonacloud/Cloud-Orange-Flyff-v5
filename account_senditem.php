<?php include('inc/header.php'); ?>
<h1>Send items</h1>
<div class="container">
<?php
	if(isset($_POST['senditem_sbm'])) {
        $charid = odbc_exec($odbc_connect, 'SELECT m_idPlayer FROM [' . $_CONFIG['db_databases']['chr'] . '].dbo.[CHARACTER_TBL] WHERE m_szName=\''.mssql_escape_string($_POST['character']).'\'');
        $charname = odbc_exec($odbc_connect, 'SELECT m_szName FROM [' . $_CONFIG['db_databases']['chr'] . '].dbo.[CHARACTER_TBL] WHERE m_szName=\''.mssql_escape_string($_POST['character']).'\'');
        if(odbc_num_rows($charid) == 1) {        
        
            $ItemSendToCharakter = '
                INSERT INTO [' . $_CONFIG['db_databases']['chr'] . '].dbo.[ITEM_SEND_TBL] (
					m_idPlayer, serverindex, Item_Name, Item_count, m_nAbilityOption, m_bItemResist, m_nResistAbilityOption, idSender, nPiercedSize
                ) VALUES(
                    \''.mssql_escape_string(odbc_result($charid, 'm_idPlayer')).'\',
                    \'01\',
                    \''.mssql_escape_string($_POST['itemname']).'\',
                    \''.mssql_escape_string($_POST['count']).'\',
                    \''.mssql_escape_string($_POST['upgrade']).'\',
                    \''.mssql_escape_string($_POST['element']).'\',
                    \''.mssql_escape_string($_POST['elementupgrade']).'\',
                    \'0000000\',
                    \''.mssql_escape_string($_POST['piercing']).'\'
                )
            ';
                
            $ItemSendLog = '
                INSERT INTO [' . $_CONFIG['db_databases']['web'] . '].dbo.[LOG_SENDITEM] (
                    von, an, itemname, count, upgrade, element, elementupgrade, piercing
                ) VALUES(
					\''.mssql_escape_string($_SESSION['user']).'\',
                    \''.mssql_escape_string(odbc_result($charname, 'm_szName')).'\',
                    \''.mssql_escape_string($_POST['itemname']).'\',
                    \''.mssql_escape_string($_POST['count']).'\',
                    \''.mssql_escape_string($_POST['upgrade']).'\',
                    \''.mssql_escape_string($_POST['element']).'\',
                    \''.mssql_escape_string($_POST['elementupgrade']).'\',
                    \''.mssql_escape_string($_POST['piercing']).'\'
                )
            ';            
            if(@odbc_exec($odbc_connect, $ItemSendToCharakter) AND @odbc_exec($odbc_connect, $ItemSendLog)) {
            echo createMessage('The item was sent successfully', 'success');
            }
            else {
                echo createMessage('The item could not be sent', 'fail');
            }
        } else {
            echo '<div class="fail">Character does not exist!</div>';
        }
 
} 	
	
	
	
	echo '
<h2>Send item to a player</h2>
<form action="" method="post">
<table>
	<tr>
		<td>Character:</td>
		<td><input type="text" name="character" /></td>
	</tr>
	<tr>
		<td>Item Name:</td>
		<td><input type="text" name="itemname" /></td>
	</tr>
	<tr>
		<td>Item Number:</td>
		<td><input type="text" name="count" /></td>
	</tr>
	<tr>
		<td>Item Upgrade:</td>
		<td>
			<select name="upgrade">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Socket Amount:</td>
		<td>
			<select name="piercing">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Element Type:</td>
		<td>
			<select name="element">
				<option value="0">None</option>
				<option value="1">Fire</option>
				<option value="2">Water</option>
				<option value="3">Electric</option>
				<option value="4">Wind</option>
				<option value="5">Earth</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Element Upgrade:</td>
		<td>
			<select name="elementupgrade">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="senditem_sbm" value="Send Item" /></td>
	</tr>
</table>
</form>';

echo '
<br />
<h2>Frequently needed items</h2>
<table cellspacing="0">
	<thead>
		<tr>
			<td>Itemname</td>
			<td>Item-ID</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Perins</td>
			<td>26456</td>
		</tr>
	</tbody>
</table>';





if(isset($_GET['nonlog'])){
	if(isset($_POST['senditem_nl'])) {
		odbc_exec($odbc_connect, 'USE [' . $_CONFIG['db_databases']['chr'] . ']');
			$charid = odbc_exec($odbc_connect, 'SELECT m_idPlayer FROM [CHARACTER_TBL] WHERE m_szName=\''.mssql_escape_string($_POST['character']).'\'');
			if(odbc_num_rows($charid) == 1) {
				odbc_exec($odbc_connect, 'INSERT INTO [ITEM_SEND_TBL](
				m_idPlayer, serverindex, Item_Name, Item_count, m_nAbilityOption, m_bItemResist, m_nResistAbilityOption, idSender, nPiercedSize
				) VALUES(
				\''.mssql_escape_string(odbc_result($charid, 'm_idPlayer')).'\',
				\'01\',
				\''.mssql_escape_string($_POST['itemname']).'\',
				\''.mssql_escape_string($_POST['count']).'\',
				\''.mssql_escape_string($_POST['upgrade']).'\',
				\''.mssql_escape_string($_POST['element']).'\',
				\''.mssql_escape_string($_POST['elementupgrade']).'\',
				\'0000000\',
				\''.mssql_escape_string($_POST['piercing']).'\'
				)');
				echo '<div class="success">The item has successfully been send!</div>';
			} else {
				echo '<div class="fail">Character does not exist!</div>';
			}
		}
     
	
	
	echo '
<h2>Send item to a player</h2>
<form action="" method="post">
<table>
	<tr>
		<td>Character:</td>
		<td><input type="text" name="character" /></td>
	</tr>
	<tr>
		<td>Item Name:</td>
		<td><input type="text" name="itemname" /></td>
	</tr>
	<tr>
		<td>Item Number:</td>
		<td><input type="text" name="count" /></td>
	</tr>
	<tr>
		<td>Item Upgrade:</td>
		<td>
			<select name="upgrade">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Socket Amount:</td>
		<td>
			<select name="piercing">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Element Type:</td>
		<td>
			<select name="element">
				<option value="0">None</option>
				<option value="1">Fire</option>
				<option value="2">Water</option>
				<option value="3">Electric</option>
				<option value="4">Wind</option>
				<option value="5">Earth</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Element Upgrade:</td>
		<td>
			<select name="elementupgrade">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="senditem_nl" value="Send Item" /></td>
	</tr>
</table>
</form>';
}
