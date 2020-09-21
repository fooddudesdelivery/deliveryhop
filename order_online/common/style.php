<style>
/*!
* jQuery Mobile 1.4.5
* Git HEAD hash: 68e55e78b292634d3991c795f06f5e37a512decc <> Date: Fri Oct 31 2014 17:33:30 UTC
* http://jquerymobile.com
*
* Copyright 2010, 2014 jQuery Foundation, Inc. and othercontributors
* Released under the MIT license.
* http://jquery.org/license
*
*/

.size-up-txt{
	height:70px !important; 	
}
/* Globals */
/* Font
-----------------------------------------------------------------------------------------------------------*/
html {
	font-size: 100%;
}
body,
input,
select,
textarea,
button,
.ui-btn {
	font-size: 1em;
	line-height: 1.3;
	font-family: 'Lato', sans-serif; /*{global-font-family}*/;
}
legend,
.ui-input-text input,
.ui-input-search input {
	color: inherit;
	text-shadow: inherit;
}
/* Form labels (overrides font-weight bold in bars, and mini font-size) */
.ui-mobile label,
div.ui-controlgroup-label {
	font-weight: normal;
	font-size: 16px;
}
/* Separators
-----------------------------------------------------------------------------------------------------------*/
/* Field contain separator (< 28em) */
.ui-field-contain {
	border-bottom-color: #828282;
	border-bottom-color: rgba(0,0,0,.15);
	border-bottom-width: 1px;
	border-bottom-style: solid;
}
/* Table opt-in classes: strokes between each row, and alternating row stripes */
/* Classes table-stroke and table-stripe are deprecated in 1.4. */
.table-stroke thead th,
.table-stripe thead th,
.table-stripe tbody tr:last-child {
	border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
	border-bottom: 1px solid rgba(0,0,0,.1);
}
.table-stroke tbody th,
.table-stroke tbody td {
	border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
	border-bottom: 1px solid rgba(0,0,0,.05);
}
.table-stripe.table-stroke tbody tr:last-child th,
.table-stripe.table-stroke tbody tr:last-child td {
	border-bottom: 0;
}
.table-stripe tbody tr:nth-child(odd) td,
.table-stripe tbody tr:nth-child(odd) th {
	background-color: #eeeeee; /* non-RGBA fallback  */
	background-color: rgba(0,0,0,.04);
}
/* Buttons
-----------------------------------------------------------------------------------------------------------*/
.ui-btn,
label.ui-btn {
	font-weight: bold;
	border-width: 1px;
	border-style: solid;
}
.ui-btn {
	text-decoration: none !important;
}
.ui-btn-active {
	cursor: pointer;
}
/* Corner rounding
-----------------------------------------------------------------------------------------------------------*/
/* Class ui-btn-corner-all deprecated in 1.4 */
.ui-corner-all {
	-webkit-border-radius: .6em /*{global-radii-blocks}*/;
	border-radius: .6em /*{global-radii-blocks}*/;
}
/* Buttons */
.ui-btn-corner-all,
.ui-btn.ui-corner-all,
/* Slider track */
.ui-slider-track.ui-corner-all,
/* Flipswitch */
.ui-flipswitch.ui-corner-all,
/* Count bubble */
.ui-li-count {
	-webkit-border-radius: .3125em /*{global-radii-buttons}*/;
	border-radius: .3125em /*{global-radii-buttons}*/;
}
/* Icon-only buttons */
.ui-btn-icon-notext.ui-btn-corner-all,
.ui-btn-icon-notext.ui-corner-all {
	-webkit-border-radius: 1em;
	border-radius: 1em;
}
/* Radius clip workaround for cleaning up corner trapping */
.ui-btn-corner-all,
.ui-corner-all {
	-webkit-background-clip: padding;
	background-clip: padding-box;
}
/* Popup arrow */
.ui-popup.ui-corner-all > .ui-popup-arrow-guide {
	left: .6em /*{global-radii-blocks}*/;
	right: .6em /*{global-radii-blocks}*/;
	top: .6em /*{global-radii-blocks}*/;
	bottom: .6em /*{global-radii-blocks}*/;
}
/* Shadow
-----------------------------------------------------------------------------------------------------------*/
.ui-shadow {
	-webkit-box-shadow: 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
	-moz-box-shadow: 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
	box-shadow: 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
}
.ui-shadow-inset {
	-webkit-box-shadow: inset 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
	-moz-box-shadow: inset 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
	box-shadow: inset 0 1px 3px /*{global-box-shadow-size}*/ rgba(0,0,0,.2) /*{global-box-shadow-color}*/;
}
.ui-overlay-shadow {
	-webkit-box-shadow: 0 0 12px 		rgba(0,0,0,.6);
	-moz-box-shadow: 0 0 12px 			rgba(0,0,0,.6);
	box-shadow: 0 0 12px 				rgba(0,0,0,.6);
}
/* Icons
-----------------------------------------------------------------------------------------------------------*/
.ui-btn-icon-left:after,
.ui-btn-icon-right:after,
.ui-btn-icon-top:after,
.ui-btn-icon-bottom:after,
.ui-btn-icon-notext:after {
	background-color: #666666 /*{global-icon-color}*/;
	background-color: rgba(0,0,0,.15) /*{global-icon-disc}*/;
	background-position: center center;
	background-repeat: no-repeat;
	-webkit-border-radius: 1em;
	border-radius: 1em;
}
/* Alt icons */
.ui-alt-icon.ui-btn:after,
.ui-alt-icon .ui-btn:after,
html .ui-alt-icon.ui-checkbox-off:after,
html .ui-alt-icon.ui-radio-off:after,
html .ui-alt-icon .ui-checkbox-off:after,
html .ui-alt-icon .ui-radio-off:after {
	background-color: #666666 /*{global-icon-color}*/;
	background-color: rgba(0,0,0,.15) /*{global-icon-disc}*/;
}
/* No disc */
.ui-nodisc-icon.ui-btn:after,
.ui-nodisc-icon .ui-btn:after {
	background-color: transparent;
}
/* Icon shadow */
.ui-shadow-icon.ui-btn:after,
.ui-shadow-icon .ui-btn:after {
	-webkit-box-shadow: 0 1px 0 rgba(255,255,255,.3) /*{global-icon-shadow}*/;
	-moz-box-shadow: 0 1px 0 rgba(255,255,255,.3) /*{global-icon-shadow}*/;
	box-shadow: 0 1px 0 rgba(255,255,255,.3) /*{global-icon-shadow}*/;
}
/* Checkbox and radio */
.ui-btn.ui-checkbox-off:after,
.ui-btn.ui-checkbox-on:after,
.ui-btn.ui-radio-off:after,
.ui-btn.ui-radio-on:after {
	display: block;
	width: 18px;
	height: 18px;
	margin: -9px 2px 0 2px;
}
.ui-checkbox-off:after,
.ui-btn.ui-radio-off:after {
	filter: Alpha(Opacity=30);
	opacity: .3;
}
.ui-btn.ui-checkbox-off:after,
.ui-btn.ui-checkbox-on:after {
	-webkit-border-radius: .1875em;
	border-radius: .1875em;
}
.ui-btn.ui-checkbox-off:after {
	background-color: #666;
	background-color: rgba(0,0,0,.3);
}
.ui-radio .ui-btn.ui-radio-on:after {
	background-image: none;
	background-color: #fff;
	width: 8px;
	height: 8px;
	border-width: 5px;
	border-style: solid; 
}
.ui-alt-icon.ui-btn.ui-radio-on:after,
.ui-alt-icon .ui-btn.ui-radio-on:after {
	background-color: #000;
}
/* Loader */
.ui-icon-loading {
	background: url("images/ajax-loader.gif");
	background-size: 2.875em 2.875em;
}
/* Swatches */
/* A
-----------------------------------------------------------------------------------------------------------*/
/* Bar: Toolbars, dividers, slider track */
.ui-bar-a,
.ui-page-theme-a .ui-bar-inherit,
html .ui-bar-a .ui-bar-inherit,
html .ui-body-a .ui-bar-inherit,
html body .ui-group-theme-a .ui-bar-inherit {
	background-color: #e9e9e9 /*{a-bar-background-color}*/;
	border-color: #dddddd /*{a-bar-border}*/;
	color: #000000 /*{a-bar-color}*/;
	text-shadow: 0 /*{a-bar-shadow-x}*/ 1px /*{a-bar-shadow-y}*/ 0 /*{a-bar-shadow-radius}*/ #ffffff /*{a-bar-shadow-color}*/;
	font-weight: bold;
}
.ui-bar-a {
	border-width: 1px;
	border-style: solid;
}
/* Page and overlay */
.ui-overlay-a,
.ui-page-theme-a,
.ui-page-theme-a .ui-panel-wrapper {
	background-color: #ffffff /*{a-page-background-color}*/;
	border-color: #bbbbbb /*{a-page-border}*/;
	color: black /*{a-page-color}*/;
	text-shadow: 0 /*{a-page-shadow-x}*/ 0 /*{a-page-shadow-y}*/ 0 /*{a-page-shadow-radius}*/ black /*{a-page-shadow-color}*/;
}
/* Body: Read-only lists, text inputs, collapsible content */
.ui-body-a,
.ui-page-theme-a .ui-body-inherit,
html .ui-bar-a .ui-body-inherit,
html .ui-body-a .ui-body-inherit,
html body .ui-group-theme-a .ui-body-inherit,
html .ui-panel-page-container-a {
	background-color: #ffffff /*{a-body-background-color}*/;
	border-color: #dddddd /*{a-body-border}*/;
	color: #333333 /*{a-body-color}*/;
	text-shadow: 0 /*{a-body-shadow-x}*/ 1px /*{a-body-shadow-y}*/ 0 /*{a-body-shadow-radius}*/ black /*{a-body-shadow-color}*/;
}
.ui-body-a {
	border-width: 1px;
	border-style: solid;
}
/* Links */
.ui-page-theme-a a,
html .ui-bar-a a,
html .ui-body-a a,
html body .ui-group-theme-a a {
	/*color: <?php  echo $this->Config['primary_color'] ?> !important; /*{a-link-color};*/
	font-weight: bold;
}
.ui-page-theme-a a:visited,
html .ui-bar-a a:visited,
html .ui-body-a a:visited,
html body .ui-group-theme-a a:visited {
    color: #3388cc /*{a-link-visited}*/;
}
.ui-page-theme-a a:hover,
html .ui-bar-a a:hover,
html .ui-body-a a:hover,
html body .ui-group-theme-a a:hover {
	color: #005599 /*{a-link-hover}*/;
}
.ui-page-theme-a a:active,
html .ui-bar-a a:active,
html .ui-body-a a:active,
html body .ui-group-theme-a a:active {
	color: #005599 /*{a-link-active}*/;
}
/* Button up */
.ui-page-theme-a .ui-btn,
html .ui-bar-a .ui-btn,
html .ui-body-a .ui-btn,
html body .ui-group-theme-a .ui-btn,
html head + body .ui-btn.ui-btn-a,
/* Button visited */
.ui-page-theme-a .ui-btn:visited,
html .ui-bar-a .ui-btn:visited,
html .ui-body-a .ui-btn:visited,
html body .ui-group-theme-a .ui-btn:visited,
html head + body .ui-btn.ui-btn-a:visited {
	background-color: #f6f6f6 /*{a-bup-background-color}*/;
	border-color: #ffffff /*{a-bup-border}*/;
	color: #333333 /*{a-bup-color}*/;
	text-shadow: 0 /*{a-bup-shadow-x}*/ 0 /*{a-bup-shadow-y}*/ 0 /*{a-bup-shadow-radius}*/ #ffffff /*{a-bup-shadow-color}*/;
}
/* Button hover */
.ui-page-theme-a .ui-btn:hover,
html .ui-bar-a .ui-btn:hover,
html .ui-body-a .ui-btn:hover,
html body .ui-group-theme-a .ui-btn:hover,
html head + body .ui-btn.ui-btn-a:hover {
	background-color:	#f6f6f6/*{a-bhover-background-color}*/;
	border: 1px solid #ffffff /*{a-bhover-border}*/;
	color: #333333/*{a-bhover-color}*/;
	text-shadow: 0 0 0 #ffffff;
}
/* Button down */
.ui-page-theme-a .ui-btn:active,
html .ui-bar-a .ui-btn:active,
html .ui-body-a .ui-btn:active,
html body .ui-group-theme-a .ui-btn:active,
html head + body .ui-btn.ui-btn-a:active {
	background-color: #f6f6f6 /*{a-bdown-background-color}*/;
	border-color: #dddddd /*{a-bdown-border}*/;
	color: #333333 /*{a-bdown-color}*/;
	text-shadow: 0 /*{a-bdown-shadow-x}*/ 1px /*{a-bdown-shadow-y}*/ 0 /*{a-bdown-shadow-radius}*/ #f3f3f3 /*{a-bdown-shadow-color}*/;
}
/* Active button */
.ui-page-theme-a .ui-btn.ui-btn-active,
html .ui-bar-a .ui-btn.ui-btn-active,
html .ui-body-a .ui-btn.ui-btn-active,
html body .ui-group-theme-a .ui-btn.ui-btn-active,
html head + body .ui-btn.ui-btn-a.ui-btn-active,
/* Active checkbox icon */
.ui-page-theme-a .ui-checkbox-on:after,
html .ui-bar-a .ui-checkbox-on:after,
html .ui-body-a .ui-checkbox-on:after,
html body .ui-group-theme-a .ui-checkbox-on:after,
.ui-btn.ui-checkbox-on.ui-btn-a:after,
/* Active flipswitch background */
.ui-page-theme-a .ui-flipswitch-active,
html .ui-bar-a .ui-flipswitch-active,
html .ui-body-a .ui-flipswitch-active,
html body .ui-group-theme-a .ui-flipswitch-active,
html body .ui-flipswitch.ui-bar-a.ui-flipswitch-active,
/* Active slider track */
.ui-page-theme-a .ui-slider-track .ui-btn-active,
html .ui-bar-a .ui-slider-track .ui-btn-active,
html .ui-body-a .ui-slider-track .ui-btn-active,
html body .ui-group-theme-a .ui-slider-track .ui-btn-active,
html body div.ui-slider-track.ui-body-a .ui-btn-active {
	background-color: <?php  echo $this->Config['primary_color'] ?> !important; /*{a-active-background-color}*/;
	border-color: #ffffff /*{a-active-border}*/;
	color: #ffffff /*{a-active-color}*/;
	text-shadow: 0 /*{a-active-shadow-x}*/ 2px /*{a-active-shadow-y}*/ 0 /*{a-active-shadow-radius}*/ #000000 /*{a-active-shadow-color}*/;
}
.checkbtn.active{
	text-shadow: 0 /*{a-active-shadow-x}*/ 2px /*{a-active-shadow-y}*/ 0 /*{a-active-shadow-radius}*/ #000000 /*{a-active-shadow-color}*/ !important;
}
/* Active radio button icon */
.ui-page-theme-a .ui-radio-on:after,
html .ui-bar-a .ui-radio-on:after,
html .ui-body-a .ui-radio-on:after,
html body .ui-group-theme-a .ui-radio-on:after,
.ui-btn.ui-radio-on.ui-btn-a:after {
	border-color: <?php  echo $this->Config['primary_color'] ?> !important; /*{a-active-background-color}*/;
}
/* Focus */
.ui-page-theme-a .ui-btn:focus,
html .ui-bar-a .ui-btn:focus,
html .ui-body-a .ui-btn:focus,
html body .ui-group-theme-a .ui-btn:focus,
html head + body .ui-btn.ui-btn-a:focus,
/* Focus buttons and text inputs with div wrap */
.ui-page-theme-a .ui-focus,
html .ui-bar-a .ui-focus,
html .ui-body-a .ui-focus,
html body .ui-group-theme-a .ui-focus,
html head + body .ui-btn-a.ui-focus,
html head + body .ui-body-a.ui-focus {
	-webkit-box-shadow: 0 0 12px <?php  echo $this->Config['primary_color'] ?> !important; /*{a-active-background-color}*/;
	-moz-box-shadow: 0 0 12px <?php  echo $this->Config['primary_color'] ?> !important; /*{a-active-background-color}*/;
	box-shadow: 0 0 12px <?php  echo $this->Config['primary_color'] ?> !important; /*{a-active-background-color}*/;
}
/* B
-----------------------------------------------------------------------------------------------------------*/
/* Bar: Toolbars, dividers, slider track */
.ui-bar-b,
.ui-page-theme-b .ui-bar-inherit,
html .ui-bar-b .ui-bar-inherit,
html .ui-body-b .ui-bar-inherit,
html body .ui-group-theme-b .ui-bar-inherit {
	background-color: #e9e9e9 /*{b-bar-background-color}*/;
	border-color: #dddddd /*{b-bar-border}*/;
	color: #333333 /*{b-bar-color}*/;
	text-shadow: 0 /*{b-bar-shadow-x}*/ 1px /*{b-bar-shadow-y}*/ 0 /*{b-bar-shadow-radius}*/ #eeeeee /*{b-bar-shadow-color}*/;
	font-weight: bold;
}
.ui-bar-b {
	border-width: 1px;
	border-style: solid;
}
/* Page and overlay */
.ui-overlay-b,
.ui-page-theme-b,
.ui-page-theme-b .ui-panel-wrapper {
	background-color: #f9f9f9 /*{b-page-background-color}*/;
	border-color: #bbbbbb /*{b-page-border}*/;
	color: #333333 /*{b-page-color}*/;
	text-shadow: 0 /*{b-page-shadow-x}*/ 1px /*{b-page-shadow-y}*/ 0 /*{b-page-shadow-radius}*/ #f3f3f3 /*{b-page-shadow-color}*/;
}
/* Body: Read-only lists, text inputs, collapsible content */
.ui-body-b,
.ui-page-theme-b .ui-body-inherit,
html .ui-bar-b .ui-body-inherit,
html .ui-body-b .ui-body-inherit,
html body .ui-group-theme-b .ui-body-inherit,
html .ui-panel-page-container-b {
	background-color: #ffffff /*{b-body-background-color}*/;
	border-color: #dddddd /*{b-body-border}*/;
	color: #333333 /*{b-body-color}*/;
	text-shadow: 0 /*{b-body-shadow-x}*/ 1px /*{b-body-shadow-y}*/ 0 /*{b-body-shadow-radius}*/ #f3f3f3 /*{b-body-shadow-color}*/;
}
.ui-body-b {
	border-width: 1px;
	border-style: solid;
}
/* Links */
.ui-page-theme-b a,
html .ui-bar-b a,
html .ui-body-b a,
html body .ui-group-theme-b a {
	color: #3388cc /*{b-link-color}*/;
	font-weight: bold;
}
.ui-page-theme-b a:visited,
html .ui-bar-b a:visited,
html .ui-body-b a:visited,
html body .ui-group-theme-b a:visited {
    color: #3388cc /*{b-link-visited}*/;
}
.ui-page-theme-b a:hover,
html .ui-bar-b a:hover,
html .ui-body-b a:hover,
html body .ui-group-theme-b a:hover {
	color: #005599 /*{b-link-hover}*/;
}
.ui-page-theme-b a:active,
html .ui-bar-b a:active,
html .ui-body-b a:active,
html body .ui-group-theme-b a:active {
	color: #005599 /*{b-link-active}*/;
}
/* Button up */
.ui-page-theme-b .ui-btn,
html .ui-bar-b .ui-btn,
html .ui-body-b .ui-btn,
html body .ui-group-theme-b .ui-btn,
html head + body .ui-btn.ui-btn-b,
/* Button visited */
.ui-page-theme-b .ui-btn:visited,
html .ui-bar-b .ui-btn:visited,
html .ui-body-b .ui-btn:visited,
html body .ui-group-theme-b .ui-btn:visited,
html head + body .ui-btn.ui-btn-b:visited {
	background-color: #f6f6f6 /*{b-bup-background-color}*/;
	border-color: #dddddd /*{b-bup-border}*/;
	color: #333333 /*{b-bup-color}*/;
	text-shadow: 0 /*{b-bup-shadow-x}*/ 1px /*{b-bup-shadow-y}*/ 0 /*{b-bup-shadow-radius}*/ #f3f3f3 /*{b-bup-shadow-color}*/;
}
/* Button hover */
.ui-page-theme-b .ui-btn:hover,
html .ui-bar-b .ui-btn:hover,
html .ui-body-b .ui-btn:hover,
html body .ui-group-theme-b .ui-btn:hover,
html head + body .ui-btn.ui-btn-b:hover {
	background-color: #ededed /*{b-bhover-background-color}*/;
	border-color: #dddddd /*{b-bhover-border}*/;
	color: #333333 /*{b-bhover-color}*/;
	text-shadow: 0 /*{b-bhover-shadow-x}*/ 1px /*{b-bhover-shadow-y}*/ 0 /*{b-bhover-shadow-radius}*/ #f3f3f3 /*{b-bhover-shadow-color}*/;
}
/* Button down */
.ui-page-theme-b .ui-btn:active,
html .ui-bar-b .ui-btn:active,
html .ui-body-b .ui-btn:active,
html body .ui-group-theme-b .ui-btn:active,
html head + body .ui-btn.ui-btn-b:active {
	background-color: #e8e8e8 /*{b-bdown-background-color}*/;
	border-color: #dddddd /*{b-bdown-border}*/;
	color: #333333 /*{b-bdown-color}*/;
	text-shadow: 0 /*{b-bdown-shadow-x}*/ 1px /*{b-bdown-shadow-y}*/ 0 /*{b-bdown-shadow-radius}*/ #f3f3f3 /*{b-bdown-shadow-color}*/;
}
/* Active button */
.ui-page-theme-b .ui-btn.ui-btn-active,
html .ui-bar-b .ui-btn.ui-btn-active,
html .ui-body-b .ui-btn.ui-btn-active,
html body .ui-group-theme-b .ui-btn.ui-btn-active,
html head + body .ui-btn.ui-btn-b.ui-btn-active,
/* Active checkbox icon */
.ui-page-theme-b .ui-checkbox-on:after,
html .ui-bar-b .ui-checkbox-on:after,
html .ui-body-b .ui-checkbox-on:after,
html body .ui-group-theme-b .ui-checkbox-on:after,
.ui-btn.ui-checkbox-on.ui-btn-b:after,
/* Active flipswitch background */
.ui-page-theme-b .ui-flipswitch-active,
html .ui-bar-b .ui-flipswitch-active,
html .ui-body-b .ui-flipswitch-active,
html body .ui-group-theme-b .ui-flipswitch-active,
html body .ui-flipswitch.ui-bar-b.ui-flipswitch-active,
/* Active slider track */
.ui-page-theme-b .ui-slider-track .ui-btn-active,
html .ui-bar-b .ui-slider-track .ui-btn-active,
html .ui-body-b .ui-slider-track .ui-btn-active,
html body .ui-group-theme-b .ui-slider-track .ui-btn-active,
html body div.ui-slider-track.ui-body-b .ui-btn-active {
	background-color: #3388cc /*{b-active-background-color}*/;
	border-color: #3388cc /*{b-active-border}*/;
	color: #ffffff /*{b-active-color}*/;
	text-shadow: 0 /*{b-active-shadow-x}*/ 1px /*{b-active-shadow-y}*/ 0 /*{b-active-shadow-radius}*/ #005599 /*{b-active-shadow-color}*/;
}
/* Active radio button icon */
.ui-page-theme-b .ui-radio-on:after,
html .ui-bar-b .ui-radio-on:after,
html .ui-body-b .ui-radio-on:after,
html body .ui-group-theme-b .ui-radio-on:after,
.ui-btn.ui-radio-on.ui-btn-b:after {
	border-color: #3388cc /*{b-active-background-color}*/;
}
/* Focus */
.ui-page-theme-b .ui-btn:focus,
html .ui-bar-b .ui-btn:focus,
html .ui-body-b .ui-btn:focus,
html body .ui-group-theme-b .ui-btn:focus,
html head + body .ui-btn.ui-btn-b:focus,
/* Focus buttons and text inputs with div wrap */
.ui-page-theme-b .ui-focus,
html .ui-bar-b .ui-focus,
html .ui-body-b .ui-focus,
html body .ui-group-theme-b .ui-focus,
html head + body .ui-btn-b.ui-focus,
html head + body .ui-body-b.ui-focus {
	-webkit-box-shadow: 0 0 12px #e8e8e8 /*{b-active-background-color}*/;
	-moz-box-shadow: 0 0 12px #e8e8e8 /*{b-active-background-color}*/;
	box-shadow: 0 0 12px #e8e8e8 /*{b-active-background-color}*/;
}


