
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>


		Resources Management
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
         
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'cms.css'); ?>" media="all" />
       
		
      
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'SpryTabbedPanels.css'); ?>" media="all" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'jTPS.css'); ?>" media="all" />
        


        <script src="<?php echo resource_url('js', '/library/cookie.js'); ?>" type="text/javascript" charset="utf-8"></script>
        
        <script src="<?php echo resource_url('js', 'cms.js'); ?>" type="text/javascript" charset="utf-8"></script>
        
        <script src="<?php echo resource_url('js', 'sorttable.js'); ?>" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo resource_url('js', 'SpryTabbedPanels.js'); ?>" type="text/javascript" charset="utf-8"></script>

  
    <?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
        
         
	<?php endblock(); ?>

<?php startblock('content'); ?>

<script>
					  
$(function () { 
/*
			$('#newsTable').jTPS( {perPages:[5]} );
			$('#eventsTable').jTPS( {perPages:[5]} );
			$('#articles').jTPS( {perPages:[5]} );
			$('#groups').jTPS( {perPages:[5]} );
			$('#tools').jTPS( {perPages:[5]} );
			$('#models').jTPS( {perPages:[5]} );
			*/
			
			page('#newsTable');
			page('#eventsTable');
			page('#articles');
			page('#groups');
			page('#tools');
			page('#models');
			
		});
              </script>
    <div class="cms">
		<div class="resources">
        
        
		  <h2 class="title">Resources Management</h2>
          <div id="TabbedPanels1" class="TabbedPanels">
            <ul class="TabbedPanelsTabGroup">
              <li class="TabbedPanelsTab" tabindex="0" onclick="saveTab(0)">News</li>
              <li class="TabbedPanelsTab" tabindex="1" onclick="saveTab(1)">Events</li>
              <li class="TabbedPanelsTab" tabindex="2" onclick="saveTab(2)">Articles</li>
              <li class="TabbedPanelsTab" tabindex="3" onclick="saveTab(3)">Organizations</li>
              <li class="TabbedPanelsTab" tabindex="4" onclick="saveTab(4)">Device Models</li>
              <li class="TabbedPanelsTab" tabindex="5" onclick="saveTab(5)">Tools</li>              
            </ul>
            <div class="TabbedPanelsContentGroup">
              <div class="TabbedPanelsContent">


              	<input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/news');?>'">
				<form name="form1" method="post" action="../cms/resources/man_multi_res">                        
				<table id="newsTable" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th width="20"  id="news_checkbox" ><input type="checkbox" name="allbox" onclick="CheckAll('news_id[]','form1')"></th>
                        <th width="12" sort="decrip" >ID</th>
                        <th sort="decrip">Subject</th>
                        <th width="70" sort="decrip">Date</th>
                        <th width="30" sort="decrip">Edit</th>
                        <th width="60" sort="decrip">Status</th> 
  					</tr>
                    </thead>
                    <tbody>
                    <?php foreach($news as $row): ?>
  					<tr id="<?php echo 'news'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td id="<?php echo $row->id;?>" class="checkbox"><input id="newsCheckBox<?php echo $row->id;?>" type="checkbox"  name="news_id[]" value="<?php echo $row->id;?>"></td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><a id="<?php echo 'newsLink'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="resources/news?id=<?php echo $row->id;?>"><?php echo $row->title;?></a></td>
                        <td sorttable_customkey="<?php echo $row->post_date;?>"><?php echo date('d M Y', $row->post_date);?></td>
                        <td><a id="<?php echo 'newsEdit'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/news/?newsid=<?php echo $row->id;?>">edit</a></td>
                        <td><div id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></div></td>
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
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form1, 0,'news','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form1, 1,'news','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form1,'news','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form1,'news')">
               
				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a>

              </div>
              <div class="TabbedPanelsContent">
              <input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/events');?>'">
				<form name="form2" method="post" action="../cms/resources/man_multi_res">               
				<table id="eventsTable" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th sort="decrip" id="events_checkbox" width="20"><input type="checkbox" name="allbox" onclick="CheckAll('events_id[]','form2')"></th>
                        <th sort="decrip" width="12">ID</th>
                        <th sort="decrip">Event Name</th>
                        <th sort="decrip">location</th>
                        <th sort="decrip" width="30">Edit</th>
                        <th sort="decrip" width="60">Status</th>
  					</tr>
                    </thead>
                    <tbody>
                      <?php foreach($coming_events as $row): ?>
                      <tr id="<?php echo 'events'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox">
                          <input id="eventsCheckBox<?php echo $row->id;?>" type="checkbox"  name="events_id[]" value="<?php echo $row->id;?>">
                        </td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><?php echo $row->name;?></td>
                        <td class="subject"><?php echo $row->location;?></td>
                        <td><a href="../resources/edit_resources/events/?eventid=<?php echo $row->id;?>">edit</a></td>
                         <td id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></td>
                      </tr>
                      <?php endforeach;?>                       
                      <?php foreach($past_events as $row): ?>
                      <tr id="<?php echo 'events'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox">
                          <input id="eventsCheckBox<?php echo $row->id;?>" type="checkbox"  name="events_id[]" value="<?php echo $row->id;?>">
                        </td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><?php echo $row->name;?></td>
                        <td class="subject"><?php echo $row->location;?></td>
                        <td><a <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/events/?eventid=<?php echo $row->id;?>">edit</a></td>
                        <td id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></td>
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
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form2, 0,'events','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form2, 1,'events','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form2,'events','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form2,'events')">
               
                
				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a> 
              </div>
              <div class="TabbedPanelsContent">
                <input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/articles');?>'">
				<form name="form3" method="post" action="../cms/resources/man_multi_res">               
				<table id="articles" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th sort="decrip"  id="articles_checkbox" width="20"><input type="checkbox" name="allbox" onclick="CheckAll('articles_id[]','form3')"></th>
                        <th sort="decrip" width="12">ID</th>
                        <th sort="decrip">Name</th>
                        <th sort="decrip">author</th>
                        <th sort="decrip" width="30">Edit</th>
                        <th sort="decrip"width="60">Status</th> 
  					</tr>
                    </thead>
                    <tbody>
                    <?php foreach($articles as $row): ?>
  					<tr id="<?php echo 'articles'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox"><input id="articlesCheckBox<?php echo $row->id;?>" type="checkbox"  name="articles_id[]" value="<?php echo $row->id;?>"></td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><a id="<?php echo 'articlesLink'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href=""><?php echo $row->name;?></a></td>
                        <td class="subject"><?php echo $row->author;?></td>
                   
                        <td><a <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/articles/?articleid=<?php echo $row->id;?>">edit</a></td>
                        <td><div id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></div></td>
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
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form3, 0,'articles','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form3, 1,'articles','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form3,'articles','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form3,'articles')">
                
				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a> 
              </div>
              <div class="TabbedPanelsContent">
              	<input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/groups');?>'">
				<form name="form4" method="post" action="../cms/resources/man_multi_res">               
				<table  id="groups" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th class="sorttable_nosort" id="groups_checkbox" width="20"><input type="checkbox" name="allbox" onclick="CheckAll('groups_id[]','form4')"></th>
                        <th width="12">ID</th>
                        <th>Name</th>
                        <th class="sorttable_nosort" width="30">Edit</th>
                        <th class="sorttable_nosort" width="60">Status</th> 
  					</tr>
                    </thead>
                    <tbody>
                    <?php foreach($groups as $row): ?>
  					<tr id="<?php echo 'model_groups'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox"><input <input id="model_groupsCheckBox<?php echo $row->id;?>" type="checkbox"  name="groups_id[]" value="<?php echo $row->id;?>"></td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><a id="<?php echo 'model_groupsLink'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href=""><?php echo $row->name;?></a></td>                   
                        <td><a <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/groups/?groupid=<?php echo $row->id;?>">edit</a></td>
                        <td><div id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></div></td>
  					</tr>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot class="nav">
                        <tr>
                            <td colspan="5">
                                <div class="pagination"></div>
                                <div class="paginationTitle">Page</div>
                                <div class="selectPerPage"></div>
                                <div class="status"></div>
                            </td>
                        </tr>
                    </tfoot>                       
				</table>
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form4, 0,'model_groups','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form4, 1,'model_groups','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form4,'model_groups','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form4,'model_groups')">

				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a> 
              </div>
              <div class="TabbedPanelsContent">
              	<input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/models');?>'">
				<form name="form5" method="post" action="../cms/resources/man_multi_res">               
				<table  id="models" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th sort="decrip"  id="models_checkbox" width="20"><input type="checkbox" name="allbox" onclick="CheckAll('models_id[]','form5')"></th>
                        <th sort="decrip" width="12">ID</th>
                        <th sort="decrip">Name</th>
                        <th sort="decrip">Author</th>
                        <th sort="decrip" width="30">Edit</th>
                        <th sort="decrip" width="60">Status</th> 
  					</tr>
                    </thead>
                    <tbody>
                    <?php foreach($models as $row): ?>
  					<tr id="<?php echo 'device_models'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox"><input <input id="device_modelsCheckBox<?php echo $row->id;?>" type="checkbox"  name="models_id[]" value="<?php echo $row->id;?>"></td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><div<?php if($row->del_status==1) echo 'style="color:#CCC"'?>><?php echo $row->name;?></div></td>  
                        <td class="subject"><?php echo $row->author;?></td>                 
                        <td><a <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/models/?modelid=<?php echo $row->id;?>">edit</a></td>
                        <td><div id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></div></td>
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
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form5, 0,'device_models','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form5, 1,'device_models','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form5,'device_models','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form5,'device_models')">
                
				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a> 
              </div>
              <div class="TabbedPanelsContent">
              	<input name="Post" type="button" value="Post" class="submit" onclick="location.href='<?php echo base_url('resources/post/tools');?>'">
 				<form name="form6" method="post" action="../cms/resources/man_multi_res">               
				<table id="tools" style="table-layout: fixed;">
                	<thead>
  					<tr>
                        <th sort="decrip" id="tools_checkbox" width="20"><input type="checkbox" name="allbox" onclick="CheckAll(CheckAll('tools_id[]','form6'))"></th>
                        <th sort="decrip" width="12">ID</th>
                        <th sort="decrip">Name</th>
                        <th sort="decrip">type</th>
                        <th sort="decrip" width="30">Edit</th>
                        <th sort="decrip" width="60">Status</th> 
  					</tr>
                    </thead>
                    <tbody>
                    <?php foreach($tools as $row): ?>
  					<tr id="<?php echo 'tools'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?>>
                        <td class="checkbox"><input <input id="toolsCheckBox<?php echo $row->id;?>" type="checkbox"  name="tools_id[]" value="<?php echo $row->id;?>"></td>
                        <td><?php echo $row->id;?></td>
                        <td class="subject"><div<?php if($row->del_status==1) echo 'style="color:#CCC"'?>><?php echo $row->name;?></div></td>  
                        <td class="subject"><?php echo $row->type;?></td>                 
                        <td><a id="<?php echo 'toolsLink'.$row->id;?>" <?php if($row->del_status==1) echo 'style="color:#CCC"'?> href="../resources/edit_resources/tools/?toolid=<?php echo $row->id;?>">edit</a></td>
                        <td><div id="approve_res<?php echo $row->id;?>"><?php if($row->approval_status==1): echo 'approved';?><?php else: echo'<font color="#FF0000">disapproved</font>';?>
                        <?php endif;?></div></td>
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
                
                <input type="hidden" name="type" value="news" />
                <input name="undelete" type="button" value="Unelete" class="submit" onclick="hideMultiRes(form6, 0,'tools','resources')">
				<input name="delete" type="button" value="Delete" class="submit" onclick="hideMultiRes(form6, 1,'tools','resources')">
                <input name="perm_delete" type="button" value="Permanently delete" class="submit" onclick="delMultiRes(form6,'tools','resources')">
                <input name="approve" type="button" value="Approve" class="submit" onclick="approveMultiRes(form6,'tools')">
          
				</form>
				<a class="return-link" href="<?php echo base_url('/cms');?>">
				Back
				</a> 
              </div>
            </div>
          </div>
        </div>
</div>    
<?php endblock(); ?>

<?php end_extend(); ?> 
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
