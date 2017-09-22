<!DOCTYPE html>
<html>
<head>
<title>Titli's Maths</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
  <link href="jquerycss.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="jquery.fireworks.js"></script>
  <script src="moment.js"></script>
  
  <script src="bootstrap-datepicker.js"></script>
  <link rel="stylesheet" href="datepicker.css">

  
<script>
  
  var totMarks = 0;
  var obtainedMarks = 0;
  var puzzle_ids = [];
  var qs_desc = "";
  var qs_main = "";
  var qs_ans = "";
  var qs_ids = "";
  var fetch_qs = 1;
  var perf_date_picker = "";
  var cal_val = "";
  var searchHtml = "";
  var filter_records = 0;
  var showAll = 0;
  
function ChangeButtonValue($id)
{
  if($('#sw_h').html() == "00" && $('#sw_m').html() == "00" && $('#sw_s').html() == "00")
  {
	  $.APP.startTimer('sw');
  }
  var html = $("#" + $id).html();
  html = html + " <span class='caret'></span>";
  $("#btnDrop").html(html);
  jQuery('.hide_div_class').hide();
  $("#" + $id + "_operation").show();
  jQuery('.answer_check_symbol').hide();
  jQuery('.clear_field').val('');
  jQuery('.check_correct_answer').hide();
  jQuery('.questions_fields').html('');
  $('#no_answer_check').hide();
  //$("#menuSelected").show('slide', 2000);
}

function ChangeDropFilter($id)
{
  var html = $("#" + $id).html();
  html = html + " <span class='caret'></span>";
  $("#slFilter").html(html);
  /*jQuery('.hide_div_class').hide();
  $("#" + $id + "_operation").show();
  jQuery('.answer_check_symbol').hide();
  jQuery('.clear_field').val('');
  jQuery('.check_correct_answer').hide();
  jQuery('.questions_fields').html('');
  $('#no_answer_check').hide();*/
  //$("#menuSelected").show('slide', 2000);
}
  
  /*$('#get_addition_data').click(function(){
    jQuery('.check_correct_answer').hide('');
});*/

function PutDataToAdd()
{
	if($('#sw_h').html() == "00" && $('#sw_m').html() == "00" && $('#sw_s').html() == "00")
	{
		  $.APP.startTimer('sw');
	}
	jQuery('.answer_check_symbol').hide();
	$('#no_answer_check').hide();
	jQuery('.clear_field').val('');
	jQuery('.check_correct_answer').show('');
	var min = 0;
	var max = 999;
	var num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#add_first').val(num);
	var res = num;
	num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#add_second').val(num);
	res = res + num;
	num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#add_third').val(num);
	res = res + num;
	
	$('#get_add_result').html(res);
	totMarks = totMarks + 1;
	$('#totalmarks').html(obtainedMarks + "/" + totMarks);
	$('#add_result').focus();
	var qsdescStr = $('#add_first').val() + " + " + $('#add_second').val() + " + " + $('#add_third').val();
	SaveToMathsDatabase(qsdescStr, "", res);
}

function PutDataToMultiply()
{
	if($('#sw_h').html() == "00" && $('#sw_m').html() == "00" && $('#sw_s').html() == "00")
	{
		  $.APP.startTimer('sw');
	}
	jQuery('.answer_check_symbol').hide();
	$('#no_answer_check').hide();
	jQuery('.clear_field').val('');
	jQuery('.check_correct_answer').show('');
	var min = 1;
	var max = 9;
	var num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#multi_first').val(num);
	var res = num;
	num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#multi_second').val(num);
	res = res * num;
	
	$('#get_multi_result').html(res);
	totMarks = totMarks + 1;
	$('#totalmarks').html(obtainedMarks + "/" + totMarks);
	$('#multi_result').focus();
	var qsdescStr = $('#multi_first').val() + " x " + $('#multi_second').val();
	SaveToMathsDatabase(qsdescStr, "", res);
}

function PutDataToSubtract()
{
	if($('#sw_h').html() == "00" && $('#sw_m').html() == "00" && $('#sw_s').html() == "00")
	{
		  $.APP.startTimer('sw');
	}
	jQuery('.answer_check_symbol').hide();
	$('#no_answer_check').hide();
	jQuery('.clear_field').val('');
	jQuery('.check_correct_answer').show('');
	var min = 0;
	var max = 999;
	var num = Math.floor(Math.random() * (max - min + 1)) + min;
	$('#sub_first').val(num);
	var res = num;
	num = Math.floor(Math.random() * (max - min + 1)) + min;
	if(num>res)
	{
		$('#sub_first').val(num);
		$('#sub_second').val(res);
		res = num - res;
	}
	else
	{
		$('#sub_second').val(num);
		res = res - num;
	}
	
	$('#get_sub_result').html(res);
	totMarks = totMarks + 1;
	$('#totalmarks').html(obtainedMarks + "/" + totMarks);
	$('#sub_result').focus();
	var qsdescStr = $('#sub_first').val() + " - " + $('#sub_second').val();
	SaveToMathsDatabase(qsdescStr, "", res);
}

function GetWordPuzzles()
{
	$.ajax({ url: 'api.php',
         data: {function2call: 'GetWordPuzzle'},
         type: 'post',
		 //dataType: 'json',
         success: function(output) {
			 var res = jQuery.parseJSON(output);
			 
			 //$('#question_desc').html(res[0]["QuestionDescription"]);
			 //$('#main_question').html(res[0]["QuestionMain"]);
			 //$('#get_word_result').html(res[0]["QuestionAnswer"]);
			 
			 qs_desc = res[0]["QuestionDescription"];
			 qs_main = res[0]["QuestionMain"];
			 qs_ans = res[0]["QuestionAnswer"];
			 qs_ids = res[0]["QuestionId"];
			 
			 if ($.inArray(qs_ids, puzzle_ids) != -1)
			 {
			  // found it
			  fetch_qs = 0;
			  GetWordPuzzles();
			 }
			 else
			 {
				puzzle_ids.push(qs_ids);
				fetch_qs = 1;
				$('#question_desc').html(qs_desc);
				$('#main_question').html(qs_main);
				$('#get_word_result').html(qs_ans);
						 
				//$('#get_multi_result').html(res);
				totMarks = totMarks + 1;
				$('#totalmarks').html(obtainedMarks + "/" + totMarks);
				$('#word_first').focus();
				
				SaveToMathsDatabase($('#question_desc').html(), $('#main_question').html(), $('#get_word_result').html());
			 }
			}
		});
}


function PutWordPuzzle()
{
	if($('#sw_h').html() == "00" && $('#sw_m').html() == "00" && $('#sw_s').html() == "00")
	{
		  $.APP.startTimer('sw');
	}
	jQuery('.answer_check_symbol').hide();
	$('#no_answer_check').hide();
	jQuery('.check_correct_answer').show();
	jQuery('.clear_field').val('');
	//make a database call to get questions
	//Get the word puzzles
	
	GetWordPuzzles();
}

