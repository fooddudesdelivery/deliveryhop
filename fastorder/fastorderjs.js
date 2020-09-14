console.log(moment().format("YYYY-MM-DD HH:mm:ss"));
window.FastOrder = React.createClass({
	displayName: 'FastOrder',

	componentDidMount: function componentDidMount() {
		if(DEFINE.ACTIVE==0){
			return;
		}
		if (typeof braintree === 'undefined') {
			setTimeout((function () {
				var script = '';
				script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = 'https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.js';
				script.async = 'true';
				document.getElementsByTagName('head')[0].appendChild(script);
				setTimeout(this.getCreditKey, 50);
				console.log('braintree injected');
			}).bind(this), 1);
		}
		this.refs.delivery.value = this.props.delivery_fee;
		this.tax_rate = this.props.tax_rate;
		this.refs.tip.value=0;
		this.refs.subtotal.value=0;
		$('.del').on('focus',function(){
			this.value='';
		});
		this.autoCalc();
		$(this.refs.datetimepicker1).datetimepicker({ minDate: moment(), maxDate: moment().add(2000, 'h'), ignoreReadonly: true });
	},
	getCreditKey: function getCreditKey() {
		$.ajax({
			url: SITE_URL+'/cordova/www/ajax.php',
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
				$('.loading').hide();
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
			url: SITE_URL+'/cordova/www/ajax.php?' + form_data + '&payment_method_nonce=' + data.nonce + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: (function (data) {
				console.log(data);
				if (data.success) {
					$('#another_btn').show();
					$('#o_placed').text('Order #' + data.orders_id + ' has been placed').show();
					$('#form_page').hide();
					$(window).scrollTop(0);
					$('.loading').hide();
					setTimeout(function () {
						location.reload();
					}, 10000);
				} else {
					alert(data.error);
					$('.loading').hide();
					$('.subbtn').removeAttr("disabled");
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
			url: SITE_URL+'/cordova/www/ajax.php?' + form_data + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: (function (data) {
				console.log(data);
				if (data.success) {
					$('#another_btn').show();
					$('#o_placed').text('Order #' + data.orders_id + ' has been placed').show();
					$('#form_page').hide();
					$(window).scrollTop(0);
					$('.loading').hide();
					setTimeout(function () {
						location.reload();
					}, 10000);
				} else {
					alert(data.error);
					$('.loading').hide();
				}
			}).bind(this),
			error: function error() {}
		});
	},
	onEvent: function onEvent(event) {
		if (event.type === "focus") {} else if (event.type === "blur") {} else if (event.type === "fieldStateChange") {
			if(event.card){}
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
	changeType: function changeType() {},
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
		console.log(this.refs.subtotal.value);
		if (isNaN(this.refs.subtotal.value)) {
			this.refs.subtotal.value = 0;
		}
		if (isNaN(this.refs.delivery.value)) {
			this.refs.delivery.value = 0;
		}
		if (isNaN(this.refs.tip.value)) {
			this.refs.tip.value = 0;
		}

		var before_tax = parseFloat(this.refs.subtotal.value) + parseFloat(this.refs.delivery.value);
		console.log(this.tax_rate);
		var tax = before_tax * this.tax_rate;
		console.log(before_tax);
		console.log(tax);
		console.log(this.refs.tip.value);
		var total = parseFloat(tax) + parseFloat(before_tax) + parseFloat(this.refs.tip.value);
		console.log(total);console.log(total);
		this.refs.tax.value = tax.toFixed(2);
		this.refs.total.value = total.toFixed(2);
	},
	zipEnter: function zipEnter() {
		var zip = parseInt(this.refs.zipcode.value.replace(/[^0-9]/g, ""));
		if (isNaN(zip)) {
			zip = '';
		}
		if ((zip + '').length == 5) {
			$(this.refs.zipcode).css('border', '1px solid #ccc');
			$.ajax({
				url: SITE_URL+'/cordova/www/ajax.php',
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
					}
					this.autoCalc();
				}).bind(this),
				error: function error() {}
			});
		} else {
			$(this.refs.zipcode).css('border', '1px solid red');
		}
		
	},
	debounce:function(){
		$('.subbtn').attr("disabled", "disabled");
		setTimeout(function(){
			$('.subbtn').removeAttr("disabled");    
		},60000);
	},
	formCheck: function formCheck() {
		
		var is_true = true;
		$('.check').each(function (index, element) {
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
			$('.loading').show();
			return true;
		}
	},
	placeCreditOrder: function placeCreditOrder() {
		this.debounce();
		if (this.formCheck()) {
				this.debounce();
			$(this.refs.real_submit).click();
		}
	},
	changeTimeSelect: function changeTimeSelect() {
		var col = $(this.refs.collapsetime);
		if ($(this.refs.asapselect).val() == 'asap') {
			col.removeClass('in');
		} else {
			col.addClass('in');
		}
	},
	render: function render() {
		if(DEFINE.ACTIVE==0){
			return React.createElement(
			  "div",
			  { className: "alert alert-danger noconfig", role: "alert" },
			  "Sorry this needs to be configured please contact Food Dudes"
			);
		}
		return React.createElement(
			'div',
			{ className: 'container' },
			React.createElement(
				'form',
				{ method: 'post', action: '', className: 'frm', id: 'main' },
				React.createElement('input', { type: 'hidden', name: 'action', value: 'fast_order' }),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Number' },
						'Your Order Number'
					),
					React.createElement('input', { name: 'wokorder', type: 'number', className: 'form-control', id: 'Number' })
				),
						React.createElement(
							'div',
							{ className: 'form-group' },
							React.createElement(
								'label',
								{ htmlFor: 'Number' },
								'Delivery Time'
							),
							React.createElement(
								'select',
								{ name: 'asapselect', ref: 'asapselect', className: 'form-control', onChange: this.changeTimeSelect },
								React.createElement(
									'option',
									{ value: 'asap' },
									'ASAP'
								),
								React.createElement(
									'option',
									{ value: 'future' },
									'FUTURE'
								)
							)
						),
						React.createElement(
							'div',
							{ className: 'form-group collapse', ref: 'collapsetime' },
							React.createElement(
								'label',
								{ htmlFor: 'Number' },
								'Date/Time'
							),
							React.createElement(
								'div',
								{ className: 'input-group date', ref: 'datetimepicker1' },
								React.createElement('input', { name: 'timeselector', type: 'text', className: 'form-control', readOnly: true }),
								React.createElement(
									'span',
									{ className: 'input-group-addon' },
									React.createElement('span', { className: 'glyphicon glyphicon-calendar' })
								)
							)
						),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Phone' },
						'Phone'
					),
					React.createElement('input', { name: 'phone', type: 'tel', className: 'form-control check', id: 'Phone' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Name' },
						'Name'
					),
					React.createElement('input', { name: 'name', type: 'text', className: 'form-control', id: 'Name' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Company' },
						'Company'
					),
					React.createElement('input', { name: 'company', type: 'text', className: 'form-control', id: 'Company' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Address' },
						'Address'
					),
					React.createElement('input', { name: 'address', type: 'text', className: 'form-control check', id: 'Address' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Apt' },
						'Apt/Suite'
					),
					React.createElement('input', { name: 'apt', type: 'text', className: 'form-control', id: 'Apt' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Zipcode' },
						'Zipcode'
					),
					React.createElement('input', { name: 'zip', type: 'text', className: 'form-control check', id: 'Zipcode', ref: 'zipcode', onChange: this.zipEnter })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'City' },
						'City'
					),
					React.createElement('input', { name: 'city', type: 'text', className: 'form-control', ref: 'city' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'State' },
						'State'
					),
					React.createElement('input', { name: 'state', type: 'text', className: 'form-control', ref: 'state' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Subtotal' },
						'Subtotal'
					),
					React.createElement('input', { name: 'subtotal', type: 'text', className: 'form-control check del', ref: 'subtotal', onChange: this.autoCalc })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Tip' },
						'Tip'
					),
					React.createElement('input', { name: 'tip', type: 'text', className: 'form-control del', ref: 'tip', onChange: this.autoCalc })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Delivery' },
						'Delivery Fee'
					),
					React.createElement('input', { readOnly: true, name: 'delivery', type: 'text', className: 'form-control', ref: 'delivery' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Tax' },
						'Tax'
					),
					React.createElement('input', { readOnly: true, name: 'tax', type: 'text', className: 'form-control', ref: 'tax', value: '0' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Total' },
						'Total'
					),
					React.createElement('input', { disabled: true, type: 'text', className: 'form-control', ref: 'total', value: '0' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'Special' },
						'Special Instructions'
					),
					React.createElement('textarea', { name: 'special', className: 'form-control', id: 'Special' })
				),
				React.createElement(
					'div',
					{ className: 'form-group' },
					React.createElement(
						'label',
						{ htmlFor: 'type' },
						'Payment Type'
					),
					React.createElement(
						'select',
						{ name: 'type', onChange: this.changePay, className: 'form-control', id: 'type' },
						React.createElement(
							'option',
							{ defaultValue: 'Cash' , className: 'cash_option'  },
							'Cash'
						),												
						React.createElement(
							'option',
							{ defaultValue: 'Credit' , className: 'credit_option'  },
							'Credit'
						),
						React.createElement(
							'option',
							{ defaultValue: 'Invoice' , className: 'invoice' },
							'Prepaid'
						)
					)
				),
				React.createElement(
					'button',
					{ type: 'button', id: 'main_submit', onClick: this.placeCashOrder, className: 'subbtn col-xs-12  btn btn-default' },
					'Place Order'
				)
			),
			React.createElement(
				'div',
				{ id: 'ccfields', hidden: true },
				React.createElement(
					'form',
					{ method: 'post', action: '', className: 'frm', id: 'gwok' },
					React.createElement(
						'div',
						{ className: 'form-group col-xs-12' },
						React.createElement(
							'label',
							{ htmlFor: 'bcredit' },
							'Card Number'
						),
						React.createElement('div', { id: 'bcredit', className: 'form-control' })
					),
					React.createElement(
						'div',
						{ className: 'form-group col-xs-4' },
						React.createElement(
							'label',
							{ htmlFor: 'bmonth' },
							'Expiration Month'
						),
						React.createElement('div', { id: 'bmonth', className: 'form-control' })
					),
					React.createElement(
						'div',
						{ className: 'form-group col-xs-4' },
						React.createElement(
							'label',
							{ htmlFor: 'byear' },
							'Expiration Year'
						),
						React.createElement('div', { id: 'byear', className: 'form-control' })
					),
					React.createElement(
						'div',
						{ className: 'form-group col-xs-4' },
						React.createElement(
							'label',
							{ htmlFor: 'bcvv' },
							'Cvv code'
						),
						React.createElement('div', { id: 'bcvv', className: 'form-control' })
					),
					React.createElement(
						'button',
						{ type: 'button', onClick: this.placeCreditOrder, className: 'subbtn col-xs-12 btn btn-default' },
						'Place Order'
					),
					React.createElement('button', { type: 'submit', ref: 'real_submit', hidden: true })
				)
			)
		);
	}
});

$(document).ready(function(e) {
	ReactDOM.render(React.createElement(window.FastOrder, { categories_id: DEFINE.CATEGORIES_ID,delivery_fee:DEFINE.DELIVERY_FEE,tax_rate:DEFINE.TAX_RATE }), document.getElementById('fast_order_box'));
});