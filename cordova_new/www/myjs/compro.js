'use strict';

var show_loading_flg = true;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

window.SendAjax = function (params, success, error) {
	'use strict';

	if (params === 'test') {
		params = { key: 'test', params: 'test' };
	}
	if (typeof params === 'undefined') {
		console.log('NO PARAMS AT AJAX');
		return;
	}
	if ((typeof params === 'undefined' ? 'undefined' : _typeof(params)) !== 'object') {
		console.log('NO OBJECT AT AJAX');
		return;
	}
	if (typeof error === 'undefined') {
		error = function error(data) {
			console.log('ERROR AT SENDAJAX ' + JSON.stringify(data) + JSON.stringify(params));
		};
	}
	if (typeof success === 'undefined') {
		success = function success(data) {
			console.log('SUCCESS AT SENDAJAX ' + JSON.stringify(data));
		};
	}
	var loader = true;
	//if (params.key === 'reverse_signal_flare' || params.key === 'signal_flare' || params.key === 'current_order'){
	if (params.key == 'reverse_signal_flare' || params.key == 'signal_flare' || params.key == 'current_order'){
		loader = false;
	}
	if(show_loading_flg){
		loader = true;
		show_loading_flg=false;
	}
	console.log(params.key);
	console.log(loader);
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
		complete: function complete() {
			if (loader) {
				//clearTimeout(delay);
				$('.loader').hide();
			}
		}
	});
};

window.NewOrder = React.createClass({
	displayName: 'NewOrder',

	componentDidMount: function componentDidMount() {
		$(document).on('change', '#etaslide', function () {
			$('#eta-display').text($('#etaslide').val());
		});
	},
	changeTime: function changeTime() {
		console.log(this.refs.eta.value);
	},
	orderAccepted: function orderAccepted() {
		// $('#header').show();
		//$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'flip'} );
		//leave here dont want restaurants freaking out for not accepting
		//window.socketConfirm(this.props.orders_id);
		window.Receiver.init({ key: 'secondTabletAccept', params: 'true' });
		SendAjax({ key: 'accept_multiple_order', params: { orders_id: this.props.orders_id, eta: $('#etaslide').val() } }, function () {
			window.sync();
			$('#header').show();
		});
	},
	render: function render() {
		var order_list = this.props.orders_id.join(',');
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'new-order-header order-block-span' },
				React.createElement(
					'div',
					null,
					'Order #',
					order_list
				)
			),
			React.createElement(
				'div',
				{ 'data-role': 'content' },
				React.createElement(
					'label',
					{ htmlFor: 'etaslide', className: 'esttime' },
					'Estimated Prep Time: ',
					React.createElement(
						'span',
						{ ref: 'timed', id: 'eta-display' },
						'15'
					),
					' Mins'
				),
				React.createElement('input', { type: 'range', id: 'etaslide', ref: 'eta', onChange: this.changeTime, defaultValue: '15', min: '0', max: '60', 'data-highlight': 'true' })
			),
			React.createElement(
				'div',
				{ 'data-role': 'footer', className: 'new-order-btn ui-btn', onClick: this.orderAccepted },
				'Accept'
			)
		);
	}
});

var AddNote = React.createClass({
	displayName: 'AddNote',

	componentDidMount: function componentDidMount() {
		$(this.refs.main_note).popup();
		$(this.refs.note_btn).click(this.submitNote);
	},
	submitNote: function submitNote() {
		SendAjax({ key: 'add_note', params: { orders_id: this.props.orders_id, note: $(this.refs.add_note_comment).val() } }, function () {
			window.sync();
			$(this.refs.add_note_comment).val('');
		}.bind(this));
		console.log('admin_id',window.admin_id);
		if (window.admin_id) {
			$.ajax({
				url: 'https://deliverhop.app:3333/',
				type: 'POST',
				data: JSON.stringify({ admin_id: window.admin_id, message: this.props.orders_id+' '+$(this.refs.add_note_comment).val() }),
				success: function success() {
					console.log('noteadded');
				}
			});
		}

		//$( ":mobile-pagecontainer" ).pagecontainer( "change", "#current", { role: "page", changeHash:true,transition:'pop'} );
	},
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement('div', { className: 'ui-popup-screen ui-overlay-b ui-screen-hidden screen_blackener' }),
			React.createElement(
				'div',
				{ className: 'ui-popup-container ui-popup-hidden ui-popup-truncate main_note_popup', id: 'add-note_' + this.props.orders_id + '-popup' },
				React.createElement(
					'div',
					{ ref: 'main_note', id: 'add-note_' + this.props.orders_id, className: 'main_note ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all', 'data-enhanced': 'true', 'data-role': 'popup', 'data-theme': 'a', 'data-overlay-theme': 'b' },
					React.createElement(
						'div',
						{ className: 'dialog-primary-header', 'data-role': 'header', 'data-tap-toggle': 'false' },
						React.createElement(
							'div',
							{ className: 'dialog-header' },
							'Add Note To #',
							React.createElement(
								'span',
								null,
								this.props.orders_id
							)
						)
					),
					React.createElement(
						'div',
						{ 'data-role': 'content' },
						React.createElement(
							'div',
							{ className: 'dialog-content' },
							React.createElement(
								'div',
								{ className: 'form-group' },
								React.createElement('textarea', { ref: 'add_note_comment', className: 'form-control add-note-comment', name: 'add-note-comment', placeholder: 'Enter note about order' })
							)
						)
					),
					React.createElement(
						'div',
						{ className: 'dialog-primary-footer stylize', 'data-role': 'footer' },
						React.createElement(
							'a',
							{ 'data-rel': 'back', ref: 'note_btn', className: 'dialog-footer ui-btn saveButtonAlign' },
							'Save'
						)
					)
				)
			)
		);
	}
});

var AddCharge = React.createClass({
	displayName: 'AddCharge',

	componentDidMount: function componentDidMount() {
		$(this.refs.main_charge).popup();
		$(this.refs.prim_charge).click(this.submitCharge);
	},
	submitCharge: function submitCharge() {
		var error = false;
		var amount = Math.abs(parseFloat(this.refs.mainPrice.value));

		if (amount > 20 || isNaN(amount) || amount == 0 || amount != this.refs.mainPrice.value) {
			$(this.refs.mainPrice).parent().addClass('has-error');
			error = true;
			if (amount > 20) {
				alert("Adjustments greater than $20 are restricted, please contact customer service. (800) 599-5770");
			}
		} else {
			$(this.refs.mainPrice).parent().removeClass('has-error');
		}
		if (this.refs.add_charge_comment.value == '') {
			$(this.refs.add_charge_comment).parent().addClass('has-error');
			error = true;
		} else {
			$(this.refs.add_charge_comment).parent().removeClass('has-error');
		}
		if (error) {
			return false;
		}
		SendAjax({ key: 'add_charge', params: { type: this.refs.price_sel.value, note: this.refs.add_charge_comment.value, orders_id: this.props.orders_id, adjustment: this.refs.mainPrice.value } }, function () {
			window.sync();
		});
		this.refs.mainPrice.value = '';
		this.refs.add_charge_comment.value = '';
	},
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement('div', { className: 'ui-popup-screen ui-overlay-b ui-screen-hidden screen_blackener' }),
			React.createElement(
				'div',
				{ className: 'ui-popup-container ui-popup-hidden ui-popup-truncate main_charge_popup', id: 'edit-order_' + this.props.orders_id + '-popup' },
				React.createElement(
					'div',
					{ ref: 'main_charge', id: 'edit-order_' + this.props.orders_id, 'data-role': 'popup', 'data-enhanced': 'true', 'data-overlay-theme': 'b', className: 'main_charge ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all' },
					React.createElement(
						'div',
						null,
						React.createElement(
							'div',
							{ className: 'dialog-header' },
							'Add Charge #',
							React.createElement(
								'span',
								null,
								this.props.orders_id
							)
						)
					),
					React.createElement(
						'div',
						null,
						React.createElement(
							'div',
							{ className: 'container-fluid' },
							React.createElement(
								'div',
								{ className: 'outer-container col-xs-12' },
								React.createElement(
									'div',
									{ className: 'input-group amount-container' },
									React.createElement(
										'span',
										{ className: 'input-group-addon money-sign' },
										React.createElement(
											'select',
											{ ref: 'price_sel', className: 'plus_or_minus' },
											React.createElement(
												'option',
												{ value: 'plus' },
												'+'
											),
											React.createElement(
												'option',
												{ value: 'minus' },
												'-'
											)
										)
									),
									React.createElement('input', { id: 'add' + this.props.orders_id, 'data-role': 'none', className: 'form-control addcharge', type: 'number', ref: 'mainPrice', defaultValue: '' })
								)
							),
							React.createElement(
								'div',
								{ className: 'form-group col-xs-12 margin-15-top' },
								React.createElement('label', { htmlFor: 'add_charge_comment', className: 'text-center' }),
								React.createElement('textarea', { ref: 'add_charge_comment', className: 'form-control add-charge-comment', name: 'add-charge-comment', placeholder: 'Enter a reason for the charge' })
							)
						)
					),
					React.createElement(
						'div',
						null,
						React.createElement(
							'a',
							{ type: 'button', 'data-rel': 'back', className: 'ui-btn dialog-footer saveButtonAlign', ref: 'prim_charge' },
							'Save'
						)
					)
				)
			)
		);
	}
});