function CheckAddAnswer()
{
	if($('#add_result').val() != "")
	{
		jQuery('.answer_check_symbol').hide();
		jQuery('.after_check_answer').hide();
		$('#no_answer_check').hide();
		var ans = $('#add_result').val();
		var correct_answer = $('#get_add_result').html();
		if(ans == correct_answer)
		{
			$('#answer_right_check').show('slide', {direction: 'down'}, 500);
			//$('#answer_right_check').slideUp(500);
			$('#right_add_answer').show();
			obtainedMarks = obtainedMarks + 1;
			$('#totalmarks').html(obtainedMarks + "/" + totMarks);
			
			$('body').fireworks();
			
			var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// show the canvas
			 canvas.style.display="block";
			 
			setTimeout(function() {
			 var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// hide the canvas
			 $(canvas).hide('fade', 1500);
			 }, 3000);
			 var qsdescStr = $('#add_first').val() + " + " + $('#add_second').val() + " + " + $('#add_third').val();
			 var todayDt = moment().format("DD/MM/YYYY");
			 SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "Yes", todayDt);

		}
		else
		{
			$('#add_result').focus();
			$('#add_result').focus(function() { $(this).select(); } );
			$('#crying_anime').show('fade', 1000);
			$('#crying_anime').show().css('display', 'flex');
			 setTimeout(function() {
			 $('#crying_anime').hide('fade', 1000);
			 }, 3000);
			$('#answer_wrong_check').show('slide', {direction: 'down'}, 500);
			$('#wrong_add_answer').show();
			jQuery('.after_check_answer').show();
			var qsdescStr = $('#add_first').val() + " + " + $('#add_second').val() + " + " + $('#add_third').val();
			var todayDt = moment().format("DD/MM/YYYY");
			SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "No", todayDt);
		}
	}
	else
	{
		$('#no_answer_check').show('slide', {direction: 'down'}, 500);
		jQuery('.noanswer_hide_me').hide();
		$('#add_result').focus();
	}
	
	if(obtainedMarks >= 1)
	{
		$('#performance_analysis').show('slide', {direction: 'right'}, 500);
	}
}

function CheckMultiAnswer()
{
	if($('#multi_result').val() != "")
	{
		jQuery('.answer_check_symbol').hide();
		jQuery('.after_check_answer').hide();
		$('#no_answer_check').hide();
		var ans = $('#multi_result').val();
		var correct_answer = $('#get_multi_result').html();
		if(ans == correct_answer)
		{
			$('#answer_right_check').show('slide', {direction: 'down'}, 500);
			//$('#answer_right_check').slideUp(500);
			$('#right_multi_answer').show();
			obtainedMarks = obtainedMarks + 1;
			$('#totalmarks').html(obtainedMarks + "/" + totMarks);
			
			$('body').fireworks();
			
			var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// show the canvas
			 canvas.style.display="block";
			 
			setTimeout(function() {
			 var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// hide the canvas
			 $(canvas).hide('fade', 1500);
			 }, 3000);
			 
			 var qsdescStr = $('#multi_first').val() + " x " + $('#multi_second').val();
			 var todayDt = moment().format("DD/MM/YYYY");
			 SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "Yes", todayDt);
		}
		else
		{
			$('#multi_result').focus();
			$('#multi_result').focus(function() { $(this).select(); } );
			$('#crying_anime').show('fade', 1000);
			$('#crying_anime').show().css('display', 'flex');
			 setTimeout(function() {
			 $('#crying_anime').hide('fade', 1000);
			 }, 3000);
			$('#answer_wrong_check').show('slide', {direction: 'down'}, 500);
			$('#wrong_multi_answer').show();
			jQuery('.after_check_answer').show();
			var qsdescStr = $('#multi_first').val() + " x " + $('#multi_second').val();
			var todayDt = moment().format("DD/MM/YYYY");
			SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "No", todayDt);
		}
	}
	else
	{
		$('#no_answer_check').show('slide', {direction: 'down'}, 500);
		jQuery('.noanswer_hide_me').hide();
		$('#multi_result').focus();
	}
	
	if(obtainedMarks >= 1)
	{
		$('#performance_analysis').show('slide', {direction: 'right'}, 500);
	}
}

function CheckWordAnswer()
{
	if($('#word_result').val() != "" && $('#word_first').val() != "")
	{
		jQuery('.answer_check_symbol').hide();
		jQuery('.after_check_answer').hide();
		$('#no_answer_check').hide();
		var ans = $('#word_result').val();
		var correct_answer = $('#get_word_result').html();
		if(ans == correct_answer)
		{
			$('#answer_right_check').show('slide', {direction: 'down'}, 500);
			//$('#answer_right_check').slideUp(500);
			$('#right_word_answer').show();
			obtainedMarks = obtainedMarks + 1;
			$('#totalmarks').html(obtainedMarks + "/" + totMarks);
			
			$('body').fireworks();
			
			var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// show the canvas
			 canvas.style.display="block";
			 
			setTimeout(function() {
			 var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// hide the canvas
			 $(canvas).hide('fade', 1500);
			 }, 3000);
			 var qsdescStr = $('#question_desc').html() + " " + $('#main_question').html();
			 var userans = $('#word_first').val();
			 var todayDt = moment().format("DD/MM/YYYY");
			 SaveToPerformanceDatabase(qsdescStr, correct_answer, userans + " = " + ans, "Yes", todayDt);
			 
		}
		else
		{
			$('#word_result').focus();
			$('#word_result').focus(function() { $(this).select(); } );
			$('#crying_anime').show('fade', 1000);
			$('#crying_anime').show().css('display', 'flex');
			 setTimeout(function() {
			 $('#crying_anime').hide('fade', 1000);
			 }, 3000);
			$('#answer_wrong_check').show('slide', {direction: 'down'}, 500);
			$('#wrong_word_answer').show();
			jQuery('.after_check_answer').show();
			var qsdescStr = $('#question_desc').html() + " " + $('#main_question').html();
			var userans = $('#word_first').val();
			var todayDt = moment().format("DD/MM/YYYY");
			SaveToPerformanceDatabase(qsdescStr, correct_answer, userans + " = " + ans, "No", todayDt);
		}
	}
	else
	{
		$('#no_answer_check').show('slide', {direction: 'down'}, 500);
		jQuery('.noanswer_hide_me').hide();
		if($('#word_first').val() == "")
		{
			$('#word_first').focus();
		}
		else
		{
			$('#word_result').focus();
		}
	}
	
	if(obtainedMarks >= 1)
	{
		$('#performance_analysis').show('slide', {direction: 'right'}, 500);
	}
}