/* C
-----------------------------------------------------------------------------------------------------------*/
/* Bar: Toolbars, dividers, slider track */
.ui-bar-c,
.ui-page-theme-c .ui-bar-inherit,
html .ui-bar-c .ui-bar-inherit,
html .ui-body-c .ui-bar-inherit,
html body .ui-group-theme-c .ui-bar-inherit {
	background-color: #e9e9e9 /*{c-bar-background-color}*/;
	border-color: #dddddd /*{c-bar-border}*/;
	color: #333333 /*{c-bar-color}*/;
	text-shadow: 0 /*{c-bar-shadow-x}*/ 1px /*{c-bar-shadow-y}*/ 0 /*{c-bar-shadow-radius}*/ #eeeeee /*{c-bar-shadow-color}*/;
	font-weight: bold;
}
.ui-bar-c {
	border-width: 1px;
	border-style: solid;
}
/* Page and overlay */
.ui-overlay-c,
.ui-page-theme-c,
.ui-page-theme-c .ui-panel-wrapper {
	background-color: #f9f9f9 /*{c-page-background-color}*/;
	border-color: #bbbbbb /*{c-page-border}*/;
	color: #333333 /*{c-page-color}*/;
	text-shadow: 0 /*{c-page-shadow-x}*/ 1px /*{c-page-shadow-y}*/ 0 /*{c-page-shadow-radius}*/ #f3f3f3 /*{c-page-shadow-color}*/;
}
/* Body: Read-only lists, text inputs, collapsible content */
.ui-body-c,
.ui-page-theme-c .ui-body-inherit,
html .ui-bar-c .ui-body-inherit,
html .ui-body-c .ui-body-inherit,
html body .ui-group-theme-c .ui-body-inherit,
html .ui-panel-page-container-c {
	background-color: #ffffff /*{c-body-background-color}*/;
	border-color: #dddddd /*{c-body-border}*/;
	color: #333333 /*{c-body-color}*/;
	text-shadow: 0 /*{c-body-shadow-x}*/ 1px /*{c-body-shadow-y}*/ 0 /*{c-body-shadow-radius}*/ #f3f3f3 /*{c-body-shadow-color}*/;
}
.ui-body-c {
	border-width: 1px;
	border-style: solid;
}
/* Links */
.ui-page-theme-c a,
html .ui-bar-c a,
html .ui-body-c a,
html body .ui-group-theme-c a {
	color: #3388cc /*{c-link-color}*/;
	font-weight: bold;
}
.ui-page-theme-c a:visited,
html .ui-bar-c a:visited,
html .ui-body-c a:visited,
html body .ui-group-theme-c a:visited {
    color: #3388cc /*{c-link-visited}*/;
}
.ui-page-theme-c a:hover,
html .ui-bar-c a:hover,
html .ui-body-c a:hover,
html body .ui-group-theme-c a:hover {
	color: #005599 /*{c-link-hover}*/;
}
.ui-page-theme-c a:active,
html .ui-bar-c a:active,
html .ui-body-c a:active,
html body .ui-group-theme-c a:active {
	color: #005599 /*{c-link-active}*/;
}
/* Button up */
.ui-page-theme-c .ui-btn,
html .ui-bar-c .ui-btn,
html .ui-body-c .ui-btn,
html body .ui-group-theme-c .ui-btn,
html head + body .ui-btn.ui-btn-c,
/* Button visited */
.ui-page-theme-c .ui-btn:visited,
html .ui-bar-c .ui-btn:visited,
html .ui-body-c .ui-btn:visited,
html body .ui-group-theme-c .ui-btn:visited,
html head + body .ui-btn.ui-btn-c:visited {
	background-color: #f6f6f6 /*{c-bup-background-color}*/;
	border-color: #dddddd /*{c-bup-border}*/;
	color: #333333 /*{c-bup-color}*/;
	text-shadow: 0 /*{c-bup-shadow-x}*/ 1px /*{c-bup-shadow-y}*/ 0 /*{c-bup-shadow-radius}*/ #f3f3f3 /*{c-bup-shadow-color}*/;
}
/* Button hover */
.ui-page-theme-c .ui-btn:hover,
html .ui-bar-c .ui-btn:hover,
html .ui-body-c .ui-btn:hover,
html body .ui-group-theme-c .ui-btn:hover,
html head + body .ui-btn.ui-btn-c:hover {
	background-color: #ededed /*{c-bhover-background-color}*/;
	border-color: #dddddd /*{c-bhover-border}*/;
	color: #333333 /*{c-bhover-color}*/;
	text-shadow: 0 /*{c-bhover-shadow-x}*/ 1px /*{c-bhover-shadow-y}*/ 0 /*{c-bhover-shadow-radius}*/ #f3f3f3 /*{c-bhover-shadow-color}*/;
}
/* Button down */
.ui-page-theme-c .ui-btn:active,
html .ui-bar-c .ui-btn:active,
html .ui-body-c .ui-btn:active,
html body .ui-group-theme-c .ui-btn:active,
html head + body .ui-btn.ui-btn-c:active {
	background-color: #e8e8e8 /*{c-bdown-background-color}*/;
	border-color: #dddddd /*{c-bdown-border}*/;
	color: #333333 /*{c-bdown-color}*/;
	text-shadow: 0 /*{c-bdown-shadow-x}*/ 1px /*{c-bdown-shadow-y}*/ 0 /*{c-bdown-shadow-radius}*/ #f3f3f3 /*{c-bdown-shadow-color}*/;
}
/* Active button */
.ui-page-theme-c .ui-btn.ui-btn-active,
html .ui-bar-c .ui-btn.ui-btn-active,
html .ui-body-c .ui-btn.ui-btn-active,
html body .ui-group-theme-c .ui-btn.ui-btn-active,
html head + body .ui-btn.ui-btn-c.ui-btn-active,
/* Active checkbox icon */
.ui-page-theme-c .ui-checkbox-on:after,
html .ui-bar-c .ui-checkbox-on:after,
html .ui-body-c .ui-checkbox-on:after,
html body .ui-group-theme-c .ui-checkbox-on:after,
.ui-btn.ui-checkbox-on.ui-btn-c:after,
/* Active flipswitch background */
.ui-page-theme-c .ui-flipswitch-active,
html .ui-bar-c .ui-flipswitch-active,
html .ui-body-c .ui-flipswitch-active,
html body .ui-group-theme-c .ui-flipswitch-active,
html body .ui-flipswitch.ui-bar-c.ui-flipswitch-active,
/* Active slider track */
.ui-page-theme-c .ui-slider-track .ui-btn-active,
html .ui-bar-c .ui-slider-track .ui-btn-active,
html .ui-body-c .ui-slider-track .ui-btn-active,
html body .ui-group-theme-c .ui-slider-track .ui-btn-active,
html body div.ui-slider-track.ui-body-c .ui-btn-active {
	background-color: #3388cc /*{c-active-background-color}*/;
	border-color: #3388cc /*{c-active-border}*/;
	color: #ffffff /*{c-active-color}*/;
	text-shadow: 0 /*{c-active-shadow-x}*/ 1px /*{c-active-shadow-y}*/ 0 /*{c-active-shadow-radius}*/ #005599 /*{c-active-shadow-color}*/;
}
/* Active radio button icon */
.ui-page-theme-c .ui-radio-on:after,
html .ui-bar-c .ui-radio-on:after,
html .ui-body-c .ui-radio-on:after,
html body .ui-group-theme-c .ui-radio-on:after,
.ui-btn.ui-radio-on.ui-btn-c:after {
	border-color: #3388cc /*{c-active-background-color}*/;
}
/* Focus */
.ui-page-theme-c .ui-btn:focus,
html .ui-bar-c .ui-btn:focus,
html .ui-body-c .ui-btn:focus,
html body .ui-group-theme-c .ui-btn:focus,
html head + body .ui-btn.ui-btn-c:focus,
/* Focus buttons and text inputs with div wrap */
.ui-page-theme-c .ui-focus,
html .ui-bar-c .ui-focus,
html .ui-body-c .ui-focus,
html body .ui-group-theme-c .ui-focus,
html head + body .ui-btn-c.ui-focus,
html head + body .ui-body-c.ui-focus {
	-webkit-box-shadow: 0 0 12px #3388cc /*{c-active-background-color}*/;
	-moz-box-shadow: 0 0 12px #3388cc /*{c-active-background-color}*/;
	box-shadow: 0 0 12px #3388cc /*{c-active-background-color}*/;
}