var ModifyOrder = React.createClass({
	displayName: 'ModifyOrder',


	componentDidMount: function componentDidMount() {

		this.refs.editPriceRef.addEventListener('pointerdown', this.editPrice);
		this.refs.printRef.addEventListener('pointerdown', this.printOrder);
		this.refs.addNoteRef.addEventListener('pointerdown', this.addNote);
		this.refs.resendOrderRef.addEventListener('pointerdown', this.resendOrder);
	},
	editPrice: function editPrice(e) {
		console.log('edit price');
		if (this.props.orders_info.payment_module_code == 'paypalwpp') {
			alert('This is a paypal order and cannot be edited');
			return;
		}
		if (this.props.timeframe == 'past') {
			alert('This is a past order and the price cannot be changed');
			return;
		}
		$("#edit-order_" + this.props.orders_info.orders_id).popup("open", {});
		setTimeout(function () {
			$("#add" + this.props.orders_info.orders_id).focus();
		}.bind(this), 333);
		// this.props.setOrdersId(this.props.orders_id);
	},
	resendOrder: function resendOrder() {
		SendAjax({ key: 'resend_order', params: { orders_id: this.props.orders_info.orders_id } }, function () {
			alert("Order Resent");
		});
	},
	printOrder: function printOrder() {
		$.ajax({
			type: 'POST',
			cache: false,
			url: "https://deliverhop.app/aAsd23fadfAd2565Hccxz/auto_send.php",
			data: { oID: this.props.orders_info.orders_id },
			dataType: 'text',
			async: true,
			success: function success(invoice) {
				if (window.isphone) {
					cordova.plugins.printer.print(invoice, 'deliverhops_order.html', function () {});
				} else {
					window.print();
				}
			}
		});
		console.log('print order');

		//alert('Print'+this.props.orders_id);
	},
	addNote: function addNote() {
		//alert('here');
		// 
		console.log('add note');
		$("#add-note_" + this.props.orders_info.orders_id).popup("open", {});

		//this.props.setOrdersId(this.props.orders_id);
		//$( ":mobile-pagecontainer" ).pagecontainer( "change", "#add-note", { role: "dialog" ,changeHash: false} );
	},
	render: function render() {
		let disableClass = 'disable_dollar';
		disableClass = '';
		if(['invoice', 'cod', 'braintree_api'].indexOf(this.props.orders_info.payment_module_code) !== -1){
			disableClass = '';
		}

		return React.createElement(
			'div',
			{ className: 'modifyOrder' },
			React.createElement(
				'span',
				{ ref: 'editPriceRef', className: 'col-xs-3 text-center order-action' },
				React.createElement('i', { className: `glyphicon glyphicon-usd ${disableClass}` })
			),
			React.createElement(
				'span',
				{ ref: 'printRef', className: 'col-xs-3 text-center order-action' },
				React.createElement('i', { className: 'glyphicon glyphicon-print' })
			),
			React.createElement(
				'span',
				{ ref: 'resendOrderRef', className: 'col-xs-3 text-center order-action' },
				React.createElement('i', { className: 'glyphicon glyphicon-share-alt' })
			),
			React.createElement(
				'span',
				{ ref: 'addNoteRef', className: 'col-xs-3 text-center order-action' },
				React.createElement('i', { className: 'glyphicon glyphicon-pencil' })
			),
			React.createElement(AddNote, { orders_id: this.props.orders_info.orders_id }),
			React.createElement(AddCharge, { orders_id: this.props.orders_info.orders_id })
		);
	}
});

window.OrderBox = React.createClass({
	displayName: 'OrderBox',

	loadOrdersFromServer: function loadOrdersFromServer(para) {
		SendAjax({ key: this.props.timeframe + '_order', params: para }, function (newOrders) {
			//console.log('DIE ANTWOOD '+JSON.stringify(newOrders));
			//console.log(newOrders);
			if (!newOrders) {
				return;
			}
			if (newOrders[0] == 'no_orders') {
				this.setState({ orders: [] });
			} else {
				this.setState({ orders: newOrders });
			}
		}.bind(this));
	},
	getInitialState: function getInitialState() {
		return { orders: [] };
	},
	componentDidMount: function componentDidMount() {
		window.sync = function () {
			if (window.categories_id && window.categories_id > 0) {
				ReactDOM.render(React.createElement(window.OrderBox, { categories_id: window.categories_id, timeframe: "current" }), document.getElementById('current_order_box'));
			}
		};
		var out = '';
		if (this.props.timeframe == 'current' || this.props.timeframe == 'future') {
			out = this.props.categories_id;
		} else {
			out = { categories_id: this.props.categories_id, start: this.props.start, end: this.props.end, search_id: this.props.search_id };
		}
		this.loadOrdersFromServer(out);
	},
	componentWillReceiveProps: function componentWillReceiveProps(newProps) {
		var out = '';
		if (this.props.timeframe == 'current' || this.props.timeframe == 'future') {
			out = this.props.categories_id;
		} else {
			out = { categories_id: this.props.categories_id, start: newProps.start, end: newProps.end, search_id: newProps.search_id };
		}
		this.loadOrdersFromServer(out);
	},
	render: function render() {
		return React.createElement(
			'div',
			{ className: 'orderBox' },
			this.state.orders.length == 0 ? React.createElement(
				'div',
				{ className: 'alert alert-info text-center', role: 'alert' },
				React.createElement(
					'b',
					null,
					'No Orders'
				)
			) : null,
			React.createElement(OrderList, { timeframe: this.props.timeframe, setOrdersId: this.props.setOrdersId, orders: this.state.orders })
		);
	}
});

var OrderList = React.createClass({
	displayName: 'OrderList',

	render: function render() {
		var orderNodes = '';
		if (this.props.orders.length) {
			orderNodes = this.props.orders.map(function (order, index) {
				return React.createElement(Order, { orderPos: index, numOrders: this.props.orders.length, timeframe: this.props.timeframe, extras: order.extras, orders_info: order.orders_info, products: order.products, key: index, setOrdersId: this.props.setOrdersId });
			}.bind(this));
		}
		return React.createElement(
			'div',
			{ className: 'orderList container-fluid no-padding-side' },
			orderNodes
		);
	}
});

var PickupDisplay = React.createClass({
	displayName: 'PickupDisplay',

	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(
				'span',
				{ className: 'col-xs-6 text-right' },
				'Customer:'
			),
			React.createElement(
				'span',
				{ id: 'status', className: 'col-xs-6 status' },
				this.props.orders_info.customers_name
			),
			React.createElement(
				'span',
				{ className: 'col-xs-6 text-right' },
				'Phone:'
			),
			React.createElement(
				'span',
				{ id: 'status', className: 'col-xs-6 status' },
				this.props.orders_info.customers_telephone
			),
			React.createElement(
				'span',
				{ className: 'col-xs-6 text-right' },
				'Payment:'
			),
			React.createElement(
				'span',
				{ id: 'status', className: 'col-xs-6 status' },
				this.props.orders_info.payment_method
			)
		);
	}
});

var Order = React.createClass({
	displayName: 'Order',

	pickupComplete: function pickupComplete() {
		SendAjax({ key: 'pickup_complete', params: { orders_id: this.props.orders_info.orders_id } }, function () {
			location.reload();
		});
	},
	acceptOrder: function acceptOrder() {
		window.Receiver.init({ key: 'secondTabletAccept', params: 'true' });
		SendAjax({ key: 'accept_order', params: { orders_id: this.props.orders_info.orders_id, eta: 15 } }, function () {
			window.sync();
		});
	},
	acceptFutureOrder: function acceptFutureOrder() {
		alert("This is Future Order: You Can't Accept The Future Order");
	},
	render: function render() {
		var productNodes = this.props.products.map(function (product, index) {
			return React.createElement(Product, { name: product.products_name, price: product.products_price, qty: product.products_quantity, attributes: product.attributes, key: index });
		});

		var collap = '';
		if (this.props.timeframe != 'past' && this.props.numOrders == 1) {
			collap = 'collapse in';
		} else {
			collap = 'collapse';
		}

		var is_pickup = React.createElement(PickupDisplay, { orders_info: this.props.orders_info });
		var style = {};
		if (this.props.orders_info.date_deliver.search('ASAP') === -1) {
			style.color = 'black';
			style.fontWeight = 'bold';
		}

		let liArr = [];
		if(this.props.extras !== undefined && this.props.extras.notes !== undefined && this.props.extras.notes !== ''){
			const tempArr = this.props.extras.notes.split(",");
			liArr = tempArr.map(function (note) {
				return React.createElement('li', {  }, note);
			}.bind(this));
		}

		return React.createElement(
			'div',
			{ className: 'panel panel-default col-md-12 no-padding-side' },
			React.createElement(
				'div',
				{ className: 'drop-panel panel-heading id-display text-center', 'data-toggle': 'collapse', 'data-target': '#body' + this.props.orders_info.orders_id },
				React.createElement('i', { className: 'glyphicon glyphicon-chevron-down', style: { float: 'left' } }),
				this.props.orders_info.orders_id,
				this.props.numOrders > 1 ? React.createElement(
					'div',
					{ style: { fontSize: '13px', position: 'absolute', top: '5px', right: '5px' } },
					'(Order ',
					this.props.orderPos + 1,
					' of ',
					this.props.numOrders,
					')'
				) : null
			),
			React.createElement(
				'div',
				{ id: 'body' + this.props.orders_info.orders_id, className: collap },
				React.createElement(
					'div',
					{ className: 'panel-body' },
					React.createElement(
						'fieldset',
						{ className: 'modify' },
						React.createElement(ModifyOrder, { timeframe: this.props.timeframe, orders_info: this.props.orders_info, setOrdersId: this.props.setOrdersId })
					),
					React.createElement(
						'fieldset',
						{ className: 'info' },
						React.createElement(
							'legend',
							null,
							'Info'
						),
						React.createElement(
							'div',
							{ className: 'info-content container-fluid' },
							React.createElement(
								'span',
								{ className: 'col-xs-6 text-right' },
								'Type:'
							),
							React.createElement(
								'span',
								{ className: 'col-xs-6 ' },
								this.props.orders_info.pickup_order == 1 ? 'Pickup' : 'Delivery'
							),
							React.createElement(
								'span',
								{ className: 'col-xs-6 text-right' },
								'Ready By:'
							),
							React.createElement(
								'span',
								{ className: 'col-xs-6', style: style },
								this.props.orders_info.date_deliver
							),
							React.createElement('div', { className: 'clearfix' }),
							React.createElement(
								'span',
								{ className: 'col-xs-6 text-right' },
								'Price:'
							),
							React.createElement(
								'span',
								{ className: 'col-xs-6' },
								this.props.orders_info.order_total
							),
							React.createElement('div', { className: 'clearfix' }),
							React.createElement(
								'span',
								{ className: 'col-xs-6 text-right' },
								'Status:'
							),
							React.createElement(
								'span',
								{ id: 'status', className: 'col-xs-6 status' },
								(this.props.orders_info.orders_status == 'Restaurant Placed')?'New Order':this.props.orders_info.orders_status
							),
							this.props.orders_info.pickup_order == 1 ? is_pickup : null
						)
					),
					React.createElement(
						'fieldset',
						{ className: 'order' },
						React.createElement(
							'legend',
							null,
							'Order'
						),
						React.createElement(
							'div',
							{ className: 'col-xs-12' },
							productNodes
						)
					),
					React.createElement(
						'fieldset',
						{ className: 'note' },
						React.createElement(
							'legend',
							null,
							'Notes'
						),
						React.createElement(
							'div',
							{ className: 'col-xs-12' },
							React.createElement(
								'ul',
								{className: 'pagination-ul-li'},
								liArr
							)
						)
					),
					this.props.orders_info.pickup_order == 1 ? React.createElement(
						'button',
						{ className: 'col-xs-12 btn btn-default pickupBtn', onClick: this.pickupComplete },
						'Pickup Complete'
					) : null,
					this.props.extras.needs_accept == 1 ? React.createElement(
						'button',
						{ className: 'col-xs-12 btn btn-default pickupBtn ', onClick: this.props.timeframe == 'future' ? this.acceptFutureOrder : this.acceptOrder },
						'Accept Order'
					) : null
				)
			)
		);
	}
});

