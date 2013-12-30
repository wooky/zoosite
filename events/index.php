<?php //IMPORTANT: DHTMLX Scheduler must be installed in the calendar/ directory
require_once("../res/template.php");
partialHead("Events Calendar");
echo '<script type="text/javascript" src="calendar/dhtmlxscheduler.js"></script>
<script type="text/javascript" src="calendar/ext/dhtmlxscheduler_readonly.js"></script>
<link rel="stylesheet" href="calendar/dhtmlxscheduler.css">';
partialBody();?>
<div class="supertitle">ZOO EVENTS</div>
<div id="scheduler_here" class="dhx_cal_container" style='width:760px;height:600px'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
    </div>
    <div class="dhx_cal_header"></div>
    <div class="dhx_cal_data"></div>       
</div><script type="text/javascript">
<?php if(!@$_SESSION['member'] || $_SESSION['member'] == "")
	echo "scheduler.config.readonly_form = true;\n";?>
scheduler.config.xml_date="%Y-%m-%d %H:%i:%s";
scheduler.config.hour_date="%h:%i %A";
scheduler.init('scheduler_here',new Date(),"month");
scheduler.load('connector.php');

var dp = new dataProcessor("connector.php");
dp.init(scheduler);
</script><?php if(@$_SESSION['member'])
	echo "To add an event, double click below the date number.<br>To edit/delete an event, double click to the right of the time of the event";
footon();?>
