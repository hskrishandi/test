<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>

		Resources
	<?php endblock(); ?>		
    
<?php startblock('content'); ?>


<script>


$(document).ready(function(){
						$('#submit').click(function(){
							//$('#commentForm').submit();	
							$('#news_form').submit();	
							$('#events_form').submit();	
							$('#articles_form').submit();
							$('#groups_form').submit();	
							$('#models_form').submit();		
							$('#tools_form').submit();					

						})
				});
				

			</script>

  
        	<div id="post_forms">
            
            
				<?php if($res=='news'){?>
       
                
                
                
                	<h2 class="title">News</h2>
               		  <div class="form">
    
                      <?php foreach($news_details as $entry): ?>
               		  <form class="form" name="news_form" id="news_form" action="<?php echo base_url('/resources/edit_resources_submit/news/?newsid='.$entry->id);?>" method="post">
            
                        
                        <table class="form_table">
                          <tr>
                          
                            <td class="label">Name:</td>
                            <td><input name="title" type="text" id="cname"  class="required" value="<?php  echo $entry->title;?>"/></td>
                          </tr>
                          <tr>
                            <td colspan="2">Content:</td>
                          </tr>
                          <tr>
                            <td colspan="2"><textarea name="content" cols="50" rows="6" class="required"><?php  echo $entry->content;?>
                            </textarea>
                            </td>
                          </tr>
                          <tr>
                          	<td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a>
                         
                          	</div>
                            </td>
                          </tr>
                        </table>
                       
                        <input type="hidden" name="post_date" value="<?php echo date("Y-m-d H:i:s");?>" />
                    
               		  </form>
                      <?php endforeach;?>
                      </div>
               		
 
                <?php } else if($res=='events'){?>
                
                
                		<h2 class="title">Event</h2>
	  <div class="form">
      					<?php foreach($event_details as $row):?>
                    	<form name="events_form" id="events_form" action="<?php echo base_url('/resources/edit_resources_submit/events');?>" method="post">
                        
                        <table class="form_table">
                          <tr>
                            <td class="label">Event Name:</td>
                            <td>
                              <input name="name" type="text" class="required" id="name" value="<?php echo $row->name;?>" />
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Event Full Name:
                              
                            </td>
                            <td>
                              <input name="full_name" type="text" class="required" id="full_name" value="<?php echo $row->full_name;?>" />
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Start Date:</td>
                            <td><script>DateInput('start_date', true, 'YYYY-MM-DD');</script></td>
                          </tr>
                          <tr>
                            <td class="label">End Date:</td>
                            <td><script>DateInput('end_date', true, 'YYYY-MM-DD');</script></td>
                          </tr>
                          <tr>
                            <td class="label">Location:</td>
                            <td><input name="location" type="text" class="required" id="location" value="<?php echo $row->location;?>" /></td>
                          </tr>
                          <tr>
                            <td class="label">Website:</td>
                            <td ><input name="website" type="text" class="url required" id="website" value="<?php echo $row->website;?>" />
                            <input type="hidden" name="eventid" value="<?php echo $row->id;?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                          </tr>
                        </table>
                  
    			
       	  				</form>   
                        		<script language="javascript">
								document.getElementById("end_date_Year_ID").value=<?php echo date('Y',strtotime($row->end_date));?>;
								document.getElementById("start_date_Day_ID").options[<?php echo date('d',strtotime($row->start_date))-1;?>].selected=true;
								document.getElementById("start_date_Month_ID").options[<?php echo date('m',strtotime($row->start_date))-1;?>].selected=true;
								
								document.getElementById("start_date_Year_ID").value=<?php echo date('Y',strtotime($row->start_date));?>;
                        		document.getElementById("end_date_Day_ID").options[<?php echo date('d',strtotime($row->end_date))-1;?>].selected=true;
								document.getElementById("end_date_Month_ID").options[<?php echo date('m',strtotime($row->end_date))-1;?>].selected=true;
                        </script>
                        <?php endforeach;?>   
                                   
                               		
	      </div>
              
                <?php } else if($res=='articles'){?>
           <div class="form">
           			  <h2 class="title">Article</h2>
                      <?php foreach($article_details as $entry):?>
                   	  <form name="articles_form" id="articles_form" action="<?php echo base_url('/resources/edit_resources_submit/articles');?>" method="post">                     
                      	<table class="form_table">
                          <tr>
                            <td class="label">Name:</td>
                            <td><input name="name" type="text" class="required" id="name" value="<?php echo $entry->name;?>" /></td>
                          </tr>
                          <tr>
                            <td class="label">Author:</td>
                            <td><input name="author" type="text" class="required" id="author" value="<?php echo $entry->author;?>"/></td>
                          </tr>
                          <tr>
                            <td class="label">Publisher name:</td>
                            <td><input name="publisher" type="text" class="required" id="publisher" value="<?php echo $entry->publisher;?>"/></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="year">Year:</label></td>
                            <td><select name="year" id="year">
                              <?php for($i=date("Y");$i>1900;$i--):?>
                              <option value="<?php echo $i;?>" <?php if($i==$entry->year) print('selected="selected"');?>><?php echo $i;?></option>
                              <?php endfor?>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="website">Website:</label></td>
                            <td><input name="website" type="text" class="url required" id="website" value="<?php echo $entry->website;?>"/></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="website">File Name:</label></td>
                            <td><input name="article_name" type="text" class="required" id="website" value="<?php echo $entry->article_name;?>"/></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="website">File Link:</label></td>
                            <td><input name="article_link" type="text" class="url required" id="website" value="<?php echo $entry->article_link;?>"/></td>
                          </tr>
                          <tr>
                            <td colspan="2">Summary:</td>
                          </tr>
                          <tr>
                            <td colspan="2"><textarea name="summary" cols="50" rows="6" wrap="physical" id="summary" class="required"><?php echo $entry->summary;?></textarea></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a>
                              <input type="hidden" name="articleid" value="<?php echo $entry->id;?>" />
                            </div></td>
                          </tr>
                        </table>
                      	<label for="select"></label>
</form>
                	<?php endforeach;?>  
               		</div>
                
                <?php } else if($res=='groups'){?>
               		<div class="form">
                    <h2 class="title">Organization</h2>
                    <?php foreach($group_details as $entry):?>
                    <form name="groups_form" id="articles_form" action="<?php echo base_url('/resources/edit_resources_submit/groups');?>" method="post">
                    <table class="form_table">
                      <tr>
                        <td class="label"><label for="name">Organization:</label></td>
                        <td><input name="name" type="text" class="required" id="name" value="<?php echo $entry->name;?>"  /></td>
                      </tr>
                      <tr>
                        <td class="label"><label for="website">Website:</label></td>
                        <td><input name="website" type="text" class="url required" id="website" value="<?php echo $entry->website;?>" /></td>
                      </tr>
                      <tr>
                        <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div>
                        <input type="hidden" name="groupid" value="<?php echo $entry->id;?>" /></td>
                        
                      </tr>
                    </table>

                    
                    </form>
                    <?php endforeach;?>
                    
                    
                
	      </div>                
                <?php } else if($res=='models'){?>
       		  <div class="form">
                <h2 class="title">Models</h2>
                <?php foreach($model_details as $entry):?>
                    <form name="models_form" id="models_form" action="<?php echo base_url('/resources/edit_resources_submit/models');?>" method="post">
                      <table class="form_table">
                        <tr>
                          <td class="label">Model Name:</td>
                          <td>
                          <input name="name" type="text" class="required" id="name" value="<?php echo $entry->name;?>" /></td>
                        </tr>
                        <tr>
                          <td class="label">Author:</td>
                          <td>
                          <input name="author" type="text" class="required" id="author" value="<?php echo $entry->author;?>" /></td>
                        </tr>
                        <tr>
                          <td class="label">Status:</td>
                          <td>
                            <select name="status" id="status">
                              <option value="released" <?php if($entry->status=="released") print('selected="selected"');?>>released</option>
                              <option value="developing"<?php if($entry->status=="developing") print('selected="selected"');?>>developing</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td class="label">Website:</td>
                          <td>
                          <input name="website" type="text" class="url required" id="website" value="<?php echo $entry->website;?>" />
                          <input type="hidden" name="modelid" value="<?php echo $entry->id;?>" /></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                        </tr>
                      </table>
    </form>
                <?php endforeach;?>
               		</div>                
                <?php } else if($res=='tools'){?>
                	<h2 class="title">Tools</h2>
   		  <div class="form">
          <?php foreach($tool_details as $entry):?>
                    <form name="tools_form" id="tools_form" action="<?php echo base_url('/resources/edit_resources_submit/tools');?>" method="post">
                      <table class="form_table">
                        <tr>
                          <td class="label">Name:</td>
                          <td>
                            <input name="name" type="text" class="required" id="name" value="<?php echo $entry->name;?>" /></td>
                        </tr>
                        <tr>
                          <td class="label"> Description :</td>
                          <td>
                            <input name="description" type="text" class="required" id="description" value="<?php echo $entry->description;?>" /></td>
                        </tr>
                        <tr>
                          <td class="label">Type:</td>
                          <td>
                            <select name="type" id="type">
                              <option value="device_sim" <?php if($entry->type=="device_sim") print('selected="selected"');?>>Device Simulator</option>
                              <option value="circuit_sim" <?php if($entry->type=="circuit_sim") print('selected="selected"');?>>Circuit Simulator</option>
                              <option value="param_extract" <?php if($entry->type=="param_extract") print('selected="selected"');?>>Model Parameter Extractor</option>
                              <option value="interface" <?php if($entry->type=="interface") print('selected="selected"');?>>Interface</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td class="label">Website:</td>
                          <td>
                            <input name="website" type="text" class="url required" id="website"  value="<?php echo $entry->website;?>"/>
                            <input type="hidden" name="toolid" value="<?php echo $entry->id;?>" /></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                        </tr>
                      </table>
    </form>
                <?php endforeach;?>
               		</div>        
                <?php } if($res=='submited'){?>     
                    	Your input is submited. Thank you.
                        
                      <a class="return-link" href="<?php echo base_url('resources/'.$_GET['res']); ?>">
					Back
				</a>
       
                <?php }/*endif*/ ?>
            
            
            </div>			

<?php endblock(); ?>

<?php end_extend(); ?>
