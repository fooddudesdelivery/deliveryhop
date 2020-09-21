	
window.SendAjax=function(params,success,error){
	'use strict';
	if(params==='test'){
		params={key:'test',params:'test'};
	}
	if(typeof params === 'undefined'){
		console.log('NO PARAMS AT AJAX');
		return;
	}
	if(typeof params !== 'object'){
		console.log('NO OBJECT AT AJAX');
		return;
	}
	if(typeof error === 'undefined'){
		error=function(data){
			console.log('ERROR AT SENDAJAX '+JSON.stringify(data)+JSON.stringify(params));
		};
	}
	if(typeof success === 'undefined'){
		success=function(data){
			console.log('SUCCESS AT SENDAJAX '+JSON.stringify(data));
		};
	}
	var loader=true;
	if(params.key==='reverse_signal_flare' || params.key==='signal_flare' || params.key==='current_order'  ){
		loader=false;
	}
	//var delay;
	if (loader) {
		//delay = setTimeout(function () {
		$('.loader').show();
		//}, 400);
	}

	$.ajax({
		url: 'https://deliverhop.app/cordova_new/www/receive.php',
		dataType: 'JSON',
		cache: false,
		type: 'POST',
		data: { restaurant: JSON.stringify(params) },
		success: success,
		error: error,
		async: true,
		timeout: 20000,
		complete: function(){
			if (loader) {
				//clearTimeout(delay);
				$('.loader').hide();
			}
		}
	});
};


window.NewOrder = React.createClass({
	componentDidMount:function(){
	  $(document).on('change','#etaslide',function(){
		  $('#eta-display').text($('#etaslide').val());
	  });
	},
   changeTime:function(){
	   console.log(this.refs.eta.value);
	 	  
   },
   orderAccepted:function(){
	 // $('#header').show();
	  //$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'flip'} );
	  //leave here dont want restaurants freaking out for not accepting
	  //window.socketConfirm(this.props.orders_id);
	  window.Receiver.init({key:'secondTabletAccept',params:'true'});
	  SendAjax({key:'accept_order',params:{orders_id:this.props.orders_id[0],eta:$('#etaslide').val()}},function(){
		window.sync();  
	  });
   },
  render: function() { 
  let order_list = this.props.orders_id.join(',');
    return (
	  <div>
		<div className="new-order-header">
		   <div>Order #{order_list}</div>
		</div>
		<div data-role="content">
		   <label htmlFor="etaslide" className="esttime">Estimated Prep Time: <span ref="timed" id="eta-display">15</span> Mins</label>
		   <input type="range" id="etaslide" ref="eta" onChange={this.changeTime} defaultValue="15" min="0" max="60" data-highlight="true" />
		</div>
		<div data-role="footer" className="new-order-btn ui-btn" onClick={this.orderAccepted}>
			Accept
		</div>
	  </div>
    );
  }
});



var AddNote = React.createClass({
  componentDidMount:function(){
	  $(this.refs.main_note).popup();
	 $(this.refs.note_btn).click(this.submitNote);
	  
  },
  submitNote:function(){
	  SendAjax({key:'add_note',params:{orders_id:this.props.orders_id,note:$(this.refs.add_note_comment).val()}},function(){
		window.sync();
		$(this.refs.add_note_comment).val('');
	  }.bind(this));
	  
	  if(window.admin_id){
		  	 $.ajax({
			  url:'https://deliverhop.app:3334/',
			  type:'POST',
			  data:JSON.stringify({admin_id:window.admin_id,message:this.props.orders_id+' '+$(this.refs.add_note_comment).val()}),
			  success:()=>{

			  }
			});
	  }

	  //$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'pop'} );
  },
  render: function() { 
    return (
	<div>
	 <div className="ui-popup-screen ui-overlay-b ui-screen-hidden screen_blackener"></div>
  	 <div className="ui-popup-container ui-popup-hidden ui-popup-truncate main_note_popup" id={'add-note_'+this.props.orders_id+'-popup'}>
	 <div ref="main_note" id={'add-note_'+this.props.orders_id} className="main_note ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all" data-enhanced="true" data-role="popup" data-theme="a" data-overlay-theme="b">
		<div className="dialog-primary-header" data-role="header" data-tap-toggle="false"  >
			<div className="dialog-header">Add Note To #<span>{this.props.orders_id}</span></div>
			
		</div>
        <div data-role="content">
			<div className="dialog-content">
				<div className="form-group">
					<textarea ref="add_note_comment" className="form-control add-note-comment" name="add-note-comment" placeholder="Enter note about order"></textarea>
				</div>
			</div>
		</div>
		<div className="dialog-primary-footer stylize" data-role="footer">
			<a data-rel="back" ref="note_btn" className="dialog-footer ui-btn">Save</a>
		</div>
	</div>
	</div>
	</div>
    );
  }
}); 

var AddCharge= React.createClass({
	componentDidMount:function(){
		$(this.refs.main_charge).popup();
		$(this.refs.prim_charge).click(this.submitCharge);
		
	},
	submitCharge:function(){
		var error=false;
		var amount = Math.abs(parseFloat(this.refs.mainPrice.value));

		if(amount>20 || isNaN(amount) || amount==0 || amount!=this.refs.mainPrice.value){
			$(this.refs.mainPrice).parent().addClass('has-error');
			error=true;
			if(amount>20){
				alert("Adjustments greater than $20 are restricted, please contact customer service. (800) 599-5770");		
			}
		}else{
			$(this.refs.mainPrice).parent().removeClass('has-error');
		}
		if(this.refs.add_charge_comment.value==''){
			$(this.refs.add_charge_comment).parent().addClass('has-error');
			error=true;
		}else{
			$(this.refs.add_charge_comment).parent().removeClass('has-error');
		}
		if(error){
			return false;
		}
		SendAjax({key:'add_charge',params:{type:this.refs.price_sel.value,note:this.refs.add_charge_comment.value,orders_id:this.props.orders_id,adjustment:this.refs.mainPrice.value}},function(){
		window.sync(); 
	  });
		this.refs.mainPrice.value='';
		this.refs.add_charge_comment.value='';
  },
  render: function() {
    return (
	<div>
	<div className="ui-popup-screen ui-overlay-b ui-screen-hidden screen_blackener"></div>
  	 <div className="ui-popup-container ui-popup-hidden ui-popup-truncate main_charge_popup" id={'edit-order_'+this.props.orders_id+'-popup'}>
      <div ref="main_charge" id={'edit-order_'+this.props.orders_id} data-role="popup" data-enhanced="true" data-overlay-theme="b" className="main_charge ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all">
         <div  >
            <div className="dialog-header">Add Charge #<span>{this.props.orders_id}</span></div>
			
         </div>
         <div>
            <div  className="container-fluid">
               <div className="outer-container col-xs-12">
                  <div className="input-group amount-container">
                     <span className="input-group-addon money-sign">
					 <select ref="price_sel" className="plus_or_minus">
					 	<option value="plus">+</option>
						<option value="minus">-</option>
					 </select>
					 </span>
                     <input id={'add'+this.props.orders_id} data-role="none" className="form-control addcharge" type="number" ref="mainPrice" defaultValue="" ></input>
                  </div>
               </div>

               <div className="form-group col-xs-12 margin-15-top">
                  <label htmlFor="add_charge_comment" className="text-center" ></label>
                  <textarea  ref="add_charge_comment" className="form-control add-charge-comment" name="add-charge-comment" placeholder="Enter a reason for the charge"></textarea>
               </div>
            </div>
         </div>
         <div>
            <a type="button" data-rel="back" className="ui-btn dialog-footer"  ref="prim_charge">Save</a>
         </div>
	</div>

</div>
</div>
    );
  }
});