function CheckSubAnswer()
{
	if($('#sub_result').val() != "")
	{
		jQuery('.answer_check_symbol').hide();
		jQuery('.after_check_answer').hide();
		$('#no_answer_check').hide();
		var ans = $('#sub_result').val();
		var correct_answer = $('#get_sub_result').html();
		if(ans == correct_answer)
		{
			$('#answer_right_check').show('slide', {direction: 'down'}, 500);
			//$('#answer_right_check').slideUp(500);
			$('#right_sub_answer').show();
			obtainedMarks = obtainedMarks + 1;
			$('#totalmarks').html(obtainedMarks + "/" + totMarks);
			
			$('body').fireworks();
			
			var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// show the canvas
			 canvas.style.display="block";
			 
			setTimeout(function() {
			 var query="canvas";
			// find the canvas
			 var canvas=document.querySelector(query);
			// hide the canvas
			 $(canvas).hide('fade', 1500);
			 }, 3000);
			 var qsdescStr = $('#sub_first').val() + " - " + $('#sub_second').val();
			 var todayDt = moment().format("DD/MM/YYYY");
			 SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "Yes", todayDt);
		}
		else
		{
			$('#sub_result').focus();
			$('#sub_result').focus(function() { $(this).select(); } );
			$('#crying_anime').show('fade', 1000);
			$('#crying_anime').show().css('display', 'flex');
			 setTimeout(function() {
			 $('#crying_anime').hide('fade', 1000);
			 }, 3000);
			$('#answer_wrong_check').show('slide', {direction: 'down'}, 500);
			$('#wrong_sub_answer').show();
			jQuery('.after_check_answer').show();
			var qsdescStr = $('#sub_first').val() + " - " + $('#sub_second').val();
			var todayDt = moment().format("DD/MM/YYYY");
			SaveToPerformanceDatabase(qsdescStr, correct_answer, ans, "No", todayDt);
		}
	}
	else
	{
		$('#no_answer_check').show('slide', {direction: 'down'}, 500);
		jQuery('.noanswer_hide_me').hide();
		$('#sub_result').focus();
	}
	
	if(obtainedMarks >= 1)
	{
		$('#performance_analysis').show('slide', {direction: 'right'}, 500);
	}
}

jQuery.fn.extend({
    live: function (event, callback) {
       if (this.selector) {
            jQuery(document).on(event, this.selector, callback);
        }
    }
});

$(document).ready(function() {

    (function($){
    
        $.extend({
            
            APP : {
                
                formatTimer : function(a) {
                    if (a < 10) {
                        a = '0' + a;
                    }                              
                    return a;
                },    
                
                startTimer : function(dir) {
                    
                    var a;
                    
                    // save type
                    $.APP.dir = dir;
                    
                    // get current date
                    $.APP.d1 = new Date();
                    
                    switch($.APP.state) {
                            
                        case 'pause' :
                            
                            // resume timer
                            // get current timestamp (for calculations) and
                            // substract time difference between pause and now
                            $.APP.t1 = $.APP.d1.getTime() - $.APP.td;                            
                            
                        break;
                            
                        default :
                            
                            // get current timestamp (for calculations)
                            $.APP.t1 = $.APP.d1.getTime(); 
                            
                            // if countdown add ms based on seconds in textfield
                            if ($.APP.dir === 'cd') {
                                $.APP.t1 += parseInt($('#cd_seconds').val())*1000;
                            }    
                        
                        break;
                            
                    }                                   
                    
                    // reset state
                    $.APP.state = 'alive';   
                    //$('#' + $.APP.dir + '_status').html('Running');
                    
                    // start loop
                    $.APP.loopTimer();
                    
                },
				
				pauseTimer : function() {
                    
                    // save timestamp of pause
                    $.APP.dp = new Date();
                    $.APP.tp = $.APP.dp.getTime();
                    
                    // save elapsed time (until pause)
                    $.APP.td = $.APP.tp - $.APP.t1;
                    
                    // change button value
                    $('#' + $.APP.dir + '_start').val('Resume');
                    
                    // set state
                    $.APP.state = 'pause';
                    $('#' + $.APP.dir + '_status').html('Paused');
                    
                },
                
                stopTimer : function() {
                    
                    // change button value
                    //$('#' + $.APP.dir + '_start').val('Restart');                    
                    
                    // set state
                    $.APP.state = 'stop';
					$('#sw_h').html('00');
					$('#sw_m').html('00');
					$('#sw_s').html('00');
                    //$('#' + $.APP.dir + '_status').html('Stopped');
                    
                },
                
                resetTimer : function() {

                    // reset display
                    $('#' + $.APP.dir + '_ms,#' + $.APP.dir + '_s,#' + $.APP.dir + '_m,#' + $.APP.dir + '_h').html('00');                 
                    
                    // change button value
                    //$('#' + $.APP.dir + '_start').val('Start');                    
                    
                    // set state
                    $.APP.state = 'reset';  
                    //$('#' + $.APP.dir + '_status').html('Reset & Idle again');
                    
                },
                
                endTimer : function(callback) {
                   
                    // change button value
                    //$('#' + $.APP.dir + '_start').val('Restart');
                    
                    // set state
                    $.APP.state = 'end';
                    
                    // invoke callback
                    if (typeof callback === 'function') {
                        callback();
                    }    
                    
                },    
                
                loopTimer : function() {
                    
                    var td;
                    var d2,t2;
                    
                    var ms = 0;
                    var s  = 0;
                    var m  = 0;
                    var h  = 0;
                    
                    if ($.APP.state === 'alive') {
                                
                        // get current date and convert it into 
                        // timestamp for calculations
                        d2 = new Date();
                        t2 = d2.getTime();   
                        
                        // calculate time difference between
                        // initial and current timestamp
                        if ($.APP.dir === 'sw') {
                            td = t2 - $.APP.t1;
                        // reversed if countdown
                        } else {
                            td = $.APP.t1 - t2;
                            if (td <= 0) {
                                // if time difference is 0 end countdown
                                $.APP.endTimer(function(){
                                    $.APP.resetTimer();
                                    //$('#' + $.APP.dir + '_status').html('Ended & Reset');
                                });
                            }    
                        }    
                        
                        // calculate milliseconds
                        ms = td%1000;
                        if (ms < 1) {
                            ms = 0;
                        } else {    
                            // calculate seconds
                            s = (td-ms)/1000;
                            if (s < 1) {
                                s = 0;
                            } else {
                                // calculate minutes   
                                var m = (s-(s%60))/60;
                                if (m < 1) {
                                    m = 0;
                                } else {
                                    // calculate hours
                                    var h = (m-(m%60))/60;
                                    if (h < 1) {
                                        h = 0;
                                    }                             
                                }    
                            }
                        }
                      
                        // substract elapsed minutes & hours
                        ms = Math.round(ms/100);
                        s  = s-(m*60);
                        m  = m-(h*60);                                
                        
                        // update display
                        $('#' + $.APP.dir + '_ms').html($.APP.formatTimer(ms));
                        $('#' + $.APP.dir + '_s').html($.APP.formatTimer(s));
                        $('#' + $.APP.dir + '_m').html($.APP.formatTimer(m));
                        $('#' + $.APP.dir + '_h').html($.APP.formatTimer(h));
                        
                        // loop
                        $.APP.t = setTimeout($.APP.loopTimer,1);
                    
                    } else {
                    
                        // kill loop
                        clearTimeout($.APP.t);
                        return true;
                    
                    }  
                    
                }
                    
            }    
        
        });
          
        $('#sw_start').click(function() {
            $.APP.startTimer('sw');
        });    

        $('#sw_stop').click(function() {
            $.APP.stopTimer();
        });
        
        $('#sw_reset').click(function() {
            $.APP.resetTimer();
        });  
        
        $('#sw_pause').click(function() {
            $.APP.pauseTimer();
        });                
                
    })(jQuery);
        
});