/* D
-----------------------------------------------------------------------------------------------------------*/
/* Bar: Toolbars, dividers, slider track */
.ui-bar-d,
.ui-page-theme-d .ui-bar-inherit,
html .ui-bar-d .ui-bar-inherit,
html .ui-body-d .ui-bar-inherit,
html body .ui-group-theme-d .ui-bar-inherit {
	background-color: #e9e9e9 /*{d-bar-background-color}*/;
	border-color: #dddddd /*{d-bar-border}*/;
	color: #333333 /*{d-bar-color}*/;
	text-shadow: 0 /*{d-bar-shadow-x}*/ 1px /*{d-bar-shadow-y}*/ 0 /*{d-bar-shadow-radius}*/ #eeeeee /*{d-bar-shadow-color}*/;
	font-weight: bold;
}
.ui-bar-d {
	border-width: 1px;
	border-style: solid;
}
/* Page and overlay */
.ui-overlay-d,
.ui-page-theme-d,
.ui-page-theme-d .ui-panel-wrapper {
	background-color: #f9f9f9 /*{d-page-background-color}*/;
	border-color: #bbbbbb /*{d-page-border}*/;
	color: #333333 /*{d-page-color}*/;
	text-shadow: 0 /*{d-page-shadow-x}*/ 1px /*{d-page-shadow-y}*/ 0 /*{d-page-shadow-radius}*/ #f3f3f3 /*{d-page-shadow-color}*/;
}
/* Body: Read-only lists, text inputs, collapsible content */
.ui-body-d,
.ui-page-theme-d .ui-body-inherit,
html .ui-bar-d .ui-body-inherit,
html .ui-body-d .ui-body-inherit,
html body .ui-group-theme-d .ui-body-inherit,
html .ui-panel-page-container-d {
	background-color: #ffffff /*{d-body-background-color}*/;
	border-color: #dddddd /*{d-body-border}*/;
	color: #333333 /*{d-body-color}*/;
	text-shadow: 0 /*{d-body-shadow-x}*/ 1px /*{d-body-shadow-y}*/ 0 /*{d-body-shadow-radius}*/ #f3f3f3 /*{d-body-shadow-color}*/;
}
.ui-body-d {
	border-width: 1px;
	border-style: solid;
}
/* Links */
.ui-page-theme-d a,
html .ui-bar-d a,
html .ui-body-d a,
html body .ui-group-theme-d a {
	color: #3388cc /*{d-link-color}*/;
	font-weight: bold;
}
.ui-page-theme-d a:visited,
html .ui-bar-d a:visited,
html .ui-body-d a:visited,
html body .ui-group-theme-d a:visited {
    color: #3388cc /*{d-link-visited}*/;
}
.ui-page-theme-d a:hover,
html .ui-bar-d a:hover,
html .ui-body-d a:hover,
html body .ui-group-theme-d a:hover {
	color: #005599 /*{d-link-hover}*/;
}
.ui-page-theme-d a:active,
html .ui-bar-d a:active,
html .ui-body-d a:active,
html body .ui-group-theme-d a:active {
	color: #005599 /*{d-link-active}*/;
}
/* Button up */
.ui-page-theme-d .ui-btn,
html .ui-bar-d .ui-btn,
html .ui-body-d .ui-btn,
html body .ui-group-theme-d .ui-btn,
html head + body .ui-btn.ui-btn-d,
/* Button visited */
.ui-page-theme-d .ui-btn:visited,
html .ui-bar-d .ui-btn:visited,
html .ui-body-d .ui-btn:visited,
html body .ui-group-theme-d .ui-btn:visited,
html head + body .ui-btn.ui-btn-d:visited {
	background-color: #f6f6f6 /*{d-bup-background-color}*/;
	border-color: #dddddd /*{d-bup-border}*/;
	color: #333333 /*{d-bup-color}*/;
	text-shadow: 0 /*{d-bup-shadow-x}*/ 1px /*{d-bup-shadow-y}*/ 0 /*{d-bup-shadow-radius}*/ #f3f3f3 /*{d-bup-shadow-color}*/;
}
/* Button hover */
.ui-page-theme-d .ui-btn:hover,
html .ui-bar-d .ui-btn:hover,
html .ui-body-d .ui-btn:hover,
html body .ui-group-theme-d .ui-btn:hover,
html head + body .ui-btn.ui-btn-d:hover {
	background-color: #ededed /*{d-bhover-background-color}*/;
	border-color: #dddddd /*{d-bhover-border}*/;
	color: #333333 /*{d-bhover-color}*/;
	text-shadow: 0 /*{d-bhover-shadow-x}*/ 1px /*{d-bhover-shadow-y}*/ 0 /*{d-bhover-shadow-radius}*/ #f3f3f3 /*{d-bhover-shadow-color}*/;
}
/* Button down */
.ui-page-theme-d .ui-btn:active,
html .ui-bar-d .ui-btn:active,
html .ui-body-d .ui-btn:active,
html body .ui-group-theme-d .ui-btn:active,
html head + body .ui-btn.ui-btn-d:active {
	background-color: #e8e8e8 /*{d-bdown-background-color}*/;
	border-color: #dddddd /*{d-bdown-border}*/;
	color: #333333 /*{d-bdown-color}*/;
	text-shadow: 0 /*{d-bdown-shadow-x}*/ 1px /*{d-bdown-shadow-y}*/ 0 /*{d-bdown-shadow-radius}*/ #f3f3f3 /*{d-bdown-shadow-color}*/;
}
/* Active button */
.ui-page-theme-d .ui-btn.ui-btn-active,
html .ui-bar-d .ui-btn.ui-btn-active,
html .ui-body-d .ui-btn.ui-btn-active,
html body .ui-group-theme-d .ui-btn.ui-btn-active,
html head + body .ui-btn.ui-btn-d.ui-btn-active,
/* Active checkbox icon */
.ui-page-theme-d .ui-checkbox-on:after,
html .ui-bar-d .ui-checkbox-on:after,
html .ui-body-d .ui-checkbox-on:after,
html body .ui-group-theme-d .ui-checkbox-on:after,
.ui-btn.ui-checkbox-on.ui-btn-d:after,
/* Active flipswitch background */
.ui-page-theme-d .ui-flipswitch-active,
html .ui-bar-d .ui-flipswitch-active,
html .ui-body-d .ui-flipswitch-active,
html body .ui-group-theme-d .ui-flipswitch-active,
html body .ui-flipswitch.ui-bar-d.ui-flipswitch-active,
/* Active slider track */
.ui-page-theme-d .ui-slider-track .ui-btn-active,
html .ui-bar-d .ui-slider-track .ui-btn-active,
html .ui-body-d .ui-slider-track .ui-btn-active,
html body .ui-group-theme-d .ui-slider-track .ui-btn-active,
html body div.ui-slider-track.ui-body-d .ui-btn-active {
	background-color: #3388cc /*{d-active-background-color}*/;
	border-color: #3388cc /*{d-active-border}*/;
	color: #ffffff /*{d-active-color}*/;
	text-shadow: 0 /*{d-active-shadow-x}*/ 1px /*{d-active-shadow-y}*/ 0 /*{d-active-shadow-radius}*/ #005599 /*{d-active-shadow-color}*/;
}
/* Active radio button icon */
.ui-page-theme-d .ui-radio-on:after,
html .ui-bar-d .ui-radio-on:after,
html .ui-body-d .ui-radio-on:after,
html body .ui-group-theme-d .ui-radio-on:after,
.ui-btn.ui-radio-on.ui-btn-d:after {
	border-color: #3388cc /*{d-active-background-color}*/;
}
/* Focus */
.ui-page-theme-d .ui-btn:focus,
html .ui-bar-d .ui-btn:focus,
html .ui-body-d .ui-btn:focus,
html body .ui-group-theme-d .ui-btn:focus,
html head + body .ui-btn.ui-btn-d:focus,
/* Focus buttons and text inputs with div wrap */
.ui-page-theme-d .ui-focus,
html .ui-bar-d .ui-focus,
html .ui-body-d .ui-focus,
html body .ui-group-theme-d .ui-focus,
html head + body .ui-btn-d.ui-focus,
html head + body .ui-body-d.ui-focus {
	-webkit-box-shadow: 0 0 12px #3388cc /*{d-active-background-color}*/;
	-moz-box-shadow: 0 0 12px #3388cc /*{d-active-background-color}*/;
	box-shadow: 0 0 12px #3388cc /*{d-active-background-color}*/;
}