var ModifyOrder = React.createClass({
	
  componentDidMount: function() {
	  
	   
	this.refs.editPriceRef.addEventListener('pointerdown',this.editPrice);
	this.refs.printRef.addEventListener('pointerdown',this.printOrder);
	this.refs.addNoteRef.addEventListener('pointerdown',this.addNote);
	this.refs.resendOrderRef.addEventListener('pointerdown',this.resendOrder);
  },
  editPrice: function(e){
	  console.log('edit price');
	  if(this.props.orders_info.payment_module_code=='paypalwpp'){
		  alert('This is a paypal order and cannot be edited');
		  return;
	  }
	  if(this.props.timeframe=='past'){
		  alert('This is a past order and the price cannot be changed');
		  return;
	  }
	  $( "#edit-order_"+this.props.orders_info.orders_id ).popup( "open", {} );
	  setTimeout(function(){
		  $("#add"+this.props.orders_info.orders_id).focus();
	  }.bind(this),333);
	 // this.props.setOrdersId(this.props.orders_id);
	  
  },
  resendOrder:function(){
	 SendAjax({key:'resend_order',params:{orders_id:this.props.orders_info.orders_id}},function(){
		alert("Order Resent"); 
	 });
  },
  printOrder:function(){
	  		$.ajax({
				type: 'POST',
				cache: false,
				url: "https://deliverhop.app/aAsd23fadfAd2565Hccxz/auto_send.php",
				data: {oID:this.props.orders_info.orders_id},
				dataType: 'text',
				async:true,
				success: function(invoice){
					if(window.isphone){
						cordova.plugins.printer.print(invoice, 'deliverhops_order.html', function () {
						});
					}else{
						window.print() ;
					}
						
						
				}
			});
	  console.log('print order');
	  
		//alert('Print'+this.props.orders_id);
  },
  addNote: function(){
	  //alert('here');
	 // 
	 console.log('add note');
	 $( "#add-note_"+this.props.orders_info.orders_id ).popup( "open", {} );
	
	  //this.props.setOrdersId(this.props.orders_id);
	  //$( ":mobile-pagecontainer" ).pagecontainer( "change", "#add-note", { role: "dialog" ,changeHash: false} );
  },
  render: function() {
    return (
      <div className="modifyOrder">
        <span ref="editPriceRef" className="col-xs-3 text-center order-action"><i className="glyphicon glyphicon-usd"></i></span>
		<span ref="printRef" className="col-xs-3 text-center order-action"><i className="glyphicon glyphicon-print"></i></span>
		<span ref="resendOrderRef" className="col-xs-3 text-center order-action"><i className="glyphicon glyphicon-share-alt"></i></span>
		<span ref="addNoteRef" className="col-xs-3 text-center order-action"><i className="glyphicon glyphicon-pencil"></i></span>
		<AddNote  orders_id={this.props.orders_info.orders_id}/>
		<AddCharge orders_id={this.props.orders_info.orders_id}/>
      </div>
    );
  }
});

window.OrderBox = React.createClass({
  loadOrdersFromServer: function(para) {
	   SendAjax({key:this.props.timeframe+'_order',params:para},function(newOrders) {
		  //console.log('DIE ANTWOOD '+JSON.stringify(newOrders));
		  //console.log(newOrders);
		 if(!newOrders){
			return;
		 }
		 if(newOrders[0]=='no_orders'){
			 this.setState({orders: []});
		
		 }else{
			 this.setState({orders: newOrders});
		 }
      }.bind(this));
  },
  getInitialState: function() {
    return {orders: []};
  },
  componentDidMount: function() {
		window.sync = (function () {
		if(window.categories_id && window.categories_id > 0){
			ReactDOM.render(React.createElement(window.OrderBox, { categories_id: window.categories_id, timeframe: "current" }), document.getElementById('current_order_box'));
		}
		});
	  var out = '';
	  if(this.props.timeframe=='current' || this.props.timeframe=='future'){
		  out=this.props.categories_id;
	  }else{
	   	  out={categories_id:this.props.categories_id,start:this.props.start,end:this.props.end,search_id:this.props.search_id};   
	  }	
      this.loadOrdersFromServer(out);
	  
  },
  componentWillReceiveProps:function(newProps){
	  var out = '';
	  if(this.props.timeframe=='current' || this.props.timeframe=='future'){
		  out=this.props.categories_id;
	  }else{
	   	  out={categories_id:this.props.categories_id,start:newProps.start,end:newProps.end,search_id:newProps.search_id};  
	  }	
      this.loadOrdersFromServer(out);	 
  },
  render: function() {
    return (
      <div className="orderBox">
	  		{this.state.orders.length==0 ? <div className="alert alert-info text-center" role="alert"><b>No Orders</b></div> : null}
        	<OrderList timeframe={this.props.timeframe} setOrdersId={this.props.setOrdersId} orders={this.state.orders} />
      </div>
    );
  }
});



var OrderList = React.createClass({
  render: function() {
	  var orderNodes='';
	if(this.props.orders.length){
	  orderNodes = this.props.orders.map(function(order, index) {
		return (
		   <Order orderPos={index} numOrders={this.props.orders.length}  timeframe={this.props.timeframe} extras={order.extras} orders_info={order.orders_info}  products={order.products} key={index} setOrdersId={this.props.setOrdersId} />
		);
	  }.bind(this));
	}
    return (
      <div className="orderList container-fluid no-padding-side">
        {orderNodes}
      </div>
    );
  }
});

var PickupDisplay = React.createClass({
  render: function() {
    return (
		<div>
		<span className="col-xs-6 text-right">Customer:</span>
		 <span id="status" className="col-xs-6 status">{this.props.orders_info.customers_name}</span>
		 <span className="col-xs-6 text-right">Phone:</span>
		 <span id="status" className="col-xs-6 status">{this.props.orders_info.customers_telephone}</span>
		 <span className="col-xs-6 text-right">Payment:</span>
		 <span id="status" className="col-xs-6 status">{this.props.orders_info.payment_method}</span>
		</div>
    );
  }
});

