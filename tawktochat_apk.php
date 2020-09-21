<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    Tawk_API.visitor = {
        name : '<?php echo $_GET['name'];?>',
        email : '<?php echo $_GET['email'];?>'
    };
(function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/5cc7e7eed07d7e0c639138b0/default';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
})();
Tawk_API.onLoad = function(){
    Tawk_API.toggle();
    
	Tawk_API.addEvent('my-detail', {    	
        'Restaurant-Name' : '<?php echo $_GET['r_name']; ?>',
        'Phone' : '<?php echo $_GET['r_phone']; ?>',
        'Address' : '<?php echo $_GET['r_address']; ?>'
    }, function(error){ console.log('inside error = ', error); });
};
    
/*Tawk_API.onChatEnded = function(){
    alert('onChatEnded');
}

Tawk_API.onChatStarted = function(){
    alert('onChatStarted');
}*/

Tawk_API.onChatHidden = function(){
    // on click cross button
    if(!Tawk_API.isChatMaximized()){
        //Tawk_API.maximize();
        //window.location.reload();
    }
} 

Tawk_API.onChatMinimized = function(){
    // on click cross button
    console.log('onChatMinimized');
    if(!Tawk_API.isChatMaximized()){
        console.log('isChatMaximized');
    //    Tawk_API.maximize();
	$('.iframeTop').hide();
	window.location.hash = 'orders';
    }
}

/*Tawk_API.onChatMaximized = function(){
    alert('onChatMaximized');
}*/
</script>
<!--End of Tawk.to Script-->