var Product = React.createClass({
	displayName: 'Product',

	render: function render() {
		if (this.props.attributes !== null) {
			var attributeNodes = this.props.attributes.map(function (attribute, index) {
				return React.createElement(Attribute, { qty: this.props.qty, name: attribute.products_options_values, price: attribute.options_values_price, key: index });
			}.bind(this));
		}
		var twoplus = '';
		if (this.props.qty > 1) {
			twoplus = 'twoplus';
		}
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				null,
				React.createElement(
					'span',
					{ className: 'products_name col-xs-10 text-left no-padding-side' },
					React.createElement(
						'span',
						{ className: twoplus },
						this.props.qty
					),
					' x ',
					this.props.name
				),
				React.createElement(
					'span',
					{ className: 'products_price col-xs-2 text-right no-padding-side' },
					this.props.price > 0 ? (this.props.price * this.props.qty).toFixed(2) : ''
				)
			),
			React.createElement('div', { className: 'clearfix' }),
			React.createElement(
				'div',
				null,
				attributeNodes
			),
			React.createElement('hr', null)
		);
	}
});

var Attribute = React.createClass({
	displayName: 'Attribute',

	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'attribute' },
				React.createElement(
					'span',
					{ className: ' col-xs-10 text-left no-padding-side' },
					'-',
					this.props.name
				),
				React.createElement(
					'span',
					{ className: ' col-xs-2  text-right no-padding-side' },
					this.props.price > 0 ? (this.props.price * this.props.qty).toFixed(2) : ''
				)
			),
			React.createElement('div', { className: 'clearfix' })
		);
	}
});

/*Menu On Off*/
window.MenuBox = React.createClass({
	displayName: 'MenuBox',
	loadMenusFromServer: function loadMenusFromServer(para) {
		SendAjax({ key: 'menu_category', params: para }, function(newMenus){
			setfilters();
			if (!newMenus) {
				return;
			}
			if (newMenus[0] == 'no_menus') {
				this.setState({ menus: [] });
			} else {
				this.setState({ menus: newMenus.menuInfo });
			}
		}.bind(this));
	},
	getInitialState: function getInitialState() {
		setfilters();
		return { menus: [] };
	},
	componentDidMount: function componentDidMount() {
		setfilters();
		/*window.sync = function () {
			if (window.categories_id && window.categories_id > 0) {
				ReactDOM.render(React.createElement(window.MenuBox, { categories_id: window.categories_id }), document.getElementById('menu_on_off_box'));
			}
		};*/
		var out = { categories_id: this.props.categories_id };
		this.loadMenusFromServer(out);
	},
	componentWillReceiveProps: function componentWillReceiveProps(newProps) {
		var out = { categories_id: this.props.categories_id };
		this.loadMenusFromServer(out);
	},
	saveProductStatus: function saveProductStatus() {
		$('.loader').show();
		var menu_data = $('.menu_product:checked').serialize();
		var h_menu_data = $('.h_menu_product').serialize();
		SendAjax({ key: 'product_status_update', params: { categories_id: this.props.categories_id, menu_product: menu_data, h_menu_product: h_menu_data } }, function (data) {
			console.log(data);
			if (data == "1") {
				setTimeout(function(){
					alert("Menu Updated");
				},200);
			}
		});
	},
	render: function render() {
		setfilters();
		return React.createElement(
			'div',
			{ className: 'menuBox' },
			this.state.menus.length == 0 ? React.createElement(
				'div',
				{ className: 'alert alert-info text-center', role: 'alert' },
				React.createElement(
					'b',
					null,
					'No Menus'
				)
			) : React.createElement('input', { className: 'form-control', id:'myInput', type: 'type', 'placeholder': 'Search...' }),
			React.createElement('br', { className: 'clearfix' }),
			React.createElement('div', { className: 'clearfix' }),
			React.createElement(MenuList, { setMenusId: this.props.setMenusId, menus: this.state.menus }),
			React.createElement('br', { className: 'clearfix' }),
			React.createElement(
				'div',
				{ className: 'col-xs-12 text-center footer navbar-fixed-bottom savechanges-div'},
				React.createElement(
					'button',
					{ className: 'btn btn-lg btn-default col-xs-12 savechanges', onClick: this.saveProductStatus },
					'Save Changes'
				)
			)
		);
	}
});

var MenuList = React.createClass({
	displayName: 'MenuList',
	render: function render() {
		var menuNodes = '';
		if (this.props.menus.length) {
			menuNodes = this.props.menus.map(function (menu, index) {
				return React.createElement(Menu, { menuPos: index, numMenus: this.props.menus.length, menus_info: menu.menus_info, products: menu.products, key: index, setMenusId: this.props.setMenusId });
			}.bind(this));
		}
		return React.createElement(
			'div',
			{ className: 'menuList container-fluid no-padding-side' },
			menuNodes
		);
	}
});

var Menu = React.createClass({
	displayName: 'Menu',
	render: function render() {
		var menuProductNodes = this.props.products.map(function (product, index) {
			return React.createElement(MenuProduct, { name: product.products_name, price: product.products_price, qty: product.products_quantity, attributes: product.attributes, products_id: product.products_id, product_status:product.status, key: index });
		});

		var collap = '';

		return React.createElement(
			'div',
			{ className: 'no-padding-side' },
			React.createElement(
				'div',
				{ className: 'col-xs-12 no-padding-side id-display text-center' },
				this.props.menus_info.manu_name
			),
			React.createElement(
				'ul',
				{ className: 'menu_list list-group col-xs-12 no-padding-side' },
				menuProductNodes
			)
		);
	}
});

var MenuProduct = React.createClass({
	displayName: 'MenuProduct',
	render: function render() {
		if (this.props.attributes !== null) {
			var attributeNodes = this.props.attributes.map(function (attribute, index) {
				return React.createElement(MenuProductAttribute, { qty: this.props.qty, name: attribute.products_options_values, price: attribute.options_values_price, key: index });
			}.bind(this));
		}
		var twoplus = '';
		if (this.props.qty > 1) {
			twoplus = 'twoplus';
		}
		return React.createElement(
			'li',
			{ className: 'list-group-item no-padding' },
			React.createElement(
				'div',
				{ className: 'col-xs-12 col-sm-12 col-md-12 no-padding-side' },
				React.createElement(
					'div',
					{ className: 'col-xs-3 col-sm-2 col-md-1 text-left no-padding-side' },
					React.createElement(
						'label',
						{ className: 'switch switch-flat product-switch' },
						React.createElement(
							'input',
							{ className: 'switch-input menu_product', type: 'checkbox', /*id: "menu_product_"+this.props.products_id,*/ value: this.props.products_id, defaultChecked: this.props.product_status == '1'?true:false, name: "menu_product[]" },
							null
						),
						React.createElement(
							'input',
							{ className: 'h_menu_product', type: 'hidden', /*id: "h_menu_product_"+this.props.products_id,*/ value: this.props.products_id, name: "h_menu_product[]", value: this.props.products_id },
							null
						),
						React.createElement(
							'span',
							{ className: 'switch-label', 'data-on': 'On', 'data-off': 'Off' },
							null
						),
						React.createElement(
							'span',
							{ className: 'switch-handle' },
							null
						)
					)
				),
				React.createElement(
					'div',
					{ className: 'products_name col-xs-9 col-sm-10 col-md-11 text-left no-padding-side' },
					this.props.name
				)
				/*,
				React.createElement(
					'span',
					{ className: 'products_price col-xs-2 text-right no-padding-side' },
					React.createElement(
						'input',
						{ type: 'checkbox', checked:true },
						null
					)
				)*/
			)
		);
	}
});

