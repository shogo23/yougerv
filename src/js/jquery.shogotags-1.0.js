/*
*	Copyright (c) 2018 jQuery Shogo Tags. Created by Victor Caviteno.
*	http://onegerv.cf
*	GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*	Version 1.01;
*/

(function($) {
	$.fn.shogotags = function(params) {

		/*
		*	Default Attributes.
		*/
		//Parent Element Border Color.
		var main_border_color = "#ccc";

		//Parent Element Background Color.
		var main_background_color = "#fff";

		//Tag Border Color.
		var tag_border_color = "#e61606";

		//Tag Background Color.
		var tag_background_color = "#e61606";

		//Tag Font Color.
		var tag_font_color = "#fff";

		//Tag Border Radius.
		var tag_border_radius = "0px";

		//Tag Hover Border Color.
		var tag_hover_border_color = "#3865f7";

		//Tag Hover Backgrouund Color.
		var tag_hover_background_color = "#3865f7";

		//Tag Hover Font Color
		var tag_hover_font_color = "yellow";


		//If params set by the user and params should be object.
		if (params && typeof params === "object") {
			
			//If Param main_border_color is set.
			if (params['main_border_color']) {
				main_border_color = params['main_border_color'];
			}

			//If main_background_color is set.
			if (params['main_background_color']) {
				main_background_color = params['main_background_color'];
			}

			//If tag_border_color is set.
			if (params['tag_border_color']) {
				tag_border_color = params['tag_border_color'];
			}

			//If tag_background_color is set.
			if (params['tag_background_color']) {
				tag_background_color = params['tag_background_color'];
			}

			//If tag_font_color is set.
			if (params['tag_font_color']) {
				tag_font_color = tag_font_color['tag_font_color'];
			}

			//If tag_border_radius is set.
			if (params['tag_border_radius']) {
				tag_border_radius = params['tag_border_radius'];
			}

			//If tag_hover_border_color is set.
			if (params['tag_hover_border_color']) {
				tag_hover_border_color = params['tag_hover_border_color'];
			}

			//If tag_hover_background_color is set.
			if (params['tag_hover_background_color']) {
				tag_hover_background_color = params['tag_hover_background_color'];
			}

			//If tag_hover_font_color is set.
			if (params['tag_hover_font_color']) {
				tag_hover_font_color = params['tag_hover_font_color'];
			}
		}

		//Hidden input variable.
		var hidden_input = document.createElement("input");

		//Parent span container of tags variable.
		var tags_container = document.createElement("span");

		//Input text variable.
		var main_input = document.createElement("input");

		//Main Tags Array.
		var tags = [];

		//Untag strings. Include untag strings as last tag.
		var untag = "";

		//Hidden Input Set Attributes.
		hidden_input.setAttribute("type", "hidden");
		hidden_input.setAttribute("name", "s_tags");
		hidden_input.setAttribute("id", "s_tags");

		//Hidden Input classList.
		hidden_input.classList.add("s_tags");

		//Add classList.
		tags_container.classList.add("shogo_tags");

		//Main Input Set Attribute.
		main_input.setAttribute("type", "text");

		//Main Input classList.
		main_input.classList.add("shogo_input_tags");

		//Append Created Elements.
		$(this).append(hidden_input);
		$(this).append(tags_container);
		$(this).append(main_input);

		//If Parent Element clicked, make focus to the Main Input Text.
		$(this).on("click", function() {
			$(".shogo_input_tags").focus();
		});

		//Parent Element CSS.
		$(this).css({
			"border": "1px solid " + main_border_color,
			"background-color": main_background_color,
			"padding": "5px",
			"cursor": "text",
			"font-family": "Arial, Helvetica, sans-serif"
		});

		/*
		*	Tags Css Variables.
		*/
		var shogo_tag = '.shogo_tags .shogo_tag { border: 1px solid ' + tag_border_color + '; background-color: ' + tag_background_color + '; color: ' + tag_font_color + '; font-size: 15px; padding: 5px 6px; margin: 2px 4px; text-align: center; display: inline-block; border-radius: ' + tag_border_radius + '; transition: border-color 1s, background-color 1s, color 1s; }';
		var shogo_tag_hover = '.shogo_tags .shogo_tag:hover { border-color: ' + tag_hover_border_color + '; background-color: ' + tag_hover_background_color + '; color: ' + tag_hover_font_color + ' }';
		var shogo_tags_after = '.shogo_tag::after { content: "x"; font-size: 13px; padding: 7px; cursor: pointer; text-align: center; }';
		var shogo_close_btn = '.shogo_tags .shogo_tag .close { position: absolute; width: 15px; margin-left: 10px; cursor: pointer }';
		var shogo_input_tags = '.shogo_input_tags { border: 0; outline: 0; margin-left: 5px; }';

		//Append Style to the head tag.
		$("head").append('<style>' + shogo_tag + ' ' + shogo_tag_hover + ' ' + shogo_tags_after + ' ' + shogo_close_btn + ' ' + shogo_input_tags + '</style>');

		//If params['data'] is set.
		if (params && typeof params === "object" && params['data']) {

			//Split data tag entries.
			var data = params['data'].split(",");

			//Data Length.
			var data_length = params['data'].split(",").length;

			//Add existing tags.
			for (var i = 0; i < data_length; i++) {
				if ($.trim(data[i]) !== "") {
                    add($.trim(data[i]));
                }
			}
		}

		//Main Input on Keyup Event.
		$(".shogo_input_tags").on("keyup", function(evt) {

			//Adjust Main Input with depends on the string length.
			$(this).css({
				"width": parseFloat(20 + $(".shogo_input_tags").textWidth()) + "px"
			});

			//KeyPress Event.
			var code = evt.which || evt.keyCode;

			//If code is 13 (ENTER BUTTON) and Main Input Text is not null or empty. Or code == 188 (,) and Main Input is not null or empty.
			if ((code == 13 && $(this).val() !== "") || (code == 188 && $(this).val() !== "" && $(this).val() !== ",")) {

				untag = "";

				//Add Tag. If code 188 remove (,).
				add($(this).val().replace(/,/g, ""));

				//Make Main Input Empty for next tagging.
				$(this).val("");

				return false;
			}
            
            //Set untag.
			untag = $(this).val().replace(",", "");
            
            //Add Tag Method.
            setInnerTags();
		}).on("keydown", function(evt) {

			//KeyPress Event.
			var code = evt.which || evt.keyCode;

			//If Backspace or code == 8 is pressed and Main Input Text is empty.
			if (code == 8 && $(this).val() == "") {

				//Remove Last Tag.
				var tags_len = tags.length - 1;
				remove(tags_len);
			}
		});

		//Add Tag Method.
		function add(text) {

			//Tag Object.
			var tag = {
				text: text, //Text Content.
				element: document.createElement('span') //Create Tag Element. <span>
			}

			//Tag Element clastList.
			tag.element.classList.add("shogo_tag");

			//Tag Element Text Content.
			tag.element.textContent = tag.text;

			//Create Close Button Element.
			var close_btn = document.createElement("span");

			//Close Button classList.
			close_btn.classList.add("close");

			//Close Button innnerHTML.
			close_btn.innerHTML = "&nbsp;";

			//Close Button Click Event.
			close_btn.addEventListener("click", function() {

				//Remove Tag. Depends on tag index.
				remove(tags.indexOf(tag));
			});

			//Append Close Button to Tag Element.
			tag.element.append(close_btn);

			//Append Tag Element to tags_container.
			$(".shogo_tags").append(tag.element);

			//Insert Tag to tags Array.
			tags.push(tag);

			//Set Inner Tags.
			setInnerTags();
		}

		//Method to Remove Tag.
		function remove(index) {

			//Tag Index.
			var tag = tags[index];

			//Remove tag from tags array.
			tags.splice(index, 1);

			//Remove Tag Element.
			document.getElementsByClassName("shogo_tags")[0].removeChild(tag.element);

			//Set Inner Tags.
			setInnerTags();
		}

		//Method to set Inner Tags to the Hidden Input.
		function setInnerTags() {

			//Inner Tags Array.
			var inner_tags = [];

			//Set Current tags to inner tags.
			for (var i = 0; i < tags.length; i++) {
				inner_tags.push(tags[i].text);
			}

			//Make inner_tags as Hidden Input Value.
            
            //If untag is empty. seperator is null.
			if (untag == "") {
				var seperator = "";
			} else {
				var seperator = ",";
			}

			$(".s_tags").attr("value", inner_tags + seperator + untag);
		}
	}

	$.fn.textWidth = function(text, font) {
    
	    if (!$.fn.textWidth.fakeEl) {
	    	$.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
	    }
	    
	    $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));
	    
	    return $.fn.textWidth.fakeEl.width();
	};
})(jQuery);