/* Structure */
/* Disabled
-----------------------------------------------------------------------------------------------------------*/
/* Class ui-disabled deprecated in 1.4. :disabled not supported by IE8 so we use [disabled] */
.ui-disabled,
.ui-state-disabled,
button[disabled],
.ui-select .ui-btn.ui-state-disabled {
	filter: Alpha(Opacity=30);
	opacity: .3;
	cursor: default !important;
	pointer-events: none;
}
/* Focus state outline
-----------------------------------------------------------------------------------------------------------*/
.ui-btn:focus,
.ui-btn.ui-focus {
	outline: 0;
}
/* Unset box-shadow in browsers that don't do it right */
.ui-noboxshadow .ui-shadow,
.ui-noboxshadow .ui-shadow-inset,
.ui-noboxshadow .ui-overlay-shadow,
.ui-noboxshadow .ui-shadow-icon.ui-btn:after,
.ui-noboxshadow .ui-shadow-icon .ui-btn:after,
.ui-noboxshadow .ui-focus,
.ui-noboxshadow .ui-btn:focus,
.ui-noboxshadow  input:focus,
.ui-noboxshadow .ui-panel {
	-webkit-box-shadow: none !important;
	-moz-box-shadow: none !important;
	box-shadow: none !important;
}
.ui-noboxshadow .ui-btn:focus,
.ui-noboxshadow .ui-focus {
	outline-width: 1px;
	outline-style: auto;
}
			
			
@media (min-width : 900px) {
.ui-page-theme-a .ui-btn:hover,
html .ui-bar-a .ui-btn:hover,
html .ui-body-a .ui-btn:hover,
html body .ui-group-theme-a .ui-btn:hover,
html head + body .ui-btn.ui-btn-a:hover {
	background-color:	<?php  echo $this->Config['primary_color'] ?> !important; /*{a-bhover-background-color}*/;
	border: 1px solid #ffffff /*{a-bhover-border}*/;
	color: #fff/*{a-bhover-color}*/;
	text-shadow: 0 2px 0 #000000 ;
}
}



</style>

<style>
@media (min-width : 900px) {
#start-spacer {
    height:30px;
}
/*#main_body{
 left: 7px;
    margin: 0 auto;
    position: relative;
    width: 800px;	
}
.main_header_container{
	max-width:800px !important;
	width:800px !important;
	left:50%;
	margin-left:-400px;
	
}*/

}
.ui-page{
	min-height:100% !important;	
}

.product-panel,.ui-header{

	 /*   transition-property: all;
    transition-duration: .3s;
    -webkit-transform: translateZ(0);*/
}
.panelpage{
	background-color:white;
	min-height:100% !important;
}
input:before,input:after,label:before,label:after{
	  -webkit-box-sizing: initial !important;
  -moz-box-sizing: initial !important;
  box-sizing: initial !important;
}
.footer_words{
	    font-size: 22px !important;
    font-weight: bold;
    margin: 0px !important;
    padding: 10px 0 !important;	
}
#close_x{
	font-size:16px;
	color:white;
	height:36px;
	width:36px;
	line-height:36px;
	position:fixed;
	text-align:center;
	right:10px;
	cursor:pointer;
	top:10px;	
	z-index:999999;
}
.footerBack{
	    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background-color: white;
    opacity: 1;
    z-index: -1;
	border:none !important;
}	
#thank_you_cart_container{
	margin-top:15px !important;	
}