function GetShowAll()
{
	GetPerformanceData(1);
	showAll = 1;
	//$('#dp1').val('');
}

function EmptyDTPicker()
{
	//$('#dp1').val('');
}

$(document).ready(function() {
    $("input:text").focus(function() { $(this).select(); } );
	var a_correct = "a_correct";
	var correct_radio = "correct_radio";
	var a_wrong = "a_wrong";
	var wrong_radio = "wrong_radio";
	var a_all_rec = "a_all_rec";
	var all_radio = "all_radio";
	var todayDt = moment().format("DD/MM/YYYY");
	GetPerformance(todayDt);
	var null_str = "";
	var dtpicker_null = "$('#dp1').val('');";
	perf_date_picker = "<input type='text' id='dp1' class='datepicker1 perf_dtpicker datepicker_input_styles' placeholder='Search Dates' name='dp1'></input><div class='show_all_perf' onclick='GetShowAll();" + "'" + ">Show All</div>";
	
	searchHtml = "<div class='filter_text'>Filter: </div><div class='btn-group dropdown todos filter_style' id='todos'>";
	searchHtml = searchHtml + "<button class='btn btn-default dropdown-toggle botn-todos' type='button' id='dropdownMenu1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span id='flt_txt'>Select Filter</span>";
	searchHtml = searchHtml + "  <span class='caret caret-posicion'></span></button>";
	searchHtml = searchHtml + "<ul class='dropdown-menu ancho-todos' aria-labelledby='dropdownMenu1'>";
	searchHtml = searchHtml + "<li><a style='color: #0044cc;' href='#' onclick='CorrectClick(); ChangeDropDownValue(" + '"' + a_correct + '"' + "," + '"' + correct_radio + '"' + ")" + "'" + "><input value='1' name='busqueda1' type='radio' class='todoss' id='correct_radio'><span id='a_correct'>Correct</span></a></li>";
	searchHtml = searchHtml + "<li><a style='color: #0044cc;' href='#' onclick='WrongClick(); ChangeDropDownValue(" + '"' + a_wrong + '"' + "," + '"' + wrong_radio + '"' + ")" + "'" + "><input value='1' name='busqueda1' type='radio' class='enc' id='wrong_radio'><span id='a_wrong'>Wrong</span></a></li>";
	searchHtml = searchHtml + "<li><a style='color: #0044cc;' href='#' onclick='AllClick(); ChangeDropDownValue(" + '"' + a_all_rec + '"' + "," + '"' + all_radio + '"' + ")" + "'" + "><input value='1' name='busqueda1' type='radio' class='nose' id='all_radio'><span id='a_all_rec'>All Records</span></a></li></ul></div>";
});

/*$('#performance_details_container').on('focus',".datepicker", function()
{
    $(this).datepicker();
});*/

function SaveToMathsDatabase($qsdesc, $qsmain, $qsanswer)
{
	$.ajax({ url: 'api.php',
         data: {function2call: 'SaveToMathsDatabase', qsdesc: $qsdesc, qsmain: $qsmain, qsanswer: $qsanswer},
         type: 'post',
		 //dataType: 'json',
         success: function(output) {
			 //var res = jQuery.parseJSON(output);
			}
		});
}

function SaveToPerformanceDatabase($qsdesc, $qsorganswer, $qsuseranswer, $success, $examdt)
{
	$.ajax({ url: 'api.php',
         data: {function2call: 'SaveToPerformanceDatabase', qsdesc: $qsdesc, qsorganswer: $qsorganswer, qsuseranswer: $qsuseranswer, success: $success, examdt: $examdt},
         type: 'post',
		 //dataType: 'json',
         success: function(output) {
			 //var res = jQuery.parseJSON(output);
			}
		});
}

function ShowPerformanceContainer()
{
	$('#performance_container').show('fold', {direction: 'left'}, 1000);
	
	var todayDt = moment().format("DD/MM/YYYY");
	GetPerformanceData(todayDt);
}

function HidePerformanceContainer()
{
	$('#performance_container').hide('fade', {direction: 'left'}, 1000);
	//$('#dp1').val('');
	cal_val = "";
	$('#dp1').datepicker('destroy');
	//GetPerformanceData();
}

/*$(function(){
   $('.datepicker').datepicker({
      format: 'mm-dd-yyyy'
    });
});*/

