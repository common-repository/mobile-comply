<script type="text/javascript">
    gvChartInit();
</script>
<h3>Statistic start date: <?php echo $start_date; ?></h3>
<h2>Total statistic</h2>
<h3>Total hits: <?php echo $total_hits; ?></h3>
<h3>Total visitors: <?php echo $total_visitors; ?></h3>
<h3>Total visits: <?php echo $total_visits; ?></h3>
<br/>
<h2>Mobilecomply version of the site</h2>
<h3>Total hits: <?php echo $total_mobilecomply_hits; ?></h3>
<h3>Total visitors: <?php echo $total_mobilecomply_visitors; ?></h3>
<h3>Total visits: <?php echo $total_mobilecomply_visits; ?></h3>
<h3>Total registered for mobile offers: <?php echo $total_mobilecomply_opt_in; ?></h3>

<script type="text/javascript">
    $ = jQuery;
    
    gvChartInit();
    
    jQuery(function(){
        jQuery('#hits_table').gvChart({
            chartType: 'AreaChart',
            gvSettings: {
                vAxis: {title: 'Hits'},
                hAxis: {title: 'Date'},
                width: 720,
                height: 300
            }
        });
    });
    
</script>
		
<table id='hits_table'>
    <caption>Hits per date</caption>
    <thead>
        <tr>
            <th></th>
            <?php
            foreach ($date_list as $date) {
                echo "<th>$date</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>        
        <tr>
            <th>Total hits</th>
            <?php
            foreach ($total_per_date as $hits) {
                echo "<td>$hits</td>";
            }
            ?>
        </tr>
        <tr>
            <th>Total Mobilecomply hits</th>
            <?php
            foreach ($total_mobilecomply_per_date as $hits) {
                echo "<td>$hits</td>";
            }
            ?>
        </tr>
    </tbody>
</table>