var Order = React.createClass({
  pickupComplete:function(){
		  SendAjax({key:'pickup_complete',params:{orders_id:this.props.orders_info.orders_id}});
  },
  acceptOrder:function(){
	  window.Receiver.init({key:'secondTabletAccept',params:'true'});
	  SendAjax({key:'accept_order',params:{orders_id:this.props.orders_info.orders_id,eta:15}},function(){
		window.sync();  
	  });
  },
  render: function() {
	var productNodes = this.props.products.map(function(product, index) {
		 return (
			 <Product name={product.products_name} price={product.products_price} qty={product.products_quantity} attributes={product.attributes} key={index}></Product>
		 );
	});
	
	var collap='';
	if(this.props.timeframe!='past' && this.props.numOrders==1){
		collap = 'collapse in';
	
	}else{
		collap = 'collapse';
	}
	
	var is_pickup = <PickupDisplay orders_info={this.props.orders_info} /> ;
	var style={};
	if(this.props.orders_info.date_deliver.search('ASAP') === -1){
		style.color = 'black';
		style.fontWeight = 'bold';
	}
    return (
	<div className="panel panel-default col-md-12 no-padding-side">
	  <div className="drop-panel panel-heading id-display text-center" data-toggle="collapse" data-target={'#body'+this.props.orders_info.orders_id}>
	  		<i className="glyphicon glyphicon-chevron-down" style={{float:'left'}} />{this.props.orders_info.orders_id} 
        {this.props.numOrders>1?<div style={{fontSize:'13px',position:'absolute',top:'5px',right:'5px'}}>(Order {this.props.orderPos+1} of {this.props.numOrders})</div> :null }
	  </div>
	  <div id={'body'+this.props.orders_info.orders_id} className={collap}>
	  <div  className="panel-body">
	  <fieldset className="modify">
	  	<ModifyOrder timeframe={this.props.timeframe} orders_info={this.props.orders_info} setOrdersId={this.props.setOrdersId}/>
	  </fieldset>
	 
	  <fieldset className="info">
		 <legend>Info</legend>
			 <div className="info-content container-fluid">
			   <span className="col-xs-6 text-right">Type:</span>
			   <span className="col-xs-6 ">{this.props.orders_info.pickup_order==1?'Pickup':'Delivery'}</span>
			   <span className="col-xs-6 text-right">Ready By:</span>
			   <span className="col-xs-6" style={style}>{this.props.orders_info.date_deliver}</span>
			   <div className="clearfix"></div>
			   <span className="col-xs-6 text-right">Price:</span>
			   <span className="col-xs-6">{this.props.orders_info.order_total}</span>
			   <div className="clearfix"></div>
			   <span className="col-xs-6 text-right">Status:</span>
			   <span id="status" className="col-xs-6 status">{this.props.orders_info.orders_status}</span>
				{this.props.orders_info.pickup_order==1 ?is_pickup :null}
			 </div>
	  </fieldset>
	  
      <fieldset className="order">
	  	<legend>Order</legend>
        <div className="col-xs-12">
			{productNodes}
        </div>
      </fieldset>
	  
	  <fieldset className="note"><legend>Notes</legend>
        <div className="col-xs-12">
			 {this.props.extras.notes}
        </div>
      </fieldset>
	  {this.props.orders_info.pickup_order==1 ? <button className="col-xs-12 btn btn-default pickupBtn" onClick={this.pickupComplete}>Pickup Complete</button>:null}
	  {this.props.extras.needs_accept==1 ? <button className="col-xs-12 btn btn-default pickupBtn" onClick={this.acceptOrder}>Accept Order</button>:null}
	</div>
	</div>
	</div>
    );
  }
});

var Product = React.createClass({
  render: function() {
	  if(this.props.attributes!==null){
	  	var attributeNodes = this.props.attributes.map(function(attribute, index) {
           return (
		   	<Attribute qty={this.props.qty} name={attribute.products_options_values} price={attribute.options_values_price}  key={index}></Attribute>
		   );
	  	}.bind(this));
	   }
	 var twoplus='';
	if(this.props.qty>1){
		twoplus='twoplus';
	}
    return (
	<div>
	
      <div>
	  	<span className="products_name col-xs-10 text-left no-padding-side"><span className={twoplus}>{this.props.qty}</span> x {this.props.name}</span>
	  	<span className="products_price col-xs-2 text-right no-padding-side">{this.props.price > 0 ? (this.props.price*this.props.qty).toFixed(2) : ''}</span>
	  </div>
	  <div className="clearfix"></div>
	  <div>
	  	{attributeNodes}
	  </div>
	  <hr></hr>
	
	</div>
	
    );
  }
});

var Attribute = React.createClass({
  render: function() {
    return (
	<div>
		<div className="attribute">
			<span className=" col-xs-10 text-left no-padding-side">-{this.props.name}</span>
			<span className=" col-xs-2  text-right no-padding-side">{this.props.price > 0 ? (this.props.price*this.props.qty).toFixed(2) : ''}</span>
		</div>
		<div className="clearfix"></div>
	</div>
	);
  }
});





window.Reports = React.createClass({
  componentDidMount:function(){
		this.loadChartData();
	

  },
  getInitialState:function(){
	  var rightNow = moment().format('YYYY-MM-DD');
	  return {timeRanges:[rightNow,rightNow],labels:[],chartData:[],tableData:[{orders_id:'No Orders'}],pord:'delivery'};
  },
  componentWillReceiveProps:function(newProps){
	//  if(newProps.page==='reports'){
//		 this.loadChartData();
//	  }
  },
  loadChartData: function() {
	  this.setState({pord:this.refs.pord.value});
	  var send = this.state.timeRanges;
	  send[2]=this.props.categories_id;
	  send[3]=this.refs.pord.value;
	
	  SendAjax({key:'report_data',params:send},this.handleAjax);
  },
  handleAjax:function(newData){
	
	 	console.log(newData);
	  	if(!newData){
			return;	
		}
		if(newData.tableData){
			this.setState({tableData:newData.tableData,chartData:newData.chartData})
		}
		// console.log(newData);
		//this.setState({labels:labelArray,chartData:chartArray});
		if(false){
		this.buildChart(newData.chartData);
		}
       
  },
  buildChart:function(params){
	$('#primaryChart').after('<canvas id="primaryChart"></canvas>').remove();
	//$('#myChart2').after('<canvas id="myChart2"></canvas>').remove();
	//console.log("chart");
	//console.log(params);
	var data = {
		labels: params.labels,
		datasets: [
			{
				label: " dataset",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: params.values
			}
		]
	};
	var graphOptions = {
		bezierCurve : false,
	};
	var ctx = $("#primaryChart").get(0).getContext("2d");
	var myLineChart = new Chart(ctx).Line(data, graphOptions);
//	var ctx = $("#myChart2").get(0).getContext("2d");
//	var myLineChart = new Chart(ctx).Line(data, graphOptions);
  },
  setTimeRanges:function(start,end){

	  
	  this.setState({timeRanges:[start,end]});
	  this.loadChartData();
  },

  render: function() {
	  //<canvas id="primaryChart" className="margin-15-bottom"></canvas> 
    return (
      <div>
	  		
	  		<div className="container-fluid text-center">
			<TimeDisplay setTimeRanges={this.setTimeRanges}/>
			  <select ref="pord" className="form-control text-center" data-role="none" onChange={this.loadChartData}>
				<option className="text-center" value="delivery">Delivery</option>
				<option className="text-center" value="pickup">Pickup</option>
			  </select>
			  <Exporter timeranges={this.state.timeRanges} categories_id={this.props.categories_id} pord={this.state.pord}/>
			
	  		
		     
			<h1>Orders</h1>
			</div>
	  		
			<ReportList tableData = {this.state.tableData} />
	  </div>
    );
  }
});

