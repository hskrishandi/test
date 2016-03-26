<?php extend('resources/layout.php'); ?>	
<?php startblock('title'); ?>
  Resources
<?php endblock(); ?>

<?php startblock('script'); ?>
    <?php echo get_extended_block(); ?>
    <script src="<?php echo resource_url('js', 'ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
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
              $('#activities_form').submit();
						})
				});
				

			</script>

  
        	<div id="post_forms">
            
            
				<?php if($res=='news'){?>
       
                
                	<h2 class="title">News</h2>
               		  <div class="form">
    
                      
               		  <form class="form" name="news_form" id="news_form" action="<?php echo base_url('/resources/submit/news');?>" method="post">
            
                        
                        <table class="form_table">
                          <tr>
                          
                            <td class="label">Name:</td>
                            <td><input name="title" type="text" id="cname"  class="required"/></td>
                          </tr>
                          <tr>

                            <td class="label">Source Link:</td>
                            <td><input name="slink" type="text" id="cname"  class="required" /></td>
                          </tr>
                          <tr>
                            <td colspan="2">Content:</td>
                          </tr>
                          <tr>
                            <td colspan="2"><textarea name="content" cols="50" rows="6" class="required" ></textarea>
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
                      </div>
               		
 
                <?php } else if($res=='events'){?>
                
                
                		<h2 class="title">Event</h2>
	  <div class="form">
                    	<form name="events_form" id="events_form" action="<?php echo base_url('/resources/submit/events');?>" method="post">
                        
                        <table class="form_table">
                          <tr>
                            <td class="label">Event Name:</td>
                            <td>
                              <input name="name" type="text" class="required" id="name" />
                            </td>
                          </tr>
                          <tr>
                            <td class="label">Event Full Name:
                              
                            </td>
                            <td>
                              <input name="full_name" type="text" class="required" id="full_name" />
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
                            <td><input name="location" type="text" class="required" id="location" /></td>
                          </tr>
                          <tr>
                            <td class="label">Website:</td>
                            <td ><input name="website" type="text" class="url required" id="website" /></td>
                          </tr>
                          <tr>
                            <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                          </tr>
                        </table>
    
       	  </form>                                      		
	      </div>
              
                <?php } else if($res=='articles'){?>
           <div class="form">
					  <h2>Post Article</h2>
                   	  <form name="articles_form" id="articles_form" action="<?php echo base_url('/resources/submit/articles');?>" method="post">                     
                      	<table class="form_table">
                          <tr>
                            <td class="label">Name</td>
                            <td><input name="name" type="text" class="required" id="name" /></td>
                          </tr>
                          <tr>
                            <td class="label">Author</td>
                            <td><input name="author" type="text" class="required" id="author" /></td>
                          </tr>
                          <tr>
                            <td class="label">Publisher name</td>
                            <td><input name="publisher" type="text" class="required" id="publisher" /></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="year">Year</label></td>
                            <td><select name="year" id="year">
                              <?php for($i=date("Y");$i>1900;$i--):?>
                              <option value="<?php echo $i;?>"><?php echo $i;?></option>
                              <?php endfor?>
                            </select></td>
                          </tr>
                          <tr>
                            <td class="label"><label for="website">Website</label></td>
                            <td><input name="website" type="text" class="url required" id="website" /></td>
                          </tr>
                          <tr>
                            <td class="label">Summary</td>
							 <td><textarea name="summary" cols="10" rows="6"  id="summary" class="required"></textarea></td>
							 <td><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                          </tr>
                        </table>
                      	<label for="select"></label>
</form>
                
               		</div>
                
                <?php } else if($res=='groups'){?>
               		<div class="form">
                    <h2>Post Organiztion</h2>
                    <form name="groups_form" id="articles_form" action="<?php echo base_url('/resources/submit/groups');?>" method="post">
                    <table class="form_table">
                      <tr>
                        <td class="label"><label for="name">Organization:</label></td>
                        <td><input name="name" type="text" class="required" id="name" /></td>
                      </tr>
                      <tr>
                        <td class="label"><label for="website">Website:</label></td>
                        <td><input name="website" type="text" class="url required" id="website" /></td>
                      </tr>
                      <tr>
                        <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                      </tr>
                    </table>

                    
                    </form>
                    
                    
                
	      </div>                
                <?php } else if($res=='models'){?>
       		  <div class="form">
                <h2>Post Reference</h2>
                    <form name="models_form" id="models_form" action="<?php echo base_url('/resources/submit/models');?>" method="post">
                      <table class="form_table">
                        <tr>
                          <td class="label">Model Name:</td>
                          <td>
                          <input name="name" type="text" class="required" id="name" /></td>
                        </tr>
                        <tr>
                          <td class="label">Author:</td>
                          <td>
                          <input name="author" type="text" class="required" id="author" /></td>
                        </tr>
                        <tr>
                          <td class="label">Status:</td>
                          <td>
                            <select name="status" id="status">
                              <option value="released">released</option>
                              <option value="developing">developing</option>
                          </select></td>
                        </tr>
                        <tr>
                          <td class="label">Website:</td>
                          <td>
                          <input name="website" type="text" class="url required" id="website" /></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                        </tr>
                      </table>
    </form>
                
               		</div>                
                <?php } else if($res=='tools'){?>
                	<h2>Post Tools</h2>
   		  <div class="form">
                    <form name="tools_form" id="tools_form" action="<?php echo base_url('/resources/submit/tools');?>" method="post">
                      <table class="form_table">
                        <tr>
                          <td class="label">Name:</td>
                          <td>
                            <input name="name" type="text" class="required" id="name" /></td>
                        </tr>
                        <tr>
                          <td class="label"> Description :</td>
                          <td>
                            <input name="description" type="text" class="required" id="description" /></td>
                        </tr>
                        <tr>
                          <td class="label">Type:</td>
                          <td>
                            <select name="type" id="type">
                              <option value="device_sim">Device Simulator</option>
                              <option value="circuit_sim">Circuit Simulator</option>
                              <option value="param_extract">Model Parameter Extractor</option>
                              <option value="interface">Interface</option>
                            </select></td>
                        </tr>
                        <tr>
                          <td class="label">Website:</td>
                          <td>
                            <input name="website" type="text" class="url required" id="website" /></td>
                        </tr>
                        <tr>
                          <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                        </tr>
                      </table>
    </form>
                
               		</div>


              <?php } else if($res=='activities'){?>
                
                
                <h2 class="title">Activities</h2>
                    <div class="form">
                      <form name="activities_form" id="activities_form" action="<?php echo base_url('/resources/submit/activities');?>" method="post">
                        
                        <table class="form_table">
                          <tr>
                            <td class="label">Content:</td>
                            <td>
                                <textarea name="activities_content" id="activities_content"></textarea>
                                <script type="text/javascript">
                                CKEDITOR.replace( 'activities_content',
                                {
                                  on :
                                  {
                                    instanceReady : function( ev )
                                     {
                                        // Output paragraphs as <p>Text</p>.
                                        this.dataProcessor.writer.setRules( 'p',
                                            {
                                                indent : false,
                                                breakBeforeOpen : false,
                                                breakAfterOpen : false,
                                                breakBeforeClose : false,
                                                breakAfterClose : false
                                            });
                                      }
                                  }
                                });
                                CKEDITOR.replace( 'activities_content' );
                                toolbar : 'MyToolbar';  
                              </script>
                            </td>
                          </tr>

                          <tr>
                            <td colspan="2"><div class="form_submit"><a class="submit" id="submit">Submit</a></div></td>
                          </tr>
                        </table>
    
          </form>                                         
        </div>

                <?php } if($res=='submited'){?>     
                    	Your input is submited. Thank you.
                      <?php
                      $backpath = 'resources/'.$_GET['res'];
                      if ($_GET['res'] == 'activities') $backpath = 'cms/'.$_GET['res'];
					  if ($_GET['res'] == 'articles') $backpath = 'documents';
                      ?>
                      <a class="return-link" href="<?php echo base_url($backpath); ?>">Back</a>
       
                <?php }/*endif*/ ?>
            
            
            </div>			

<?php endblock(); ?>

<?php end_extend(); ?>