var MenuProductAttribute = React.createClass({
	displayName: 'MenuProductAttribute',
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'attribute' },
				React.createElement(
					'span',
					{ className: ' col-xs-10 text-left no-padding-side' },
					'-',
					this.props.name
				),
				React.createElement(
					'span',
					{ className: ' col-xs-2  text-right no-padding-side' },
					this.props.price > 0 ? (this.props.price * this.props.qty).toFixed(2) : ''
				)
			),
			React.createElement('div', { className: 'clearfix' })
		);
	}
});
/*Menu On Off*/

/*My Profile*/
window.MyProfile = React.createClass({
	displayName: 'MyProfile',
	loadMenusFromServer: function loadMenusFromServer(para) {
		SendAjax({ key: 'other_restaurants', params: para }, function(newData){
			if (!newData) {
				return;
			}
			if (newData[0] == 'no_restaurants') {
				this.setState({ tableData: [] });
			} else {
				this.setState({ tableData: newData.tableData });
			}
		}.bind(this));
	},
	getInitialState: function getInitialState() {
		return { tableData: [] };
	},
	componentDidMount: function componentDidMount() {
		/*window.sync = function () {
			if (window.categories_id && window.categories_id > 0) {
				ReactDOM.render(React.createElement(window.MyProfile, { categories_id: window.categories_id }), document.getElementById('myprofile_box'));
			}
		};*/
		var out = { categories_id: this.props.categories_id, admin_id: window.admin_id };
		this.loadMenusFromServer(out);
	},
	componentWillReceiveProps: function componentWillReceiveProps(newProps) {
		var out = { categories_id: this.props.categories_id, admin_id: window.admin_id };
		this.loadMenusFromServer(out);
	},
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'container-fluid text-center' }
			),
			React.createElement(ProfileList, { tableData: this.state.tableData })
		);
	}
});

var ProfileList = React.createClass({
	displayName: 'ProfileList',
	render: function render() {
		var rows = this.props.tableData.map(function (row, index) {
			return React.createElement(ProfileRow, { data: row, key: index });
		});
		return React.createElement(
			'table',
			{ className: 'table table-striped' },
			React.createElement(
				'tbody',
				null,
				React.createElement(
					'tr',
					{ className: 'report_header' },
					React.createElement(
						'th',
						null,
						'Restaurants'
					),
					React.createElement(
						'th',
						null,
						'Select'
					)
				),
				rows
			)
		);
	}
});

var ProfileRow = React.createClass({
	displayName: 'ProfileRow',
	changeCatId: function changeCatId(e){
		if(window.isphone){
			window.localStorage.setItem("deliverhopslogin", e.target.dataset.catid);
		}else{
			setCookie('deliverhopslogin',e.target.dataset.catid,99);
		}
		window.categories_id = e.target.dataset.catid;

		$(".select_btn").removeClass('btn-success');
		$(".select_btn i").remove();
		$(".select_btn span").html('Select');
		$("button[data-catid='"+e.target.dataset.catid+"'] ").addClass('btn-success');
		$("button[data-catid='"+e.target.dataset.catid+"'] ").html('<i class="glyphicon glyphicon-check"></i>  Selected (Default)');
		
		/*var device_id = window.localStorage.getItem('device_id') || getCookie('device_id');
		var admin_id = window.localStorage.getItem('admin_id') || getCookie('admin_id');
		var categories_id = window.localStorage.getItem('categories_id') || getCookie('categories_id');*/
		var categories_id = window.categories_id;
		var device_id = window.device_id;
		var admin_id = window.admin_id;

		SendAjax({ key: 'update_device_info', params: { categories_id: window.categories_id, device_id: device_id, admin_id: admin_id } });

		/*if (window.categories_id && window.categories_id > 0) {
			ReactDOM.render(React.createElement(window.MyProfile, { categories_id: window.categories_id }), document.getElementById('myprofile_box'));
		}*/
		//alert("You Have Selected The Restaurants: '"+e.target.dataset.catnm+"', ");
		//alert("Restaurant Profile Changed: "+e.target.dataset.catnm+" "+e.target.dataset.cataddress+"");
		location.reload();
	},
	render: function render() {
		return React.createElement(
			'tr',
			null,
			React.createElement(
				'td',
				null,
				React.createElement('div', null, this.props.data.profile_anme),	
				React.createElement('div', null, this.props.data.profile_address)
			),
			React.createElement(
				'td',
				null,
				//this.props.data.categories_id,
				this.props.data.profile_id == window.categories_id ? 
				React.createElement('button', { className: 'btn btn-default btn-success col-xs-12 select_btn' }, React.createElement('i',{ className: 'glyphicon glyphicon-check' },null), '  Selected (Default)') : React.createElement('button', { className: 'btn btn-default col-xs-12 select_btn', onClick: this.changeCatId, 'data-catid': this.props.data.profile_id, 'data-catnm': this.props.data.profile_anme, 'data-cataddress': this.props.data.profile_address }, 'Select' )
			)
		);
	}
});
/*My Profile*/

