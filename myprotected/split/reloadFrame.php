	<div class="underhead">  
    	 <div class="r-z-header" id="r-z-header">
        	
            <div class="admin_header_line">Welcome</div>
            
         </div>
    </div><!-- underhead -->
        
    <div id="r-z-content">
    	<div id="sub-r-z-content">
        <div class="dashboard">
        	
            <?php 
			$table_schema 	= $db->q('SHOW TABLES');
			$all_users 		= $db->q('SELECT COUNT(id) as count FROM [pre]users',1);
			$admin_users 	= $db->q('SELECT COUNT(id) as count FROM [pre]users WHERE `type`=1',1);
			$mysqlVersion	= $db->q("SHOW VARIABLES LIKE 'version'",1);
			?>
			
            <br>
            <center>Welcome to admin panel <b><i>Annuity-Ranker</i></b>.</center>
            
            <h2 class="dataCaption">Application info-data</h2>
            
            <table class="maintable">
            	<thead>
                	<tr>
                    	<th>Parametr</th>
                		<th>Value</th>
                    </tr>
                </thead>
                <tbody>
                	<tr class="trcolor">
                    	<td class="param">Domain name</td>
                        <td class="value"><?= $_SERVER['HTTP_HOST'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">PHP version</td>
                        <td class="value"><?= phpversion() ?></td>
                    </tr>
                    <tr class="trcolor">
                    	<td class="param">MySQL version</td>
                        <td class="value"><?= $mysqlVersion['Value'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">Tables in database</td>
                        <td class="value"><?= count($table_schema) ?></td>
                    </tr>
                    <tr class="trcolor">
                    	<td class="param">Users count</td>
                        <td class="value"><?= $all_users['count'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">Superadmins count</td>
                        <td class="value"><?= $admin_users['count'] ?></td>
                    </tr>
                </tbody>
            </table>
            
         </div>
         </div><!-- sub-r-z-content -->
	</div><!-- r-z-content -->