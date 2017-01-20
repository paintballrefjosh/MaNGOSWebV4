<br>
<?php builddiv_start(0, "Server Info") ?>
<style type="text/css">
    table.serverstatus1 td, table.serverstatus1 th{
        font-size: 0.8em;
        border-style: solid;
        border-width: 0px 2px 2px 1px;
        border-color: #010101;
    }
    table.serverstatus1 td.value {
        text-align: center;
    }
    table.serverstatus1 th {
        text-align:center;
        font-weight: bolder;
        color: #FFFFFF;
        background-color: #010101;
    }
</style>
<table class="serverstatus1" align="center" cellpadding="0">
    <tr><th colspan="2">Server Info</th></tr>
<?php foreach($write_straight as $key=>$value): ?>
    <tr><td><?php echo htmlspecialchars($value); ?></td><td class="value"><?php echo isset($config_details[$key]) ? htmlspecialchars($config_details[$key]) : ''; ?></td></tr>
<?php endforeach; ?>
    <tr><th colspan="2">Horde and Alliance Interaction</th></tr>
<?php foreach($write_true_false as $key=>$value): ?>
    <tr><td><?php echo htmlspecialchars($value); ?></td><td class="value"><?php echo isset($config_details[$key]) ? (($config_details[$key] == 1) ? 'YES' : 'NO') : ''; ?></td></tr>
<?php endforeach; ?>
    <tr><th colspan="2">Server Rates</th></tr>
<?php foreach($write_blizzlike as $key=>$value): ?>
    <tr><td><?php echo htmlspecialchars($value); ?></td><td class="value"><?php echo isset($config_details[$key]) ? htmlspecialchars($config_details[$key]) . ' x BlizzLike' : ''; ?></td></tr>
<?php endforeach; ?>
    <tr><th colspan="2">Skill Chance Values</th></tr>
<?php foreach($write_skillchances as $key=>$value): ?>
    <tr><td><?php echo htmlspecialchars($value); ?>'</td><td class="value"><?php echo isset($config_details[$key]) ? htmlspecialchars($config_details[$key]) . '%' : ''; ?></td></tr>
<?php endforeach; ?>
</table>
<?php builddiv_end() ?>