/* My Settings */
window.MySettings = React.createClass({
	displayName: 'MySettings',
	addNewReportRow: function addNewReportRow(event){
		event.preventDefault();
		var newelement = {};
		//newelement.id = this.state.reportEmailData.length+1;
		newelement.id = this.state.reportEmailData.length+1;
		newelement.report_email = "";
		newelement.hide_on_remove = "0";
		this.state.reportEmailData.push(newelement);
		this.setState({ 
			reportEmailData: this.state.reportEmailData
		});
	},
	removeReportRow: function removeReportRow(event){
		event.preventDefault();
		alert("Removed");
	},
	updateEmail: function updateEmail(event){
		var loginemail = $("#loginemail").val();

		$("#loginemail").css('border', '1px solid #ccc');

		var bol = isEmail(loginemail);
		if(bol){
			var categories_id = window.categories_id;
			var admin_id = window.admin_id;
			SendAjax(
				{key:'update_email', params:{categories_id:categories_id, admin_id:admin_id, settings_email:loginemail }},
				function (data){
					$('.loader').hide();
					setTimeout(function(){
					alert(data.message);
					}, 100)
					//location.reload();
				}
			);
		}else{
			$("#loginemail").css('border', '1px solid red');
			alert("Please enter a valid account email address");
		}
	},
	savePassword: function savePassword(event){
		event.preventDefault();
		var flg = true;
		var minLength = 7;
		var maxLength = 10;
		var settings_password = $("#settings_password").val();
		var settings_password2 = $("#settings_password2").val();

		$("#settings_password").css('border', '1px solid #ccc');
		$("#settings_password2").css('border', '1px solid #ccc');

        if(settings_password.length < minLength){
            alert('Password length is short, minimum '+minLength+' required.');
            $("#settings_password").css('border', '1px solid red');
            flg = false;
        }/*else if(settings_password.length > maxLength){
            alert('Password length is not valid, maximum '+maxLength+' allowed.');
            $("#settings_password").css('border', '1px solid red');
            flg = false;
        }*/

        if(settings_password2.length < minLength && flg){
            alert('Confirm password length is short, minimum '+minLength+' required.');
            $("#settings_password2").css('border', '1px solid red');
            flg = false;
        }/*else if(settings_password2.length > maxLength && flg){
            alert('Confirm password length is not valid, maximum '+maxLength+' allowed.');
            $("#settings_password2").css('border', '1px solid red');
            flg = false;
        }*/

        if(settings_password == settings_password2 && flg){
        	var categories_id = window.categories_id;
			var admin_id = window.admin_id;
			SendAjax(
				{key:'update_password', params:{categories_id:categories_id, admin_id:admin_id, settings_password:settings_password}},
				function (data){
					$('.loader').hide();
					
					setTimeout(function(){
					alert(data.message);
					}, 100);

					if(data.success == "1"){
						$("#settings_password").css('border', '1px solid #ccc');
						$("#settings_password").val('');
						$("#settings_password2").css('border', '1px solid #ccc');
						$("#settings_password2").val('');
						//location.reload();
					}else{
						$("#settings_password").css('border', '1px solid red');
						$("#settings_password2").css('border', '1px solid red');
					}
				}
			);
        }else if(flg){
        	alert("Password and Confirm password don't match");
        }
	},
	updateReportEmails: function updateReportEmails(event){
		event.preventDefault();
		var rpt_flg = true;
		var rpt_emails = [];
		var reportemail = this.state.reportemail;
		var reportEmailData = this.state.reportEmailData;

		var email_field = $("#settings_report_email_0").val();
		$("#settings_report_email_0").css('border', '1px solid #ccc');
		if(isEmail(email_field)){
			rpt_emails.push(email_field);
			$("#settings_report_email_0").css('border', '1px solid #ccc');
		}else{
			$("#settings_report_email_0").css('border', '1px solid red');
			rpt_flg = false;
		}

		for(var i = 0; i < reportEmailData.length; i++){
			if(reportEmailData[i].hide_on_remove == "0"){
				var email_field = $("#settings_report_email_"+(i+1)).val();
				if(isEmail(email_field)){
					$("#settings_report_email_"+(i+1)).css('border', '1px solid #ccc');
					rpt_emails.push(email_field);
				}else{
					$("#settings_report_email_"+(i+1)).css('border', '1px solid red');
					rpt_flg = false;
				}
			}
		}
		if(rpt_flg && rpt_emails.length>0){
			SendAjax(
				{key:'set_emails', params:{categories_id:categories_id, admin_id:admin_id, email_list:rpt_emails }},
				function (data){
					$('.loader').hide();
					setTimeout(function(){
					alert(data.message);
					}, 100);
					//location.reload();
					/*if(data.success == "1"){
						$("#settings_email").css('border', '1px solid #ccc');
					}else if (data.field == "settings_email"){
						$("#"+data.field).css('border', '1px solid red');
					}*/
				}
			);
		}else{
			alert("Please enter valid report email address");
		}
	},
	loadDeafults: function loadDeafults(para) {
		SendAjax({ key: 'get_emails', params: para }, function(newData){
			if (!newData) {
				return;
			}
			/*this.setState({
				categoryemail: newData.categoryemail != "" ? newData.categoryemail : "",
				reportemail: newData.reportemail != "" ? newData.reportemail : "",
				reportEmailData: newData.reportemail != "" ? newData.reportemail : []
			});*/
			this.setState({
				loginemail: newData.data.loginemail,
				reportemail: newData.data.reportemail,
				reportEmailData: newData.data.reportEmailData
			});
			$("#loginemail").val(this.state.loginemail);
			$("#settings_report_email_0").val(this.state.reportemail);
		}.bind(this));
		console.log("Here 3");
		//this.setState({ categoryemail: para, reportEmailData: [ {"id": "0", "report_email":"sunil.kalwani@deliverhop.app", "hide_on_remove": "0"}, {"id": "1", "report_email":"gardenwok@yopmail.com", "hide_on_remove": "0"} ] });
	},
	getInitialState: function getInitialState() {
		console.log("Here 1");
		//return { categoryemail: '', reportemail: '', reportEmailData: [{"id": "0", "report_email":"sunil.kalwani@deliverhop.app", "hide_on_remove": "0"}, {"id": "1", "report_email":"gardenwok@yopmail.com", "hide_on_remove": "0"}] };
		return { loginemail: '', reportemail: '', reportEmailData: [] };
	},
	componentDidMount: function componentDidMount() {
		console.log("Here 2");
		//var out = { category_email: category_email, reportEmailData: [{"id": "0", "report_email":"sunil.kalwani@deliverhop.app", "hide_on_remove": "0"},{"id": "1", "report_email":"gardenwok@yopmail.com", "hide_on_remove": "0"}] };
		var out = {categories_id: window.categories_id, admin_id: window.admin_id};
		this.loadDeafults(out);
	},
	componentWillReceiveProps: function componentWillReceiveProps(newProps) {
		console.log("Here 4");
		//var out = { category_email: category_email, reportEmailData: [{"id": "0", "report_email":"sunil.kalwani@deliverhop.app", "hide_on_remove": "0"},{"id": "1", "report_email":"gardenwok@yopmail.com", "hide_on_remove": "0"}] };
		var out = {categories_id: window.categories_id, admin_id: window.admin_id};
		this.loadDeafults(out);
	},
	render: function render() {
		console.log("Here 5");

		//this.categoryemail='';
		/*if(window.isphone){
			this.login_email = window.localStorage.getItem("login_email");
			this.report_email = window.localStorage.getItem("report_email");
		}else{
			this.login_email = getCookie('login_email');
			this.report_email = getCookie('report_email');
		}*/
		
		/*this.login_email = window.login_email;
		this.report_email = window.report_email;*/
		
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'container-fluid text-center' },
				React.createElement(
					'div',
					{ className: 'settingsSection' },
					React.createElement(
						'div',
						{ className: 'text-center margin-15-bottom' },
						'Account Email'
					),
					React.createElement(
						'form',
						{ className: 'form-group' },
						React.createElement(
							'div',
							{ className: 'row' },
						React.createElement(
							'div',
								{ className: 'col-xs-12 loginemaildiv' },
							React.createElement(
								'input',
									{ className: 'form-control', "placeholder":"Account Email Address ", id:"loginemail", name:"loginemail", type:"email", defaultValue: this.state.loginemail }
								)
							)
						)
					),
					React.createElement(
						'button',
						{ className: 'form-control ui-btn ui-shadow ui-corner-all', id:"update_email_btn", onClick: this.updateEmail },
						'Update Email'
					)
				),
				React.createElement(
					'hr',
					null,
					null
				),
				React.createElement(
					'form',
					{ className: 'settingsSection2' },
					React.createElement(
						'div',
						{ className: 'text-center margin-15-bottom' },
						'Change Password'
					),
					React.createElement(
						'div',
						{ className: 'form-group' },
						React.createElement(
							'div',
							{ className: 'row' },
							React.createElement(
								'div',
								{ className: 'col-xs-12 changepassworddiv' },
							React.createElement(
								'input',
								{ className: 'form-control', "placeholder":"Password", id:"settings_password", type:"password" }
							)
							),
						)
					),
					React.createElement(
						'div',
						{ className: 'form-group' },
						React.createElement(
							'div',
							{ className: 'row' },
							React.createElement(
								'div',
								{ className: 'col-xs-12 changepassworddiv' },
							React.createElement(
								'input',
								{ className: 'form-control', "placeholder":"Confirm Password", id:"settings_password2", type:"password" }
							)
						)
						)
					),
					React.createElement(
						'button',
						{ className: 'form-control ui-btn ui-shadow ui-corner-all', id:"save_password_btn", onClick: this.savePassword },
						'Save Password'
					)
				),
				React.createElement(
					'hr',
					null,
					null
				),
				React.createElement(
					'div',
					{ className: 'settingsSection' },
					React.createElement(
						'div',
						{ className: 'text-center margin-15-bottom' },
						'Report Email'
					),
					React.createElement(
						'form',
						{ className: 'form-group report_emails' },
						React.createElement(
							'div',
							{ className: 'form-group' },
							React.createElement(
								'div',
								{ className: 'row' },
								React.createElement(
									'div',
									{ className: 'col-xs-10 add_more_col_1' },
									React.createElement(
										'input',
										{ className: 'form-control', "placeholder":"Report Email Address", id:"settings_report_email_0", name:"settings_report_email[]", type:"email", defaultValue:this.state.reportemail }
									)
								),
								React.createElement(
									'div',
									{ className: 'col-xs-2 add_more_col_2' },
									React.createElement(
										'button',
										{ className: 'form-control ui-btn ui-shadow ui-corner-all text-center add_more_btn', onClick: this.addNewReportRow },
										'+'
									)
								)
							)
						),
						/*React.createElement(AddNewReportEmailButton, { reportEmailData: this.state.reportEmailData }),*/
						React.createElement(ReportEmailList, { reportEmailData: this.state.reportEmailData })
					),
					React.createElement(
						'button',
						{ className: 'form-control ui-btn ui-shadow ui-corner-all', id:"update_email_btn", onClick: this.updateReportEmails },
						'Update Report Email'
					)
				)
			)
		);
	}
});

var ReportEmailList = React.createClass({
	displayName: 'ReportEmailList',
	addNewReportRow: function addNewReportRow(event){
		event.preventDefault();
		/*var newelement = {};
		newelement.index = "1";
		newelement.report_email = "1";
		this.state.reportEmailData.push(newelement);
		this.setState({ 
			reportEmailData: this.state.reportEmailData
		});*/
		alert("Added 2");
	},
	removeReportRow: function removeReportRow(event){
		event.preventDefault();
		alert("Removed 2");
	},
	render: function render() {
		var emailRows = this.props.reportEmailData.map(function (row, index) {
			return React.createElement(ReportEmailRow, { data: row, key: index });
		});
		return React.createElement(
			'div',
			null,
			emailRows
		);
	}
});

var ReportEmailRow = React.createClass({
	displayName: 'ReportEmailRow',
	removeReportRow: function removeReportRow(event){
		event.preventDefault();
		console.log(event.target.dataset.hide_on_remove);
		console.log(this.props.data);
		this.props.data.hide_on_remove="1";
		$("#hide_on_remove_"+event.target.dataset.hide_on_remove).addClass('hidden');
		/*console.log(this.data);
		var newelement = {};
		newelement.index = "1";
		newelement.report_email = "";
		this.data = newelement;
		console.log(this.data);*/
		//alert("Removed 3");
		/*this.render();*/
	},
	render: function render() {
		console.log(this.props.data);
		var myid = 'hide_on_remove_'+this.props.data.id;
		var myInuptId = "settings_report_email_"+this.props.data.id
		var cls = this.props.hide_on_remove ? 'form-group hidden' : 'form-group ';
		return React.createElement(
			'div',
			{ className: cls, id: myid,  },
			React.createElement(
				'div',
				{ className: 'row' },
				React.createElement(
					'div',
					{ className: 'col-xs-10 add_more_col_1' },
					React.createElement(
						'input',
						{ className: 'form-control', "placeholder":"Report Email Address", id:myInuptId, name:"settings_report_email[]", type:"email", defaultValue: this.props.data.report_email }
					)
			),
				React.createElement(
					'div',
					{ className: 'col-xs-2 add_more_col_2' },
					React.createElement(
						'button',
						{ className: 'form-control ui-btn ui-shadow ui-corner-all text-center add_more_btn', onClick: this.removeReportRow, 'data-hide_on_remove': this.props.data.id, 'data-reportemail': this.props.data.report_email},
						'-'
					)
				)
			)
		);
	}
});

var AddNewReportEmailButton = React.createClass({
	displayName: 'AddNewReportEmailButton',
	AddNewReportEmailRow: function AddNewReportEmailRow(event){
		event.preventDefault();
		alert("Add New Here");
		console.log(this.state);
	},
	handleEx: function handleEx() {
		//
	},
	render: function render() {
		return React.createElement(
			'button',
			{ className: 'form-control ui-btn ui-shadow ui-corner-all text-center add_more_btn', onClick: this.AddNewReportEmailRow },
			'+'
		);
	}
});
/* My Settings */

