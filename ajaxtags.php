<input type="text" name="transaction-tags" id="transaction-tags" class="input" value=""/>
<script>
	$('#transaction-tags').tagbox({
        url: "classes/valuelist.class.php?valuelist=tags",
        jval: CLIENT_TAGS,
        lowercase: true,
        minLength: 1,
        maxLength: 20
    });
</script>