var ReportList = React.createClass({
  render: function() { 
  var rows = this.props.tableData.map(function(row,index){
	  return(
	  	<ReportRow data={row} key={index}/>
	  )
  });
    return (
      <table className="table table-striped">
	  <tbody>
		  <tr className="report_header">
			<th>Orders Id</th>
			<th>Date</th>
			<th>Total</th>
		  </tr>
		  {rows}
	  </tbody>
	  </table>
    );
  }
});

var ReportRow = React.createClass({
  render: function() { 
 
    return (
      <tr>
			<td>{this.props.data.orders_id}</td>
			<td>{this.props.data.date_deliver}</td>
			<td>{this.props.data.order_total}</td>
	  </tr>
    );
  }
});

var Exporter = React.createClass({
  
  mainExport:function(){
	  //SendAjax({key:'export',params:{categories_id:this.props.categories_id,timeranges:this.props.timeranges}},this.handleEx);
	  	$.ajax(
		{
			url:'https://deliverhop.app/aAsd23fadfAd2565Hccxz/cron_report.php',
			type:'POST',
			data:{rID:this.props.categories_id,start:this.props.timeranges[0],end:this.props.timeranges[1],pord:this.props.pord},
			dataType:"JSON",
			success: function(d){
				alert('Report Sent');
			},
			error: function(data){
				alert('Error! please try again later');
				
			}
		});
  },
  handleEx:function(){
	  
  },
  render: function() { 
  console.log('TEST__'+this.props.pord);
    return (
      <div className="container-fluid no-padding-side margin-10-top">
			<button  className="btn btn-default col-xs-12" onClick={this.mainExport}>
				Send Report
			</button>
	  </div>
    );
  }
});


var TimeDisplay = React.createClass({
  componentDidMount :function(){
    $('.time-display').html(moment().format('MMMM D, YY') + ' - ' + moment().format('MMMM D, YY'));
    $('.reportrange').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment(),
        endDate: moment(),
        minDate: '01/01/2007',
      //  maxDate: '12/31/2020',
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		   'YTD': [moment().startOf('year'), moment()]
        },
        opens: 'left',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-default',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Search',
            cancelLabel: 'Cancel',
            fromLabel: 'Start',
            toLabel: 'End',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 0
        }
    }, function(start, end, label) {
        $('.time-display').html(start.format('MMMM D, YY') + ' - ' + end.format('MMMM D, YY'));
		this.props.setTimeRanges(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
    }.bind(this));  
  },
  render: function() {
    return (
		<div className='container-fluid form-control time-select margin-15-bottom text-center'>
			<div className='reportrange'>
			  <span className="time-display"/>
			  <i className='glyphicon glyphicon-calendar'></i>
		    </div>
	  </div>
	);
  }
});