function GetPerformanceData($examdt)
{
	$.ajax({ url: 'api.php',
         data: {function2call: 'GetPerformanceData', examdt: $examdt},
         type: 'post',
		 //dataType: 'json',
         success: function(output) {
			 var res = jQuery.parseJSON(output);
			 
			 var hLine = "";
			 var html = "";
			 html = html + "<div class='col-lg-12 perf_top'><h3>Performance Sheet</h3>" + perf_date_picker + searchHtml + "<span class='pull-right' style='position: relative;margin-right: 20px; margin-top: -35px;'><i class='fa fa-window-close' id='close_all_orders' title='Close' style='cursor: pointer; text-shadow: 2px 2px 2px #928f8f;' onclick='HidePerformanceContainer();'></i></span></div>";
			 
			 html = html + "<div class='row perf_header'><div class='col-lg-3'>Question</div><div class='col-lg-3'>Answer</div><div class='col-lg-3'>User's Answer</div><div class='col-lg-1'>Success</div><div class='col-lg-2' style='text-align: center;'>Date</div></div>";
			 
			 html = html + "<div style='margin-top: 130px; background: rgba(58, 54, 54, 0.72);'><div style='height: 15px'/>";
			 
			 for(var i = 0; i < res.length; i++)
			 {
				 if(res[i]["Success"] == "Yes")
				 {
					 styleColor = "style='color:rgb(239, 229, 231); padding-left: 15px;'";
				 }
				 else
				 {
					 styleColor = "style='color:red; padding-left: 15px;'";
				 }
				 //styleColor = "style='color:rgb(239, 229, 231); padding-left: 15px;'";
				 hlastLine = "<hr class='w3-clear' style='border-top: 1px dotted #337ab7;'>";
				 if(i ==  res.length - 1)
				 {
					 //hLine = "<hr class='w3-clear' style='border-top: 1px solid #337ab7; margin-right: 15px; margin-left: 15px;'>";
				 }
				 if(filter_records == 1)
				 {
					 if(res[i]["Success"] == "Yes")
					 {
						html = html + "<div class='row'" + styleColor + ">" + hLine + "<div style='display:none;'>" + res[i]["PerformanceId"] + "</div><div class='col-lg-3'>" + res[i]["QuestionDesc"] + "</div><div class='col-lg-3'>" + res[i]["OriginalAnswer"] + "</div><div class='col-lg-3'>" + res[i]["UserAnswer"] + "</div><div class='col-lg-1'>" + res[i]["Success"] + "</div><div class='col-lg-2' style='text-align: center;'>" + res[i]["ExamDate"] + "</div></div><div style='height: 20px'>" + hlastLine + "</div>";
					 }
				 }
				 else if(filter_records == 2)
				 {
					 if(res[i]["Success"] == "No")
					 {
						html = html + "<div class='row'" + styleColor + ">" + hLine + "<div style='display:none;'>" + res[i]["PerformanceId"] + "</div><div class='col-lg-3'>" + res[i]["QuestionDesc"] + "</div><div class='col-lg-3'>" + res[i]["OriginalAnswer"] + "</div><div class='col-lg-3'>" + res[i]["UserAnswer"] + "</div><div class='col-lg-1'>" + res[i]["Success"] + "</div><div class='col-lg-2' style='text-align: center;'>" + res[i]["ExamDate"] + "</div></div><div style='height: 20px'>" + hlastLine + "</div>";
					 }
				 }
				 else if(filter_records == 3)
				 {
					 //if(res[i]["Success"] == "Yes")
					 {
						html = html + "<div class='row'" + styleColor + ">" + hLine + "<div style='display:none;'>" + res[i]["PerformanceId"] + "</div><div class='col-lg-3'>" + res[i]["QuestionDesc"] + "</div><div class='col-lg-3'>" + res[i]["OriginalAnswer"] + "</div><div class='col-lg-3'>" + res[i]["UserAnswer"] + "</div><div class='col-lg-1'>" + res[i]["Success"] + "</div><div class='col-lg-2' style='text-align: center;'>" + res[i]["ExamDate"] + "</div></div><div style='height: 20px'>" + hlastLine + "</div>";
					 }
				 }
				 else
				 {
					html = html + "<div class='row'" + styleColor + ">" + hLine + "<div style='display:none;'>" + res[i]["PerformanceId"] + "</div><div class='col-lg-3'>" + res[i]["QuestionDesc"] + "</div><div class='col-lg-3'>" + res[i]["OriginalAnswer"] + "</div><div class='col-lg-3'>" + res[i]["UserAnswer"] + "</div><div class='col-lg-1'>" + res[i]["Success"] + "</div><div class='col-lg-2' style='text-align: center;'>" + res[i]["ExamDate"] + "</div></div><div style='height: 20px'>" + hlastLine + "</div>"; 
				 }
			 }
			 html = html + '</div>';
			 
			 $('#performance_details_container').html(html);
			 if(filter_records == 1)
			 {
				 $('#flt_txt').html('Correct');
				 $("#correct_radio").prop("checked", true);
			 }
			 else if(filter_records == 2)
			 {
				 $('#flt_txt').html('Wrong');
				 $("#wrong_radio").prop("checked", true);
			 }
			 if(filter_records == 3)
			 {
				 $('#flt_txt').html('All Records');
				 $("#all_radio").prop("checked", true);
			 }
			 
			 $('#dp1').datepicker({
			  format: 'dd/mm/yyyy'
			});
			
			$('#dp1').on('changeDate', function(e) {
				//alert($('#dp1').val());
				cal_val = $('#dp1').val();
				GetPerformanceData(cal_val);
			});
			if(showAll == 0)
			{
				$('#dp1').val(cal_val);
			}
			else
			{
				cal_val = "";
			}
			showAll = 0;
			}
		});
		$('#dp1').datepicker('destroy');
}

function GetPerformance($examdt)
{
	$.ajax({ url: 'api.php',
         data: {function2call: 'GetPerformance', examdt: $examdt},
         type: 'post',
		 //dataType: 'json',
         success: function(output) {
			 var res = jQuery.parseJSON(output);
			 if(res[0]["COUNT(*)"] > 0)
			 {
				 $('#performance_analysis').show('slide', {direction: 'right'}, 500);
			 }
			}
		});
}

$(document).on("keypress", "#add_result", function (e) {
    if (e.keyCode == 13 || e.which == '13') {
		$('#add_result').blur();
        CheckAddAnswer();
    }
});

$(document).on("keypress", "#sub_result", function (e) {
    if (e.keyCode == 13 || e.which == '13') {
		$('#sub_result').blur();
        CheckSubAnswer();
    }
});


$(document).on("keypress", "#multi_result", function (e) {
    if (e.keyCode == 13 || e.which == '13') {
		$('#multi_result').blur();
        CheckMultiAnswer();
    }
});

$(document).on("keypress", "#word_result", function (e) {
    if (e.keyCode == 13 || e.which == '13') {
		$('#word_result').blur();
        CheckWordAnswer();
    }
});

function CorrectClick()
{
	filter_records = 1;
}

function WrongClick()
{
	filter_records = 2;
}

function AllClick()
{
	filter_records = 3;
}

function ChangeDropDownValue($id, $radioId)
{
	var html = $("#" + $id).html();
    html = html + ' <span class="caret caret-posicion"></span>';
    
	$("#" + $radioId).prop("checked", true);
	//jQuery("#" + $radioId).attr('checked', true);
	$("#" + $id).closest('.dropdown').find('.dropdown-toggle').html(html);
	
	var dt = "";
	if($('#dp1').val() == "")
	{
		dt = 1;
	}
	else
	{
		dt = $('#dp1').val();
	}
	//alert($("#" + $id).html());
	GetPerformanceData(dt);
}

/*$('.dropdown-menu').on( 'click', 'a', function() {
	var text = $(this).html();
	alert(text);
	var htmlText = text + ' <span class="caret caret-posicion"></span>';
	$(this).closest('.dropdown').find('.dropdown-toggle').html(htmlText);
});*/

/*$(function() {
	
});*/

/*$('#get_wrd_data').on('mousedown', function () {
	$('#get_wrd_data').css('text-shadow', '0 0 0 #777');
});
$('#get_wrd_data').on('mouseup', function () {
	$('#get_wrd_data').css('text-shadow', '4px 4px 6px #777');
});*/

</script>
  
<style>

@font-face{
 font-family:'digital-clock-font';
 src: url('fonts/digital-7.ttf');
}

.dropdown-menu {
	background-color: white;
	color: #271d71;
}

.dropdown-menu > li > a:hover 
{
	background-color: red;
	color: #fff;
}
					
.dropdown-menu > li > a 
{
	color: #d4cccc;
}

.operation_symbol
{
	display: flex;
    justify-content: center;
    align-items: center;
    height: 26px;
}

.input_styles
{
	width: 120%;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #c0c7c0;
	text-align: center;
	box-shadow: 3px 5px 8px 0px rgba(0, 0, 0, 0.35);
}

.datepicker_input_styles
{
    font-size: 13px;
    border-radius: 5px;
    border: 1px solid #c0c7c0;
    box-shadow: 3px 5px 8px 0px rgba(0, 0, 0, 0.35);
    width: 130px;
    padding-left: 15px;
    height: 27px;
    background-image: url(search.png);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: 10px;
    background-size: 15px 15px;
    text-indent: 20px;
}

