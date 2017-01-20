		</div> <!-- #main -->					
	</div> <!-- #body -->
<!-- Start #footer -->
	<div id="footer">
		<center>
		<p>Page generated in <?php echo round(PAGE_LOAD_TIME, 4);?> sec.
			Query's: (Realm DB: <?php echo $DB->_statistics['count']; ?>,
			World DB: <?php echo $WDB->_statistics['count']?>,
			Character DB: <?php echo $CDB->_statistics['count']?>)<br/>
			Template originally designed by <a href="http://rodcreative.com/">Rod Creative</a>, Modified by Wilson212 for MangosWeb.<br /> 
			<?php echo $Core->copyright; // DONOT remove!!! ?> 
		</p>
		</center>
	</div>
</div> <!-- #page -->
</body>
</html>