window.FastOrder = React.createClass({
	displayName: 'FastOrder',

	componentDidMount: function componentDidMount() {
		if (typeof braintree === 'undefined') {
			setTimeout((function () {
				var script = '';
				script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = 'https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.js';
				script.async = 'true';
				document.getElementsByTagName('head')[0].appendChild(script);
				setTimeout(this.getCreditKey, 150);
				console.log('braintree injected');
			}).bind(this), 50);
		}
		setTimeout(function () {
				var script = '';
				script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = 'https://deliverhop.app/cordova_new/www/myjs/datetimepicker.js';
				document.getElementsByTagName('head')[0].appendChild(script);
				
				var link = document.createElement('link');
				link.setAttribute('rel', 'stylesheet');
				link.setAttribute('type', 'text/css');
				link.setAttribute('href', 'https://deliverhop.app/cordova_new/www/mycss/datetimepicker.css');
				document.getElementsByTagName('head')[0].appendChild(link);
		}.bind(this), 50);
		
		setTimeout(function(){
			$(this.refs.datetimepicker1).datetimepicker({minDate: moment(),maxDate: moment().add(2000, 'h'),ignoreReadonly:true});
		}.bind(this),1000);
		 
		this.refs.delivery.value = this.props.delivery_fee;
		this.tax_rate = this.props.tax_rate;
		
		if(!this.rates_aquired){
			SendAjax({ key: 'get_tax_fee', params: { categories_id: window.categories_id } }, function (data) {
				this.refs.delivery.value = data.delivery_fee;
				this.tax_rate=data.tax_rate;
				this.rates_aquired=true;
				$(this.refs.taxrate).text('('+(this.tax_rate*100).toFixed(4)+'%)');
				
				if(data.active==0){
					$(this.refs.main_form).hide();
					$(this.refs.noconfig).show();
				}
				
				var type = $('#type');
				type.html('');
//				if (true) {
//					type.append('<option value="">Select Method</option>');
//				}
				if(data.payment.cash==1){
					type.append('<option value="Cash">Cash</option>');
				}
				if(data.payment.credit==1){
					type.append('<option value="Credit">Credit</option>');
				}

				if(data.payment.invoice==1){
					type.append('<option value="Invoice">Prepaid</option>');
				}				
			}.bind(this));	
		}
		$(document).on('focus','#Tip',function(){
				this.value='';
		});
		$(this.refs.refr).click(function(){
			location.reload();
		});
		
	},
	getCreditKey: function getCreditKey() {
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php',
			type: 'post',
			dataType: "text",
			data: { get_credit_key: 1 },
			success: (function (data) {
				setTimeout((function () {
					this.beginSetup(data);
				}).bind(this), 100);
			}).bind(this),
			error: function error() {}
		});
	},
	beginSetup: function beginSetup(key) {
		if (typeof braintree === 'undefined') {
			console.log('no braintree, uncaught');
			setTimeout((function () {
				this.beginSetup(key);
			}).bind(this), 100);
			return false;
		}
		braintree.setup(key, "custom", {
			id: 'gwok',
			onPaymentMethodReceived: this.receivePaymentNonce,
			onReady: function onReady(data) {
				console.log('braintree ready');
				return true;
			},
			onError: function onError(data) {
				alert('Error: '+data.message);
				$('.subbtn').removeAttr("disabled");    
				return true;
			},
			hostedFields: {
				number: {
					selector: "#bcredit",
					placeholder: "Credit Card Number"
				},
				expirationMonth: {
					selector: "#bmonth",
					placeholder: "Month"
				},
				expirationYear: {
					selector: "#byear",
					placeholder: "Year"
				},
				cvv: {
					selector: "#bcvv",
					placeholder: "On the back"
				},
				onFieldEvent: this.onEvent,
				styles: this.styles()

			}
		});
		return true;
	},
	receivePaymentNonce: function receivePaymentNonce(data) {
		if($(this.refs.asapselect).val()=='asap'){
			$(this.refs.datetimepicker1).val(moment().format("YYYY-MM-DD HH:mm:ss"));
		}
		var form_data = $('#main').serialize();
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php?' + form_data + '&payment_method_nonce=' + data.nonce + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: (function (data) {
				
				console.log(data);
				if (data.success) {
					this.orderPlaced(data.orders_id);
				} else {
					alert(data.error);
				}
			}).bind(this),
			error: function error() {}
		});
	},
	placeCashOrder: function placeCashOrder() {
		this.debounce();
		if (!this.formCheck()) {
			return false;
		}
		if($(this.refs.asapselect).val()=='asap'){
			$(this.refs.datetimepicker1).val(moment().format("YYYY-MM-DD HH:mm:ss"));
		}
		var form_data = $('#main').serialize();
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php?' + form_data + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: (function (data) {
				console.log(data);
				if (data.success) {
					this.orderPlaced(data.orders_id);
				} else {
					alert(data.error);
				}
			}).bind(this),
			error: function error() {}
		});
	},
	onEvent: function onEvent(event) {
		if (event.type === "focus") {} else if (event.type === "blur") {} else if (event.type === "fieldStateChange") {
			//console.log(event.isValid); // true|false
			if (event.card) {
				//console.log(event.card.type);
			
			}
		}
		return true;
	},
	styles: function styles() {
		return {
			// Style all elements
			"input": {
				"font-size": "14pt",
				"font-weight": "100",
				"color": "#3A3A3A"
			},
			// Styling element state
			":focus": {
				"color": "#3A3A3A",
				"border-color": "red",
				"box-shadow": "0 0 0 red inset, 0 0 8px red"
			},
			".valid": {
				"color": "green"
			},
			".invalid": {
				"color": "red"
			},
			// Note that these apply to the iframe, not the root window.
			"@media screen and (max-width: 700px)": {
				"input": {
					"font-size": "14pt"
				}
			}
		}; //end of style
	},
	shouldComponentUpdate: function shouldComponentUpdate() {
		return false;
	},
	changePay: function changePay() {
		var val = $('#type').val();
		if (val == 'Credit') {
			$('#main_submit').hide();
			$('#ccfields').slideDown(200);
		} else {
			$('#main_submit').show();
			$('#ccfields').slideUp(200);
		}
	},
	autoCalc: function autoCalc() {
		var subto=0;
		var ti=0;
		if (isNaN(this.refs.subtotal.value) || this.refs.subtotal.value === '') {
			//this.refs.subtotal.value = 0;
		}else{
			subto=this.refs.subtotal.value;
		}
		if (isNaN(this.refs.delivery.value) || this.refs.delivery.value === '') {
			this.refs.delivery.value = 0;
		}
		if (isNaN(this.refs.tip.value) || this.refs.tip.value === '') {
			//this.refs.tip.value = 0;
		}else{
			ti	=this.refs.tip.value;
		}

		var before_tax = parseFloat(subto) + parseFloat(this.refs.delivery.value);
		var tax = before_tax * this.tax_rate;
		var total = parseFloat(tax) + parseFloat(before_tax) + parseFloat(ti);
		this.refs.tax.value = tax.toFixed(2);
		this.refs.total.value = total.toFixed(2);
	},
	debounce:function(){
		$('.subbtn').attr("disabled", "disabled");
		setTimeout(function(){
			$('.subbtn').removeAttr("disabled");    
		},60000);
	},
	zipEnter: function zipEnter() {
		var zip = parseInt(this.refs.zipcode.value.replace(/[^0-9]/g, ""));
		if (isNaN(zip)) {
			zip = '';
		}
		if ((zip + '').length == 5) {
			$(this.refs.zipcode).css('border', '1px solid #ccc');
			$.ajax({
				url: 'https://deliverhop.app/cordova_new/www/ajax.php',
				type: 'post',
				dataType: "json",
				data: { zip_info: zip },
				success: (function (data) {
					if (data.success === false) {
						$(this.refs.zipcode).css('border', '1px solid red');
						return false;
					}
					if (data.city) {
						this.refs.city.value = data.city;
					}
					if (data.state) {
						this.refs.state.value = data.state;
					}
					if (data.combined_tax) {
						//this.tax_rate = data.combined_tax;
						//this is far better than the other way but whatever this is how dave wnats it
					}
				}).bind(this),
				error: function error() {}
			});
		} else {
			$(this.refs.zipcode).css('border', '1px solid red');
		}
	},
	formCheck: function formCheck() {
		
		var is_true = true;
		
		$('.check').each(function (index, element) {
			//console.log('asdasd'+element.value);
			if (element.value.length < 1) {
				$(element).css('border', '1px solid red');
				is_true = false;
			} else {
				$(element).css('border', '1px solid #ccc');
			}
		});
		if ($('#Zipcode').val().length != 5) {
			$('#Zipcode').css('border', '1px solid red');
			is_true= false;
		}else{
			$('#Zipcode').css('border', '1px solid #ccc');	
		}
		if (!is_true) {
			$('.subbtn').removeAttr("disabled");  
			$(window).scrollTop(0);
			alert('Please fill out all the required fields.');
			return false;
		} else {
			return true;
		}
	},
	placeCreditOrder: function placeCreditOrder() {
		this.debounce();
		if (this.formCheck()) {
			$(this.refs.real_submit).click();
		}
	},
	orderPlaced:function(orders_id){
		$(this.refs.main_form).hide();
		$(this.refs.placed_order).show();
		$('input','#fast_order').val('');
		$('#o_placed').text('Order #' + orders_id + ' has been placed').show();
	
		$(window).scrollTop(0);
		setTimeout(function () {
			location.reload();
		}, 6000);
	},
	changeTimeSelect:function(){
		var col = $(this.refs.collapsetime);
		if($(this.refs.asapselect).val()=='asap'){
			col.removeClass('in');
		}else{
			col.addClass('in');
		}
	},
	render: function render() {
		return (
		<div>
		<div ref="noconfig" className="alert alert-danger nofastconfig">Sorry this page needs to be configured, please contact Food Dudes to set it up</div>
		<div  className="fast_form">
		  <div className="container" ref="placed_order" hidden>
		  		<div className="alert alert-success" id="o_placed" role="alert" ></div>
				<div className="col-xs-12 btn btn-default pickupBtn" ref="refr">Place Another</div>
		  </div>
		  <div className="container" ref="main_form">
		  
	  <form method="post" action="" className="frm" id="main">
	  <input type="hidden" name="action" value="fast_order" />
	  
	  <div className="form-group" >
		  <label htmlFor="Number">Your Order Number</label>
		  <input name="wokorder" type="number" className="form-control" id="Number" />
	  </div>
	  
	  <div className="form-group" >
		  <label>Delivery Time</label>
		  <select name="asapselect" ref="asapselect" className="form-control" onChange={this.changeTimeSelect}>
		  		<option value="asap">ASAP</option>
				<option value="future">FUTURE</option>
		  </select>
	  </div>

	  <div className="form-group collapse" ref="collapsetime">
		  <label htmlFor="Number">Date/Time</label>
		  <div className='input-group date' ref='datetimepicker1'>
			  <input name="timeselector" type='text' className="form-control" readOnly />
			  <span className="input-group-addon">
				  <span className="glyphicon glyphicon-calendar"></span>
			  </span>
		  </div>
	  </div>

	  <div className="form-group">
		  <label htmlFor="Phone">Phone</label>
		  <input name="phone" type="tel" className="form-control check" id="Phone" />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Name">Name</label>
		  <input name="name" type="text" className="form-control" id="Name" />
	  </div>

	  
	  <div className="form-group">
		  <label htmlFor="Company">Company</label>
		  <input name="company" type="text" className="form-control" id="Company" />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Address">Address</label>
		  <input name="address" type="text" className="form-control check" id="Address" />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Apt">Apt/Suite</label>
		  <input name="apt" type="text" className="form-control" id="Apt" />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Zipcode">Zipcode</label>
		  <input name="zip" type="number" className="form-control check" id="Zipcode" ref="zipcode" onChange={this.zipEnter} />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="City">City</label>
		  <input name="city" type="text" className="form-control" ref="city"  />
	  </div>
  
  
  	  <div className="form-group">
		  <label htmlFor="State">State</label>
		  <input name="state" type="text" className="form-control" ref="state"  />
	  </div>
	  <div className="form-group">
		  <label htmlFor="Subtotal">Subtotal</label>
		  <input name="subtotal" type="number" className="form-control check" ref="subtotal" onChange={this.autoCalc} />
	  </div>
		<div className="form-group">
		  <label htmlFor="Tip">Tip</label>
		  <input name="tip" type="number" className="form-control" id="Tip" ref="tip" onChange={this.autoCalc} />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Delivery">Delivery Fee</label>
		  <input readOnly name="delivery" type="text" className="form-control" ref="delivery"  />
	  </div>
	  
	
	  
	  <div className="form-group">
		  <label htmlFor="Tax">Tax <span ref="taxrate"></span></label>
		  <input readOnly name="tax" type="text" className="form-control" ref="tax" value="0" />
	  </div>
	  
	  <div className="form-group">
		  <label htmlFor="Total">Total</label>
		  <input disabled type="text" className="form-control" ref="total"  value="0" />
	  </div>
	  <div className="form-group">
		  <label htmlFor="Special">Special Instructions</label>
		  <textarea name="special" className="form-control" id="Special" ></textarea>
	  </div>
	  <div className="form-group">
		  <label htmlFor="type">Payment Type</label>
		  <select name="type" onChange={this.changePay} className="form-control" id="type">
			  <option defaultValue="Cash">Cash</option>
			  <option defaultValue="Credit">Credit</option>
		  </select>
	  </div>
	  <button type="button" id="main_submit" onClick={this.placeCashOrder} className="col-xs-12  btn btn-default subbtn pickupBtn">Place Order</button>
	  </form>
	  <div id="ccfields" hidden>
	  <form method="post" action=""  className="frm" id="gwok" >
	  <div className="form-group col-xs-12">
		   <label htmlFor="bcredit">Card Number</label>
		   <div id="bcredit" className="form-control"></div>
	  </div>
	  
	  <div className="form-group col-xs-4">
		   <label htmlFor="bmonth">Expiration Month</label>
		   <div id="bmonth" className="form-control"></div>
	  </div>
	  
	  <div className="form-group col-xs-4">
		  <label htmlFor="byear">Expiration Year</label>
		  <div id="byear" className="form-control"></div>
	  </div>
	  
	  <div className="form-group col-xs-4">
		  <label htmlFor="bcvv">Cvv code</label>
		  <div id="bcvv" className="form-control"></div>
	  </div>
		  <button type="button" onClick={this.placeCreditOrder} className="col-xs-12 btn btn-default subbtn pickupBtn">Place Order</button>
		  <button type="submit" ref="real_submit" hidden></button>
		  </form>
	  </div>
	  </div>
	  </div>
	  </div>
		);
	}
});