.fa-equal:before {
  content: "=";
}

.fa-equal {
  font-family: Arial;
  font-weight: bold;
}

.answer_right
{
	display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    border: 1px solid #c0c7c0;
    background: darkseagreen;
    color: green;
    font-size: 40px;
    width: 1170px;
    border-top-right-radius: 5px;
	border-top-left-radius: 5px;
    position: fixed;
    bottom: 0;
}

.answer_wrong
{
	display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    border: 1px solid #c0c7c0;
    background: #fd6674;
    color: rgba(175, 37, 61, 0.88);
	font-size: 40px;
	width: 1170px;
    border-top-right-radius: 5px;
	border-top-left-radius: 5px;
    position: fixed;
    bottom: 0;
}

.smiley_right
{
	color: #2900ff;
	text-shadow: 1px 1px #cecfd8, 2px 2px #deded4, 0.1em 0.1em 0.2em rgb(136, 136, 129);
}

.smiley_wrong
{
	color: #ff002d;
	text-shadow: 1px 1px #ead3da, 2px 2px #ecece5, 0.1em 0.1em 0.2em rgb(195, 195, 184);
}

.total_marks
{
	float: right;
    margin-top: -50px;
    position: relative;
    border: 1px solid #272927;
    background: #191818;
    color: rgba(239, 234, 234, 0.88);
    width: 120px;
    text-align: center;
    height: 50px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
	padding: 10px;
	box-shadow: 3px 5px 8px 0px rgba(0, 0, 0, 0.35);
}

.time_calculation
{
	margin-top: -50px;
    position: relative;
    border: 1px solid #272927;
    background: #191818;
    color: rgba(239, 234, 234, 0.88);
    width: 120px;
    text-align: center;
    height: 50px;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
    box-shadow: 3px 5px 8px 0px rgba(0, 0, 0, 0.35);
    float: left;
    margin-left: 43%;
	font-size: 25px;
}

.time_control
{
	margin-top: -35px;
    position: relative;
    color: rgba(239, 234, 234, 0.88);
    width: 120px;
    text-align: left;
    height: 20px;
    border-radius: 10px;
    display: flex;
    justify-content: left;
    align-items: center;
    padding: 10px;
    float: left;
    margin-left: 54%;
}

.question_main_txt
{
	width: 1000px;
    text-align: justify;
	font-size: 20px;
	padding-left: 98px;
}

.question_ans_txt
{
	width: max-content;
    text-align: justify;
	font-size: 20px;
	padding-left: 98px;
}

.aligning_ans_div
{
	display: flex;
    align-items: center;
}

#menuSelected {
    width: 150px;
    height: 55px;
    background-color: #368EC5;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 40px;
    color: white;
	margin-left: -30px;
    position: absolute;
    margin-top: -80px;
}
.arrowhead {
    border-top: 20px solid #368EC5;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -20px;
    left: 45%;
}

.performance_style
{
	position: absolute;
    right: 0px;
    border: 1px solid #368EC5;
    background: #368EC5;
    color: white;
    font-family: digital-clock-font;
    width: 30px;
    text-align: center;
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
    top: 0;
	margin-top: 90px;
    box-shadow: -4px 4px 8px 0px rgba(0, 0, 0, 0.35);
	cursor: pointer;
	padding-top: 10px;
    padding-bottom: 10px;
	display: none;
}

.overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    /*background: rgba(51,51,51,0.7);*/
    z-index: 10;
	display: flex;
    justify-content: center;
    align-items: center;
	/*background-image: url('crying.gif');*/
	background-repeat: no-repeat;
	display: none;
  }
  
.performance_views
{
	display:none; 
	background: rgba(8, 8, 8, 0.96); 
	z-index: 110;
}

.performance_details
{
	width: 80%;
	position: absolute; 
	margin-top: 2%;
	margin-left: 10%;
	background-color: rgba(117, 110, 110, 0);
	overflow-x: hidden;
	box-shadow: 3px 4px 4px 1px #3e3939;
	border-radius: 5px; 
	border: 1px solid white;
	height: 500px;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 4px;
}
 
::-webkit-scrollbar-track {
    background-color: #ebebeb;
    -webkit-border-radius: 0px;
    border-radius: 0px;
}

::-webkit-scrollbar-thumb {
    -webkit-border-radius: 0px;
    border-radius: 0px;
    background: #6d6d6d; 
}

.perf_top
{
	height: 90px;
	width: 1085px;
	background: rgb(249, 146, 146);
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
	position: fixed;
	z-index: 120; 
	text-shadow: 2px 2px 2px #c7c1c1;
}

.perf_header
{
	text-shadow: 3px 3px 2px #989090;
	margin-top: 90px;
	position: fixed;
	width: 1085px;
	background: rgb(219, 241, 168);
	margin-left: 0px;
	z-index: 119;
	height: 40px;
	display: flex;
    justify-content: center;
    align-items: center;
	color: black;
}

.perf_dtpicker
{
	position: absolute;
    margin-left: 380px;
    margin-top: -37px;
}

::-webkit-input-placeholder { /* WebKit, Blink, Edge */
    color:    #d6cfcf;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
   color:    #d6cfcf;
   opacity:  1;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
   color:    #d6cfcf;
   opacity:  1;
}
:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color:    #d6cfcf;
}
::-ms-input-placeholder { /* Microsoft Edge */
   color:    #d6cfcf;
}

.show_all_perf
{
	cursor: pointer;
    position: absolute;
    margin-left: 550px;
    margin-top: -34px;
    color: yellow;
    text-shadow: 0px 0px 0px #c58686;
    border: 1px solid black;
    background: black;
    width: 80px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 3px 5px 8px 0px rgba(0, 0, 0, 0.35);
}

