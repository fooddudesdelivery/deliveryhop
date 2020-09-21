<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;target-densityDpi=device-dpi" />
<title>Online Ordering</title>
<link href='https://fonts.googleapis.com/css?family=Lato:400,900,700italic,700,400italic,900italic,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
<?php $this->generateJsDefines(); ?>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" href="css/jquerymobile.css">

<?php $this->displayPage('style'); ?>

<script>
if (!('indexOf' in Array.prototype)) {
    Array.prototype.indexOf= function(find, i /*opt*/) {
        if (i===undefined) i= 0;
        if (i<0) i+= this.length;
        if (i<0) i= 0;
        for (var n= this.length; i<n; i++)
            if (i in this && this[i]===find)
                return i;
        return -1;
    };
}
</script>
<script type="text/javascript" src="js/jquerybootstrap.js" ></script>


<script src="js/jquerymobile.js"></script>