var SearchOrder = React.createClass({
  componentDidMount: function() {
	this.refs.searchIdBtn.addEventListener('pointerdown',this.setSearchId);
	this.refs.searchIdText.addEventListener('keypress',this.searchKeypress);
  },
  searchKeypress:function(e){
	  var key = e.which || e.keyCode;
	  if (key === 13) { 
	 		this.setSearchId();
	  }
  },
  setSearchId:function(){
	  //alert('must have same categories id as searched order');
	  this.props.setSearchId(this.refs.searchIdText.value);
	  this.refs.searchIdText.value='';
  },
  render: function() { 
    return (
	<div className="container-fluid no-padding-side margin-15-bottom" data-role="none">
	  <div className="input-group">
		  <input ref="searchIdText" className="form-control" type="search" defaultValue="" placeholder="Search Orders Id" aria-describedby="searchAddon" data-role="none" />
  		  <span ref="searchIdBtn" className="input-group-addon searchBtn" id="searchAddon">Search</span>
	  </div>
	</div>
    );
  }
});
window.PastOrders = React.createClass({
  getInitialState:function(){
	  var rightNow = moment().format('YYYY-MM-DD');
	  console.log(rightNow+' NOW');
	  return {timeRanges:[rightNow,rightNow],searchId:0};
  },
  setTimeRanges:function(start,end){
	  this.setState({timeRanges: [start,end],searchId:0});
  },
  setSearchId:function(id){
	  console.log(id);
	  this.setState({searchId:id});
  },
  render: function() {
    return (
		<div>
			<TimeDisplay setTimeRanges={this.setTimeRanges}/>
			<SearchOrder setSearchId={this.setSearchId}/>
			<OrderBox timeframe='past' categories_id={this.props.categories_id} search_id={this.state.searchId} start={this.state.timeRanges[0]} end={this.state.timeRanges[1]}/>
		</div>
	);
  }
});