li:first-child input[type='radio']{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #92d04f;
    border-radius:50%;
    outline:none;
    margin: 0 13px -3px 0;
    /*box-shadow:0 0 5px 0px #6a706d inset;*/
    }
    li:first-child input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 17% 22%;    
        border-radius:50%;    
    }
    li:first-child input[type='radio']:checked:before {
        background:#6a706d;
    }
    li:nth-child(2) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #f1d04d;
    border-radius:50%;
    outline:none;
     margin: 0 13px -3px 0;
    }

    li:nth-child(2) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 17% 22%;    
        border-radius:50%;    
    }
    li:nth-child(2) input[type='radio']:checked:before{
        background:#f1d04d;
    }

    li:nth-child(3) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #ed5850;
    border-radius:50%;
    outline:none;
    /*box-shadow:0 0 5px 0px #caaf40 inset;*/
    margin: 0 13px -3px 0;
    }

    li:nth-child(3) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 17% 22%;    
        border-radius:50%;    
    }
    li:nth-child(3) input[type='radio']:checked:before{
        background:#caaf40;
    }

    li:nth-child(4) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #92d04f;
    border-radius:50%;
    outline:none;
    /*box-shadow:0 0 5px 0px #92d04f inset;*/
    margin: 0 13px -3px 0;
    }

    li:nth-child(4) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 20% auto;    
        border-radius:50%;    
    }
    li:nth-child(4) input[type='radio']:checked:before{
        background:#92d04f;
    }

    li:nth-child(5) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #7aaf42;
    border-radius:50%;
    outline:none;
    /*box-shadow:0 0 5px 0px #7aaf42 inset;*/
    margin: 0 13px -3px 0;
    }
    li:nth-child(5) input[type='radio']:hover {
        box-shadow:0 0 5px 0px #7aaf42 inset;
    }
    li:nth-child(5) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 20% auto;    
        border-radius:50%;    
    }
    li:nth-child(5) input[type='radio']:checked:before{
        background:#7aaf42;
    }    

    li:nth-child(6) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #ed5850;
    border-radius:50%;
    outline:none;
    /*box-shadow:0 0 5px 0px #b70218 inset;*/
    margin: 0 13px -3px 0;
    }

    li:nth-child(6) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 20% auto;    
        border-radius:50%;    
    }
    li:nth-child(6) input[type='radio']:checked:before{
        background:#ed5850;
    }

    li:nth-child(7) input[type='radio'] {
    -webkit-appearance:none;
    width:15px;
    height:15px;
    border:3px solid #b70218;
    border-radius:50%;
    outline:none;
    /*box-shadow:0 0 5px 0px #b70218 inset;*/
    margin: 0 13px -3px 0;
    }
    li:nth-child(7) input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 20% auto;    
        border-radius:50%;    
    }
    li:nth-child(7) input[type='radio']:checked:before{
        background:#b70218;
    }
	
.filter_style
{
	position: absolute;
	margin-left: 740px;
	margin-top: -40px;
	text-shadow: 0px 0px 0px #c7c1c1;
}

.filter_text
{
	margin-left: 690px;
    margin-top: -34px;
    position: absolute;
    text-shadow: 0px 0px 0px #c7c1c1;
}
</style>
</head>
<body>

