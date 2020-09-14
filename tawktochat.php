<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
Tawk_API.visitor = {
name : '<?php echo $_GET['name'];?>',
email : '<?php echo $_GET['email'];?>',
hash : '<?php echo hash_hmac("sha256",$_GET['email'],"33d88ae6c6a4b6571b1db0274a353effd5007bba"); ?>'
};
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/597ef7c50d1bb37f1f7a6a53/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
Tawk_API.onLoad = function(){
    Tawk_API.toggle();
	Tawk_API.addEvent('my-detail', {    	
        'Order-no'    : '<?php echo str_replace(' ', '-', $_GET['name']);?>/<?php echo isset($_GET['orderno']) ? $_GET['orderno']: "none";?>'                
    }, function(error){});    
};
</script>
<!--End of Tawk.to Script-->