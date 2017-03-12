<div class="ui container">
	<div class="ui basic segment">
	<?php echo $instance->config->headerText; ?>
<?php
$logged_info = \Module\Member\Model::getLoggedMemberInfo();
if(isset($logged_info->isAdmin) && $logged_info->isAdmin == 'Y')
{
?>
<a href="/admin/board/edit/<?php echo $instance->instanceId; ?>" class="ui button">설정</a>
<?php } ?>