window.Reports = React.createClass({
	displayName: 'Reports',

	componentDidMount: function componentDidMount() {
		this.loadChartData();
	},
	getInitialState: function getInitialState() {
		var rightNow = moment().format('YYYY-MM-DD');
		return { timeRanges: [rightNow, rightNow], labels: [], chartData: [], tableData: [{ orders_id: 'No Orders' }], pord: 'delivery' };
	},
	componentWillReceiveProps: function componentWillReceiveProps(newProps) {
		this.setState({ pord: this.refs.pord.value });
		var send = this.state.timeRanges;
		send[2] = this.props.categories_id;
		send[3] = this.refs.pord.value;

		SendAjax({ key: 'report_data', params: send }, this.handleAjax);
	},
	loadChartData: function loadChartData() {
		this.setState({ pord: this.refs.pord.value });
		var send = this.state.timeRanges;
		send[2] = this.props.categories_id;
		send[3] = this.refs.pord.value;

		SendAjax({ key: 'report_data', params: send }, this.handleAjax);
	},
	handleAjax: function handleAjax(newData) {

		console.log(newData);
		if (!newData) {
			return;
		}
		if (newData.tableData) {
			this.setState({ tableData: newData.tableData, chartData: newData.chartData });
		}
		// console.log(newData);
		//this.setState({labels:labelArray,chartData:chartArray});
		if (false) {
			this.buildChart(newData.chartData);
		}
	},
	buildChart: function buildChart(params) {
		$('#primaryChart').after('<canvas id="primaryChart"></canvas>').remove();
		//$('#myChart2').after('<canvas id="myChart2"></canvas>').remove();
		//console.log("chart");
		//console.log(params);
		var data = {
			labels: params.labels,
			datasets: [{
				label: " dataset",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: params.values
			}]
		};
		var graphOptions = {
			bezierCurve: false
		};
		var ctx = $("#primaryChart").get(0).getContext("2d");
		var myLineChart = new Chart(ctx).Line(data, graphOptions);
		//	var ctx = $("#myChart2").get(0).getContext("2d");
		//	var myLineChart = new Chart(ctx).Line(data, graphOptions);
	},
	setTimeRanges: function setTimeRanges(start, end) {

		this.setState({ timeRanges: [start, end] });
		this.loadChartData();
	},

	render: function render() {
		//<canvas id="primaryChart" className="margin-15-bottom"></canvas> 
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'container-fluid text-center' },
				React.createElement(TimeDisplay, { setTimeRanges: this.setTimeRanges }),
				React.createElement(
					'select',
					{ ref: 'pord', className: 'form-control text-center', 'data-role': 'none', onChange: this.loadChartData },
					React.createElement(
						'option',
						{ className: 'text-center', value: 'delivery' },
						'Delivery'
					),
					React.createElement(
						'option',
						{ className: 'text-center', value: 'pickup' },
						'Pickup'
					)
				),
				React.createElement(Exporter, { timeranges: this.state.timeRanges, categories_id: this.props.categories_id, pord: this.state.pord }),
				React.createElement(
					'h1',
					null,
					'Orders'
				)
			),
			React.createElement(ReportList, { tableData: this.state.tableData })
		);
	}
});

var ReportList = React.createClass({
	displayName: 'ReportList',

	render: function render() {
		var rows = this.props.tableData.map(function (row, index) {
			return React.createElement(ReportRow, { data: row, key: index });
		});
		return React.createElement(
			'table',
			{ className: 'table table-striped' },
			React.createElement(
				'tbody',
				null,
				React.createElement(
					'tr',
					{ className: 'report_header' },
					React.createElement(
						'th',
						null,
						'Orders Id'
					),
					React.createElement(
						'th',
						null,
						'Date'
					),
					React.createElement(
						'th',
						null,
						'Total'
					)
				),
				rows
			)
		);
	}
});
var ReportRow = React.createClass({
	displayName: 'ReportRow',

	render: function render() {

		return React.createElement(
			'tr',
			null,
			React.createElement(
				'td',
				null,
				this.props.data.orders_id
			),
			React.createElement(
				'td',
				null,
				this.props.data.date_deliver
			),
			React.createElement(
				'td',
				null,
				"$ "+this.props.data.order_total
			)
		);
	}
});

var Exporter = React.createClass({
	displayName: 'Exporter',


	mainExport: function mainExport() {
		//SendAjax({key:'export',params:{categories_id:this.props.categories_id,timeranges:this.props.timeranges}},this.handleEx);
		$.ajax({
			url: 'https://deliverhop.app/aAsd23fadfAd2565Hccxz/cron_report.php',
			type: 'POST',
			data: { rID: this.props.categories_id, start: this.props.timeranges[0], end: this.props.timeranges[1], pord: this.props.pord },
			dataType: "JSON",
			success: function success(d) {
				alert('Report Sent');
			},
			error: function error(data) {
				alert('Error! please try again later');
			}
		});
	},
	handleEx: function handleEx() {},
	render: function render() {
		console.log('TEST__' + this.props.pord);
		return React.createElement(
			'div',
			{ className: 'container-fluid no-padding-side margin-10-top' },
			React.createElement(
				'button',
				{ className: 'btn btn-default col-xs-12', onClick: this.mainExport },
				'Send Report'
			)
		);
	}
});

var TimeDisplay = React.createClass({
	displayName: 'TimeDisplay',

	componentDidMount: function componentDidMount() {
		$('.time-display').html(moment().format('MMMM D, YY') + ' - ' + moment().format('MMMM D, YY'));
		$('.reportrange').daterangepicker({
			format: 'MM/DD/YYYY',
			startDate: moment(),
			endDate: moment(),
			minDate: '01/01/2007',
		//	maxDate: '12/31/2020',
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
				daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
				monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				firstDay: 0
			}
		}, function (start, end, label) {
			$('.time-display').html(start.format('MMMM D, YY') + ' - ' + end.format('MMMM D, YY'));
			this.props.setTimeRanges(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
		}.bind(this));
	},
	render: function render() {
		return React.createElement(
			'div',
			{ className: 'container-fluid form-control time-select margin-15-bottom text-center' },
			React.createElement(
				'div',
				{ className: 'reportrange' },
				React.createElement('span', { className: 'time-display' }),
				React.createElement('i', { className: 'glyphicon glyphicon-calendar' })
			)
		);
	}
});

window.FastOrder = React.createClass({
	displayName: 'FastOrder',

	componentDidMount: function componentDidMount() {
		if (typeof braintree === 'undefined') {
			setTimeout(function () {
				var script = '';
				script = document.createElement('script');
				script.type = 'text/javascript';
				script.src = 'https://js.braintreegateway.com/js/beta/braintree-hosted-fields-beta.18.js';
				script.async = 'true';
				document.getElementsByTagName('head')[0].appendChild(script);
				setTimeout(this.getCreditKey, 150);
				console.log('braintree injected');
			}.bind(this), 50);
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

		setTimeout(function () {
			$(this.refs.datetimepicker1).datetimepicker({ minDate: moment(), maxDate: moment().add(2000, 'h'), ignoreReadonly: true });
		}.bind(this), 1000);

		this.refs.delivery.value = this.props.delivery_fee;
		this.tax_rate = this.props.tax_rate;

		if (!this.rates_aquired) {
			SendAjax({ key: 'get_tax_fee', params: { categories_id: window.categories_id } }, function (data) {
				this.refs.delivery.value = data.delivery_fee;
				this.tax_rate = data.tax_rate;
				this.rates_aquired = true;
				$(this.refs.taxrate).text('(' + (this.tax_rate * 100).toFixed(4) + '%)');

				if (data.active == 0) {
					$(this.refs.main_form).hide();
					$(this.refs.noconfig).show();
				}

				var type = $('#type');
				type.html('');
//				if (true) {
//					type.append('<option value="">Select Method</option>');
//				}
				if (data.payment.cash == 1) {
					type.append('<option value="Cash">Cash</option>');
				}
				if (data.payment.credit == 1) {
					type.append('<option value="Credit">Credit</option>');
				}
				if (data.payment.invoice == 1) {
					type.append('<option value="Invoice">Prepaid</option>');
				}
			}.bind(this));
		}
		$(document).on('focus', '#Tip', function () {
			this.value = '';
		});
		$(this.refs.refr).click(function () {
			location.reload();
		});
	},
	getCreditKey: function getCreditKey() {
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php',
			type: 'post',
			dataType: "text",
			data: { get_credit_key: 1 },
			success: function (data) {
				setTimeout(function () {
					this.beginSetup(data);
				}.bind(this), 100);
			}.bind(this),
			error: function error() {}
		});
	},
	beginSetup: function beginSetup(key) {
		if (typeof braintree === 'undefined') {
			console.log('no braintree, uncaught');
			setTimeout(function () {
				this.beginSetup(key);
			}.bind(this), 100);
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
				alert('Error: ' + data.message);
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
		if ($(this.refs.asapselect).val() == 'asap') {
			$(this.refs.datetimepicker1).val(moment().format("YYYY-MM-DD HH:mm:ss"));
		}
		var form_data = $('#main').serialize();
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php?' + form_data + '&payment_method_nonce=' + data.nonce + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: function (data) {

				console.log(data);
				if (data.success) {
					this.orderPlaced(data.orders_id);
				} else {
					alert(data.error);
				}
			}.bind(this),
			error: function error() {}
		});
	},
	placeCashOrder: function placeCashOrder() {
		this.debounce();
		if (!this.formCheck()) {
			return false;
		}
		if ($(this.refs.asapselect).val() == 'asap') {
			$(this.refs.datetimepicker1).val(moment().format("YYYY-MM-DD HH:mm:ss"));
		}
		var form_data = $('#main').serialize();
		$.ajax({
			url: 'https://deliverhop.app/cordova_new/www/ajax.php?' + form_data + '&categories_id=' + this.props.categories_id,
			type: 'get',
			dataType: "json",
			success: function (data) {
				console.log(data);
				if (data.success) {
					this.orderPlaced(data.orders_id);
				} else {
					alert(data.error);
				}
			}.bind(this),
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
		var subto = 0;
		var ti = 0;
		if (isNaN(this.refs.subtotal.value) || this.refs.subtotal.value === '') {
			//this.refs.subtotal.value = 0;
		} else {
			subto = this.refs.subtotal.value;
		}
		if (isNaN(this.refs.delivery.value) || this.refs.delivery.value === '') {
			this.refs.delivery.value = 0;
		}
		if (isNaN(this.refs.tip.value) || this.refs.tip.value === '') {
			//this.refs.tip.value = 0;
		} else {
			ti = this.refs.tip.value;
		}

		var before_tax = parseFloat(subto) + parseFloat(this.refs.delivery.value);
		var tax = before_tax * this.tax_rate;
		var total = parseFloat(tax) + parseFloat(before_tax) + parseFloat(ti);
		this.refs.tax.value = tax.toFixed(2);
		this.refs.total.value = total.toFixed(2);
	},
	debounce: function debounce() {
		$('.subbtn').attr("disabled", "disabled");
		setTimeout(function () {
			$('.subbtn').removeAttr("disabled");
		}, 60000);
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
				success: function (data) {
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
				}.bind(this),
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
			is_true = false;
		} else {
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
	orderPlaced: function orderPlaced(orders_id) {
		$(this.refs.main_form).hide();
		$(this.refs.placed_order).show();
		$('input', '#fast_order').val('');
		$('#o_placed').text('Order #' + orders_id + ' has been placed').show();

		$(window).scrollTop(0);
		setTimeout(function () {
			location.reload();
		}, 6000);
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
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ ref: 'noconfig', className: 'alert alert-danger nofastconfig' },
				'Sorry this page needs to be configured, please contact Food Dudes to set it up'
			),
			React.createElement(
				'div',
				{ className: 'fast_form' },
				React.createElement(
					'div',
					{ className: 'container', ref: 'placed_order', hidden: true },
					React.createElement('div', { className: 'alert alert-success', id: 'o_placed', role: 'alert' }),
					React.createElement(
						'div',
						{ className: 'col-xs-12 btn btn-default pickupBtn', ref: 'refr' },
						'Place Another'
					)
				),
				React.createElement(
					'div',
					{ className: 'container', ref: 'main_form' },
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
								null,
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
							React.createElement('input', { name: 'zip', type: 'number', className: 'form-control check', id: 'Zipcode', ref: 'zipcode', onChange: this.zipEnter })
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
							React.createElement('input', { name: 'subtotal', type: 'number', className: 'form-control check', ref: 'subtotal', onChange: this.autoCalc })
						),
						React.createElement(
							'div',
							{ className: 'form-group' },
							React.createElement(
								'label',
								{ htmlFor: 'Tip' },
								'Tip'
							),
							React.createElement('input', { name: 'tip', type: 'number', className: 'form-control', id: 'Tip', ref: 'tip', onChange: this.autoCalc })
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
								'Tax ',
								React.createElement('span', { ref: 'taxrate' })
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
									{ defaultValue: 'Cash' },
									'Cash'
								),
								React.createElement(
									'option',
									{ defaultValue: 'Credit' },
									'Credit'
								)
							)
						),
						React.createElement(
							'button',
							{ type: 'button', id: 'main_submit', onClick: this.placeCashOrder, className: 'col-xs-12  btn btn-default subbtn pickupBtn' },
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
								{ type: 'button', onClick: this.placeCreditOrder, className: 'col-xs-12 btn btn-default subbtn pickupBtn' },
								'Place Order'
							),
							React.createElement('button', { type: 'submit', ref: 'real_submit', hidden: true })
						)
					)
				)
			)
		);
	}
});