var TextFieldUl = React.createClass({
  errorField:function(){
	  $(this.refs.inputGroup).addClass('has-error');
	  $(this.refs.addDataState).focus();
  },
  addData:function(){
	  $(this.refs.inputGroup).removeClass('has-error');
	  var cur_state = this.props.data;
	  if(this.refs.addDataState.value.length<1){
		  this.errorField();
		  return;
	  }
	  if(this.props.testRegex){
		  if(!this.props.testRegex.test(this.refs.addDataState.value)){
			     this.errorField();
				 return;
		  }
	  }
	  cur_state.push(this.refs.addDataState.value); 
	  var new_state={};
	  new_state[this.props.field]=cur_state;
	  this.props.setParent(new_state);
	  this.refs.addDataState.value='';
  },
  removeData:function(cc){
	  var cur_state = this.props.data;
	  cur_state.remove($(cc.target).attr('data-main'));
	  var new_state={};
	  new_state[this.props.field]=cur_state;
	  this.props.setParent(new_state);
  },
  formSub:function(e){
	e.preventDefault();
	this.addData();
	return false;  
  },
  render: function() {
	  var dataList='';
	  if(this.props.data && this.props.data.length && this.props.data[0]!=""){
		    dataList = this.props.data.map(function(data,index){
			return(
			  <li className="list-group-item" key={index}>{data}<span onClick={this.removeData} data-main={data} className="glyphicon glyphicon-remove pull-right"></span></li>
			);
		}.bind(this));
	  }else{
			dataList=<li className="list-group-item">No values</li>;  
	  }
    return (
	<div className="config-div">
		<form onSubmit={this.formSub}>
			<ul className="list-group config-ul">
			  {dataList}
			</ul>
			<div ref="inputGroup" className="input-group">
			  <input ref="addDataState" type={this.props.fieldtype} className="form-control " placeholder={this.props.placeholder}  />
			  <span onClick={this.addData} className="input-group-addon">Add</span>
			</div>
		</form>
	</div>
	);
  }
});

var SendMethodCheckBox = React.createClass({
  handleChange:function(cc){
	var pos;
	switch(this.props.type){
		case 'email':pos=0;break;
		case 'fax':pos=1;break;
		case 'cloud':pos=2;break;
		case 'phone':pos=3;break;
		case 'auto':pos=4;break;
	}
	var tmp_code = this.props.smc.split('');
	if(cc.target.checked){
		tmp_code[pos]='1';
	}else{
		tmp_code[pos]='0';
	}
	this.props.setParent({send_method_code:tmp_code.join('')});
  },
  shouldCheck:function(){
    var is_checked = false;
	switch(this.props.type){
		case 'email':
			if(this.props.smc[0]==1){
				is_checked=true;
			}
		break;
		case 'fax':
			if(this.props.smc[1]==1){
				is_checked=true;
			}
		break;
		case 'cloud':
			if(this.props.smc[2]==1){
				is_checked=true;
			}
		break;
		case 'phone':
			if(this.props.smc[3]==1){
				is_checked=true;
			}
		break;
		case 'auto':
			if(this.props.smc[4]==1){
				is_checked=true;
			}
		break;
	}
	return is_checked;
  },
  render: function() {
	var is_checked=this.shouldCheck();
    return (
	<div>
		<input ref="cbox" type="checkbox" checked={is_checked} onChange={this.handleChange}/>
	</div>
	);
  }
});


var TimeSlider = React.createClass({
  componentDidMount:function(){
	var slider = document.getElementById('range');

	noUiSlider.create(slider, {
		start: [ 36000, 75600 ], // Handle start position
		step: 900, // Slider moves in increments of '10'
		margin: 20, // Handles must be more than '20' apart
		connect: true, // Display a colored bar between the handles
		direction: 'ltr', // Put '0' at the bottom of the slider
		orientation: 'horizontal', // Orient the slider vertically
		behaviour: 'tap-drag', // Move handle on tap, bar is draggable
		range: { // Slider can select '0' to '100'
			'min': 0,
			'max': 86400
		}
	});
	var start = this.refs.start;
	var end = this.refs.end;
	slider.noUiSlider.on('update', function(){
			var ranges = slider.noUiSlider.get();
			$(start).text(moment().startOf('day').seconds(ranges[0]).format('h:mma'));
			$(end).text(moment().startOf('day').seconds(ranges[1]).format('h:mma'));
	});
  
  },
  render: function() {
    return (
	<div className="container-fluid">
	<div ref="start"></div>
	<div ref="end"></div>
	<div id="range"></div>
	</div>
		
	);
  }
});


window.Config = React.createClass({
  componentWillMount:function(){
	  this.getConfig();
  },
  getInitialState:function(){
  		return {
			email:[],
			fax:[],
			report_email:[],
			report_fax:[],
			send_method_code:'00000'
			};
  },
  getConfig:function(){
	  SendAjax(
	  {key:'get_config',params:this.props.categories_id},
	  function(data){
		  this.setState(data);
	  }.bind(this));
  },
  setConfig:function(){
	  
	  SendAjax(
	  {key:'set_config',params:{state:this.state,categories_id:this.props.categories_id}},
	  function(data){
		  if(data==1){
			  $('#header').append('<div class="temp_alert alert alert-success text-center" role="alert">Saved</div>');
			  setTimeout(function(){
				  $('.temp_alert').remove();
			  },3000);
		  }
	  });
	  
  },
  setParent:function(params){
		 this.setState(params);
  },
  render: function() {
//<TimeSlider />
    return (
	<div>
		
		<div className="container-fluid">
		<SendMethodCheckBox type="email" smc={this.state.send_method_code} setParent={this.setParent}/>
		<SendMethodCheckBox type="fax" smc={this.state.send_method_code} setParent={this.setParent}/>
		<SendMethodCheckBox type="cloud" smc={this.state.send_method_code} setParent={this.setParent}/>
		<SendMethodCheckBox type="phone" smc={this.state.send_method_code} setParent={this.setParent}/>
		<SendMethodCheckBox type="auto" smc={this.state.send_method_code} setParent={this.setParent}/>
		
		<TextFieldUl testRegex={/\S+@\S+\.\S+/} placeholder={"Email"} fieldtype={"text"} field={"email"} setParent={this.setParent} data={this.state.email} />
		<TextFieldUl testRegex={/^[0-9]*$/} placeholder={"Fax"} fieldtype={"text"} field={"fax"} setParent={this.setParent} data={this.state.fax}/>
		<TextFieldUl testRegex={/\S+@\S+\.\S+/} placeholder={"Report Email"} fieldtype={"text"} field={"report_email"} setParent={this.setParent} data={this.state.report_email} />
		<TextFieldUl testRegex={/^[0-9]*$/} placeholder={"Report Fax"} fieldtype={"text"} field={"report_fax"} setParent={this.setParent} data={this.state.report_fax}/>
		</div>
		<button className="btn btn-default" onClick={this.setConfig}>Save</button>
	</div>
	);
  }
});


