<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
    Activities management
<?php endblock(); ?>
    
<?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jTPS.css'); ?>" media="all" />

    <script src="<?php echo resource_url('js', 'cms.js'); ?>" type="text/javascript" charset="utf-8"></script>

    <script src="<?php echo resource_url('js', 'sorttable.js'); ?>" type="text/javascript" charset="utf-8"></script>
<?php endblock(); ?>

<?php startblock('side_menu'); ?>
    <?php echo get_extended_block(); ?>
    <?php $this->load->view('account/account_block'); ?>
<?php endblock(); ?>


<?php startblock('content'); ?>

<script>					  
$(function () {
			page('#activities_table');
});
</script>

    <div class="cms">
    	<div class="activities">
			<h2 class="title">Activities management</h2>
            <input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/activities');?>'">
            <form name="form1" method="post"> 
            <table id="activities_table">
            	<thead>
                  <tr>
                    <th width="20"  id="news_checkbox" ><input type="checkbox" name="allbox" onclick="CheckAll('activities_id[]','form1')"></th>
                    <th width="12" sort="decrip" >ID</th>
                    <th sort="decrip">Subject</th>
                    <th width="70">Date</th>
                    <th width="30" sort="decrip">Edit</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($activities as $row): ?>
                  <tr id="<?php echo 'activities'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                    <td id="<?php echo $row->id;?>" class="checkbox">
                      <input id="activitiesCheckBox<?php echo $row->id;?>" type="checkbox"  name="activities_id[]" value="<?php echo $row->id;?>">
                    </td>
                    <td><?php echo $row->id;?></td>
                    <td><?php echo $row->content;?></td>
                    <td><?php echo date('d M Y', $row->date);;?></td>
                    <td><a id="<?php echo 'activitiesEdit'.$row->id;?>" href="">edit</a></td>
                  </tr>
                  <?php endforeach;?>
                 </tbody>
                    <tfoot class="nav">
                        <tr>
                            <td colspan="6">
                                <div class="pagination"></div>
                                <div class="paginationTitle">Page</div>
                                <div class="selectPerPage"></div>
                                <div class="status"></div>
                            </td>
                        </tr>
                    </tfoot>  
            </table>
                <input type="hidden" name="type" value="activities" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form1, 0,'activities','activities')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form1, 1,'activities','activities')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form1,'activities','activities')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form1,'activities')">
            </form>
            <a class="return-link" href="<?php echo base_url('/cms');?>">
			Back
			</a>
        </div>
	</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