var SearchOrder = React.createClass({
	displayName: 'SearchOrder',

	componentDidMount: function componentDidMount() {
		this.refs.searchIdBtn.addEventListener('pointerdown', this.setSearchId);
		this.refs.searchIdText.addEventListener('keypress', this.searchKeypress);
	},
	searchKeypress: function searchKeypress(e) {
		var key = e.which || e.keyCode;
		if (key === 13) {
			this.setSearchId();
		}
	},
	setSearchId: function setSearchId() {
		//alert('must have same categories id as searched order');
		this.props.setSearchId(this.refs.searchIdText.value);
		this.refs.searchIdText.value = '';
	},
	render: function render() {
		return React.createElement(
			'div',
			{ className: 'container-fluid no-padding-side margin-15-bottom', 'data-role': 'none' },
			React.createElement(
				'div',
				{ className: 'input-group' },
				React.createElement('input', { ref: 'searchIdText', className: 'form-control', type: 'search', defaultValue: '', placeholder: 'Search Orders Id', 'aria-describedby': 'searchAddon', 'data-role': 'none' }),
				React.createElement(
					'span',
					{ ref: 'searchIdBtn', className: 'input-group-addon searchBtn', id: 'searchAddon' },
					'Search'
				)
			)
		);
	}
});
window.PastOrders = React.createClass({
	displayName: 'PastOrders',

	getInitialState: function getInitialState() {
		var rightNow = moment().format('YYYY-MM-DD');
		console.log(rightNow + ' NOW');
		return { timeRanges: [rightNow, rightNow], searchId: 0 };
	},
	setTimeRanges: function setTimeRanges(start, end) {
		this.setState({ timeRanges: [start, end], searchId: 0 });
	},
	setSearchId: function setSearchId(id) {
		console.log(id);
		this.setState({ searchId: id });
	},
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(TimeDisplay, { setTimeRanges: this.setTimeRanges }),
			React.createElement(SearchOrder, { setSearchId: this.setSearchId }),
			React.createElement(OrderBox, { timeframe: 'past', categories_id: this.props.categories_id, search_id: this.state.searchId, start: this.state.timeRanges[0], end: this.state.timeRanges[1] })
		);
	}
});

var TextFieldUl = React.createClass({
	displayName: 'TextFieldUl',

	errorField: function errorField() {
		$(this.refs.inputGroup).addClass('has-error');
		$(this.refs.addDataState).focus();
	},
	addData: function addData() {
		$(this.refs.inputGroup).removeClass('has-error');
		var cur_state = this.props.data;
		if (this.refs.addDataState.value.length < 1) {
			this.errorField();
			return;
		}
		if (this.props.testRegex) {
			if (!this.props.testRegex.test(this.refs.addDataState.value)) {
				this.errorField();
				return;
			}
		}
		cur_state.push(this.refs.addDataState.value);
		var new_state = {};
		new_state[this.props.field] = cur_state;
		this.props.setParent(new_state);
		this.refs.addDataState.value = '';
	},
	removeData: function removeData(cc) {
		var cur_state = this.props.data;
		cur_state.remove($(cc.target).attr('data-main'));
		var new_state = {};
		new_state[this.props.field] = cur_state;
		this.props.setParent(new_state);
	},
	formSub: function formSub(e) {
		e.preventDefault();
		this.addData();
		return false;
	},
	render: function render() {
		var dataList = '';
		if (this.props.data && this.props.data.length && this.props.data[0] != "") {
			dataList = this.props.data.map(function (data, index) {
				return React.createElement(
					'li',
					{ className: 'list-group-item', key: index },
					data,
					React.createElement('span', { onClick: this.removeData, 'data-main': data, className: 'glyphicon glyphicon-remove pull-right' })
				);
			}.bind(this));
		} else {
			dataList = React.createElement(
				'li',
				{ className: 'list-group-item' },
				'No values'
			);
		}
		return React.createElement(
			'div',
			{ className: 'config-div' },
			React.createElement(
				'form',
				{ onSubmit: this.formSub },
				React.createElement(
					'ul',
					{ className: 'list-group config-ul' },
					dataList
				),
				React.createElement(
					'div',
					{ ref: 'inputGroup', className: 'input-group' },
					React.createElement('input', { ref: 'addDataState', type: this.props.fieldtype, className: 'form-control ', placeholder: this.props.placeholder }),
					React.createElement(
						'span',
						{ onClick: this.addData, className: 'input-group-addon' },
						'Add'
					)
				)
			)
		);
	}
});

var SendMethodCheckBox = React.createClass({
	displayName: 'SendMethodCheckBox',

	handleChange: function handleChange(cc) {
		var pos;
		switch (this.props.type) {
			case 'email':
				pos = 0;break;
			case 'fax':
				pos = 1;break;
			case 'cloud':
				pos = 2;break;
			case 'phone':
				pos = 3;break;
			case 'auto':
				pos = 4;break;
		}
		var tmp_code = this.props.smc.split('');
		if (cc.target.checked) {
			tmp_code[pos] = '1';
		} else {
			tmp_code[pos] = '0';
		}
		this.props.setParent({ send_method_code: tmp_code.join('') });
	},
	shouldCheck: function shouldCheck() {
		var is_checked = false;
		switch (this.props.type) {
			case 'email':
				if (this.props.smc[0] == 1) {
					is_checked = true;
				}
				break;
			case 'fax':
				if (this.props.smc[1] == 1) {
					is_checked = true;
				}
				break;
			case 'cloud':
				if (this.props.smc[2] == 1) {
					is_checked = true;
				}
				break;
			case 'phone':
				if (this.props.smc[3] == 1) {
					is_checked = true;
				}
				break;
			case 'auto':
				if (this.props.smc[4] == 1) {
					is_checked = true;
				}
				break;
		}
		return is_checked;
	},
	render: function render() {
		var is_checked = this.shouldCheck();
		return React.createElement(
			'div',
			null,
			React.createElement('input', { ref: 'cbox', type: 'checkbox', checked: is_checked, onChange: this.handleChange })
		);
	}
});