.checkbox,.cartbox{
	padding:0px;
	
	
}
.cartbox{
	padding-right:5px;
}
.checkbox{
	padding-left:5px;
}
.cart_words{
	border-top: 1px solid <?php  echo $this->Config['primary_color'] ?> !important;
    border-right: 1px solid <?php  echo $this->Config['primary_color'] ?> !important;

}
.footer_words{
    border-top: 1px solid <?php  echo $this->Config['primary_color'] ?> !important;
   /* border-left: 1px solid <?php // echo $this->Config['primary_color'] ?> !important;*/


}
.main_footer,.main_cart_button,#menu-footer{
    opacity: 1 !important;
    background-color: transparent !important;
    color: black !important;
    font-weight: bold !important;
    cursor: pointer !important;
    border: none !important;
    text-shadow: 0 2px 0 white;
    font-size: 22px !important;
}
#popupCart{
	text-shadow:none;
	padding-top:30px;
	padding-bottom:30px;
	padding-left:15px;
	padding-right:15px;
	border-color:<?php  echo $this->Config['primary_color'] ?> !important;	
}
.onei{
	margin-left:5px;
		
}



.twoi{
	margin-right:5px;
		
}
.colprim{
	color:	<?php  echo $this->Config['primary_color'] ?> ;
	text-shadow: 0 2px 0 white !important;
	margin-top:-3px;
}
.intext{
	color:black;
}
.footer_words.intext{
	border-left:1px solid <?php  echo $this->Config['primary_color'] ?> !important;	
}
.cart_words{
    font-size: 22px !important;
    font-weight: bold;
    margin: 0px !important;
    padding: 10px 0 !important;	
}
.main_cart_button,.main_cart_button a{
	height:100%; 
	width:100%;	
}
.ispacer_product{
	height:30px !important;	
	
}
.ipanel{
	border:1px solid 	<?php  echo $this->Config['primary_color'] ?> !important;
}
.imain_footer,.icheckoutfooter{
    text-align: center;
    font-size: 25px;
    background-color: <?php  echo $this->Config['primary_color'] ?> !important;
    color: white;
    font-weight: bold;
    text-shadow: 0 2px 0 black;
    margin-top: 5px;
	cursor:pointer;
	padding:5px;
	width:100%;
	position:relative;
}
.imain_footer i{
	right:5px;
	position:absolute;	
	top:5px;
}
.close_button {
    -moz-box-shadow: 0 0 15px -4px #000;
    -webkit-box-shadow: 0 0 15px -4px #000;
    box-shadow: 0 0 15px -4px #000;
    background-color: #000;
    text-indent: 0;
    border: 2px solid #000;
    display: inline-block;
    color: #fff;
    font-size: 20px;
    font-weight: 700;
    font-style: normal;
    height: 36px;
    line-height: 36px;
    width: 36px;
    position: absolute;

    text-decoration: none;
    text-align: center;
    left: 100%;
    cursor: pointer;
    margin-top: 5px
}

.header_img{
	height:100%;width:100%	;
}
.close_button:hover {
    background-color: #000
}
.back-page:hover{
	background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff;
	border:1px solid transparent;
}
#cart-button {
    font-size: 25px
}

#google_restaurant_iframe {
    width: 100%;
    height: 100%;
    border: 0
}
.second_header_container{
	background-color: white;
	 
}
.main_header_container {

    line-height: 52px;
    width: 100%;
   
    min-height: 52px;
	z-index:4;
    position: fixed;
    font-weight: 700;
    font-size: 22px;
    margin-top: 0;
    top: 0;
    background-color: transparent;
    text-align: center;
   border-bottom:1px solid <?php echo $this->Config['primary_color'] ?>;
  /*  transition-property: all;
    transition-duration: 0s!important;
    -webkit-transform: translateZ(0)*/
}
#mypanel{
		
}
#main_body {
    background-color: transparent;
	overflow-y: auto ;

}
.ui-input-text,.ui-btn{
	border-radius:0px !important;	
}
.ui-input-search input[type="text"] { 
text-shadow:none !important;
height:100px !important;
}
.style-footer {
    width: 100%;
   
    height: 52px;
    padding: 10px;
    z-index: 5;
    position: fixed;
    font-weight: 700;
    font-size: 22px;
    cursor: pointer;
    background-color: #fff;
    text-align: center;
    border-top: 1px solid <?php echo $this->Config['primary_color'] ?>;
/*    transition-property: all;
    transition-duration: .3s!important;
    -webkit-transform: translateZ(0);*/
    margin-bottom: 0;
    bottom: 0;
    display: none
}

.style-footer:hover {
    background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff
}

#set_height {
    height: 100.1%;
    width: 0;
    background-color: transparent;
    position: absolute;
    left: 0;
    top: 0
}

#outer_main {
    background-color: transparent;
    width: 100%;
    position: relative;
    height: 100%
}

.multimenu {
    margin-top: 20px;
    margin-bottom: 20px
}

.checkout-cog {
    position: absolute;
    left: 15px;
    bottom: 10px;
    z-index: 5
}

#inner_main {
    background-color: #fff;
    width: 100%;
    
    margin: 0 auto;
    position: relative;
    height: 100%;
    left: 8px;
    min-height: 800px
}

.spacer {
    height: 70px;
    background-color: #fff
}

.google_address_text {
    height: 40px
}

.in-panel {
    top: 0!important;
    display: block!important;
/*position:absolute !important;*/
/*    transition-property: all;
    transition-duration: .5s!important;
    -webkit-transform: translateZ(0);*/
    background-color: #fff;
    margin: 0 auto;
/*margin-top:20px;*/
    width: 100%;
}

.close_modal_mobile {
    cursor: pointer;
    line-height: 36px;
    text-align: center;
    height: 36px;
	color:black !important;
	text-shadow:none !important;
	font-weight:bold;
    border-bottom: 1px solid <?php echo $this->Config['primary_color'] ?>;
	margin-bottom:20px;
	font-size:20px;
}

#close_header {
    background-color: #fff;
    display: none;
    font-size: 20px;
    height: 52px;
    left: 100%;
    line-height: 52px;
    position: absolute;
    text-align: center;
    top: 0;
    width: 52px;
    -webkit-box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75);
    -moz-box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75);
    box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75)
}

.input-group-addon {
    cursor: pointer
}

a:focus {
    outline: none
}


.ui-page-theme-a .ui-radio-on::after, html .ui-bar-a .ui-radio-on::after, html .ui-body-a .ui-radio-on::after, html body .ui-group-theme-a .ui-radio-on::after, .ui-btn.ui-radio-on.ui-btn-a::after {
    border-color: <?php echo $this->Config['primary_color'] ?> !important;
}
.ui-page-theme-a .ui-btn.ui-btn-active, html .ui-bar-a .ui-btn.ui-btn-active, html .ui-body-a .ui-btn.ui-btn-active, html body .ui-group-theme-a .ui-btn.ui-btn-active, html head + body .ui-btn.ui-btn-a.ui-btn-active, .ui-page-theme-a .ui-checkbox-on::after, html .ui-bar-a .ui-checkbox-on::after, html .ui-body-a .ui-checkbox-on::after, html body .ui-group-theme-a .ui-checkbox-on::after, .ui-btn.ui-checkbox-on.ui-btn-a::after, .ui-page-theme-a .ui-flipswitch-active, html .ui-bar-a .ui-flipswitch-active, html .ui-body-a .ui-flipswitch-active, html body .ui-group-theme-a .ui-flipswitch-active, html body .ui-flipswitch.ui-bar-a.ui-flipswitch-active, .ui-page-theme-a .ui-slider-track .ui-btn-active, html .ui-bar-a .ui-slider-track .ui-btn-active, html .ui-body-a .ui-slider-track .ui-btn-active, html body .ui-group-theme-a .ui-slider-track .ui-btn-active, html body div.ui-slider-track.ui-body-a .ui-btn-active {
    background-color: <?php echo $this->Config['primary_color'] ?> !important;
    border-color: <?php echo $this->Config['primary_color'] ?> !important;
    color: #fff;
    text-shadow: 0 1px 0 <?php echo $this->Config['primary_color'] ?> !important;
}
.ui-radio,.ui-checkbox{
	/*margin-left:5px !important;
	margin-right:5px !important;	*/
}
.product-panel-heading {
    border-radius: 0px !important;
	background-color: <?php echo $this->Config['primary_color'] ?> !important;
	color:white !important;
	font-weight:bold;
}

.error_msg_style {
    cursor: pointer;
    transition-property: all;
    transition-duration: .3s;

    width: inherit !important;
	max-width:800px;
    min-height: 52px;
    line-height: 52px;
    background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff;
    display: none;
	position:fixed;
	text-shadow: 0 1px 0 black;
}
.controlgroup-textinput{
    padding-top:.22em;
    padding-bottom:.22em;
}
/*.main_cart_button{
    position: absolute;
    left: 20px;
    font-size: 25px !important;
    padding: 3px;
    margin-top: 5px;
    width: 36px;
    height: 36px;
	cursor:pointer;
    border-radius: 4px !important;
}*/
.ui-input-search input{
		text-shadow:none !important;
}
#payment-select-menu,.ui-selectmenu-list{
	border-radius:0px !important;	
}
.hide_footer{
	display:none !important;	
}
#payment-select{
	color:black !important;	
}
#menu_header_icon:hover,#main_cart_button:hover {
    color: <?php echo $this->Config['primary_color'] ?>!important;
  /*  transition-property: all;
    transition-duration: .3s;
    -webkit-transform: translateZ(0)*/
}

#cart-dropdown-mobile {
    color: #000!important;
    width: 300px;
	line-height:25px;
}

.btn-max-width:hover {
/*    transition-property: all;
    transition-duration: .3s!important;
    -webkit-transform: translateZ(0);*/
    background-color: <?php echo $this->Config['primary_color'] ?>!important;
    color: #fff!important;
    border-color: <?php echo $this->Config['primary_color'] ?>!important
}

.form-control:focus {
    border-color: <?php echo $this->Config['primary_color'] ?>!important;
    box-shadow: 0 0 0 <?php echo $this->Config['primary_color'] ?> inset,0 0 8px <?php echo $this->Config['primary_color'] ?>!important
}

.product-row:hover {
/*box-shadow:0 1px 0px color inset !important;
			transition-property: all; transition-duration: .1s !important;
	-webkit-transform: translateZ(0);*/
    cursor: pointer
}
.header_a{
	    text-shadow: none;

	font-weight:bold;padding:5px !important;
	border:1px solid <?php echo $this->Config['primary_color'] ?>!important;
	color:black !important;
	margin-bottom:10px !important; 
}
.header_new_a{
	color:black !important;
	text-decoration:none !important;
	text-shadow: none;	
	font-weight:500 !important;
	font-size: 1em !important;
}

	
.header_fieldset{
    text-shadow: none;

	font-weight:bold;padding:5px !important;
	
	color:black;
	margin-bottom:5px !important; 	
}
.form-control {
    border-radius: 0!important
}

.top-menu-select a {
    color: #333 !important;
    font-size: 20px;
    font-weight: 700;
	border-radius:0px !important;
}

.top-menu-select a:hover {
    background-color: <?php echo $this->Config['primary_color'] ?>!important;
    color: #fff!important;
}

.top-menu-select.active a:hover {
    background-color: #fff!important;
    color: <?php echo $this->Config['primary_color'] ?>!important;
}
.search-dropdown:hover{
	   
    border-color: #dddddd;
	text-shadow:none !important;
    color: <?php echo $this->Config['primary_color'] ?>!important;
}
.show_page {
    display: block!important
}

