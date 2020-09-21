<?php



//keys to the kingdom

//





define('DB_SERVER','192.168.1.11');

define('DB_DATABASE','fooddudestaging_staging');

define('DB_SERVER_USERNAME','fooddudestaging_user');

define('DB_SERVER_PASSWORD','3W.mmR=Q]#{U');



if(true){

define('BRAINTREE_ENVIROMENT','production');

define('BRAINTREE_MERCHANT_ID','vt7n4fr3h9xwkn55');

define('BRAINTREE_PUBLIC_KEY','frpvgg3g7xyjzzwk');

define('BRAINTREE_PRIVATE_KEY','aed2ba70051f1055050d30076f965142');

}else{

//

define('BRAINTREE_ENVIROMENT','sandbox');

define('BRAINTREE_MERCHANT_ID','vztk698qjg5q4xzp');

define('BRAINTREE_PUBLIC_KEY','hjmqb53r3q8nrh37');

define('BRAINTREE_PRIVATE_KEY','711108442f94ca4cc8416c94d1f52829');

}

//define('SERVER_NAME','192.168.1.11');

//define('DATABASE_NAME','deliverhop_mirror');

//define('DATABASE_USER','fooddudestaging_user');

//define('DATABASE_PASS','nAb9H!q9V2DEpRz^');









define('TEXT_YOUR_ORDER_NUMBER','Your order number is: ');

define('TEXT_THANK_YOU','Thank You!');

define('TEXT_START_PAGE_OR','Or');

define('TEXT_SUBTOTAL','Subtotal: ');

define('TEXT_TAX','Tax: ');

define('TEXT_DELIVERY_FEE','Delivery Fee: ');

define('TEXT_TIP','Tip: ');

define('TEXT_GRAND_TOTAL','Total: ');

define('TEXT_DELIVERY','Delivery');

define('TEXT_PICKUP','Pickup');

define('TEXT_GOOGLE_SEARCH_PLACEHOLDER','Enter an Address');

define('TEXT_HEADER_CONTACT','Contact');

define('TEXT_HEADER_CART','Cart');

define('TEXT_HEADER_TOTALS','Totals');

define('TEXT_HEADER_PAYMENT','Payment');

define('TEXT_HEADER_SPECIAL','Special Instructions');

define('TEXT_EMPTY_CART','Your cart is empty');

define('TEXT_EXIT_ORDERING','Exit');

define('TEXT_HEADER_DELIVERY_HOURS','Delivery Hours');



define('TEXT_HEADER_PICKUP_HOURS','Pickup Hours');













//regular defines

define('TAX_MULTIPLYER',10000000);

define('SPECIAL_INSTRUCTIONS_STRING','Special Instructions');





///VVV Error messages VVV

//credit card errors

define('ERROR_NO_NONCE','no nonce man');





//top level errors

define('ERROR_FAILED_TO_LINK','There was an error please try again');

define('ERROR_TOP_LEVEL_LOCATION','There was an error finding your address');

define('ERROR_TOP_LEVEL_TIME','There was an error with the menu times');

define('ERROR_TOP_LEVEL_TOTAL','There was an error calculating totals');

define('ERROR_TOP_LEVEL_DISPLAY','There was an error');

define('ERROR_TOP_LEVEL_CREATE_ORDER','There was an error creating your order please call (320) 251-1888');

define('ERROR_TOP_LEVEL_RESTAURANT_MATRIX','There was an error finding products');

define('ERROR_TOP_MUST_GENERATE_MATRIX','Error please try again');

//most important error messages 

define('ERROR_INVALID_CATEGORIES_ID','Error online ordering is currently offline');

define('ERROR_INVALID_POST_KEY','Error online ordering is currently offline temporarely');

define('ERROR_SPECIFY_DELIVERY','Error please try again.');

define('ERROR_VALIDATE_OPEN_MENUS','Error please refresh');

define('ERROR_DEFAULT_SWITCH_KEY','Error bad connection');





//config errors

define('ERROR_NO_LAT_OR_LNG_CONFIG','no restaurant lat or lng');

define('ERROR_NO_DELIVERY_CONFIG','no delivery config');

define('ERROR_NO_DELIVERY_ACTIVE_CONFIG','no delivery acive config');

define('ERROR_NO_DELIVERY_CREDIT_CONFIG','no delivery credit');

define('ERROR_NO_DELIVERY_CASH_CONFIG','no rdelivery cash');

define('ERROR_NO_PICKUP_CONFIG','no pickup config');

define('ERROR_NO_PICKUP_ACTIVE_CONFIG','no pickup active');

define('ERROR_NO_PICKUP_CREDIT_CONFIG','no pickup credit');

define('ERROR_NO_PICKUP_INSTORE_CONFIG','no pickup INSTORE');



//location error messages

//pobably wont get used

define('ERROR_COORDS_COUNT','Wrong amount of coords');

define('ERROR_COORDS_NOT_DOUBLE','coords arent doubles');

define('ERROR_NO_JSON_RANGE','no json range found');

define('ERROR_COORDS_NOT_IN_POLYGON','coords not inside polygon');

define('ERROR_NO_DELIVERY_ADDRESS','order has delivery so it must have a delivery address');

define('ERROR_NO_ZIPCODE','enter a zip');

define('ERROR_DISTANCE_TOO_FAR','rror distance too far');

define('ERROR_BAD_ZIPCODE','Please enter a valid zipcode');

define('ERROR_DELIVERY_NOT_BOOLEAN','delivery not boolean');



//time error messages

define('ERROR_RESTAURANT_IS_CLOSED_HOLIDAY','Closed for holiday');

define('ERROR_RESTAURANT_IS_ON_BREAK','On break be back soon');

define('ERROR_RESTAURANT_IS_CLOSED_MENU','All menus closed for the day');



//total error messages

define('ERROR_BAD_PRODUCT_ID','messup up product id');

define('ERROR_BAD_QUANTITY','messup up cart quantiy/ quantity below 1');

define('ERROR_BAD_OPTIONS','options is not array');

define('ERROR_NO_ORDER','Malformed Order');

define('ERROR_NO_CART','No cart on order');

define('ERROR_MALFORMED_CART','malformed cart yo');

define('ERROR_NO_TAX','Couldnt find tax');

define('ERROR_NO_ZIP','No zipcode');

//define('ERROR_TSA_PRECHECK','  tsa');

define('ERROR_NO_DASH_IN_OPTION','no dash in option');





//display error messages

define('ERROR_NO_MAIN_MENU','No main menus');

define('ERROR_NO_SUB_MENU','No sub menus');

define('ERROR_NO_PRODUCTS','No products');





?>