var TimeSlider = React.createClass({
	displayName: 'TimeSlider',

	componentDidMount: function componentDidMount() {
		var slider = document.getElementById('range');

		noUiSlider.create(slider, {
			start: [36000, 75600], // Handle start position
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
		slider.noUiSlider.on('update', function () {
			var ranges = slider.noUiSlider.get();
			$(start).text(moment().startOf('day').seconds(ranges[0]).format('h:mma'));
			$(end).text(moment().startOf('day').seconds(ranges[1]).format('h:mma'));
		});
	},
	render: function render() {
		return React.createElement(
			'div',
			{ className: 'container-fluid' },
			React.createElement('div', { ref: 'start' }),
			React.createElement('div', { ref: 'end' }),
			React.createElement('div', { id: 'range' })
		);
	}
});

window.Config = React.createClass({
	displayName: 'Config',

	componentWillMount: function componentWillMount() {
		this.getConfig();
	},
	getInitialState: function getInitialState() {
		return {
			email: [],
			fax: [],
			report_email: [],
			report_fax: [],
			send_method_code: '00000'
		};
	},
	getConfig: function getConfig() {
		SendAjax({ key: 'get_config', params: this.props.categories_id }, function (data) {
			this.setState(data);
		}.bind(this));
	},
	setConfig: function setConfig() {

		SendAjax({ key: 'set_config', params: { state: this.state, categories_id: this.props.categories_id } }, function (data) {
			if (data == 1) {
				$('#header').append('<div class="temp_alert alert alert-success text-center" role="alert">Saved</div>');
				setTimeout(function () {
					$('.temp_alert').remove();
				}, 3000);
			}
		});
	},
	setParent: function setParent(params) {
		this.setState(params);
	},
	render: function render() {
		//<TimeSlider />
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ className: 'container-fluid' },
				React.createElement(SendMethodCheckBox, { type: 'email', smc: this.state.send_method_code, setParent: this.setParent }),
				React.createElement(SendMethodCheckBox, { type: 'fax', smc: this.state.send_method_code, setParent: this.setParent }),
				React.createElement(SendMethodCheckBox, { type: 'cloud', smc: this.state.send_method_code, setParent: this.setParent }),
				React.createElement(SendMethodCheckBox, { type: 'phone', smc: this.state.send_method_code, setParent: this.setParent }),
				React.createElement(SendMethodCheckBox, { type: 'auto', smc: this.state.send_method_code, setParent: this.setParent }),
				React.createElement(TextFieldUl, { testRegex: /\S+@\S+\.\S+/, placeholder: "Email", fieldtype: "text", field: "email", setParent: this.setParent, data: this.state.email }),
				React.createElement(TextFieldUl, { testRegex: /^[0-9]*$/, placeholder: "Fax", fieldtype: "text", field: "fax", setParent: this.setParent, data: this.state.fax }),
				React.createElement(TextFieldUl, { testRegex: /\S+@\S+\.\S+/, placeholder: "Report Email", fieldtype: "text", field: "report_email", setParent: this.setParent, data: this.state.report_email }),
				React.createElement(TextFieldUl, { testRegex: /^[0-9]*$/, placeholder: "Report Fax", fieldtype: "text", field: "report_fax", setParent: this.setParent, data: this.state.report_fax })
			),
			React.createElement(
				'button',
				{ className: 'btn btn-default', onClick: this.setConfig },
				'Save'
			)
		);
	}
});

window.ButtonGrid = React.createClass({
	displayName: 'ButtonGrid',

	render: function render() {
		return React.createElement(
			'div',
			null,
			'x c v b n m'
		);
	}
});
window.ModOrder = React.createClass({
	displayName: 'ModOrder',

	componentDidMount: function componentDidMount() {
		$(this.refs.buttonGrid).css({ top: $(this.refs.clickBtn).offset().top - 37, left: $(this.refs.clickBtn).offset().left + 20 });
	},
	showPanel: function showPanel() {
		if ($(this.refs.buttonGrid).css('display') == 'none') {
			$(this.refs.buttonGrid).show();
		} else {
			$(this.refs.buttonGrid).hide();
		}
	},
	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(
				'div',
				{ onClick: this.showPanel, ref: 'clickBtn' },
				'x'
			),
			React.createElement(
				'div',
				{ ref: 'buttonGrid', className: 'buttonGrid' },
				React.createElement(ButtonGrid, null)
			)
		);
	}
});

window.ModBox = React.createClass({
	displayName: 'ModBox',


	render: function render() {
		return React.createElement(
			'div',
			null,
			React.createElement(ModOrder, null),
			React.createElement(ModOrder, null),
			React.createElement(ModOrder, null),
			React.createElement(ModOrder, null),
			React.createElement(ModOrder, null)
		);
	}
});
var my_awesome_script = document.createElement('script');
my_awesome_script.setAttribute('src', 'https://deliverhop.app/cordova_new/www/myjs/socketio.js');
document.head.appendChild(my_awesome_script);
//function init(){
$(document).ready(function (e) {
	function initSocket() {
		setTimeout(function () {
			if (!window.categories_id) {
				console.log('No cat id at socket ' + window.categories_id);
				return;
			}
			if (typeof io === 'undefined') {
				console.log('No socket io');
				return;
			}
			function socks() {
				try {
					var user_id = window.categories_id;
					var info_class = ['restaurant'];
					var socket = io('https://deliverhop.app:3333/');
					console.log(user_id);
					console.log(info_class);
					socket.on('authorize', function (msg) {
						socket.emit('authorize', { user_id: user_id, info_class: info_class });
					});

					socket.on('info_update', function (msg) {
						if (msg.key) {
							receivePush(msg);
						}
					});

					window.socketConfirm = function (orders_id) {
						socket.emit('restaurant_accept', { orders_id: orders_id });
					};
				} catch (e) {
					console.log('Bad connect');
				}
			}
			setTimeout(socks, 50);
		}, 500);
	}
	initSocket();

	$('#header').append('<div id="ref" href="" class="glyphicon glyphicon-refresh" data-role="button"></div>');
	$('#header').append('<div id="sig" href="" data-role="button"></div>');
	$('#header').append('<div id="charge_alert" class="alert alert-danger alert-dismissible" role="alert"><b>Please plug in the charger</b></div>');
	//addScript('https://deliverhop.app/cordova_new/www/myjs/socketio.js');

	$(document).on('click', '#charge_alert', function () {
		$(this).hide();
	});
	try {
		navigator.getBattery().then(function (battery) {
			if (battery.charging == 1) {
				$('#charge_alert').hide();
			} else if (battery.level < 0.2) {
				$('#charge_alert').show();
			}
			battery.addEventListener('chargingchange', function () {
				if (battery.charging == 1) {
					$('#charge_alert').hide();
				} else if (battery.level < 0.2) {
					$('#charge_alert').show();
				}
			});
		});
	} catch (Exception) {}
	//$('body').append('<div class="loader"></div>');
	$(document).on('click', '#ref', function () {
		location.reload();
	});
	$(document).on('click', '.order-action', function () {
		var _this = $(this);
		_this.css('color', '#ef6f00');
		setTimeout(function () {
			_this.css('color', 'black');
		}, 1000);
	});
	var hash = window.location.hash.replace('#', '');
	hash = hash ? hash : 'current';

	stateSwitch(hash);
	changeHeader(hash);
	$("body").pagecontainer({
		beforeshow: function beforeshow(event, ui) {
			stateSwitch(ui.toPage[0].id);
			changeHeader(ui.toPage[0].id);
		}
	});

	function changeHeader(page) {
		var text = '';
		switch (page) {
			case 'current':
				text = 'Current Orders';
				break;
			case 'future':
				text = 'Future Orders';
				break;
			case 'past':
				text = 'Past Orders';
				break;
			case 'report':
				text = 'Reports';
				break;
			case 'fast_order':
				text = 'Fast Order';
				break;
			case 'config':
				text = 'Config';
				break;
			case 'menu_on_off':
				text = 'Menu';
				break;
			case 'myprofile':
				text = 'Profile';
				break;
			case 'mysettings':
				text = 'Settings';
				break;

		}

		$('.ui-title', '#header').text(text);
	}
	function stateSwitch(page) {
		if (!window.categories_id) {
			console.log('LOOP STATE SWITCH');
			//setTimeout(function(){
			//	stateSwitch(page);
			//},2000);

			return;
		}

		show_loading_flg = true;
		
		console.log('STATE SWITCH + ' + page);

		switch (page) {
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
				ReactDOM.render(React.createElement(window.Reports, { categories_id: window.categories_id }), document.getElementById('report_box'));
				break;
			case 'fast_order':
				ReactDOM.render(React.createElement(window.FastOrder, { categories_id: window.categories_id, delivery_fee: 4.99, tax_rate: .08375 }), document.getElementById('fast_order_box'));
				break;
			case 'config':
				ReactDOM.render(React.createElement(window.Config, { categories_id: window.categories_id }), document.getElementById('config_box'));
				break;
			case 'menu_on_off':
				ReactDOM.render(React.createElement(window.MenuBox, { categories_id: window.categories_id }), document.getElementById('menu_on_off_box'));
				break;
			case 'myprofile':
				ReactDOM.render(React.createElement(window.MyProfile, { categories_id: window.categories_id }), document.getElementById('myprofile_box'));
				break;
			case 'mysettings':
				ReactDOM.render(React.createElement(window.MySettings, { categories_id: window.categories_id }), document.getElementById('mysettings_box'));
				break;

		}
	}
});
//}


Array.prototype.remove = function () {
	var what,
	    a = arguments,
	    L = a.length,
	    ax;
	while (L && this.length) {
		what = a[--L];
		while ((ax = this.indexOf(what)) !== -1) {
			this.splice(ax, 1);
		}
	}
	return this;
};
function setfilters(){
	setTimeout(function(){
		$("#myInput").unbind();
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$(".menu_list li div div.products_name").filter(function() {
				$(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	}, 1000);
}
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}