<div class="container">
	<div class="row">
	  <h2 style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6)">Mathematics</h2>
	  <div class="time_calculation" id="timeCalc">
		<span id="sw_h" style="font-family:digital-clock-font;">00</span><span style="font-family:digital-clock-font;">:</span>
		<span id="sw_m" style="font-family:digital-clock-font;">00</span><span style="font-family:digital-clock-font;">:</span>
		<span id="sw_s" style="font-family:digital-clock-font;">00</span><span style="font-family:digital-clock-font;"></span>
	  </div>
	  <div class="time_control" id="timeCalc">
		<span id="sw_start"><i title="Start Time" class="fa fa-play 4x" style="color: blue; cursor: pointer;"></i></span>
		<span style="width: 15px;"></span>
		<span id="sw_pause"><i title="Pause Time" class="fa fa-pause 4x" style="color: blue; cursor: pointer;"></i></span>
		<span style="width: 15px;"></span>
		<span id="sw_stop"><i title="Stop Time" class="fa fa-stop 4x" style="color: blue; cursor: pointer;"></i></span>
	  </div>
	  <div class="total_marks">Marks:&nbsp;<span id="totalmarks"></span></div>
	  <hr></hr>
	</div>
  <!--<p>The .dropdown class is used to indicate a dropdown menu.</p>
  <p>Use the .dropdown-menu class to actually build the dropdown menu.</p>
  <p>To open the dropdown menu, use a button or a link with a class of .dropdown-toggle and data-toggle="dropdown".</p>-->
  <!--<div class="row">
		<div class="btn-group dropdown todos" id="todos">
            <button class="btn btn-default dropdown-toggle botn-todos" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Select Filter
            <span class="caret caret-posicion"></span>
            </button>
            <ul class="dropdown-menu ancho-todos" aria-labelledby="dropdownMenu1">
              <li><a href="#" onclick="ChangeDropDownValue('a_correct', 'correct_radio');"><input value="1" name="busqueda1" type="radio" class="todoss" id="correct_radio"><span id="a_correct">Correct</span></a></li>
              <li><a href="#" onclick="ChangeDropDownValue('a_wrong', 'wrong_radio');"><input value="1" name="busqueda1" type="radio" class="enc" id="wrong_radio"><span id="a_wrong">Wrong</span></a></li>
              <li><a href="#" onclick="ChangeDropDownValue('a_all_rec', 'all_radio');"><input value="1" name="busqueda1" type="radio" class="nose" id="all_radio"><span id="a_all_rec">All Records</span></a></li>-->
              <!--<li><a href="#"><input value="1" name="busqueda1" type="radio" class="entre"> Entregado</a></li>
              <li><a href="#"><input value="1" name="busqueda1" type="radio" class="entre2"> Entregado al 2do intento</a></li>
              <li><a href="#"><input value="1" name="busqueda1" type="radio" class="nose"> No se puede entregar</a></li>
              <li><a href="#"><input value="1" name="busqueda1" type="radio" class="cancelado"> Cancelado</a></li>-->
            <!--</ul>
          </div>
  </div>-->
	
	<div class="row">
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="btnDrop">Select Operation
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" style="background: rgb(34,34,34);">
			  <li><a href="#" onclick="ChangeButtonValue('a_add')" id="a_add"><span style="padding-right: 15px;"><i class="fa fa-plus-square 4x" style="cursor: pointer;"></i></span>Addition</a></li>
			  <!--<li class="divider"></li>-->
			  <li><a href="#" onclick="ChangeButtonValue('a_sub')" id="a_sub"><span style="padding-right: 15px;"><i class="fa fa-minus-square 4x" style="cursor: pointer;"></i></span>Subtraction</a></li>
			  <!--<li class="divider"></li>-->
			  <li><a href="#" onclick="ChangeButtonValue('a_multi')" id="a_multi"><span style="padding-right: 15px;"><i class="fa fa-window-close 4x" style="cursor: pointer;"></i></span>Multiplication</a></li>
			  <li class="divider"></li>
			  <li><a href="#" onclick="ChangeButtonValue('a_word')" id="a_word"><span style="padding-right: 15px;"><i class="fa fa-wordpress 4x" style="cursor: pointer;"></i></span>Word Problems</a></li>
			  <!--<li><a href="#" onclick="ChangeButtonValue('a_divn')" id="a_divn"><span style="padding-right: 15px;" class="glyphicons glyphicons-divide"></span>Division</a></li>-->
			</ul>
		</div>
	</div>
	<div style="height: 100px;"></div>
	<br></br>
	<div class="row hide_div_class" id="a_add_operation" style="display: none">
		<div id="menuSelected"><span class="arrowhead"></span>Click on this icon</div>
		<div class="col-lg-1 operation_symbol" id="get_addition_data" onclick="PutDataToAdd();"><i title="Get Numbers" class="fa fa-refresh 4x" style="color: blue; cursor: pointer; text-shadow: rgb(119, 119, 119) 2px 3px 3px;" id="get_add_data" onmousedown="$('#get_add_data').css('text-shadow', 'rgb(119, 119, 119) -2px -1px 3px');" onmouseup="$('#get_add_data').css('text-shadow', 'rgb(119, 119, 119) 2px 3px 3px');"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="add_first" disabled></input></div><div class="col-lg-1 operation_symbol"><i class="fa fa-plus 4x"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="add_second" disabled></input></div><div class="col-lg-1 operation_symbol"><i class="fa fa-plus 4x"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="add_third" disabled></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer"><i class="fa fa-equal"></i></div>
		<div class="col-lg-1 check_correct_answer"><input type="text" class="input_styles clear_field" id="add_result"></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer after_check_answer" onclick="CheckAddAnswer();" style="display: none;"><i id="check_add" class="fa fa-check 4x" style="color: green; cursor: pointer;"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="right_add_answer" style="display: none"><i class="fa fa-smile-o fa-3x smiley_right"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="wrong_add_answer" style="display: none"><i class="fa fa-frown-o fa-3x smiley_wrong"></i></div>
	</div>
	
	<div class="row hide_div_class" id="a_sub_operation" style="display: none">
		<div id="menuSelected"><span class="arrowhead"></span>Click on this icon</div>
		<div class="col-lg-1 operation_symbol" id="get_subtraction_data" onclick="PutDataToSubtract();"><i title="Get Numbers" class="fa fa-refresh 4x" style="color: blue; cursor: pointer; text-shadow: rgb(119, 119, 119) 2px 3px 3px;" id="get_sub_data" onmousedown="$('#get_sub_data').css('text-shadow', 'rgb(119, 119, 119) -2px -1px 3px');" onmouseup="$('#get_sub_data').css('text-shadow', 'rgb(119, 119, 119) 2px 3px 3px');"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="sub_first" disabled></input></div><div class="col-lg-1 operation_symbol"><i class="fa fa-minus 4x"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="sub_second" disabled></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer"><i class="fa fa-equal"></i></div>
		<div class="col-lg-1 check_correct_answer"><input type="text" class="input_styles clear_field" id="sub_result"></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer after_check_answer" onclick="CheckSubAnswer();" style="display: none;"><i id="check_sub" class="fa fa-check 4x" style="color: green; cursor: pointer;"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="right_sub_answer" style="display: none"><i class="fa fa-smile-o fa-3x smiley_right"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="wrong_sub_answer" style="display: none"><i class="fa fa-frown-o fa-3x smiley_wrong"></i></div>
	</div>
	
	
	<div class="row hide_div_class" id="a_multi_operation" style="display: none">
		<div id="menuSelected"><span class="arrowhead"></span>Click on this icon</div>
		<div class="col-lg-1 operation_symbol" id="get_multiplication_data" onclick="PutDataToMultiply();"><i title="Get Numbers" class="fa fa-refresh 4x" style="color: blue; cursor: pointer; text-shadow: rgb(119, 119, 119) 2px 3px 3px;" id="get_multi_data" onmousedown="$('#get_multi_data').css('text-shadow', 'rgb(119, 119, 119) -2px -1px 3px');" onmouseup="$('#get_multi_data').css('text-shadow', 'rgb(119, 119, 119) 2px 3px 3px');"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="multi_first" disabled></input></div><div class="col-lg-1 operation_symbol"><i class="fa fa-close 4x"></i></div>
		<div class="col-lg-1"><input type="text" class="input_styles clear_field" id="multi_second" disabled></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer"><i class="fa fa-equal"></i></div>
		<div class="col-lg-1 check_correct_answer"><input type="text" class="input_styles clear_field" id="multi_result"></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer after_check_answer" onclick="CheckMultiAnswer();" style="display:none;"><i id="check_multi" class="fa fa-check 4x" style="color: green; cursor: pointer;"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="right_multi_answer" style="display: none"><i class="fa fa-smile-o fa-3x smiley_right"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="wrong_multi_answer" style="display: none"><i class="fa fa-frown-o fa-3x smiley_wrong"></i></div>
	</div>
	
	
	<div class="row hide_div_class" id="a_word_operation" style="display: none">
		<div id="menuSelected"><span class="arrowhead"></span>Click on this icon</div>
		<div class="col-lg-1 operation_symbol" id="get_word_data" onclick="PutWordPuzzle();"><i title="Get Puzzle" class="fa fa-refresh 4x" style="color: blue; cursor: pointer; text-shadow: rgb(119, 119, 119) 2px 3px 3px;" id="get_wrd_data" onmousedown="$('#get_wrd_data').css('text-shadow', 'rgb(119, 119, 119) -2px -1px 3px');" onmouseup="$('#get_wrd_data').css('text-shadow', 'rgb(119, 119, 119) 2px 3px 3px');"></i></div>
		<div class="clear_field question_main_txt questions_fields" id="question_desc" disabled></div><br></br>
		<div style="height: 50px;"></div>
		<div class="aligning_ans_div"><div class="col-lg-1 question_ans_txt questions_fields" id="main_question"></div>
		<div class="col-lg-1 check_correct_answer" style="width: max-content;"><input type="text" style="width: 130px;" class="input_styles clear_field" id="word_first"></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer"><i class="fa fa-equal"></i></div>
		<div class="col-lg-1 check_correct_answer"><input type="text" class="input_styles clear_field" id="word_result"></input></div>
		<div class="col-lg-1 operation_symbol check_correct_answer after_check_answer" onclick="CheckWordAnswer();" style="display:none;"><i id="check_word" class="fa fa-check 4x" style="color: green; cursor: pointer;"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="right_word_answer" style="display: none"><i class="fa fa-smile-o fa-3x smiley_right"></i></div>
		<div class="col-lg-1 operation_symbol answer_check_symbol noanswer_hide_me" id="wrong_word_answer" style="display: none"><i class="fa fa-frown-o fa-3x smiley_wrong"></i></div></div>
	</div>
	<div class="performance_style" id="performance_analysis" onclick="ShowPerformanceContainer();">P<br>e<br>r<br>f<br>o<br>r<br>m<br>a<br>n<br>c<br>e</div>
	<div class="row" style="height: 30px;"></div>
	<div class="row answer_right answer_check_symbol" id="answer_right_check" style="display: none;"><strong>That's Correct</strong></div>
	<div class="row answer_wrong answer_check_symbol" id="answer_wrong_check" style="display: none;"><strong>That's Wrong</strong></div>
	<div class="row answer_wrong" id="no_answer_check" style="display: none; font-size: 20px;"><strong>Please provide your answer</strong></div>
</div>

<div style="display: none;" id="get_add_result"></div>
<div style="display: none;" id="get_sub_result"></div>
<div style="display: none;" id="get_multi_result"></div>
<div style="display: none;" id="get_word_result"></div>
<div class="overlay" id="crying_anime"><img src="crying.gif"></img></div>

<div class='overlay performance_views' id="performance_container">
	<div class="performance_details" id="performance_details_container"></div>
</div>

</body>
</html>