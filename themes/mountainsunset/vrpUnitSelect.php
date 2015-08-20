<div id="selectCondo_wrapper">
	<select id="selectCondo">
	    <option value="">Select Unit by Name/Code</option>
	    <?php global $vrp;
	        $r = $vrp->proplist();
	        foreach ($r as $v){
	        echo "<option value=\"$v->page_slug\">$v->Name</option>";   
	        }
	    ?>
	    
	</select>
</div> <!-- close .condoselectwrapper -->