window.ButtonGrid = React.createClass({
  render: function() {
    return (
	<div>
		x c v b n m
	</div>
	);
  }
});
window.ModOrder = React.createClass({
  componentDidMount:function(){
	  $(this.refs.buttonGrid).css({top:$(this.refs.clickBtn).offset().top-37,left:$(this.refs.clickBtn).offset().left+20});
  },
  showPanel:function(){
	  if($(this.refs.buttonGrid).css('display')=='none'){
		  $(this.refs.buttonGrid).show();
	  }else{
			$(this.refs.buttonGrid).hide();  
	  }
  },
  render: function() {
    return (
	<div>
		<div onClick={this.showPanel} ref="clickBtn">x</div>
		<div ref="buttonGrid" className="buttonGrid">
			<ButtonGrid />
		</div>
	</div>
	);
  }
});

window.ModBox = React.createClass({

  render: function() {
    return (
	<div>
		<ModOrder />
		<ModOrder />
		<ModOrder />
		<ModOrder />
		<ModOrder />
	</div>
	);
  }
});
var my_awesome_script = document.createElement('script');
my_awesome_script.setAttribute('src','https://deliverhop.app/cordova/www/myjs/socketio.js'); 
document.head.appendChild(my_awesome_script);
//function init(){
	$(document).ready(function(e) {
		function initSocket(){
		  setTimeout(function(){
				if(!window.categories_id){
					console.log('No cat id at socket '+window.categories_id);
					return;
				}
				if(typeof io === 'undefined'){
					console.log('No socket io');
					return;
				}
				function socks(){
				  try{
					  var user_id = window.categories_id;
					  var info_class = ['restaurant'];
					  var socket = io('https://deliverhop.app:3333/');
					  console.log(user_id);
					  console.log(info_class);
					  socket.on('authorize', function(msg){
						socket.emit('authorize',{user_id:user_id,info_class:info_class});
					  });
					  
					  socket.on('info_update', function(msg){
						  if(msg.key){
							receivePush(msg);
						  }	
					  });	
					  
					  window.socketConfirm=function(orders_id){
						  socket.emit('restaurant_accept',{orders_id:orders_id});
					  };
				  }catch(e){
					  console.log('Bad connect');
				  }
	
				}
				setTimeout(socks,50);		
		  },500);
		}
		initSocket();
		
		$('#header').append('<div id="ref" href="" class="glyphicon glyphicon-refresh" data-role="button"></div>');
		$('#header').append('<div id="sig" href="" data-role="button"></div>');
		$('#header').append('<div id="charge_alert" class="alert alert-danger alert-dismissible" role="alert"><b>Please plug in the charger</b></div>');
		//addScript('https://deliverhop.app/cordova_new/www/myjs/socketio.js');
		
		$(document).on('click','#charge_alert',function(){
			$(this).hide();	
		});
		try{
		navigator.getBattery().then(function(battery) {
		  	  if(battery.charging==1){
				  $('#charge_alert').hide();
			  }else if(battery.level<0.2){
				  $('#charge_alert').show();
			  }
			  battery.addEventListener('chargingchange', function() {
				  if(battery.charging==1){
					  $('#charge_alert').hide();
				  }else if(battery.level<0.2){
					  $('#charge_alert').show();
				  }
			  });
		});
		}catch(Exception){
	
		}
		//$('body').append('<div class="loader"></div>');
		$(document).on('click','#ref',function(){
			location.reload();	
		});
		$(document).on('click','.order-action',function(){
			var _this=$(this);	
			_this.css('color','#ef6f00');
			setTimeout(function(){
				_this.css('color','black');	
			},1000);
		});
		var hash=window.location.hash.replace('#','');
		hash = hash ? hash : 'current';
		
		stateSwitch(hash);
		changeHeader(hash);
		$( "body" ).pagecontainer({
  			beforeshow:  function( event, ui ) {
				stateSwitch(ui.toPage[0].id);
				changeHeader(ui.toPage[0].id);
			}
	    });

		function changeHeader(page){
			var text='';
			switch(page){
				case 'current':
					text='Current Orders';
				break;
				case 'future':
					text='Future Orders';
				break;
				case 'past':
					text='Past Orders';
				break;
				case 'report':
					text='Reports';
				break;
				case 'fast_order':
					text='Fast Order';
				break;
				case 'config':
					text='Config';
				break;
			}
			
			$('.ui-title','#header').text(text);
		}
		function stateSwitch(page){
			if(!window.categories_id){
				console.log('LOOP STATE SWITCH');
				//setTimeout(function(){
				//	stateSwitch(page);
				//},2000);
				
				return;
			}
			console.log('STATE SWITCH + '+page);
		
			switch(page){
					case 'current':
				ReactDOM.render(React.createElement(window.OrderBox, { categories_id: window.categories_id, timeframe: "current" }), document.getElementById('current_order_box'));
					break;
					case 'future':
				ReactDOM.render(React.createElement(window.OrderBox, { categories_id: window.categories_id, timeframe: "future" }), document.getElementById('future_order_box'));
					break;
					case 'past':
				ReactDOM.render(React.createElement(window.PastOrders, { categories_id: window.categories_id }), document.getElementById('past_order_box'));
					break;
					case 'report':
				ReactDOM.render(React.createElement(window.Reports, { categories_id:window.categories_id}), document.getElementById('report_box'));
					break;
					case 'fast_order':
				ReactDOM.render(React.createElement(window.FastOrder, { categories_id: window.categories_id,delivery_fee:4.99 ,tax_rate:.08375 }), document.getElementById('fast_order_box'));
					break;
					case 'config':
				ReactDOM.render(React.createElement(window.Config, {categories_id: window.categories_id}), document.getElementById('config_box'));
					break;
					
			}
			
		}
});
//}

	
	
	
	
	
	
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};