.product_option {
    margin: 5px
}
.circlegl{
 background-color: white;
    border-radius: 50%;
    height: 30px;
    padding: 1px;
    position: absolute;
    right: 10px;
    width: 30px;
}
.circlegl1{
 background-color: #ddd;
    border-radius: 50%;
    height: 30px;
    padding: 1px;
    position: absolute;
    right: 10px;

    width: 30px;
}
.menu-left{
	height:30px;
	width:30px;
	line-height:30px;
	position: absolute;
    right: 10px;
	text-align: center;
}
.glyphicon-chevron-down{
	color:	 <?php echo $this->Config['primary_color'] ?>!important;
	text-shadow:none !important;

}
.glyphicon-chevron-left{
	color:	white !important;
	text-shadow:none !important;
	
}
.product_option_checkout {
    background-color: #f5f5f5
}
.search-item-display{
	
}
.search-item a:hover{
	  color:white !important;
	  text-shadow:0 2px 0 black !important;
	  
}

#start-spacer{
	height:52px;
}

.form-control{
	text-shadow:none !important;	
}
.start-page-row {
    margin-top: 16px;
	margin-bottom: 16px;
	padding:0px;
}

.btn-max-width {
    width: 100%;
	font-size:22px;
	font-weight:bold;
}

hr {
    margin: 0;
    padding: 0
}

.no-pad {
    padding: 0
}
.no-marg {
    margin: 0
}
.text-bold {
    font-weight: 700
}
.hr-menu{
	border-color:	<?php echo $this->Config['primary_color'] ?>;
}

.menu-header {
    font-size: 20px;
    padding: 15px 0;
    cursor: pointer;
    background-color: #fff;
    color: black;
	margin-bottom:1px;
    text-shadow: 0 /*{a-bdown-shadow-x}*/ 1px /*{a-bdown-shadow-y}*/ 0 /*{a-bdown-shadow-radius}*/ #fff /*{a-bdown-shadow-color}*/;
    border-bottom: 2px solid <?php echo $this->Config['primary_color'] ?>;
}
.product-panel-heading{
	text-shadow: 0 /*{a-bdown-shadow-x}*/ 1px /*{a-bdown-shadow-y}*/ 0 /*{a-bdown-shadow-radius}*/ black /*{a-bdown-shadow-color}*/;
}
.checkoutlegend{
	    width: 300px;
    background-color: white;
    padding: 3px;
 	display:none;
    color: <?php echo $this->Config['primary_color'] ?>;
    font-size: 20px;
    font-weight: 300;
    margin-left: 15px;
    border: 1px solid <?php echo $this->Config['primary_color'] ?>;
	border-bottom:0px transparent;
	border-right:0px transparent;
}


.panel-back-btn{
	
    padding-top: 2px !important;

    margin: 0px ;
    font-size: 30px !important;
    padding-top: 0px;
    padding-bottom: 0px;
    line-height: 60px;
    background-color: transparent !important;
    color: <?php echo $this->Config['primary_color'] ?> !important;
/*    -webkit-box-shadow: 0px 0px 6px 1px <?php //echo $this->Config['primary_color'] ?> !important;
    -moz-box-shadow: 0px 0px 6px 1px <?php //echo $this->Config['primary_color'] ?> !important;
    box-shadow: 0px 0px 6px 1px <?php // echo $this->Config['primary_color'] ?> !important;*/
	border-radius:50% !important;
	height:60px !important;
	width:60px !important;
	
    text-align: center !important;
    padding-right: 0px;
    padding-left: 0px;
	top:15px !important;
	left:15px ;
	    border: 1px solid <?php  echo $this->Config['primary_color'] ?> !important;

}
.menu-active {
    background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff;
	text-shadow: 0 /*{a-bdown-shadow-x}*/ 1px /*{a-bdown-shadow-y}*/ 0 /*{a-bdown-shadow-radius}*/ black /*{a-bdown-shadow-color}*/;
}
.ui-loader{
	opacity:1 !important;	
	border:none !important;
	background-color: transparent !important;
}
.ui-icon-loading {
            background:none !important;
			background-color:transparent;
        }
.product-row {
    margin-top: 20px;
    line-height: 25px;
    color: black;
}

#product-panel div {
    background-color: #fff
}

.google_address_button {
	background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff;
    border: 2px solid <?php echo $this->Config['primary_color'] ?>;
    border-radius: 0;
	font-weight:bold;
}

.google_address_button:hover {
    background-color: #fff;
    color: <?php echo $this->Config['primary_color'] ?>;;
    border: 2px solid <?php echo $this->Config['primary_color'] ?>;
	font-weight:bold;
}

.product-panel-drop:hover {
    background-color: <?php echo $this->Config['primary_color'] ?>;
    color: #fff;
/*    transition-property: all;
    transition-duration: .3s;
    -webkit-transform: translateZ(0)*/
}

.active {
    background-color: <?php echo $this->Config['primary_color'] ?>!important;
    color: #fff!important;

}

.product-panel-drop {
    cursor: pointer;
/*margin-left:-15px;
	margin-right:-15px;*/
	margin-top:0px;
	height:52px;
	line-height:52px;
    padding-left: 30px
/*border-bottom:1px solid #ef6f00;*/
}

.glyphicon {
    cursor: pointer
}

/*.backdrop{
display:none;background-color:black;opacity:.3;position:absolute;width:100%;height:100%;z-index:494;bottom:0px;left:0px	
}*/
.btn {
    border-radius: 0
}

.change-bar span {
  
}

.price-bar {
    margin-top: -20px;

}

.checkout-heading {
    padding-bottom: 0;
    background-color: #fff!important;
    border-bottom: 0
}

.checkout-footer {
    padding-top: 0;
    background-color: #fff!important;
    border-top: 0
}

.checkout-footer span {
    padding-left: 0;
    padding-right: 0
}


.google-map-container {
    height: 200px;
	position:relative;text-align:center;
	margin: -16px;
}

.header-info,.header-info a,.header-info a:hover {
    color: #666;
    font-weight: 700;
    text-decoration: none
}
.panel-back-btn:hover{
	color:white !important;	
}
#main_del_form{
	
}
#cart_count{
    position: absolute;
    font-size: 14px;
    margin-left: 9px;
    margin-top: 2px;
    z-index: 9999;
    color: white;
    text-shadow: none;	
}
.header-legend {
    margin-top: 20px;
	margin-bottom: 10px;
    color: white;
	background-color: <?php echo $this->Config['primary_color'] ?>;
	text-shadow:0 1px 0 black;
    font-weight: bold;
	padding:3px;
	width: 272px;
	margin-left:-16px;
	font-size:20px;
	text-align:center;
}

.glyphicon-repeat {
    font-size: 16px
}

.delete-product {
    transition-property: all;
    transition-duration: .5s;
    -webkit-transform: translateZ(0);
    opacity: 0;
    margin-top: -152px
}

.tip-label {
     font-size: 25px;
    font-weight: 700;
    background-color: #f5f5f5;
    color: black;
    text-align: center;
    width: 900px;
    height: 60px;
	padding: 4px;
}

#menu_header_icon {
    height: 52px;
    line-height: 52px
}

.tip-btn {
    margin: 3px;
    width: 75px
}

.tip-dropdown-btn {
    width: 75px
}

.info_container {
    margin-bottom: 50px
}

.dropdown-menu li {
    cursor: pointer
}

.undo-delete {
    transition-property: all;
    transition-duration: .5s!important;
    -webkit-transform: translateZ(0);
    opacity: 0!important
}

.undo-delete-animate {
    transition-property: all;
    transition-duration: .5s!important;
    -webkit-transform: translateZ(0);
    opacity: 1!important
}
.main-menu-inner-show{

}
.main-menu-inner {

}
.ui-page{
	/*overflow-y:scroll !important;*/	
}
.main-menu {
    height: 100%;
    -webkit-box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75);
    -moz-box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75);
    box-shadow: 5px 1px 7px -1px rgba(0,0,0,0.75);
    position: fixed;
    top: 0;
    transition-property: all;
/*    transition-duration: .5s!important;
    -webkit-transform: translateZ(0);
    background-color: #fff;*/

    width: 0;
    height: 100%
}

.main-menu-show {
    width: 30%!important;
/*    transition-property: all;
    transition-duration: .5s!important;
    -webkit-transform: translateZ(0)!important;*/
	
}

@media (max-width : 900px) {
#inner_main {
    left: 0!important
}
}

start_div
@media (max-width : 768px) {
.main_header_container {
    margin-top: 0
}

.style-footer {
    margin-bottom: 0
}

.main-menu-show {
    width: 75%!important
}

.main-menu {
    margin-top: 0;
    margin-bottom: 0
}

.in-panel {
    top: 0!important
}
}

#pickup_name,#pickup_number{
	text-shadow:none;
}

</style>


        <style>
		@charset "utf-8";
/* CSS Document */

/*
Copyright (c) 2010, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.com/yui/license.html
version: 3.3.0
build: 3167
*/

#spinners{
position: absolute;
top: 50%;
left: 50%;
}
#spinners li{
	position:absolute;
	float:left;
	width:100px;
	height:50px;
	top:0px;
	left:0px;
	opacity:0;
	-webkit-transition:all .3s ease-in-out;
	-webkit-transform:translateX(-100px);

	-moz-transition:all .3s ease-in-out;
	-moz-transform:translateX(-100px);

	-ms-transition:all .3s ease-in-out;
	-ms-transform:translateX(-100px);

	transition:all .3s ease-in-out;
	transform:translateX(-100px);
}
.next,.prev{
	width:50px;
	font-size: 53px;
position: absolute;
top: 50%;
right: 20px;
text-decoration: none;
color: #7f8c8d;
margin-top: -30px;
-webkit-transition:all .3s ease-in-out;
-moz-transition:all .3s ease-in-out;
-ms-transition:all .3s ease-in-out;
transition:all .3s ease-in-out;
}
.prev{
	left: 20px;
}
.next:hover,.prev:hover{
	color:#3498db;
}
#pagination{
	width: 140px;
position: fixed;
bottom: 20px;
left: 50%;
margin-left: -54px;
}
#pagination li a{
	width:18px;
	height:18px;
	background:#7F8C8D;
	float:left;
	margin-right:5px;
	border-radius:20px;
	display:block;
}
#pagination li a.pag_active{
background:#3498DB;
}
.clear{
	clear:both;
	display:block;
}
#spinners li.active{
-webkit-transform:translateX(0);
-moz-transform:translateX(0);
-ms-transform:translateX(0);
transform:translateX(0);
opacity:1;
}
#spinners li:nth-child(2){
margin-top: -17px;
margin-left: -43px;
}
#spinners li:nth-child(3){
margin-top: -14px;
margin-left: 6px;
}
#spinners li:nth-child(3){
margin-top:-10px;
}
#spinners li:nth-child(4){
margin-left: -22px;
margin-top: -8px;
}
#spinners li:nth-child(5){
margin-left: 19px;
margin-top: -10px;
}
#spinners li:nth-child(6){
margin-top: -21px
}
/******************* PRELOADER 1 **********
*******************************************/
#preloader_1{
	position:relative;
}
#preloader_1 span{
	display:block;
	bottom:0px;
	width: 9px;
	height: 5px;
	background:<?php echo $this->Config['primary_color'] ?>;
	position:absolute;
-webkit-animation: preloader_1 1.5s	 infinite ease-in-out;
-moz-animation: preloader_1 1.5s	 infinite ease-in-out;
-ms-animation: preloader_1 1.5s	 infinite ease-in-out;
-o-animation: preloader_1 1.5s	 infinite ease-in-out;
animation: preloader_1 1.5s	 infinite ease-in-out;

}
#preloader_1 span:nth-child(2){
left:11px;
-webkit-animation-delay: .2s;
-moz-animation-delay: .2s;
-ms-animation-delay: .2s;
-o-animation-delay: .2s;
animation-delay: .2s;

}
#preloader_1 span:nth-child(3){
left:22px;
-webkit-animation-delay: .4s;
-moz-animation-delay: .4s;
-ms-animation-delay: .4s;
-o-animation-delay: .4s;
animation-delay: .4s;
}
#preloader_1 span:nth-child(4){
left:33px;
-webkit-animation-delay: .6s;
-moz-animation-delay: .6s;
-ms-animation-delay: .6s;
-o-animation-delay: .6s;
animation-delay: .6s;
}
#preloader_1 span:nth-child(5){
left:44px;
-webkit-animation-delay: .8s;
-moz-animation-delay: .8s;
-ms-animation-delay: .8s;
-o-animation-delay: .8s;
animation-delay: .8s;
}
@-webkit-keyframes preloader_1 {
    0% {height:5px;-webkit-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    25% {height:30px;-webkit-transform:translateY(15px);background:#fff;}
    50% {height:5px;-webkit-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    100% {height:5px;-webkit-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
}

@-moz-keyframes preloader_1 {
    0% {height:5px;-moz-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    25% {height:30px;-moz-transform:translateY(15px);background:#fff;}
    50% {height:5px;-moz-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    100% {height:5px;-moz-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
}

@-ms-keyframes preloader_1 {
    0% {height:5px;-ms-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    25% {height:30px;-ms-transform:translateY(15px);background:#fff;}
    50% {height:5px;-ms-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    100% {height:5px;-ms-transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
}

@keyframes preloader_1 {
    0% {height:5px;transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    25% {height:30px;transform:translateY(15px);background:#fff;}
    50% {height:5px;transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
    100% {height:5px;transform:translateY(0px);background:<?php echo $this->Config['primary_color'] ?>;}
}




/******************* PRELOADER 2 **********
*******************************************/



#preloader_2{
position: relative;
left: 50%;
width: 40px;
height: 40px;
}
#preloader_2 span{
	display:block;
	bottom:0px;
	width: 20px;
	height: 20px;
	background:<?php echo $this->Config['primary_color'] ?>;
	position:absolute;
}
#preloader_2 span:nth-child(1){
-webkit-animation: preloader_2_1 1.5s infinite ease-in-out;
-moz-animation: preloader_2_1 1.5s infinite ease-in-out;
-ms-animation: preloader_2_1 1.5s infinite ease-in-out;
animation: preloader_2_1 1.5s infinite ease-in-out;
}
#preloader_2 span:nth-child(2){
left:20px;
-webkit-animation: preloader_2_2 1.5s infinite ease-in-out;
-moz-animation: preloader_2_2 1.5s infinite ease-in-out;
-ms-animation: preloader_2_2 1.5s infinite ease-in-out;
animation: preloader_2_2 1.5s infinite ease-in-out;

}
#preloader_2 span:nth-child(3){
top:0px;
-webkit-animation: preloader_2_3 1.5s infinite ease-in-out;
-moz-animation: preloader_2_3 1.5s infinite ease-in-out;
-ms-animation: preloader_2_3 1.5s infinite ease-in-out;
animation: preloader_2_3 1.5s infinite ease-in-out;
}
#preloader_2 span:nth-child(4){
top:0px;
left:20px;
-webkit-animation: preloader_2_4 1.5s infinite ease-in-out;
-moz-animation: preloader_2_4 1.5s infinite ease-in-out;
-ms-animation: preloader_2_4 1.5s infinite ease-in-out;
animation: preloader_2_4 1.5s infinite ease-in-out;
}

@-webkit-keyframes preloader_2_1 {
    0% {-webkit-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-webkit-transform: translateX(-20px) translateY(-10px) rotate(-180deg); border-radius:20px;background:#3498db;}
    80% {-webkit-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
     100% {-webkit-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-webkit-keyframes preloader_2_2 {
    0% {-webkit-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-webkit-transform: translateX(20px) translateY(-10px) rotate(180deg);border-radius:20px;background:#f1c40f;}
    80% {-webkit-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
    100% {-webkit-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-webkit-keyframes preloader_2_3 {
    0% {-webkit-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-webkit-transform: translateX(-20px) translateY(10px) rotate(-180deg); border-radius:20px;background:#2ecc71;}
    80% {-webkit-transform: translateX(0px) translateY(0px) rotate(-360deg);border-radius:0px;}
     100% {-webkit-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}


@-webkit-keyframes preloader_2_4 {
    0% {-webkit-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-webkit-transform: translateX(20px) translateY(10px) rotate(180deg); border-radius:20px;background:#e74c3c;}
    80% {-webkit-transform: translateX(0px) translateY(0px) rotate(360deg); border-radius:0px;}
     100% {-webkit-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-moz-keyframes preloader_2_1 {
    0% {-moz-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-moz-transform: translateX(-20px) translateY(-10px) rotate(-180deg); border-radius:20px;background:#3498db;}
    80% {-moz-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
     100% {-moz-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-moz-keyframes preloader_2_2 {
    0% {-moz-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-moz-transform: translateX(20px) translateY(-10px) rotate(180deg);border-radius:20px;background:#f1c40f;}
    80% {-moz-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
    100% {-moz-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-moz-keyframes preloader_2_3 {
    0% {-moz-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-moz-transform: translateX(-20px) translateY(10px) rotate(-180deg); border-radius:20px;background:#2ecc71;}
    80% {-moz-transform: translateX(0px) translateY(0px) rotate(-360deg);border-radius:0px;}
     100% {-moz-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-moz-keyframes preloader_2_4 {
    0% {-moz-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-moz-transform: translateX(20px) translateY(10px) rotate(180deg); border-radius:20px;background:#e74c3c;}
    80% {-moz-transform: translateX(0px) translateY(0px) rotate(360deg); border-radius:0px;}
     100% {-moz-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-ms-keyframes preloader_2_1 {
    0% {-ms-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-ms-transform: translateX(-20px) translateY(-10px) rotate(-180deg); border-radius:20px;background:#3498db;}
    80% {-ms-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
     100% {-ms-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-ms-keyframes preloader_2_2 {
    0% {-ms-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-ms-transform: translateX(20px) translateY(-10px) rotate(180deg);border-radius:20px;background:#f1c40f;}
    80% {-ms-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
    100% {-ms-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-ms-keyframes preloader_2_3 {
    0% {-ms-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-ms-transform: translateX(-20px) translateY(10px) rotate(-180deg); border-radius:20px;background:#2ecc71;}
    80% {-ms-transform: translateX(0px) translateY(0px) rotate(-360deg);border-radius:0px;}
     100% {-ms-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-ms-keyframes preloader_2_4 {
    0% {-ms-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-ms-transform: translateX(20px) translateY(10px) rotate(180deg); border-radius:20px;background:#e74c3c;}
    80% {-ms-transform: translateX(0px) translateY(0px) rotate(360deg); border-radius:0px;}
     100% {-ms-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-keyframes preloader_2_1 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-transform: translateX(-20px) translateY(-10px) rotate(-180deg); border-radius:20px;background:#3498db;}
    80% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-keyframes preloader_2_2 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-transform: translateX(20px) translateY(-10px) rotate(180deg);border-radius:20px;background:#f1c40f;}
    80% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
    100% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-keyframes preloader_2_3 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-transform: translateX(-20px) translateY(10px) rotate(-180deg); border-radius:20px;background:#2ecc71;}
    80% {-transform: translateX(0px) translateY(0px) rotate(-360deg);border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}


@-keyframes preloader_2_4 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-transform: translateX(20px) translateY(10px) rotate(180deg); border-radius:20px;background:#e74c3c;}
    80% {-transform: translateX(0px) translateY(0px) rotate(360deg); border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}

/******************* PRELOADER 3 **********
*******************************************/


#preloader_3{
	position:relative;
}
#preloader_3:before{
	width:20px;
	height:20px;
	border-radius:20px;
	background:blue;
	content:'';
	position:absolute;
	background:#9b59b6;
	-webkit-animation: preloader_3_before 1.5s infinite ease-in-out;
	-moz-animation: preloader_3_before 1.5s infinite ease-in-out;
	-ms-animation: preloader_3_before 1.5s infinite ease-in-out;
	animation: preloader_3_before 1.5s infinite ease-in-out;
}

#preloader_3:after{
	width:20px;
	height:20px;
	border-radius:20px;
	background:blue;
	content:'';
	position:absolute;
	background:#2ecc71;
	left:22px;
	-webkit-animation: preloader_3_after 1.5s infinite ease-in-out;
	-moz-animation: preloader_3_after 1.5s infinite ease-in-out;
	-ms-animation: preloader_3_after 1.5s infinite ease-in-out;
	animation: preloader_3_after 1.5s infinite ease-in-out;
}

@-webkit-keyframes preloader_3_before {
    0% {-webkit-transform: translateX(0px) rotate(0deg)}
    50% {-webkit-transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
  	100% {-webkit-transform: translateX(0px) rotate(0deg)}
}
@-webkit-keyframes preloader_3_after {
    0% {-webkit-transform: translateX(0px)}
    50% {-webkit-transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
  	100% {-webkit-transform: translateX(0px)}
}

@-moz-keyframes preloader_3_before {
    0% {-moz-transform: translateX(0px) rotate(0deg)}
    50% {-moz-transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
  	100% {-moz-transform: translateX(0px) rotate(0deg)}
}
@-moz-keyframes preloader_3_after {
    0% {-moz-transform: translateX(0px)}
    50% {-moz-transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
  	100% {-moz-transform: translateX(0px)}
}


@-ms-keyframes preloader_3_before {
    0% {-ms-transform: translateX(0px) rotate(0deg)}
    50% {-ms-transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
  	100% {-ms-transform: translateX(0px) rotate(0deg)}
}
@-ms-keyframes preloader_3_after {
    0% {-ms-transform: translateX(0px)}
    50% {-ms-transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
  	100% {-ms-transform: translateX(0px)}
}

@keyframes preloader_3_before {
    0% {transform: translateX(0px) rotate(0deg)}
    50% {transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
  	100% {transform: translateX(0px) rotate(0deg)}
}
@keyframes preloader_3_after {
    0% {transform: translateX(0px)}
    50% {transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
  	100% {transform: translateX(0px)}
}

/******************* PRELOADER 4 **********
*******************************************/


#preloader_4{
	position:relative;
}
#preloader_4 span{
	position:absolute;
	width:20px;
	height:20px;
	background:#3498db;
	opacity:0.5;
border-radius:20px;
	-webkit-animation: preloader_4 1s infinite ease-in-out;
	-moz-animation: preloader_4 1s infinite ease-in-out;
	-ms-animation: preloader_4 1s infinite ease-in-out;
	-animation: preloader_4 1s infinite ease-in-out;

}
#preloader_4 span:nth-child(2){
	left:20px;
	-webkit-animation-delay: .2s;
	-moz-animation-delay: .2s;
	-ms-animation-delay: .2s;
	animation-delay: .2s;
}
#preloader_4 span:nth-child(3){
	left:40px;
	-webkit-animation-delay: .4s;
	-moz-animation-delay: .4s;
	-ms-animation-delay: .4s;
	animation-delay: .4s;
}
#preloader_4 span:nth-child(4){
	left:60px;
	-webkit-animation-delay: .6s;
	-moz-animation-delay: .6s;
	-ms-animation-delay: .6s;
	animation-delay: .6s;
}
#preloader_4 span:nth-child(5){
	left:80px;
	-webkit-animation-delay: .8s;
	-moz-animation-delay: .8s;
	-ms-animation-delay: .8s;
	animation-delay: .8s;
}

@-webkit-keyframes preloader_4 {
    0% {opacity: 0.3; -webkit-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
    50% {opacity: 1; -webkit-transform: translateY(-10px); background:#f1c40f;	box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
  	100%  {opacity: 0.3; -webkit-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
}
@-moz-keyframes preloader_4 {
    0% {opacity: 0.3; -moz-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
    50% {opacity: 1; -moz-transform: translateY(-10px); background:#f1c40f;	box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
  	100%  {opacity: 0.3; -moz-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
}
@-ms-keyframes preloader_4 {
    0% {opacity: 0.3; -ms-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
    50% {opacity: 1; -ms-transform: translateY(-10px); background:#f1c40f;	box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
  	100%  {opacity: 0.3; -ms-transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
}
@keyframes preloader_4 {
    0% {opacity: 0.3; transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
    50% {opacity: 1; transform: translateY(-10px); background:#f1c40f;	box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
  	100%  {opacity: 0.3; transform:translateY(0px);	box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
}


/******************* PRELOADER 5 **********
*******************************************/

#preloader5{
	position:relative;
	width:30px;
	height:30px;
	background:#3498db;
	border-radius:50px;
	-webkit-animation: preloader_5 1.5s infinite linear;
	-moz-animation: preloader_5 1.5s infinite linear;
	-ms-animation: preloader_5 1.5s infinite linear;
	animation: preloader_5 1.5s infinite linear;
}
#preloader5:after{
	position:absolute;
	width:50px;
	height:50px;
	border-top:10px solid #9b59b6;
	border-bottom:10px solid #9b59b6;
	border-left:10px solid transparent;
	border-right:10px solid transparent;
	border-radius:50px;
	content:'';
	top:-20px;
	left:-20px;
	-webkit-animation: preloader_5_after 1.5s infinite linear;
	-moz-animation: preloader_5_after 1.5s infinite linear;
	-ms-animation: preloader_5_after 1.5s infinite linear;
	animation: preloader_5_after 1.5s infinite linear;
}


@-webkit-keyframes preloader_5 {
    0% {-webkit-transform: rotate(0deg);}
    50% {-webkit-transform: rotate(180deg);background:#2ecc71;}
    100% {-webkit-transform: rotate(360deg);}
}
@-webkit-keyframes preloader_5_after {
    0% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
    50% {border-top:10px solid #3498db;border-bottom:10px solid #3498db;}
    100% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
}


@-moz-keyframes preloader_5 {
    0% {-moz-transform: rotate(0deg);}
    50% {-moz-transform: rotate(180deg);background:#2ecc71;}
    100% {-moz-transform: rotate(360deg);}
}
@-moz-keyframes preloader_5_after {
    0% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
    50% {border-top:10px solid #3498db;border-bottom:10px solid #3498db;}
    100% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
}

@-ms-keyframes preloader_5 {
    0% {-ms-transform: rotate(0deg);}
    50% {-ms-transform: rotate(180deg);background:#2ecc71;}
    100% {-ms-transform: rotate(360deg);}
}
@-ms-keyframes preloader_5_after {
    0% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
    50% {border-top:10px solid #3498db;border-bottom:10px solid #3498db;}
    100% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
}

@keyframes preloader_5 {
    0% {transform: rotate(0deg);}
    50% {transform: rotate(180deg);background:#2ecc71;}
    100% {transform: rotate(360deg);}
}
@keyframes preloader_5_after {
    0% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
    50% {border-top:10px solid #3498db;border-bottom:10px solid #3498db;}
    100% {border-top:10px solid #9b59b6;border-bottom:10px solid #9b59b6;}
}


/******************* PRELOADER 6 **********
*******************************************/
#preloader6{
	position:relative;
	width: 42px;
	height: 42px;
	-webkit-animation: preloader_6 5s infinite linear;
	-moz-animation: preloader_6 5s infinite linear;
	-ms-animation: preloader_6 5s infinite linear;
	animation: preloader_6 5s infinite linear;
}
#preloader6 span{
	width:20px;
	height:20px;
	position:absolute;
	background:red;
	display:block;
	-webkit-animation: preloader_6_span 1s infinite linear;
	-moz-animation: preloader_6_span 1s infinite linear;
	-ms-animation: preloader_6_span 1s infinite linear;
	animation: preloader_6_span 1s infinite linear;
}
#preloader6 span:nth-child(1){
background:#2ecc71;

}
#preloader6 span:nth-child(2){
left:22px;
background:#9b59b6;
	-webkit-animation-delay: .2s;
	-moz-animation-delay: .2s;
	-ms-animation-delay: .2s;
	animation-delay: .2s;

}
#preloader6 span:nth-child(3){
top:22px;
background:#3498db;
	-webkit-animation-delay: .4s;
	-moz-animation-delay: .4s;
	-ms-animation-delay: .4s;
	animation-delay: .4s;
}
#preloader6 span:nth-child(4){
top:22px;
left:22px;
background:#f1c40f;
	-webkit-animation-delay: .6s;
	-moz-animation-delay: .6s;
	-ms-animation-delay: .6s;
	animation-delay: .6s;
}

@-webkit-keyframes preloader_6 {
    from {-webkit-transform: rotate(0deg);}
    to {-webkit-transform: rotate(360deg);}
}
@-webkit-keyframes preloader_6_span {
   0% { -webkit-transform:scale(1); }
   50% { -webkit-transform:scale(0.5); }
   100% { -webkit-transform:scale(1); }
}


@-moz-keyframes preloader_6 {
    from {-moz-transform: rotate(0deg);}
    to {-moz-transform: rotate(360deg);}
}
@-moz-keyframes preloader_6_span {
   0% { -moz-transform:scale(1); }
   50% { -moz-transform:scale(0.5); }
   100% { -moz-transform:scale(1); }
}

@-ms-keyframes preloader_6 {
    from {-ms-transform: rotate(0deg);}
    to {-ms-transform: rotate(360deg);}
}
@-ms-keyframes preloader_6_span {
   0% { -ms-transform:scale(1); }
   50% { -ms-transform:scale(0.5); }
   100% { -ms-transform:scale(1); }
}

@-ms-keyframes preloader_6 {
    from {-ms-transform: rotate(0deg);}
    to {-ms-transform: rotate(360deg);}
}
@keyframes preloader_6_span {
   0% { transform:scale(1); }
   50% { transform:scale(0.5); }
   100% { transform:scale(1); }
}

		#preloader_2{
position: relative;
left: 50%;
width: 40px;
height: 40px;
}
#preloader_2 span{
    display:block;
    bottom:0px;
    width: 20px;
    height: 20px;
    background:#9b59b6;
    position:absolute;
}
#preloader_2 span:nth-child(1){
animation: preloader_2_1 1.5s infinite ease-in-out;
}
#preloader_2 span:nth-child(2){
left:20px;
animation: preloader_2_2 1.5s infinite ease-in-out;
 
}
#preloader_2 span:nth-child(3){
top:0px;
animation: preloader_2_3 1.5s infinite ease-in-out;
}
#preloader_2 span:nth-child(4){
top:0px;
left:20px;
animation: preloader_2_4 1.5s infinite ease-in-out;
}
 
@-keyframes preloader_2_1 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-transform: translateX(-20px) translateY(-10px) rotate(-180deg); border-radius:20px;background:#3498db;}
    80% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
@-keyframes preloader_2_2 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-transform: translateX(20px) translateY(-10px) rotate(180deg);border-radius:20px;background:#f1c40f;}
    80% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
    100% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}
@-keyframes preloader_2_3 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg);border-radius:0px;}
    50% {-transform: translateX(-20px) translateY(10px) rotate(-180deg); border-radius:20px;background:#2ecc71;}
    80% {-transform: translateX(0px) translateY(0px) rotate(-360deg);border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(-360deg); border-radius:0px;}
}
 
 
@-keyframes preloader_2_4 {
    0% {-transform: translateX(0px) translateY(0px)  rotate(0deg); border-radius:0px;}
    50% {-transform: translateX(20px) translateY(10px) rotate(180deg); border-radius:20px;background:#e74c3c;}
    80% {-transform: translateX(0px) translateY(0px) rotate(360deg); border-radius:0px;}
     100% {-transform: translateX(0px) translateY(0px) rotate(360deg);border-radius:0px;}
}



.tip-btn:hover,.tip-btn:active,.tip-btn:focus{
	background-color:	<?php  echo $this->Config['primary_color'] ?> !important;
	border: 1px solid #ffffff !important;
	color: #fff!important;
	text-shadow: 0 2px 0 #000000 !important;
}
#braintree-hosted-field-number,#braintree-hosted-field-expirationMonth,#braintree-hosted-field-expirationYear,#braintree-hosted-field-cvv{
	border:1px solid #dddddd /*{a-body-border}*/ !important;
	border-radius:0px;
	margin-bottom:20px;
}
#bt_credit,#bt_month,#bt_year,#bt_cvv{
	height:40px;	
}


.ui-header{
	border-top:none !important;	
	top: -3px;
}
.ui-footer-fixed{
bottom:0px !important;	
}
@media only screen and (max-width : 991px){
	.container-fluid{
		padding-left:0px;
		padding-right:0px;	
	}
}

@media only screen and (min-width : 992px){
	#scrollme{
	overflow-y:auto !important;
	
	height:1500px;
	position: relative;
	}
 #browser_min{
    height: 100%;
    margin: 0 auto;
    max-width: 800px !important;
    position: relative;
	background-color:white !important;
	overflow-y:hidden;
}
.panel-back-btn{
	    left: 50%;
    margin-left: -385px !important;

}

.main_header_container,.main_footer,#menu-footer{
	    left: 50%;
    margin-left: -400px !important;
    max-width: 800px;
}
body,html{
	background-color:transparent;	
}
	}
	.htb{
	width:208px;
	margin-bottom:20px;
	border:0px none !important;
}
.htb td{
	width:104px;
	padding:5px;
}
.opennowtxt{
	color:<?php echo $this->Config['primary_color'] ?>;	
}
.closednowtxt{
	color:red;	
}
.header_active{
	border-bottom:1px solid <?php echo $this->Config['primary_color'] ?>;	 !important;
}
.special_dumbass_table{
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    text-shadow: none;
    width: 100%;
	color:black;
		
}
.marg20top{
	margin-top:20px;	
}
.circlegl{
	margin-right:1px;	
}
.header_switch{
	cursor:pointer;	
}
		</style>
        
        
        
